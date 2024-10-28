<?php

namespace App\Livewire\Customer;

use Carbon\Carbon;
use Livewire\Component;

use Filament\Actions\Action;
use Jubaer\Zoom\Facades\Zoom;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class Memorial extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function modalFormAction()
    {
        return Action::make('modalForm')
            ->label('Add Memorial')
            ->color(Color::Blue)
            ->form([
                TextInput::make('deceased_name')->required(),
                Textarea::make('message')->required(),
                DateTimePicker::make('date_time') ->minDate(Carbon::now()->addDay(3)),
                Radio::make('payment_method')
                    ->options([
                        'Cash' => 'Cash',
                        'Gcash' => 'Gcash',

                    ])->default('Cash'),
                FileUpload::make('images')->image()
            ])
            ->action(function ($data) {
                $start_time = Carbon::parse($data['date_time'], 'Asia/Singapore')->toIso8601String();

                $time = Carbon::parse($data['date_time'])->format('Y-m-d\TH:i:s\Z');

                $meetings = Zoom::createMeeting([
                    'agenda' => $data['message'],
                    "topic" => $data['deceased_name'],
                    // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                    "timezone" => 'Asia/Singapore',
                    "pre_schedule" => false,

                    "start_time" => $start_time, // set your start time
                    "settings" => [
                        'join_before_host' => false, // if you want to join before host set true otherwise set false
                        'host_video' => false, // if you want to start video when host join set true otherwise set false
                        'participant_video' => false, // if you want to start video when participants join set true otherwise set false
                        'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
                        'waiting_room' => true, // if you want to use waiting room for participants set true otherwise set false
                        'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
                        'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
                        'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
                    ],

                ]);

               $memorialData = \App\Models\Memorial::create([
                    'payment_method' => $data['payment_method'],
                    'deceased_name' => $data['deceased_name'],
                    'message' => $data['message'],
                    'date_time' => $data['date_time'],
                    'link' => $meetings['data']['join_url'],
                    'password' => $meetings['data']['password'],
                    'price' => 1000,
                    'user_id' => Auth::id(),
                    'status' => \App\Enums\StatusEnum::NotPaid->value,
                    'images' => $data['images']
                ]);

                if($data['payment_method'] == 'Gcash')
                {
                    $checkout = Paymongo::checkout()->create([
                        'cancel_url' => route('memorial'),
                        'billing' => [
                            'name' => Auth::user()->fname." ".Auth::user()->mname." ".Auth::user()->lname,
                            'email' => Auth::user()->email,
                            'phone' => Auth::user()->contact,
                        ],
                        'description' =>$memorialData->id,
                        'line_items' => [
                            [
                                'amount' => 1000 * 100,
                                'currency' => 'PHP',

                                'name' => $data['deceased_name'],
                                'quantity' => 1
                            ]
                        ],
                        'payment_method_types' => [
                            'gcash',
                        ],
                        'success_url' =>route('my_memorial'),
                        'statement_descriptor' => 'OCMIS ONLINE PAYMENT',
                        'metadata' => [
                            'Key' => 'Value'
                        ]
                    ]);

                    $memorialData->update([
                        'payment_ref' => $checkout->getData()['id'],
                        'checkout_url'=>$checkout->getData()['checkout_url']
                    ]);
                    return $this->redirect($checkout->getData()['checkout_url']);
                }
                Notification::make()
                    ->title('Created successfully')
                    ->success()
                    ->send();
            });
    }

    #[Title('Memorial')]
    public function render()
    {
       if(Auth::check())
       {
        $memorials = \App\Models\Memorial::where('user_id',Auth::id())->orWhere('status',\App\Enums\StatusEnum::Paid->value)->get();
       }else{
        $memorials = \App\Models\Memorial::where('status',\App\Enums\StatusEnum::Paid->value)->get();
       }
        return view('livewire.customer.memorial', compact('memorials'));
    }
}
