
<x-admin.layout>
    <div class="">
        <div >
            @livewire(\App\Livewire\Admin\Forecast\SalesNiche::class)
        </div>
        <div class="mt-10">
            @livewire(\App\Livewire\Admin\Forecast\SalesShop::class)
        </div>

        <div class="mt-10">
            {{ $this->table }}
        </div>
    </div>
</x-admin.layout>
