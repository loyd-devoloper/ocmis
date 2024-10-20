<div>
    <nav class="border-b shadow-sm bg-[#ffffff] min-h-[4rem] max-h-[4rem]" wire:ignore>
        <div class="navbar min-h-[4rem] max-h-[4rem]  max-w-screen-xl mx-auto">
            <div class="navbar-start">

                <a class="btn btn-ghost text-xl">OCMIS </a>
            </div>
            <div class="navbar-center ">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'font-bold' : '' }}">Home</a>
                    </li>
                    <li><a href="{{ route('niches') }}"
                            class="{{ request()->routeIs('niches') || request()->routeIs('niches.building') ? 'font-bold' : '' }}">Niches</a>
                    </li>
                    <li><a href="{{ route('services') }}"
                            class="{{ request()->routeIs('services') ? 'font-bold' : '' }}">Services</a></li>
                    <li><a href="{{ route('shop') }}"
                        class="{{ request()->routeIs('shop') ? 'font-bold' : '' }}">Shop</a></li>
                    <li><a href="{{ route('memorial') }}"
                        class="{{ request()->routeIs('memorial') ? 'font-bold' : '' }}">Memorials</a></li>

                    <li><a>About Us</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <div class="dropdown dropdown-end">
                    <a href="{{ route('cart') }}" tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="badge badge-sm indicator-item">8</span>
                        </div>
                    </a>

                </div>
                @auth
                <div class="dropdown dropdown-end">
                    <details class="dropdown ">
                        <summary class="btn m-1 flex items-center bg-transparent border-none shadow-none">{{ Auth::user()->username }}<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                          </svg>
                          </summary>
                        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                            <li><a href="{{ route('my_transaction') }}">My Transaction</a></li>
                          <li><a>Setting</a></li>
                          <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                      </details>
                </div>

                @endauth
               @guest
               <div class="dropdown dropdown-end">
                <ul class="menu menu-horizontal px-1">

                    <li><a href="{{ route('login') }}"
                            class="{{ request()->routeIs('login') ? 'font-bold' : '' }}">Login</a></li>
                    <li><a href="{{ route('register') }}"
                            class="{{ request()->routeIs('register') ? 'font-bold' : '' }}">Register</a></li>

                </ul>
            </div>
               @endguest
            </div>

        </div>
    </nav>

    <div class="min-h-[calc(100svh-4rem)] max-h-[calc(100svh-4rem)]   overflow-y-auto  ">
        {{ $slot }}
    </div>
</div>
