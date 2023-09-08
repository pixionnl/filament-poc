<?php

namespace App\Filament\Resources\CourseResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseResource\Widgets\CourseCount;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nieuwe Cursus'),

            Action::make('sendEmail')
                ->label('Mail alle deelnemers')
                ->form([
                    TextInput::make('subject')->required(),
                    RichEditor::make('body')->required(),
                ])
                ->action(function (array $data) {
                    logger()->info($data);
                })
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }
}
