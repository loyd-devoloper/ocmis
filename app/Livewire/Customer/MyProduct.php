<?php

namespace App\Livewire\Customer;

use Carbon\Carbon;
use Filament\Tables;
use Livewire\Component;
use App\Models\ShopOrder;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class MyProduct extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public function mount()
    {
        $orders = ShopOrder::query()->where('user_id', Auth::id())->where('payment_method', 'Gcash')->where('status', \App\Enums\StatusEnum::NotPaid->value)->get();
        foreach ($orders as $order) {
            if (!!$order?->payment_ref) {
                $checkout = Paymongo::checkout()->find($order->payment_ref);

                $order->update([
                    'status' => !!$checkout->getData()['payments'] ? \App\Enums\StatusEnum::Paid->value : \App\Enums\StatusEnum::NotPaid->value
                ]);
                Mail::to(Auth::user()->email)->send(new \App\Mail\SuccessPayment(Auth::user()->username,'Gcash',$order->total,$order->id,Carbon::parse($checkout->getData()['paid_at'])));
            }
        }
    }
    public function getViewData($record)
    {
        return [
            'rating' => $record->rating,
            // Add more data as needed
        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(ShopOrder::query()->where('user_id', Auth::id())->with('userInfo'))
            ->columns([
                TextColumn::make('id')->label('Ref'),
                TextColumn::make('total')->label('Price')->formatStateUsing(fn($state) => "₱$state"),

                TextColumn::make('userInfo.username')->label('User')->searchable(['username']),
                TextColumn::make('payment_method'),
                TextColumn::make('status')->color(fn ($record) => match ($record->status) {
                    'Paid' => 'success', // Use a predefined color
                    'Cancelled' => 'danger',
                    'Not Paid' => 'warning',
                    default => '', // Default color if no match
                })->badge(),
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
                Action::make('pay')
                    ->hidden(function ($record) {
                        if (!!$record->payment_ref) {

                            return $record->status == \App\Enums\StatusEnum::Paid->value || $record->status == \App\Enums\StatusEnum::Cancelled->value ? true : false;
                        } else {
                            return true;
                        }
                    })
                    ->icon('heroicon-o-banknotes')
                    ->color(Color::Green)
                    ->url(function ($record) {
                        if (!!$record->payment_ref) {
                            return $record->checkout_url;
                        } else {
                            return '#';
                        }
                    })->openUrlInNewTab(),
                Action::make('cancel')
                    ->color(Color::Red)
                    ->modalWidth(MaxWidth::Medium)
                    ->action(function ($data, $record) {
                        foreach (json_decode($record?->items) as $item) {
                            $product =  \App\Models\ShopProduct::where('id', $item->product_id)->first();
                            $product->update([
                                'quantity' => (int)$product->quantity + (int)$item->quantity
                            ]);
                        }
                        $record->update([
                            'status' => \App\Enums\StatusEnum::Cancelled->value
                        ]);

                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn($record) => $record?->status == \App\Enums\StatusEnum::Paid->value || $record?->status == \App\Enums\StatusEnum::Cancelled->value ? true : false),
            ])
        ;
    }

    public function render(): View
    {
        return view('livewire.customer.my-product');
    }
}
