<div>
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">OCMIS Niches</p>
                <p class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


    {{-- section --}}
    <section class="p-10">
        <h1 class="text-center text-2xl font-semibold ">{{ $buildingName }}</h1>
        <div class="flex justify-center items-center gap-2">
            <div class="bg-green-500 font-medium p-1 rounded w-fit h-fit text-[.7rem] text-white">Available</div>
            <div class="bg-gray-400 font-medium p-1 rounded w-fit h-fit text-[.7rem] text-white">Pending</div>
            <div class="bg-red-500 font-medium p-1 rounded w-fit h-fit text-[.7rem] text-white">Occupied</div>
        </div>

        {{-- cards --}}
        <div class="grid grid-cols-4 max-w-screen-lg  mx-auto py-10 gap-10">
            @foreach ($building?->niches as $niche)
            <a href="{{ route('niches.payment',['niche_id'=>$niche->id]) }}" class="card  {{ $niche->status == 'Available' ? 'bg-green-500' : '' }} {{ $niche->status == 'Pending' ? 'bg-gray-400' : '' }} {{ $niche->status == 'Occupied' ? 'bg-red-500' : '' }} text-white px-4 pt-4 pb-10">
                <img src="{{ asset('storage/'.$niche->image) }}" class="min-h-[4rem] max-w-[4rem] rounded-sm border border-black" alt="">
                <p class="font-medium">{{ $niche->level }} - {{ $niche->niche_number }}</p>
                <p>Urn Capacity: {{ $niche->capacity }}</p>
            </a>
            @endforeach
        </div>
    </section>
    </x-customer.header>
</div>
