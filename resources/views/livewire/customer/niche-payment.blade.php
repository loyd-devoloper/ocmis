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
            <img src="{{ asset('example.jpg') }}" class="min-h-[8rem] mx-auto max-w-[8rem] min-w-[8rem] max-h-[8rem]" alt="">
            <p class="text-center border border-black p-2 rounded">{{ $niche->level }} - {{ $niche->niche_number }}</p>
            <p class="text-center border border-black p-2 rounded">₱{{ $niche?->price }}</p>

            <div >
                <p class="text-xs">PAYMENT TYPE </p>

                <input type="radio" name="radio-2" class="radio radio-primary radio-xs"  /> <span class="text-sm">Full</span>
                <br>
                <input type="radio" name="radio-2" class="radio radio-primary radio-xs"  /><span class="text-sm"> Installment</span>

            </div>
            <button class="btn btn-primary btn-md">Submit</button>
        </form>
    </section>
    </x-customer.header>
</div>
