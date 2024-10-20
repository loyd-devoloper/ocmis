<div x-data="main">
    <x-customer.header>

        <div class="p-10">
            <x-filament::tabs label="Content tabs" class="my-2">
                <x-filament::tabs.item  tag="a" :href="route('my_transaction')">
                    My Service Request
                </x-filament::tabs.item >

                <x-filament::tabs.item tag="a" :href="route('my_product')">
                    My Product Purchases
                </x-filament::tabs.item>

                <x-filament::tabs.item>
                    My Niche
                </x-filament::tabs.item>
                <x-filament::tabs.item active class="!bg-blue-500 !text-white" tag="a" :href="route('my_memorial')">
                    My Memorial
                </x-filament::tabs.item>
            </x-filament::tabs>
            {{ $this->table }}
        </div>

    </x-customer.header>
</div>
