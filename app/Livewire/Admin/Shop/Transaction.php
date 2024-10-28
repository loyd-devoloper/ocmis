<?php

namespace App\Livewire\Admin\Shop;

use Filament\Tables;
use Livewire\Component;
use App\Models\ShopOrder;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Transaction extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(ShopOrder::query()->with('userInfo'))
            ->heading('Shop Transaction')
            ->columns([
                TextColumn::make('id')->label('Ref'),
                TextColumn::make('total')->label('Price')->formatStateUsing(fn($state) => "₱$state"),

                TextColumn::make('userInfo.username')->label('User')->searchable(['username']),
                TextColumn::make('payment_method'),
                TextColumn::make('status')->color(fn($record) => match ($record->status) {
                    'Paid' => 'success', // Use a predefined color
                    'Cancelled' => 'danger',
                    'Not Paid' => 'warning',
                    default => '', // Default color if no match
                })->badge()->searchable(),
                TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        ViewField::make('rating')->view('livewire.customer.products.items')


                    ]),
                Action::make('approved')
                    ->color(Color::Green)->icon('heroicon-o-check')
                    ->hidden(fn($record) => $record->payment_method == 'Cash' ? false : true)
                    ->action(function ($record) {
                        \App\Models\OrderItem::where('order_id',$record->id)->update(['status'=>\App\Enums\StatusEnum::Paid->value]);
                        $record->update(['status' => \App\Enums\StatusEnum::Paid->value]);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    })->hidden(fn($record) => $record?->status == \App\Enums\StatusEnum::Paid->value ? true : false),
                Action::make('cancelled')->color(Color::Red)
                    ->icon('heroicon-o-x-mark')
                    ->hidden(fn($record) => $record->payment_method == 'Cash' || $record->status == \App\Enums\StatusEnum::Paid->value ? false : true)
                    ->action(function ($record) {
                        foreach (json_decode($record?->items) as $item) {
                            $product =  \App\Models\ShopProduct::where('id', $item->product_id)->first();
                            $product->update([
                                'quantity' => (int)$product->quantity + (int)$item->quantity
                            ]);
                        }
                        \App\Models\OrderItem::where('order_id',$record->id)->update(['status'=>\App\Enums\StatusEnum::Cancelled->value]);
                        $record->update(['status' => \App\Enums\StatusEnum::Cancelled->value]);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    })->hidden(fn($record) => $record?->status == \App\Enums\StatusEnum::Cancelled->value ? true : false),
            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.shop.transaction');
    }
}
