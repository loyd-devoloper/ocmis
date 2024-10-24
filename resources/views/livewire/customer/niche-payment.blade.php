<div>
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">Ocmis Services</p>
                <p class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        {{-- section --}}
        <section class="p-10" x-data="dropdown(@js($schedules), @entangle('serviceArr'), @entangle('productArr'))">


            <form class="card bg-white max-w-screen-sm mx-auto p-4 space-y-2">
                <img src="{{ asset('storage/' . $niche->image) }}"
                    class="min-h-[8rem] mx-auto max-w-[8rem] min-w-[8rem] max-h-[8rem]" alt="">
                <p class="text-center border border-black p-2 rounded">{{ $niche->level }} - {{ $niche->niche_number }}
                </p>
                <p class="text-center border border-black p-2 rounded">₱{{ $niche?->price }}</p>
                <article>
                    <h5>Description</h5>
                    <div class="px-3 py-2">
                        {!! $niche?->description !!}
                    </div>
                </article>
                <div class="grid grid-cols-2 gap-10">
                    <label for="my_modal_6" class="btn" class="flex items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Services
                    </label>

                    <div>
                        <label for="modalProduct" class="btn" class="flex items-center">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add Product
                        </label>
                        <label for="items" class="btn" class="flex items-center">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        items
                        </label>

                    </div>
                </div>
                {{-- <div x-data="{payment_method: 'Full'}">
                    <p class="text-xs">PAYMENT TYPE </p>

                    <input type="radio" wire:model.live="payment_method" x-model="payment_method" value="Full" class="radio  radio-xs"  /> <span
                        class="text-sm">Full</span>
                    <br>
                    <input type="radio" wire:model.live="payment_method" x-model="payment_method" value="Installment" class="radio  radio-xs" /><span class="text-sm">
                        Installment</span>
                       <div x-show="payment_method == 'Installment'" x-cloak x-transition>
                        <hr class="my-2">

                        <label class="form-control w-full max-w-xs">
                            <span class="label-text">New Price (price + 2%)</span>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs bg-gray-100"
                                value="{{ number_format($newPrice) }}" readonly />
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <span class="label-text">Down Payment</span>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs bg-gray-100"
                                value="{{ number_format($downpayment) }}" readonly />
                        </label>
                        <label class="form-control w-full max-w-xs">
                            <span class="label-text">Montly Dues for 3 Months</span>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs bg-gray-100"
                                value="{{ number_format($perMonth) }}" readonly />
                        </label>
                    </div>
                </div> --}}
                <a class="btn btn-primary btn-md" type="button"
                    href="{{ route('niches.payment.checkout', ['niche_id' => $niche_id, 'type' => $payment_method]) }}">Submit</a>
            </form>


            <input type="checkbox" id="my_modal_6" x-model="my_modal_6" class="modal-toggle" />
            <div x-ref="modal" class="modal  " wire:ignore>

                <form x-on:submit.prevent="submit" x-cloak class="w-11/12 max-w-2xl modal-box">
                    <h3 class="text-lg font-bold">Invoice</h3>
                    <section>


                        <div class="p-4 space-y-4">
                            <label class="form-control w-full ">

                                <span class="label-text">SERVICES</span>

                                <select x-model="service.service_id" class="select select-bordered" required>
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach ($aLLServices as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>

                            </label>
                            <label class="form-control w-full ">

                                <span class="label-text"> DECEASED NAME: </span>
                                <input type="text" placeholder="Type here" class="input input-bordered w-full "
                                    x-model="service.deceased_name" required />

                            </label>
                            <label class="form-control w-full ">
                                <span class="label-text"> MESSAGE: </span>
                                <textarea placeholder="Type here" class="textarea textarea-bordered h-24" required></textarea>
                            </label>

                            <div class="flex items-center gap-1">
                                <label for="ownPriest" class="label-text ">Own Priest: </label>
                                <input type="checkbox" x-model="service.own_priest" id="ownPriest" />
                            </div>
                            <div x-show="service.own_priest" class="mb-3">
                                <label>Schedule: </label>
                                <input type="datetime-local" x-model="service.date" class="form-control"
                                    :required="service.own_priest == true ? true : false">
                            </div>

                            <div x-show="service.own_priest == false" class="mb-3" id="priestDropdown">
                                <label for="priest" class="form-label">Priest</label>
                                <select x-model="service.priest_id" id="priest" class="form-select"
                                    :required="service.own_priest == false ? true : false">
                                    <option value="" selected>-- Select --</option>
                                    @foreach ($priests as $priest)
                                        <option value="{{ $priest->id }}">Fr. {{ $priest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div x-show="showSched && service.own_priest == false" class="mb-3" id="priestDropdown">
                                <label for="priest" class="form-label">Priest Schedules <span
                                        class="text-secondary">(Date -- Start Time TO End Time)</span></label>
                                <select class="form-select" id="priest" x-model="service.date_id"
                                    :required="service.own_priest == false ? true : false">
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
                        <button class="btn btn-primary btn-md">Submit</button>
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
            <input type="checkbox" id="modalProduct" x-model="modalProduct" class="modal-toggle" />

            <input type="checkbox" id="items" x-model="items" class="modal-toggle" />
            <div x-ref="modal" class="modal  " wire:ignore>

                <div class="w-11/12 max-w-6xl modal-box">

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
                    <div class="modal-action">

                        <label for="items" class="btn">Close</label>
                    </div>
                </div>
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
                service_id: '',
                message: '',
                deceased_name: '',
                date: '',
                own_priest: false,
                priest_id: '',
                date_id: ''

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

                    if (!!val) {
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

                        if (!!val) {
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
                this.my_modal_6 = !this.my_modal_6
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

                        if (!!val) {
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

                        if (!!val) {
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

                this.$watch('service.priest_id', (value) => {
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
