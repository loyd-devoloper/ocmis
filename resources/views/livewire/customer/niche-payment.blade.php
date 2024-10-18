<div>
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">Ocmis Services</p>
                <p class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        {{-- section --}}
        <section class="p-10">


            <form action="" class="card bg-white max-w-screen-sm mx-auto p-4 space-y-2">
                <img src="{{ asset('example.jpg') }}" class="min-h-[8rem] mx-auto max-w-[8rem] min-w-[8rem] max-h-[8rem]"
                    alt="">
                <p class="text-center border border-black p-2 rounded">{{ $niche->level }} - {{ $niche->niche_number }}
                </p>
                <p class="text-center border border-black p-2 rounded">₱{{ $niche?->price }}</p>

                <div>
                    <p class="text-xs">PAYMENT TYPE </p>

                    <input type="radio" name="radio-2" class="radio  radio-xs" checked /> <span
                        class="text-sm">Full</span>
                    <br>
                    <input type="radio" name="radio-2" class="radio  radio-xs" /><span class="text-sm">
                        Installment</span>
                    <hr class="my-2">

                    <label class="form-control w-full max-w-xs">
                        <span class="label-text">New Price (price + 2%)</span>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs"
                            value="{{ number_format($newPrice) }}" />
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <span class="label-text">Down Payment</span>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs"
                            value="{{ number_format(10000) }}" />
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <span class="label-text">Montly Dues for 3 Months</span>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs"
                            value="{{ number_format($perMonth) }}" />
                    </label>
                </div>
                <button class="btn btn-primary btn-md">Submit</button>
            </form>
        </section>
    </x-customer.header>
</div>
