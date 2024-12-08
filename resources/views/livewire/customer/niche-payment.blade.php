<div>
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">Ocmis Services</p>
                <p class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        {{-- section --}}
        <section class="p-10" x-data="dropdown(@js($schedules), @entangle('serviceArr'), @entangle('productArr'), @entangle('date'))">


            <main class="max-w-screen-xl mx-auto  grid grid-cols-3">
                <div class="col-span-2 space-y-3">
                    <form class="card bg-white w-11/12 max-w-2xl   p-4 space-y-2">
                        <img src="{{ asset('storage/' . $niche->image) }}"
                            class="min-h-[8rem] mx-auto max-w-[8rem] min-w-[8rem] max-h-[8rem]" alt="">
                        <p class="text-center border border-black p-2 rounded">{{ $niche->level }} -
                            {{ $niche->niche_number }}
                        </p>
                        <p class="text-center border border-black p-2 rounded">₱{{ $niche?->price }}</p>
                        <article>
                            <h5>Description</h5>
                            <div class="px-3 py-2">
                                {!! $niche?->description !!}
                            </div>
                        </article>
                        <div class="grid grid-cols-2 gap-10">
                            <div x-on:click="service.open_services = true" class="btn" class="flex items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Services
                            </div>
                            {{-- <label for="my_modal_6" class="btn" class="flex items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Services
                    </label> --}}
                            <label for="modalProduct" class="btn" class="flex items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Product
                            </label>
                            {{-- <div>

                        <label for="items" class="btn" class="flex items-center">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>


                        </label>

                    </div> --}}
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
                        {{-- <a class="btn btn-primary btn-md" type="button"
                        href="{{ route('niches.payment.checkout', ['niche_id' => $niche_id]) }}">Proceed to checkout
                    </a> --}}
                    </form>

                    {{-- services --}}
                    {{-- <input type="checkbox" id="my_modal_6" x-model="my_modal_6" class="modal-toggle" />
                    <div x-ref="modal" class="modal  " wire:ignore>

                        <form x-on:submit.prevent="submit" x-cloak class="w-11/12 max-w-2xl ">
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
                                        <textarea placeholder="Type here" class="textarea textarea-bordered h-24" x-model="service.message" required></textarea>
                                    </label>

                                    <div class="flex items-center gap-1">
                                        <label for="ownPriest" class="label-text ">Own Priest: </label>
                                        <input type="checkbox" x-model="service.own_priest" id="ownPriest" />
                                    </div>
                                    <div x-show="service.own_priest" class="mb-3">
                                        <label>Schedule: </label>
                                        {{ $this->form }}
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
                    </div> --}}

                    <form x-show="service.open_services" x-on:submit.prevent="submit" x-cloak
                        class="w-11/12 max-w-2xl card bg-white p-4">
                        <div class="flex justify-between">
                            <h3 class="text-lg font-bold">Services</h3>
                            <button x-show="service.open_services_submit" x-on:click="removeService">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                            </button>
                        </div>
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
                                    <textarea placeholder="Type here" class="textarea textarea-bordered h-24" x-model="service.message" required></textarea>
                                </label>

                                <div class="flex items-center gap-1">
                                    <label for="ownPriest" class="label-text ">Non-resident: </label>
                                    <input type="checkbox" x-model="service.own_priest" id="ownPriest" />
                                </div>
                                <div x-show="service.own_priest" class="mb-3">
                                    <label>Schedule: </label>
                                    {{ $this->form }}
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
                                <div x-show="showSched && service.own_priest == false" class="mb-3"
                                    id="priestDropdown">
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
                            <button type="submit" class="btn btn-primary btn-md"
                                x-show="!service.open_services_submit">Submit</button>
                            <button type="button" x-on:click="service.open_services = false" class="btn "
                                x-show="!service.open_services_submit">Close</button>
                            {{-- <label for="my_modal_6" class="btn">Close!</label> --}}
                        </div>
                    </form>
                    {{-- end services --}}

                    {{-- products --}}
                    <main class="w-11/12 max-w-2xl card bg-white p-4" x-show="productArr.length > 0">

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
                                                x-text="product?.product_name">
                                                John Doe</td>

                                            <td class="py-4 px-6 border-b border-gray-200 truncate">
                                                <div class="flex items-center">

                                                    <button type="button"
                                                        x-on:click="changeQuantity(product,'minus')"
                                                        :disabled="product?.quantitys < 2"
                                                        class="border rounded-md py-2 px-4 mr-2">-</button>
                                                    <span class="text-center w-8" x-text="product?.quantitys"></span>
                                                    <button type="button" x-on:click="changeQuantity(product,'plus')"
                                                        class="border rounded-md py-2 px-4 ml-2">+</button>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 border-b border-gray-200" x-text="product?.price">
                                                555-555-5555</td>
                                            <td class="py-4 px-6 border-b border-gray-200">
                                                <x-filament::icon-button icon="heroicon-m-trash" color="danger"
                                                    x-on:click="removeProduct(product)" label="New label" />
                                            </td>
                                        </tr>
                                    </template>

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
                    </main>
                </div>
                <form class="card bg-white  p-4 h-fit space-y-3">
                    <h1>Total: <strong>₱<span x-text="parseFloat(productTotal)+parseFloat(service.service_price)+@js((float) $niche?->price)"></span></strong></h1>
                    <a class="btn btn-primary btn-md" type="button"
                        href="{{ route('niches.payment.checkout', ['niche_id' => $niche_id]) }}">Proceed to checkout
                    </a>
                </form>
            </main>

            <input type="checkbox" id="modalProduct" x-model="modalProduct" class="modal-toggle" />
            <div x-ref="modal" class="modal  ">

                <form x-cloak wire:submit="submit" class="w-11/12 max-w-6xl modal-box">


                    <label for="modalProduct" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>

                    <h3 class="text-lg font-bold">Invoice</h3>
                    <div class="flex justify-end">
                        <span class="text-2xl">TOTAL: <strong x-text="'₱'+productTotal"></strong></span>
                    </div>
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

                                        <div class="card-actions justify-between items-center">
                                            <x-filament::icon-button x-show="perProduct({{ $product->id }}) !== 0"
                                                icon="heroicon-m-trash" color="danger"
                                                x-on:click="removeProduct({{ $product }})" label="New label" />

                                            <div class="flex items-center"
                                                x-show="perProduct({{ $product->id }}) !== 0">

                                                <button type="button"
                                                    x-on:click="changeQuantity({{ $product }},'minus')"
                                                    class="border rounded-md py-2 px-4 mr-2">-</button>
                                                <span class="text-center w-8"
                                                    x-text="perProduct({{ $product->id }})"></span>
                                                <button type="button"
                                                    x-on:click="changeQuantity({{ $product }},'plus')"
                                                    class="border rounded-md py-2 px-4 ml-2">+</button>
                                            </div>
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

            {{-- <input type="checkbox" id="items" x-model="items" class="modal-toggle" /> --}}
            {{-- product table --}}
            {{-- <div x-ref="modal" class="modal  " wire:ignore>

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
                                        <td class="py-4 px-6 border-b border-gray-200" x-text="product?.product_name">
                                            John Doe</td>

                                        <td class="py-4 px-6 border-b border-gray-200 truncate">
                                            <div class="flex items-center">

                                                <button type="button" x-on:click="changeQuantity({{ $product }},'minus')"
                                                    :disabled="product?.quantitys < 2"
                                                    class="border rounded-md py-2 px-4 mr-2">-</button>
                                                <span class="text-center w-8" x-text="product?.quantitys"></span>
                                                <button type="button" x-on:click="changeQuantity({{ $product }},'plus')"
                                                    class="border rounded-md py-2 px-4 ml-2">+</button>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200" x-text="product?.price">
                                            555-555-5555</td>
                                        <td class="py-4 px-6 border-b border-gray-200">
                                            <x-filament::icon-button icon="heroicon-m-trash" color="danger"
                                                x-on:click="removeProduct(product)" label="New label" />
                                        </td>
                                    </tr>
                                </template>

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
            </div> --}}


        </section>

    </x-customer.header>
