<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

use Str;
use Closure;
use Carbon\Carbon;
use Filament\Forms;
use App\Models\Customer;
use Filament\Resources\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DatePicker;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

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
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\TextInput::make('email')->email()->required(),
                                    Forms\Components\TextInput::make('phone')->tel(),
                                    DatePicker::make('birthday')->displayFormat('M d, Y'),
                                ]),
                            ])->columnSpan(2),
                            
                    Card::make()
                        ->schema([
                            Placeholder::make('Created at')
                                ->content(function(Closure $get){
                                   if (!empty(Customer::find($get('id')))) {
                                        $create_at = Customer::find($get('id'))->created_at;
                                        return Carbon::parse($create_at)->subMinutes(2)->diffForHumans();
                                   }
                                }),
                                
                            Placeholder::make('Last modified at') ->content(function(Closure $get){
                                if (!empty(Customer::find($get('id')))) {
                                    $updated_at = Customer::find($get('id'))->updated_at;
                                    return Carbon::parse($updated_at)->subMinutes(2)->diffForHumans();
                                }
                            }),
                        ])->columnSpan(1),
                ])
            ]);
    }
}
