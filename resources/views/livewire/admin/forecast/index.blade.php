<x-admin.layout>
    <div class="">
        <div class="bg-gray-300 p-4 border border-gray-400 grid grid-cols-5">
            @foreach ($buildings as $building)
            <a href="{{ route('admin.forecast.niches', ['building_id' => $building->id]) }}"
                class="bg-green-500 border-8 border-[#8b5e3c] p-6 text-center text-gray-900 ">
                <h1 class="text-2xl mb-2">{{ $building->name }}</h1>


            </a>
            @endforeach

        </div>
    </div>
</x-admin.layout>
