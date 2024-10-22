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
                @foreach ($services as $service)
                    <div class="card bg-base-100  shadow-xl">
                        <figure>
                            <img src="{{ asset('storage/'.$service->image) }}"
                                alt="Shoes" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ $service->name }}</h2>
                            <p>₱{{ $service->price }}</p>
                            <div class="card-actions justify-end">
                               @if (Auth::check())
                               <a href="{{ route('services.payment',['service_id'=>$service->id]) }}" class="btn btn-primary">Avail </a>
                               @else
                               <a href="{{ route('login') }}" class="btn btn-primary">Avail </a>
                               @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </x-customer.header>
</div>
