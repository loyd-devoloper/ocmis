
<x-admin.layout>
    <div class="">
        <div>
            {{ $this->table }}
        </div>
        <div class="mt-10">
            @livewire(\App\Livewire\Admin\Forecast\SalesShop::class)
        </div>
        <div class="mt-10">
            @livewire(\App\Livewire\Admin\Forecast\SalesNiche::class)
        </div>
    </div>
</x-admin.layout>
