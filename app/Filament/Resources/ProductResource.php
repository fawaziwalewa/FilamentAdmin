<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\Repeater;

use Livewire\TemporaryUploadedFile;
use Str;
use Closure;

use App\Filament\Resources\ProductResource;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Grid::make('2')->schema([
                        Card::make([
                            Forms\Components\TextInput::make('name')->autofocus()->reactive()->afterStateUpdated(function(Closure $set, $state){
                                $set('slug', Str::slug($state));
                            })->required(),
                    
                            Forms\Components\TextInput::make('slug')->required(),
                           
                            MarkdownEditor::make('description')->columnSpan(2),
                        ]),
    
                        Section::make('Images')
                            ->schema([
                                Repeater::make('product_images')
                                    ->relationship('product_images')
                                    ->schema([
                                        FileUpLoad::make('image')
                                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                            return (string) 'images/'.Str::random(10).'-'.$file->getClientOriginalName();
                                        })->image()->maxSize(4096)->label('')->maxFiles(4),
                                    ]),
                                    ])->collapsible(),
                                    

                        Section::make('Pricing')
                            ->schema([
                                Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('price')->numeric()->required()->columnSpan(1),
                                    Forms\Components\TextInput::make('compare_at_price')->numeric()->required()->columnSpan(1),
                                    Forms\Components\TextInput::make('cost_per_item')->numeric()->required()->helperText("Products won't see this price.")->columnSpan(1),
                                ]),
                            ]),

                        Section::make('Inventory')
                            ->schema([
                                Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('sku')->label('SKU (Stock Keeping Unit)')->numeric()->required()->columnSpan(1),
                                    Forms\Components\TextInput::make('barcode')->label('Barcode (ISBN, UPC, GTIN, etc.)')->numeric()->required()->columnSpan(1),
                                    Forms\Components\TextInput::make('quantity')->numeric()->required()->columnSpan(1),
                                    Forms\Components\TextInput::make('security_stock')->numeric()->required()->helperText("The safety stock is the limit stock for your products which alerts you if the product stock will soon be out of stock.")->columnSpan(1),
                                ]),
                            ]),

                        Section::make('Shipping')
                            ->schema([
                                Grid::make(2)->schema([
                                    Checkbox::make('returnable')->label('This product can be returned.'),
                                    Checkbox::make('shipped')->label('This product will be shipped.')
                                ]),
                            ]),

                    ])->columnSpan(2),

                    Grid::make(1)->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('visibility')->label('Visible')->default(1)->helperText('This product will be hidden from all sales channels.'),
                                DatePicker::make('availability')->displayFormat('M d, Y')->default(now()),
                            ]),
                        Section::make('Associations')
                            ->schema([
                                Select::make('brands')
                                ->options(Category::all()->pluck('name', 'id'))->searchable(),

                                Select::make('categories')
                                ->options(Category::all()->pluck('name', 'id'))->multiple()->required()->searchable(), 
                            ]),
                        ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('Image')->view('tables.columns.product-image-column'),
                TextColumn::make('name')->searchable(['name','brand', 'price', 'sku'])->sortable(),
                TextColumn::make('brands')->toggleable()->sortable(),
                TextColumn::make('price')->sortable(),
                TextColumn::make('sku')->toggleable()->sortable(),
                TextColumn::make('quantity')->label('Qty')->toggleable()->sortable(),
                TextColumn::make('security_stock')->toggleable()->sortable(),
                IconColumn::make('visibility')->boolean()->toggleable()->sortable(),
                TextColumn::make('created_at')->label('Published Date')->dateTime('M d, Y')->toggleable()->sortable(),
            ])
            ->filters([
                
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
            CommentResource\RelationManagers\CommentsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProductResource\Widgets\ProductStatsOverview::class,
        ];
    }
}
