<div >
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">OCMIS Memorial</p>
                <p  class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>

        <div>

        </div>
        <section class="p-10">
            <h1 class="text-center text-2xl font-semibold ">Memorials</h1>
            <div class="flex justify-center items-center gap-2">
               @auth
               {{ $this->modalFormAction }}
               @endauth
                <x-filament-actions::modals />
            </div>
            <div class="grid grid-cols-4 max-w-screen-lg  mx-auto py-10 gap-10">
                @foreach ($memorials as $memorial)
                <a href="{{ route('memorial_view',['memorial_id'=>$memorial->id]) }}" class="card bg-green-500 text-white px-4 pt-4 pb-10">
                    {{-- <img src="{{ asset('storage/'.$memorial->images) }}" class="min-h-[4rem] max-w-[4rem] rounded-sm border border-black" alt=""> --}}
                    <p class="font-medium">{{ $memorial->deceased_name }} </p>
                    <p>Date: {{ \Carbon\Carbon::parse($memorial?->date_time)->format('F d, Y') }}</p>
                    <p>Start: {{ \Carbon\Carbon::parse($memorial?->date_time)->format('h:i:s A') }}</p>
                </a>
                @endforeach
            </div>
        </section>
    </x-customer.header>

</div>
