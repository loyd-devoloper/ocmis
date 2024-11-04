<?php

namespace App\Livewire\Customer;


use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class MyMemorial extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public function mount() {
        $orders = \App\Models\Memorial::query()->where('user_id',Auth::id())->where('payment_method','Gcash')->where('status',\App\Enums\StatusEnum::NotPaid->value)->get();
        foreach($orders as $order)
        {
             $checkout = Paymongo::checkout()->find($order->payment_ref);

            $order->update([
                'status'=> !!$checkout->getData()['payments'] ? \App\Enums\StatusEnum::Paid->value : \App\Enums\StatusEnum::NotPaid->value
            ]);
            // if(!!$checkout->getData()['payments'])
            // {
            // Mail::to(Auth::user()->email)->send(new \App\Mail\SuccessPayment(Auth::user()->username,'Gcash',$order->price,$order->id,Carbon::parse($checkout->getData()['paid_at'])));

            // }
        }

    }
    public function table(Table $table): Table
    {
        return $table
            ->query( \App\Models\Memorial::query()->where('user_id',Auth::id()))
            ->columns([
                TextColumn::make('id'),

                TextColumn::make('deceased_name'),
                TextColumn::make('message'),
                TextColumn::make('price')->state('10000'),
                TextColumn::make('payment_method'),
                TextColumn::make('date_time')->state(function($record){
                    if($record->own_priest)
                    {
                        $date = Carbon::parse($record->date)->format('F d, Y h:i:s A');
                    }else{
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
                ->action(function ($data,$record) {
                   $record->update([
                    'status'=>\App\Enums\StatusEnum::Cancelled->value
                   ]);
                    Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                }),
            ])
           ;
    }

    public function render(): View
    {
        return view('livewire.customer.my-memorial');
    }
}
