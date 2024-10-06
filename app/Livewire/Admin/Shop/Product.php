<?php

namespace App\Livewire\Admin\Shop;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Actions\CreateAction;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
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

class Product extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\ShopProduct::query()->with('categoryInfo','SellerInfo'))
            ->headerActions([
                Action::make('create')
                    ->label('Add Product')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ExtraLarge)

                    ->form([
                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2
                        ])->schema([
                            Select::make('category_id')
                                ->label('Category')
                                ->options(\App\Models\ShopCategory::all()->pluck('name', 'id')),
                            TextInput::make('product_name'),
                            TextInput::make('price')->numeric(),
                            TextInput::make('quantity')->numeric(),
                            TextInput::make('description'),
                            Select::make('status')
                                ->options([
                                    'Active' => 'Active',
                                    'InActive' => 'InActive',
                                ])->default('1'),
                            Select::make('seller_id')
                                ->label('Seller')
                                ->options(\App\Models\ShopSeller::all()->pluck('name', 'id')),
                                FileUpload::make('image')->directory('/shop/product')->image(),
                        ])
                    ])
                    ->action(function ($data) {
                        \App\Models\ShopProduct::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('id')->searchable(),
                ImageColumn::make('image')->width(100)->height(100),
                TextColumn::make('product_name')->searchable(),
                TextColumn::make('categoryInfo.name')->label('Category'),
                TextColumn::make('sellerInfo.name')->label('Seller'),
                TextColumn::make('price'),
                TextColumn::make('quantity'),

                TextColumn::make('status'),

            ])

            ->actions([
                EditAction::make('edit')
                    ->label('Edit')

                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ExtraLarge)

                    ->form([
                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2
                        ])->schema([
                            Select::make('category_id')
                                ->label('Category')
                                ->options(\App\Models\ShopCategory::all()->pluck('name', 'id')),
                            TextInput::make('product_name'),
                            TextInput::make('price')->numeric(),
                            TextInput::make('quantity')->numeric(),
                            TextInput::make('description'),
                            Select::make('status')
                                ->options([
                                    'Active' => 'Active',
                                    'InActive' => 'InActive',
                                ])->default('1'),
                            Select::make('seller_id')
                                ->label('Seller')
                                ->options(\App\Models\ShopSeller::all()->pluck('name', 'id')),
                                FileUpload::make('image')->directory('/shop/product')->image(),
                        ])
                    ])
                    ->action(function ($data,$record) {
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
    #[Title('Shop - Product')]
    public function render()
    {
        return view('livewire.admin.shop.product');
    }
}
