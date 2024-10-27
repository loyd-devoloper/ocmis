
<x-admin.layout>
    <div class="">
        <div>
            {{ $this->table }}
        </div>
        <div class="mt-10">
            @livewire(\App\Livewire\admin\forecast\SalesShop::class)
        </div>
    </div>
</x-admin.layout>
