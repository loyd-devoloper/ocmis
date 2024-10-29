<?php

namespace App\Livewire\Customer;

use Carbon\Carbon;
use Livewire\Component;

use Filament\Tables\Table;
use App\Models\Shop\Product;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class MyTransaction extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function mount()
    {
        $orders = \App\Models\UserService::query()->where('user_id', Auth::id())->where('payment_method', 'Gcash')->where('status', \App\Enums\StatusEnum::NotPaid->value)->get();
        foreach ($orders as $order) {
            if (!!$order?->payment_ref) {
                $checkout = Paymongo::checkout()->find($order->payment_ref);

                $order->update([
                    'status' => !!$checkout->getData()['payments'] ? \App\Enums\StatusEnum::Paid->value : \App\Enums\StatusEnum::NotPaid->value
                ]);
                Mail::to(Auth::user()->email)->send(new \App\Mail\SuccessPayment(Auth::user()->username,'Gcash',$order->price,$order->id,Carbon::parse($checkout->getData()['paid_at'])));
            }
        }
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\UserService::query()->with(['category', 'userInfo', 'schedule', 'priest'])->where('user_id', Auth::id())->orderByDesc('id'))
            ->columns([
                TextColumn::make('id'),

                TextColumn::make('category.name'),
                TextColumn::make('category.price'),
                TextColumn::make('priest')->state(fn($record) => !!$record->priest_id ? $record?->priest?->name : 'Own Priest'),
                TextColumn::make('userInfo.username')->label('User')->searchable(['username']),
                TextColumn::make('date')->state(function ($record) {
                    if ($record->own_priest) {
                        $date = Carbon::parse($record->date)->format('F d, Y h:i:s A');
                    } else {
                        $mydate = Carbon::parse($record->schedule?->date)->format('F d, Y');
                        $mytime = Carbon::parse($record->schedule?->start_time)->format('h:i:s A');
                        $date = "$mydate $mytime";
                    }
                    return $date;
                }),
                TextColumn::make('status')->searchable(),
            ])

            ->actions([
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
                ->url(function($record){
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
                        $record->update([
                            'status' => \App\Enums\StatusEnum::Cancelled->value
                        ]);
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    })->hidden(fn($record) => $record?->status == \App\Enums\StatusEnum::Paid->value ? true : false),

            ])
        ;
    }
    #[Title('My Transaction')]
    public function render()
    {
        return view('livewire.customer.my-transaction');
    }
}
