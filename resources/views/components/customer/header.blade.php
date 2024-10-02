<div>
    <nav class="border-b shadow-sm bg-[#ffffff]">
        <div class="navbar  max-w-screen-xl mx-auto">
            <div class="navbar-start">

                <a class="btn btn-ghost text-xl">OCMIS </a>
            </div>
            <div class="navbar-center ">
                <ul class="menu menu-horizontal px-1">
                    <li ><a href="{{ route('home') }}"  class="{{ request()->routeIs('home') ? 'font-bold' : '' }}">Home</a></li>
                    <li><a>Niches</a></li>
                    <li><a>Services</a></li>
                    <li><a>Shop</a></li>
                    <li><a>Memorials</a></li>

                    <li><a>About Us</a></li>
                </ul>
            </div>
            <div class="navbar-end">

                <ul class="menu menu-horizontal px-1">
                    <li> <a>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>

                            Cart
                            <div class="badge badge-md badge-primary">+99</div>
                        </a></li>
                    <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'font-bold' : '' }}">Login</a></li>
                    <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'font-bold' : '' }}">Register</a></li>

                </ul>
            </div>
        </div>
    </nav>
</div>
