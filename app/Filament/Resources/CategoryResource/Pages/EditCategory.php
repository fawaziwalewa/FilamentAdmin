<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Str;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make(3)->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('name')->autofocus()->reactive()->afterStateUpdated(function (Closure $set, $state) {
                                    $set('slug', Str::slug($state));
                                })->required(),

                                Forms\Components\TextInput::make('slug')->required(),

                                Select::make('parent')
                                        ->label('Parent')
                                        ->options(function (Closure $get) {
                                            $id = $get('id');

                                            return Category::where('id','!=', $id)->pluck('name', 'id');
                                        })->searchable()->columnSpan(2),

                                Toggle::make('visibility')->label('Visible to customers.')->columnSpan(2),
                                MarkdownEditor::make('description')->columnSpan(2),
                            ]),
                    ])->columnSpan(2),

                Card::make()
                    ->schema([
                        Placeholder::make('Created at')
                            ->content(function (Closure $get) {
                                if (!empty(Category::find($get('id')))) {
                                    $create_at = Category::find($get('id'))->created_at;

                                    return Carbon::parse($create_at)->subMinutes(2)->diffForHumans();
                                }
                            }),

                        Placeholder::make('Last modified at')->content(function (Closure $get) {
                            if (!empty(Category::find($get('id')))) {
                                $updated_at = Category::find($get('id'))->updated_at;

                                return Carbon::parse($updated_at)->subMinutes(2)->diffForHumans();
                            }
                        }),

                    ])->columnSpan(1),
            ]),
        ]);
    }
}
