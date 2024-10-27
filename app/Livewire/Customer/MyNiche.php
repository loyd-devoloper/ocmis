<?php

namespace App\Livewire\Customer;

use Filament\Tables;
use App\Models\Niche;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use SebastianBergmann\Type\TrueType;

class MyNiche extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount()
    {
        $orders = Niche::query()->where('customer_id', Auth::id())->where('payment_method', 'Gcash')->where('status', 'Pending')->get();
        foreach ($orders as $order) {
            if (!!$order?->payment_ref) {
                $checkout = Paymongo::checkout()->find($order->payment_ref);

                if ($order->payment_type == 'Full') {
                    $order->update([
                        'status' => !!$checkout->getData()['payments'] ? 'Occupied' : 'Pending',
                        'total_paid' => !!$checkout->getData()['payments'] ? $order->price_checkout : 0,
                    ]);
                } else {
                    $order->update([
                        'status' => !!$checkout->getData()['payments'] ? 'Occupied' : 'Pending',
                        'total_paid' => !!$checkout->getData()['payments'] ? 10000 : 0,
                    ]);
                }
            }
        }
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Niche::query()->with(['buildingInfo', 'customerInfo', 'installments'])->where('customer_id', Auth::id()))

            ->columns([
                TextColumn::make('id')->searchable(),
                ImageColumn::make('image')->width(50)->height(50),
                TextColumn::make('buildingInfo.name')->label('Buinding Name')->searchable(),
                TextColumn::make('niche_number'),
                TextColumn::make('capacity'),
                TextColumn::make('status'),
                TextColumn::make('level'),

                TextColumn::make('payment_method'),
                TextColumn::make('payment_type'),
                TextColumn::make('plan')->formatStateUsing(fn($state) => "$state Months")

                ,

                TextColumn::make('price')->label('Niche Price'),
                TextColumn::make('price_checkout')->label('Total'),
                TextColumn::make('total_paid')->label('Total Paid'),


            ])

            ->actions([
                ViewAction::make()
                    ->form([
                        ViewField::make('rating')->view('livewire.customer.niche.items')


                    ]),
                Action::make('pay')
                    ->hidden(function ($record) {
                        if (!!$record->payment_ref) {

                            return $record->status == 'Occupied' || $record->status == 'Cancelled' ? true : false;
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
                    ->icon('heroicon-o-x-mark')
                    ->color(Color::Red)
                    ->action(function ($record) {})
            ]);
    }

    public function render(): View
    {
        return view('livewire.customer.my-niche');
    }
}
