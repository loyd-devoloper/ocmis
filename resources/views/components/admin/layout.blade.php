<div class="flex h-[100svh] min-w-[100svw] max-w-[100svw] ">
    <aside class="bg-white w-[18rem] max-w-[18rem] min-h-[100svh]" wire:ignore>
        <h1 class="font-bold text-center text-2xl py-7">ADMIN PANEL</h1>
        <ul class="menu gap-1 rounded-box min-w-[18rem] max-w-[18rem]">
            <li><a href="{{ route('admin.users') }}"
                    class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Users</a></li>
            <li>
                <details
                    {{ request()->routeIs('admin.niches.building') || request()->routeIs('admin.niches.niche') || request()->routeIs('admin.niches.urn') ? 'open' : 'close' }}>
                    <summary>Niches</summary>
                    <ul>
                        <li><a href="{{ route('admin.niches.building') }}"
                                class="{{ request()->routeIs('admin.niches.building') ? 'active' : '' }}">Buildings</a>
                        </li>
                        <li><a href="{{ route('admin.niches.niche') }}"
                                class="{{ request()->routeIs('admin.niches.niche') ? 'active' : '' }}">Niches</a></li>
                        <li><a href="{{ route('admin.niches.urn') }}"
                                class="{{ request()->routeIs('admin.niches.urn') ? 'active' : '' }}">Urn</a></li>
                        <li><a>Sales</a></li>

                    </ul>
                </details>
            </li>
            <li>
                <details
                    {{ request()->routeIs('admin.services.category') || request()->routeIs('admin.services.priest') || request()->routeIs('admin.services.sales') || request()->routeIs('admin.services.transaction') || request()->routeIs('admin.services.memorial') ? 'open' : 'close' }}>
                    <summary>Services</summary>
                    <ul>
                        <li><a href="{{ route('admin.services.category') }}"
                                class="{{ request()->routeIs('admin.services.category') ? 'active' : '' }}">Category</a>
                        </li>
                        <li><a href="{{ route('admin.services.priest') }}"
                                class="{{ request()->routeIs('admin.services.priest') ? 'active' : '' }}">Priest</a>
                        </li>
                        <li><a href="{{ route('admin.services.transaction') }}"
                                class="{{ request()->routeIs('admin.services.transaction') ? 'active' : '' }}">Services
                                Transactions</a></li>
                        <li><a href="{{ route('admin.services.memorial') }}"
                                class="{{ request()->routeIs('admin.services.memorial') ? 'active' : '' }}">Online
                                Memorial</a></li>
                        <li><a href="{{ route('admin.services.sales') }}"
                                class="{{ request()->routeIs('admin.services.sales') ? 'active' : '' }}">Sales</a></li>

                    </ul>
                </details>
            </li>
            <li>
                <details
                    {{ request()->routeIs('admin.shop.category') || request()->routeIs('admin.shop.seller') || request()->routeIs('admin.shop.product') || request()->routeIs('admin.shop.transaction') || request()->routeIs('admin.shop.sales')  ? 'open' : 'close' }}>
                    <summary>Shop</summary>
                    <ul>
                        <li><a href="{{ route('admin.shop.transaction') }}"
                                class="{{ request()->routeIs('admin.shop.transaction') ? 'active' : '' }}">Transaction</a>
                        </li>
                        <li><a href="{{ route('admin.shop.category') }}"
                                class="{{ request()->routeIs('admin.shop.category') ? 'active' : '' }}">Category</a>
                        </li>
                        <li><a href="{{ route('admin.shop.seller') }}"
                                class="{{ request()->routeIs('admin.shop.seller') ? 'active' : '' }}">Seller</a></li>
                        <li><a href="{{ route('admin.shop.product') }}"
                                class="{{ request()->routeIs('admin.shop.product') ? 'active' : '' }}">Product</a></li>
                        <li><a href="{{ route('admin.shop.sales') }}"
                            class="{{ request()->routeIs('admin.shop.sales') ? 'active' : '' }}">Sales</a></li>

                    </ul>
                </details>
            </li>
            <li>
                <details  {{ request()->routeIs('admin.forecast.buildings') || request()->routeIs('admin.forecast.sales') || request()->routeIs('admin.forecast.niches') || request()->routeIs('admin.forecast.view')  ? 'open' : 'close' }}>
                    <summary>Forecast</summary>
                    <ul>
                        <li><a href="{{ route('admin.forecast.buildings') }}"
                            class="{{ request()->routeIs('admin.forecast.buildings') ? 'active' : '' }}">Forecast</a></li>

                        <li><a href="{{ route('admin.forecast.sales') }}"
                            class="{{ request()->routeIs('admin.forecast.sales') ? 'active' : '' }}">Sales</a></li>

                    </ul>
                </details>
            </li>
        </ul>
    </aside>
    <main class="  min-w-[calc(100svw-18rem)] max-w-[calc(100svw-18rem)] max-h-screen overflow-y-auto px-10 pb-10 pt-2">

        <div class="navbar bg-transparent flex justify-end">

            <div class="flex-none ">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">

                        <li><a href="{{ route('admin.setting') }}">Settings</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{ $slot }}
    </main>
</div>