</div>
@script
    <script>
        Alpine.data('dropdown', (schedules, serviceArr, productArr, date_time = null) => ({
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
                priest_name: '',
                date_id: '',
                service_name: '',
                service_sched: '',
                schedule_own_priest: date_time,
                open_services_submit: false,
                open_services: false,
                service_price: 0

            },
            serviceArr: serviceArr,
            productArr: [],
            productTotal: 0,
            productNewArr: [],
            changeName(date, start, end) {

                return `${date} -- ${this.changeTIme(start)} TO ${this.changeTIme(end)}`;
            },
            removeProduct(product) {

                // var newarr = this.productArr.splice(product.id, 1);
                // console.log(newarr)
                var x = this.productArr.filter((val, key) => val.id !== product.id);
                this.productArr = x;

                var self = this;
                this.productTotal = 0;
                this.productArr.filter((val, key) => {

                    if (!!val) {
                        self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                    }
                    return val;
                })
            },
            addProduct(product) {
                $wire.changeQuantity(product.id);
                const index = this.productArr.findIndex(oldProduct => oldProduct.id === product.id);

                if (index !== -1) {
                    this.productTotal = 0;
                    var self = this;
                    var x = this.productArr.map((val) => {

                        if (!!val) {

                            if (val.id == product.id) {
                                val.quantitys = val.quantitys + 1;
                                self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                            } else {
                                self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                            }

                        }

                        return val;
                    })
                } else {
                    // Add new product
                    product['quantitys'] = 1;
                    this.productArr.push(product);
                    this.productTotal += parseInt(product.quantitys) * parseInt(product.price);
                }


                // if (!!this.productArr[product.id]) {


                //     var x = this.productArr[product.id];
                //     this.productArr[product.id]['quantitys'] = x.quantitys + 1;
                //     this.productArr[product.id] = x;
                //     var self = this;
                //     this.productTotal = 0;
                //     this.productArr.filter((val) => {

                //         if (!!val) {
                //             self.productTotal += parseInt(val.quantitys) * parseInt(val.price);

                //         }
                //         return val;

                //     })

                // } else {

                //     product['quantitys'] = 1;
                //     this.productArr.push(product);

                //     var self = this;
                //     this.productTotal = 0;

                //     var x = this.productArr.map((val) => {

                //         if (!!val) {
                //             self.productTotal += parseInt(val.quantitys) * parseInt(val.price);

                //         }
                //         return val;
                //     })


                // }
                // console.log(this.productArr)
                // localStorage.setItem('products', this.productArr)
                // this.perProduct(product.id)
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
            async submit() {
                const price =  await $wire.servicePrice(this.service.service_id);
                console.log(price)
                this.service.service_price = price;
                this.service.open_services_submit = true;
                if (this.service.own_priest == false) {
                    this.service.service_sched = await $wire.priestSched(this.service.date_id);
                    this.service.priest_name = await $wire.priestName(this.service.priest_id);
                }
                this.my_modal_6 = !this.my_modal_6
                this.serviceArr = await this.service;
                var serviceName = await $wire.serviceName(this.service.service_id);


                localStorage.setItem('service', JSON.stringify(this.serviceArr))

            },
            changeQuantity(product, type) {

                const index = this.productArr.findIndex(oldProduct => oldProduct.id === product.id);
                this.productTotal = 0;
                if (index !== -1) {
                    // if (!!this.productArr[product.id]) {

                    $wire.changeQuantitys(type, product.id);
                    if (type == 'minus') {
                        // var x = this.productArr[product.id];
                        // this.productArr[product.id]['quantitys'] = x.quantitys - 1;
                        // this.productArr[product.id] = x;
                        var self = this;
                        var x = this.productArr.map((val) => {

                            if (!!val) {

                                if (val.id == product.id) {
                                    val.quantitys = val.quantitys - 1;
                                    self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                                } else {
                                    self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                                }

                            }

                            return val;
                        })

                    } else {
                        // var x = this.productArr[product.id];
                        // this.productArr[product.id]['quantitys'] = x.quantitys + 1;

                        // this.productArr[product.id] = x;
                        var self = this;
                        var x = this.productArr.map((val) => {

                            if (!!val) {

                                if (val.id == product.id) {
                                    val.quantitys = val.quantitys + 1;
                                    self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                                } else {
                                    self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                                }

                            }

                            return val;
                        })
                    }
                    // var self = this;
                    // this.productTotal = 0;
                    // this.productArr.filter((val) => {

                    //     if (!!val) {
                    //         self.productTotal += parseInt(val.quantitys) * parseInt(val.price);
                    //     }
                    //     return val;
                    // })
                }
            },
            perProduct(product_id) {
                const index = this.productArr.findIndex(oldProduct => oldProduct.id === product_id);
                console.log(index)
                if (index !== -1) {
                    var self = this;
                    // var x = this.productArr.filter((val) => {
                    //     return val.id == product_id;
                    // })
                    const foundValue = this.productArr.find(element => element.id === product_id);

                    return  parseInt(foundValue.quantitys);
                } else {
                    return 0;
                }

            },
            async removeService() {
                this.service.open_services = false;
                this.service.open_services_submit = false;
                this.serviceArr.open_services_submit = false;
                this.serviceArr.open_services = false;
                this.service.deceased_name = '';
                this.serviceArr.deceased_name = '';
                this.service.message = '';
                this.serviceArr.message = '';
                this.service.service_id = '';
                this.serviceArr.service_id = '';
                this.service.date_id = '';
                this.serviceArr.date_id = '';
                this.service.priest_id = '';
                this.service.priest_id = '';
                this.serviceArr.priest_name = '';
                this.serviceArr.priest_name = '';
                this.service.own_priest = false;
                this.serviceArr.own_priest = false;
                this.service.service_price = 0;
                this.serviceArr.service_price = 0;

                this.serviceArr = await this.service;

                localStorage.setItem('service', JSON.stringify(this.serviceArr))
                // localStorage.removeItem('service');
            },
            init() {

                if (localStorage.getItem('service') !== null) {
                    this.service = JSON.parse(localStorage.getItem('service'))
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


                // this.$watch('serviceArr', function(val) {


                //     if (val.length == 0) {
                //         localStorage.removeItem("service");
                //     } else {
                //         localStorage.setItem('service', JSON.stringify(val))
                //     }

                // })
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
