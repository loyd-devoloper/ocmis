<x-admin.layout>
    <div class="">
        <div class="bg-gray-300 p-4 border border-gray-400 grid grid-cols-5">
            @foreach ($niches as $niche)
            <a href="{{ route('admin.forecast.view', ['niche_id' => $niche->id]) }}"
                class="bg-[#4a4a4a] border-8 border-[#8b5e3c] p-6 text-center text-green-500 ">
                <h1 class="text-2xl mb-2">{{ $niche->level }} - {{ $niche->niche_number }}</h1>
                <h2 class="text-lg mb-2">Urn Capacity: {{ $niche->capacity }}</h2>

            </a>
            @endforeach

        </div>
    </div>
</x-admin.layout>
