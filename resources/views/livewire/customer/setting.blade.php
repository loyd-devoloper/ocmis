
<div x-data="main">
    <x-customer.header>

        <div class="p-10">
            <x-filament::section>
                <x-slot name="heading">
                    Setting
                </x-slot>
                <form wire:submit="update">
                    {{ $this->form }}


                    <x-filament::button type="submit" class="w-full mt-8" color="success">
                        Update
                    </x-filament::button>
                    <div class="w-full mt-2">
                        {{$this->modalFormAction}}
                    </div>
                </form>
                {{-- Content --}}
            </x-filament::section>
        </div>
        <x-filament-actions::modals />
    </x-customer.header>
</div>
