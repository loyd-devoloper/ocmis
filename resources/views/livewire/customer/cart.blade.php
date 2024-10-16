<div>
    <x-customer.header>



        {{-- section --}}
        <section class="p-10 w-full" x-data="dropdown(@entangle('invoice'),@entangle('ref'))">
            <div class="py-8" wire:ignore>
                <div class="container mx-auto px-4">
                    <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="md:w-3/4">
                            <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th class="text-left font-semibold">Product</th>
                                            <th class="text-left font-semibold">Price</th>
                                            <th class="text-left font-semibold">Quantity</th>
                                            <th class="text-left font-semibold">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $cart)
                                            <tr>
                                                <td class="py-4">
                                                    <div class="flex items-center">
                                                        <img class="h-16 w-16 mr-4"
                                                            src="{{ asset('storage/' . $cart->product?->image) }}"
                                                            alt="Product image">
                                                        <span
                                                            class="font-semibold">{{ $cart->product?->product_name }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-4">₱{{ $cart->product?->price }}</td>
                                                <td class="py-4">
                                                    <div class="flex items-center">
                                                        <button class="border rounded-md py-2 px-4 mr-2"
                                                            wire:click="changeQuantity('decrement',{{ $cart->id }})">-</button>
                                                        <span class="text-center w-8">{{ $cart?->quantity }}</span>
                                                        <button class="border rounded-md py-2 px-4 ml-2"
                                                            wire:click="changeQuantity('increment',{{ $cart->id }})">+</button>
                                                    </div>
                                                </td>
                                                <td class="py-4">
                                                    ₱{{ (float) $cart->product?->price * (float) $cart->quantity }}</td>
                                            </tr>
                                        @endforeach
                                        <!-- More product rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form wire:submit="checkout" class="md:w-1/4">
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h2 class="text-lg font-semibold mb-4">Summary</h2>

                                <h1 class="text-xs">PAYMENT METHOD</h1>
                                <div class="form-control w-fit space-x-2 text-xs">
                                    <label class="label cursor-pointer">

                                        <input type="radio" name="radio-10" wire:model="payment_method" value="Cash"
                                            class="radio radio-xs mr-1" />Cash
                                    </label>
                                </div>
                                <div class="form-control w-fit space-x-2 text-xs">
                                    <label class="label cursor-pointer">

                                        <input type="radio" name="radio-10" wire:model="payment_method" value="Gcash"
                                            class="radio radio-xs  mr-1" checked="checked" />Gcash
                                    </label>
                                </div>
                                <hr class="my-2">
                                <div class="flex justify-between mb-2">
                                    <span class="font-semibold">Total</span>
                                    <span class="font-semibold">₱{{ $total }}</span>
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Open the modal using ID.showModal() method -->

            <dialog x-ref="modal" class="modal " wire:ignore>

                <div class="w-11/12 max-w-5xl modal-box">
                    <h3 class="text-lg font-bold">Invoice</h3>

                   <div class="indent-3 py-4">
                    <p>{{ Auth::user()->username }}</p>
                    <p x-text="'Invoice No: '+ref"></p>
                    <p>{{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
                   </div>
                    <div class="overflow-x-auto">
                        <table class="table table-md">
                            <thead>
                                <tr>

                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <th>{{ $cart->product?->product_name }}</th>
                                        <td>{{ $cart->product?->price }}</td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td>₱{{ (float) $cart->product?->price * (float) $cart->quantity }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th><strong class="text-black">Total</strong></th>
                                    <th><strong class="text-black">₱{{ $total }}</strong></th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </section>

    </x-customer.header>
</div>

@script
    <script>
        Alpine.data('dropdown', (invoice,ref) => ({
            invoice: invoice,
            ref: ref,

            init() {
                var self = this;
                this.$watch('invoice', function(val) {
                    if (val) {
                        console.log(val)
                        self.$refs.modal.showModal();
                    }
                })
            }
        }))
    </script>
@endscript
