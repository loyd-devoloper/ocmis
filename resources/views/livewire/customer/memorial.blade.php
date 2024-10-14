<div >
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">OCMIS Memorial</p>
                <p  class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>

        <div>
            {{ $this->modalFormAction }}
            <x-filament-actions::modals />
        </div>

    </x-customer.header>

</div>
