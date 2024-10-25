<x-admin.layout>
    <div class="">
        @livewire(\App\Livewire\Services::class)
        <div class="mt-10">
            @livewire(\App\Livewire\Service\Daily::class)
        </div>
    </div>
</x-admin.layout>
