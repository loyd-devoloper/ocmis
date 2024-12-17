<?php

namespace App\Livewire\Customer\Niche;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Notifications\Notification;

class Checkout extends Component
{
    public $niche = null;
    public $niche_id = '';
    public $newPrice = 0;
    public $perMonth = 0;
    public $downpayment = 10000;
    public $plan = 12;
    public $subtotal = 0;
    public $payment_method = 'Cash';
    public $payment_type = 'Full';


    // services
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
    public $service_price = 0;

    public $serviceArr = [];
    public $productArr = [];
    public function mount($niche_id)
    {

        $this->niche_id = $niche_id;
        $niche = \App\Models\Niche::with('buildingInfo')->where("id", $niche_id)->first();
        $this->newPrice = (float)$niche->price + (2.5 / 100 * (float)$niche->price);

        $this->perMonth = ($this->newPrice - $this->downpayment) / 3;

        $this->niche = $niche;

        // services
        // $this->service_id = 1;
        // $x = \App\Models\Category::where('id', 1)->first();
        // $this->service = $x;
        $this->schedules = \App\Models\PriestSchedule::where('status', 0)->get();
        $this->priests = \App\Models\Priest::where('status', 'Active')->get();
    }

    public function removeService()
    {
        $this->serviceArr = [];
    }
    public function submit()
    {

        $x = \App\Models\Category::where('id', $this->service_id)->first();
        $this->serviceArr = [
            'own_priest' => $this->own_priest,
            'service_id' => $this->service_id,
            'user_id' => Auth::id(),
            'message' => $this->message,
            'deceasedname' => $this->deceasedname,
            'status' => \App\Enums\StatusEnum::NotPaid->value,
            'image' => $x?->image,
            'name' => $x?->name,
            'price' => $x?->price,
        ];

        if ($this->own_priest) {
            $this->serviceArr['date'] = $this->date;
            $this->serviceArr['date_format'] = Carbon::parse($this->date)->format('F d, Y h:i:s A');
        } else {
            $priestInfo = \App\Models\Priest::where('id', $this->priest_id)->first();
            $schedule = \App\Models\PriestSchedule::where('id', $this->schedule)->first();
            $date = Carbon::parse($schedule->date)->format('F d, Y');
            $start = Carbon::parse($schedule->start_time)->format('h:i A');
            $end = Carbon::parse($schedule->end_time)->format('h:i A');
            $this->serviceArr['schedule_id'] = $this->schedule;
            $this->serviceArr['schedule_info'] = "$date $start TO $end";
            $this->serviceArr['priest_id'] = $this->priest_id;
            $this->serviceArr['priest_name'] = $priestInfo?->name;
        }
    }

    public function addToCart($product)
    {
        if (is_array($this->productArr)) {
        } else {

            $x = json_decode($this->productArr, true);
            $this->productArr = $x;
        }


        if (array_key_exists($product['id'], $this->productArr)) {
            $x =  $this->productArr[$product['id']];
            $x['quantitys'] = $x['quantitys'] + 1;
            $this->productArr[$product['id']] = $x;
        } else {
            $product['quantitys'] = 1;
            $this->productArr[$product['id']] = $product;
        }
    }

