<?php

namespace App\Livewire\Customer\Services;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class PaymentPage extends Component
{

    public $service = [];
    public $schedules = [];
    public $priests = [];

    public $own_priest = false;
    public $date;
    public $priest_id;
    public $message;
    public $deceasedname;
    public $schedule;
    public $service_id;
    public $payment_method = 'Cash';
    public function mount($service_id)
    {
        $this->service_id = $service_id;
        $x = \App\Models\Category::where('id', $service_id)->first();
        $this->service = $x;
        $this->schedules = \App\Models\PriestSchedule::where('status', 0)->get();
        $this->priests = \App\Models\Priest::where('status', 'Active')->get();
    }
    public function submit()
    {
        $createservice = \App\Models\UserService::create([
            'own_priest' => $this->own_priest,
            'service_id' => $this->service_id,
            'user_id' => Auth::id(),
            'message' => $this->message,
            'deceasedname' => $this->deceasedname,
            'payment_method' => $this->payment_method,
            'status' => \App\Enums\StatusEnum::NotPaid->value,
            'price' => (float)$this->service['price'],
        ]);

        if ($this->own_priest) {
            $createservice->update([
                'date' => $this->date,
            ]);
        } else {
            $createservice->update([
                'schedule_id' => $this->schedule,
                'priest_id' => $this->priest_id,
            ]);
        }
        if ($this->payment_method == 'Gcash') {
            $checkout = Paymongo::checkout()->create([
                'cancel_url' => route('services.payment', ['service_id' => $this->service_id]),
                'billing' => [
                    'name' => Auth::user()->fname . " " . Auth::user()->mname . " " . Auth::user()->lname,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->contact,
                ],
                'description' => $createservice->id,
                'line_items' => [
                    [
                        'amount' => (float)$this->service['price'] * 100,
                        'currency' => 'PHP',

                        'name' => $this->service['name'],
                        'quantity' => 1
                    ]
                ],
                'payment_method_types' => [

                    'gcash',

                    'paymaya'
                ],
                'success_url' => route('my_transaction'),
                'statement_descriptor' => 'OCMIS ONLINE PAYMENT',
                'metadata' => [
                    'Key' => 'Value'
                ]
            ]);

            $createservice->update([
                'payment_ref' => $checkout->getData()['id'],
                'checkout_url' => $checkout->getData()['checkout_url']
            ]);
            return $this->redirect($checkout->getData()['checkout_url']);
        }
        Notification::make()
        ->title('Submitted successfully')
        ->success()
        ->send();
        return $this->redirectRoute('my_transaction');
    }
    #[Title('Service')]
    public function render()
    {
        return view('livewire.customer.services.payment-page');
    }
}
