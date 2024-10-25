<x-admin.layout>
    <div class="">
        <div >
            @livewire(\App\Livewire\Forecast\Niche::class,['records' =>$niche_id])
        </div>
    </div>
</x-admin.layout>
