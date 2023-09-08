<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Author;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CourseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Filament\Resources\CourseResource\Widgets\CourseCount;
use App\Filament\Resources\CourseResource\RelationManagers\LessonRelationManager;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Cursussen');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Cursussen');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-book-open';
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Algemeen')->schema([

                Select::make('status')
                    ->label('Status')
                    ->options(['active' => __('Actief'), 'inactive' => __('Inactief')]),


                TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->label(__('Naam'))
                    ->placeholder('Bijv. Dakdekken voor beginners'),

                RichEditor::make('description')->required(),

            ]),

            Section::make('Media')->schema([
                FileUpload::make('image')->required()->label(__('Afbeelding'))
                ,
            ])->collapsible()->description('Omschrijving van dit panel'),

            Section::make('Auteur')->schema([
                Select::make('author_id')
                    ->label('Auteur')
                    ->options(Author::all()->pluck('name', 'id'))
                    ->searchable()
            ])->compact()->collapsible()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->toggleable(),

                TextColumn::make('status')
                    ->sortable()
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->icons([
                        'heroicon-o-x-mark',
                        'heroicon-o-x-mark' => static fn ($state): bool => $state === 'inactive',
                        'heroicon-o-check' => static fn ($state): bool => $state === 'active',
                    ])->colors([
                        'danger',
                        'danger' => static fn ($state): bool => $state === 'inactive',
                        'success' => static fn ($state): bool => $state === 'active',
                    ])->label('Status'),

                TextColumn::make('name')
                    ->description(fn (Course $record): string => Str::limit(strip_tags($record->description), 200), position: 'below')
                    ->wrap()
                    ->copyable()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold'),

                TextColumn::make('author.name')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')->since()->sortable()->toggleable()

            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'inactive' => 'Inactief',
                        'active' => 'Actief',
                    ])
                    ->label('Huidige Status'),
                SelectFilter::make('author')->relationship('author', 'name')->label('Filter op Auteur')

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LessonRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/new'),
            'edit'   => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
        ];
    }
}
