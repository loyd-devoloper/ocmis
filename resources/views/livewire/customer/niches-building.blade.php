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
            <div class="flex justify-center items-center gap-2 max-w-screen-lg  mx-auto py-10 ">
                <div class="bg-green-500 font-medium p-1 rounded w-fit h-fit text-[.7rem] text-white">Available</div>
                <div class="bg-gray-400 font-medium p-1 rounded w-fit h-fit text-[.7rem] text-white">Pending</div>
                <div class="bg-red-500 font-medium p-1 rounded w-fit h-fit text-[.7rem] text-white">Occupied</div>
            </div>
            <div class="bg-gray-300 p-4 border border-gray-400 grid grid-cols-5">
                @foreach ($building?->niches as $niche)
                    @if ($niche->status == 'Available')
                        @if (Auth::check())
                        <a href="{{ route('niches.payment', ['niche_id' => $niche->id]) }}"
                            class="bg-[#4a4a4a] border-8 border-[#8b5e3c] p-6 text-center text-green-500 ">
                            <h1 class="text-2xl mb-2">{{ $niche->level }} - {{ $niche->niche_number }}</h1>
                            <h2 class="text-lg mb-2">Urn Capacity: {{ $niche->capacity }}</h2>

                        </a>
                        @else
                        <a href="{{ route('login') }}"
                            class="bg-[#4a4a4a] border-8 border-[#8b5e3c] p-6 text-center text-green-500 ">
                            <h1 class="text-2xl mb-2">{{ $niche->level }} - {{ $niche->niche_number }}</h1>
                            <h2 class="text-lg mb-2">Urn Capacity: {{ $niche->capacity }}</h2>

                        </a>
                        @endif
                    @elseif (!!$niche->customer_id && $niche->status == 'Pending')
                        <div
                            class="bg-[#4a4a4a] border-8 border-[#8b5e3c] p-6 text-center text-gray-400 ">
                            <h1 class="text-2xl mb-2">{{ $niche->level }} - {{ $niche->niche_number }}</h1>
                            <h2 class="text-lg mb-2">Urn Capacity: {{ $niche->capacity }}</h2>

                        </div>
                    @elseif (!!$niche->customer_id && $niche->status == 'Occupied')
                        @if (Auth::id() == $niche->customer_id)
                        <a href="{{ route('niches.view', ['id' => $niche->id]) }}"
                            class="bg-[#4a4a4a] border-8 border-[#8b5e3c] p-6 text-center text-red-500 ">
                            <h1 class="text-2xl mb-2">{{ $niche->level }} - {{ $niche->niche_number }}</h1>
                            <h2 class="text-lg mb-2">Urn Capacity: {{ $niche->capacity }}</h2>

                        </a>
                        @else
                        <div
                            class="bg-[#4a4a4a] border-8 border-[#8b5e3c] p-6 text-center text-red-500 ">
                            <h1 class="text-2xl mb-2">{{ $niche->level }} - {{ $niche->niche_number }}</h1>
                            <h2 class="text-lg mb-2">Urn Capacity: {{ $niche->capacity }}</h2>

                        </div>
                        @endif
                    @endif
                @endforeach

            </div>
            {{-- cards --}}
            {{-- <div class="grid grid-cols-4 max-w-screen-lg  mx-auto py-10 gap-10">
            @foreach ($building?->niches as $niche)
            <a href="{{ route('niches.payment',['niche_id'=>$niche->id]) }}" class="card  {{ $niche->status == 'Available' ? 'bg-green-500' : '' }} {{ $niche->status == 'Pending' ? 'bg-gray-400' : '' }} {{ $niche->status == 'Occupied' ? 'bg-red-500' : '' }} text-white px-4 pt-4 pb-10">

                <p class="font-medium">{{ $niche->level }} - {{ $niche->niche_number }}</p>
                <p>Urn Capacity: {{ $niche->capacity }}</p>
            </a>
            @endforeach
        </div> --}}
        </section>
    </x-customer.header>
</div>
