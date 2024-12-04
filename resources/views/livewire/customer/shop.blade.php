<div>
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">OCMIS Services</p>
                <p class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        {{-- section --}}
        <section class="p-10">

            {{-- cards --}}
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

                            <div class="card-actions justify-end items-center">





                                @if (Auth::check())
                                @if ($this->perProduct($product->id) != 0)
                                <x-filament::icon-button icon="heroicon-m-trash" color="danger"
                                   wire:click="removeProduct({{ $product->id }})" label="New label" />
                                <div class="flex items-center">

                                    <button type="button"  wire:click="changeQuantity('decrement',{{ $product->id }})"
                                        class="border rounded-md py-2 px-4 mr-2">-</button>
                                    <span class="text-center w-8">{{ $this->perProduct($product->id) }}</span>
                                    <button type="button" wire:click="changeQuantity('increment',{{ $product->id }})"
                                        class="border rounded-md py-2 px-4 ml-2">+</button>
                                </div>
                            @endif
                                    <button wire:click="addToCart({{ $product->id }})"
                                        class="btn border border-primary bg-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn border border-primary bg-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </x-customer.header>
</div>
