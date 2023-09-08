<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class LessonRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)->autofocus(),
                Select::make('status')
                    ->label('Status')
                    ->options(['active' => __('Actief'), 'inactive' => __('Inactief')]),
                RichEditor::make('description')->required(),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->maxLength(255),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
