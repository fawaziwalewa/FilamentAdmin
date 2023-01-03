<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
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
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),

                TextColumn::make('parent')->getStateUsing(function (Model $record): string {
                    if (!empty(Category::find($record->parent))) {
                        return Category::find($record->parent)->name;
                    }

                    return 'Not set';
                }),

                IconColumn::make('visibility')->boolean()->sortable(),
                TextColumn::make('updated_at')->dateTime('M d, Y')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
