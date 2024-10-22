<div>
    <x-customer.header>




        <section class=" w-full" x-data="dropdown(@js($schedules), @entangle('serviceArr'), @entangle('productArr'))">
            <div class="py-8" wire:ignore>
                <div class="container mx-auto px-4">

                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="md:w-3/4 grid grid-cols-1 lg:grid-cols-2 gap-10">
                            <div class="bg-white rounded-lg shadow-md px-6 pb-6 pt-2 mb-4">
                                <h1 class="text-2xl font-semibold mb-4">Niche</h1>
                                <div class="flex gap-10">
                                    <img src="{{ asset('storage/' . $niche->image) }}"
                                        class="min-h-[4rem] rounded-md  max-w-[4rem] min-w-[4rem] max-h-[4rem]"
                                        alt="">
                                    <div class="text-sm">
                                        <p> <span class="font-bold">Niche Number: </span>{{ $niche->level }} -
                                            {{ $niche->niche_number }}</p>
                                        <p><span class="font-bold">Price: </span> ₱{{ number_format($niche?->price) }}
                                        </p>
                                        <p><span class="font-bold">Payment Type: </span> {{ $payment_method }}</p>
                                        @if ($payment_method == 'Installment')
                                            <p><span class="font-bold">New Price (Price + 2%): </span>
                                                {{ $newPrice }}</p>
                                            <p><span class="font-bold">Down Payment: </span>
                                                {{ number_format($downpayment) }}</p>
                                            <p><span class="font-bold">Montly Dues for 3 Months: </span>
                                                {{ number_format($perMonth) }}</p>
                                        @endif

                                    </div>
                                </div>
                                <div class="pt-2">
                                    <hr class=" content-black">
                                    <p class="float-right">Total:
                                        {{ $payment_method == 'Installment' ? number_format($downpayment) : number_format($niche?->price) }}
                                    </p>
                                </div>
                            </div>
                            {{-- service --}}
                            <div class="bg-white rounded-lg shadow-md px-6 pb-6 pt-2 mb-4">
                                <h1 class="text-2xl font-semibold mb-4">Services</h1>
                                <label x-show="serviceArr.length == 0" for="my_modal_6" class="btn"
                                    class="flex items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Add Services
                                </label>

                                <div x-show="serviceArr?.deceasedname" x-cloak class="flex gap-10">
                                    <div>
                                        <img src="{{ asset('storage/' . $niche->image) }}"
                                            class="min-h-[4rem] rounded-md  max-w-[4rem] min-w-[4rem] max-h-[4rem]"
                                            alt="">
                                        <button wire:click="removeService">Delete</button>
                                    </div>
                                    <div class="text-sm">
                                        <p> <span class="font-bold">Deceased Name: </span><span
                                                x-text="serviceArr?.deceasedname"></span></p>
                                        <p><span class="font-bold">Message: </span>
                                            <span x-text="serviceArr?.message"></span>
                                        </p>
                                        <p><span class="font-bold">Own Priest: </span> <span
                                                x-text="serviceArr?.own_priest ? 'Yes' : 'No'"></span></p>
                                        <p x-show="serviceArr?.own_priest == false"><span class="font-bold">Priest Name:
                                            </span> <span x-text="serviceArr?.priest_name"></span></p>
                                        <p x-show="serviceArr?.own_priest"><span class="font-bold">Schedule: </span>
                                            <span x-text="serviceArr?.date_format"></span>
                                        </p>

                                        <p x-show="serviceArr?.own_priest == false"><span class="font-bold">Schedule:
                                            </span> <span x-text="serviceArr?.schedule_info"></span></p>


                                    </div>
                                </div>
                                <div x-show="serviceArr?.deceasedname" x-cloak class="pt-2">
                                    <hr class=" content-black">
                                    <p class="float-right">Total:
                                        {{ number_format(10000) }}
                                    </p>
                                </div>
                                {{-- <div class="pt-2">
                                    <hr class=" content-black">
                                    <p class="float-right">Total: {{ $payment_method == 'Installment' ? number_format($downpayment) : number_format($niche?->price) }}</p>
                                   </div> --}}
                            </div>
                            {{-- product --}}
                            <div class="bg-white rounded-lg shadow-md px-6 pb-6 pt-2 mb-4 col-span-1 lg:col-span-2">
                                <h1 class="text-2xl font-semibold mb-4">Products</h1>
                                <label for="modalProduct" class="btn" class="flex items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Add Product
                                </label>

                                <div class="shadow-lg rounded-lg overflow-hidden mt-2">
                                    <table class="w-full table-fixed">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                    Product</th>
                                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                    Quantity</th>
                                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                    Price</th>
                                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">

                                            <template x-for="(product,index) in productArr">


                                                <tr x-show="!!product">
                                                    <td class="py-4 px-6 border-b border-gray-200"
                                                        x-text="product?.product_name">John Doe</td>
                                                    {{-- <td class="py-4 px-6 border-b border-gray-200 truncate"
                                                        x-text="product?.quantitys">johndoe@gmail.com</td> --}}
                                                    <td class="py-4 px-6 border-b border-gray-200 truncate">
                                                        <div class="flex items-center">

                                                            <button x-on:click="changeQuantity(product,'minus')"
                                                                :disabled="product.quantitys < 2"
                                                                class="border rounded-md py-2 px-4 mr-2">-</button>
                                                            <span class="text-center w-8"
                                                                x-text="product?.quantitys"></span>
                                                            <button x-on:click="changeQuantity(product,'plus')"
                                                                class="border rounded-md py-2 px-4 ml-2">+</button>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 border-b border-gray-200"
                                                        x-text="product?.price">555-555-5555</td>
                                                    <td class="py-4 px-6 border-b border-gray-200">
                                                        <x-filament::icon-button icon="heroicon-m-trash" color="danger"
                                                            x-on:click="removeProduct(product)" label="New label" />
                                                    </td>
                                                </tr>
                                            </template>
                                            <!-- Add more rows here -->
                                        </tbody>
                                        <tfoot class="bg-white">

                                            <tr class="bg-gray-100">
                                                <td class="py-4 px-6 border-b border-gray-200"></td>
                                                <td class="py-4 px-6 border-b border-gray-200"></td>
                                                <td class="py-4 px-6 border-b border-gray-200"><strong>Total</strong>
                                                </td>
                                                <td class="py-4 px-6 border-b border-gray-200"><strong
                                                        x-text="'₱'+productTotal"></strong></td>

                                            </tr>
                                            </tbody>
                                    </table>
                                </div>
                                {{-- <div class="pt-2">
                                    <hr class=" content-black">
                                    <p class="float-right">Total: {{ $payment_method == 'Installment' ? number_format($downpayment) : number_format($niche?->price) }}</p>
                                   </div> --}}
                            </div>
                        </div>
                        <form wire:submit="checkout" class="md:w-1/4">
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h2 class="text-lg font-semibold mb-4">Summary</h2>

                                <h1 class="text-xs">PAYMENT METHOD</h1>
                                <div class="form-control w-fit space-x-2 text-xs">
                                    <label class="label cursor-pointer">

                                        <input type="radio" name="radio-10" wire:model="payment_method"
                                            value="Cash" class="radio radio-xs mr-1" />Cash
                                    </label>
                                </div>
                                <div class="form-control w-fit space-x-2 text-xs">
                                    <label class="label cursor-pointer">

                                        <input type="radio" name="radio-10" wire:model="payment_method"
                                            value="Gcash" class="radio radio-xs  mr-1" checked="checked" />Gcash
                                    </label>
                                </div>
                                <hr class="my-2">
                                <div class="flex justify-between mb-2">
                                    <span class="font-semibold">Total</span>
                                    <span class="font-semibold">₱1222</span>
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Open the modal using ID.showModal() method -->


            <input type="checkbox" id="my_modal_6" x-model="my_modal_6" class="modal-toggle" />
            <div x-ref="modal" class="modal  " wire:ignore>

                <form x-cloak wire:submit="submit" class="w-11/12 max-w-2xl modal-box">
                    <h3 class="text-lg font-bold">Invoice</h3>
                    <section>


                        <div class="p-4 space-y-4">
                            <label class="form-control w-full ">

                                <span class="label-text">SERVICES</span>

                                <select wire:model="service_id" class="select select-bordered">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach ($aLLServices as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>

                            </label>
                            <label class="form-control w-full ">

                                <span class="label-text"> DECEASED NAME: </span>
                                <input type="text" placeholder="Type here" class="input input-bordered w-full "
                                    x-model="service.deceased_name" wire:model="deceasedname" required />

                            </label>
                            <label class="form-control w-full ">
                                <span class="label-text"> MESSAGE: </span>
                                <textarea placeholder="Type here" class="textarea textarea-bordered h-24" wire:model="message" required></textarea>
                            </label>

                            <div class="flex items-center gap-1">
                                <label for="ownPriest" class="label-text ">Own Priest: </label>
                                <input type="checkbox" x-model="own_priest" id="ownPriest"
                                    wire:model="own_priest" />
                            </div>
                            <div x-show="own_priest" class="mb-3">
                                <label>Schedule: </label>
                                <input type="datetime-local" wire:model="date" class="form-control"
                                    :required="own_priest == true ? true : false">
                            </div>

                            <div x-show="own_priest == false" class="mb-3" id="priestDropdown">
                                <label for="priest" class="form-label">Priest</label>
                                <select x-model="priest" wire:model="priest_id" id="priest" class="form-select"
                                    :required="own_priest == false ? true : false">
                                    <option value="" selected>-- Select --</option>
                                    @foreach ($priests as $priest)
                                        <option value="{{ $priest->id }}">Fr. {{ $priest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div x-show="showSched && own_priest == false" class="mb-3" id="priestDropdown">
                                <label for="priest" class="form-label">Priest Schedules <span
                                        class="text-secondary">(Date -- Start Time TO End Time)</span></label>
                                <select class="form-select" wire:model="schedule" id="priest"
                                    :required="own_priest == false ? true : false">
                                    <option value="" selected>-- Select --</option>


                                    <template x-for="(v,i) in sched || []" x-key="i">
                                        <option :value="v.id"
                                            x-text="changeName(v.date,v.start_time,v.end_time)"></option>
                                    </template>
                                </select>
                            </div>


                        </div>
                    </section>

                    <div class="modal-action">
                        <button class="btn btn-primary btn-md" x-on:click="my_modal_6 = !my_modal_6">Submit</button>
                        <label for="my_modal_6" class="btn">Close!</label>
                    </div>
                </form>
            </div>

            <input type="checkbox" id="modalProduct" x-model="modalProduct" class="modal-toggle" />
            <div x-ref="modal" class="modal  " wire:ignore>

                <form x-cloak wire:submit="submit" class="w-11/12 max-w-6xl modal-box">


                    <label for="modalProduct" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>

                    <h3 class="text-lg font-bold">Invoice</h3>
                    <section>
                        <div class="grid grid-cols-3 max-w-screen-lg  mx-auto py-10 gap-10">
                            @foreach ($products as $product)
                                <div class="card bg-base-100  shadow-xl">
                                    <figure>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Shoes" />
                                    </figure>
                                    <div class="card-body">
                                        <h2 class="card-title">{{ $product->product_name }}</h2>
                                        <p>Stock: {{ $product->quantity }}</p>
                                        <p>₱{{ $product->price }}</p>

                                        <div class="card-actions justify-end">
                                            <button type="button" x-on:click="addProduct({{ $product }})"
                                                class="btn border border-primary bg-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <div class="modal-action">

                        <label for="modalProduct" class="btn">Close</label>
                    </div>
                </form>
            </div>

        </section>

    </x-customer.header>
</div>

@script
    <script>
        Alpine.data('dropdown', (schedules, serviceArr, productArr) => ({
            open: false,
            my_modal_6: false,
            modalProduct: false,
            schedules: schedules,
            own_priest: false,
            priest: '',
            sched: [],
            showSched: false,
            serviceModal: false,
            service: {
                service: '',
                message: 'ss',
                deceased_name: ''
            },
            serviceArr: serviceArr,
            productArr: [],
            productTotal: 0,
            productNewArr: [],
            changeName(date, start, end) {

                return `${date} -- ${this.changeTIme(start)} TO ${this.changeTIme(end)}`;
            },
            removeProduct(product) {
                this.productArr = this.productArr.filter((val) => {

                    if (!!val) {
                        return val.id != product.id;
                    } else {
                        return val;
                    }
                })
                var self = this;
                    this.productTotal = 0;
                    this.productArr.filter((val) => {

                        if(!!val)
                       {
                        self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                       }
                        return val;
                    })
            },
            addProduct(product) {


                if (!!this.productArr[product.id]) {


                    var x = this.productArr[product.id];
                    this.productArr[product.id]['quantitys'] = x.quantitys + 1;
                    this.productArr[product.id] = x;
                    var self = this;
                    this.productTotal = 0;
                    this.productArr.filter((val) => {

                        if(!!val)
                       {
                        self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                       }
                        return val;
                    })

                } else {
                    product['quantitys'] = 1;
                    this.productArr[product.id] = product;
                }

            },
            changeTIme(time) {
                var timeArray = time.split(':');
                var hours = parseInt(timeArray[0], 10);
                var minutes = parseInt(timeArray[1], 10);

                // Determining AM or PM
                var period = (hours >= 12) ? "PM" : "AM";

                // Converting hours to 12-hour format
                hours = (hours > 12) ? hours - 12 : hours;
                hours = (hours == 0) ? 12 : hours;

                // Creating the 12-hour time string
                var time12Hour = hours.toString().padStart(2, '0') + ':' + minutes.toString()
                    .padStart(2, '0') + ' ' + period;

                return time12Hour;
            },
            submit() {
                console.log(this.service)
            },
            changeQuantity(product, type) {
                if (!!this.productArr[product.id]) {


                    if (type == 'minus') {
                        var x = this.productArr[product.id];
                        this.productArr[product.id]['quantitys'] = x.quantitys - 1;
                        this.productArr[product.id] = x;

                    } else {
                        var x = this.productArr[product.id];
                        this.productArr[product.id]['quantitys'] = x.quantitys + 1;

                        this.productArr[product.id] = x;
                    }
                    var self = this;
                    this.productTotal = 0;
                    this.productArr.filter((val) => {

                        if(!!val)
                       {
                        self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                       }
                        return val;
                    })
                }
            },
            init() {

                if (localStorage.getItem('service') !== null) {

                    this.serviceArr = JSON.parse(localStorage.getItem('service'))
                    // $wire.set('products', JSON.parse(this.productArr))
                }
                if (localStorage.getItem('products') !== null) {

                    this.productArr = JSON.parse(localStorage.getItem('products'))
                    var self = this;
                    this.productTotal = 0;
                    this.productArr.filter((val) => {

                        if(!!val)
                       {
                        self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                       }
                        return val;
                    })


                }


                this.$watch('serviceArr', function(val) {


                    if (val.length == 0) {
                        localStorage.removeItem("service");
                    } else {
                        localStorage.setItem('service', JSON.stringify(val))
                    }

                })
                this.$watch('productArr', function(val) {
                    if (val.length == 0) {
                        localStorage.removeItem("products");
                    } else {
                        localStorage.setItem('products', JSON.stringify(val))
                        this.productArr = JSON.stringify(val);

                        // $wire.set('productArr', JSON.parse(this.productArr))
                        // $wire.set('serviceArr', JSON.parse(this.productArr))
                    }

                })
                var self = this;

                this.$watch('service.priest', (value) => {
                    console.log(value)
                    if (!!value) {
                        self.showSched = [];

                        var x = self.schedules.filter((val) => {
                            return val.priest_id == value;
                        })
                        self.sched = x;
                        self.showSched = true;


                    } else {
                        self.showSched = [];
                        self.showSched = false;

                    }
                })



            }
        }))
    </script>
@endscript
