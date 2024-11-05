<?php

namespace App\Livewire\Admin\Shop;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Actions\CreateAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Seller extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\ShopSeller::query())
            ->headerActions([
                Action::make('create')
                    ->label('Add Seller')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([
                        TextInput::make('name')->label('Supplier Name'),
                        TextInput::make('contact')->label('Contact Number'),
                        TextInput::make('address'),
                        Select::make('status')
                            ->options([
                                'Active' => 'Active',
                                'InActive' => 'InActive',
                            ])->default('1'),

                    ])
                    ->action(function ($data) {
                        \App\Models\ShopSeller::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                // TextColumn::make('id')->searchable(),

                TextColumn::make('name')->searchable(),
                TextColumn::make('contact')->searchable(),
                TextColumn::make('address')->searchable(),

                TextColumn::make('status'),
            ])

            ->actions([
                EditAction::make('edit')
                    ->label('Edit')

                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::Medium)

                    ->form([
                        TextInput::make('name')->label('Category Name'),
                        TextInput::make('contact')->label('Contact Number'),
                        TextInput::make('address'),
                        Select::make('status')
                            ->options([
                                'Active' => 'Active',
                                'InActive' => 'InActive',
                            ])->default('1'),


                    ])
                    ->action(function ($data, $record) {
                        $record->update($data);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make()
            ])
        ;
    }
    #[Title('Shop Seller')]
    public function render()
    {
        return view('livewire.admin.shop.seller');
    }
}