    public function checkout()
    {

        //

        if (count($this->serviceArr)) {
            $this->serviceArr['price'] = (float)$this->service_price;
        }
        $newProduct = [];
        $totalProduct = 0;
        foreach ($this->productArr as $key => $product) {
            if (!!$product) {
                $newProduct[$key] = $product;
                $totalProduct += (int)$product['price'];
            }
        }

        $niche = \App\Models\Niche::where('id', $this->niche_id)->update([
            'payment_method' => $this->payment_method,
            'payment_type' => $this->payment_type,
            'products' => json_encode($newProduct),
            'service' => json_encode($this->serviceArr),
            'price_checkout' => $this->newPrice,
            'total_paid' => 0,
            'customer_id' => Auth::id(),
            'status' => 'Pending',
            'plan' => $this->payment_type == 'Full' ? '' : $this->plan,
        ]);

        if (!!$newProduct) {

            // $orders = \App\Models\ShopOrder::create([
            //     'user_id' => Auth::id(),
            //     'status' => \App\Enums\StatusEnum::NotPaid->value,
            //     'payment_method' => $this->payment_method,
            //     'items' => json_encode($newProduct),
            //     'total' => $totalProduct
            // ]);
            $x = [];
            foreach ($newProduct as $product) {

                $x['name'] = $product['product_name'];
                $x['product_id'] = $product['category_id'];
                $x['price'] = $product['price'];
                $x['quantity'] = $product['quantitys'];
                $x['status'] = \App\Enums\StatusEnum::NotPaid->value;
                $x['amount'] = (int)$product['price'] * (int)$product['quantitys'];
                $x['user_id'] = Auth::id();
                $x['order_id'] = $this->niche_id;
                \App\Models\OrderItem::create($x);
            }
        }
        if ($this->payment_type == 'Installment') {
            \App\Models\NicheInstallment::where('niche_id', $this->niche_id)->delete();
            $x = 0;
            for ($i = (int)$this->plan; $i > 0; $i--) {
                $x++;
                $currentDate = Carbon::now();

                \App\Models\NicheInstallment::create([
                    'niche_id' => $this->niche_id,
                    'customer_id' => Auth::id(),
                    'price' => $this->perMonth,
                    'status' => \App\Enums\StatusEnum::NotPaid->value,
                    'date' => $currentDate->addMonths($x)->format('Y-m-d'),
                ]);
            }
            $inv = 'INV-' . date('Y') . '-' . str_pad($this->niche_id, 5, '0', STR_PAD_LEFT);
            \App\Models\Niche::where('id', $this->niche_id)->update([
                'ref_number' => $inv,
                'downpayment' => $this->downpayment
            ]);


        }


        if ($this->payment_method == 'Gcash') {
            $inv = 'INV-' . date('Y') . '-' . str_pad($this->niche_id, 5, '0', STR_PAD_LEFT);
            $level = $this->niche?->level;
            $niche_number = $this->niche?->niche_number;
            $checkout = Paymongo::checkout()->create([
                'cancel_url' => route('cart'),
                'billing' => [
                    'name' => Auth::user()->fname . " " . Auth::user()->mname . " " . Auth::user()->lname,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->contact,
                ],
                'description' => "Invoice No.:  $inv",
                'line_items' => [
                    ['amount' => $this->payment_type == 'Full' ? $this->subtotal * 100 : (float)$this->downpayment * 100, 'currency' => 'PHP', 'name' => "Niche $level - $niche_number", 'quantity' => 1]
                ],
                'payment_method_types' => [
                    'gcash'

                ],
                'success_url' => route('my_niche'),
                'statement_descriptor' => 'OCMIS ONLINE PAYMENT',
                'metadata' => [
                    'Key' => 'Value'
                ]
            ]);

            \App\Models\Niche::where('id', $this->niche_id)->update([
                'payment_ref' => $checkout->getData()['id'],
                'checkout_url' => $checkout->getData()['checkout_url']
            ]);

            return $this->redirect($checkout->getData()['checkout_url']);
        } else {
            Notification::make()
                ->title('Submitted successfully')
                ->success()
                ->send();
            return $this->redirect(route('my_niche'));
        }
    }
    public function changeQuantitys($type, $ShopProduct)
    {
        $x = \App\Models\ShopProduct::where('id', $ShopProduct)->first();


        $x->update([
            'quantity' => $type == 'plus' ? (int)$x?->quantity - 1 : (int)$x?->quantity + 1
        ]);
        return redirect()->route('niches.payment.checkout', ['niche_id' => $this->niche_id]);
    }
    public function servicePrice($service_id)
    {
        $price = \App\Models\Category::where('id', $service_id)->first();
        return $price->price;
    }
    public function render()
    {
        $aLLServices = \App\Models\Category::get();
        $serviceArray = $this->serviceArr;
        $products = \App\Models\ShopProduct::with('categoryInfo')->get();


        return view('livewire.customer.niche.checkout', compact('aLLServices', 'serviceArray', 'products'));
    }
}
