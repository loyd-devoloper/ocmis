<div class="flex h-[100dvh] min-w-[100svw] max-w-[100svw] ">
    <aside class="bg-white w-[18rem] max-w-[18rem] min-h-[100svh]">
        <h1 class="font-bold text-center text-2xl py-7">ADMIN PANEL</h1>
        <ul class="menu  rounded-box min-w-[18rem] max-w-[18rem]">
            <li><a>Users</a></li>
            <li>
                <details >
                    <summary>Niches</summary>
                    <ul>
                        <li><a>Buildings</a></li>
                        <li><a>Niches</a></li>
                        <li><a>Urn</a></li>
                        <li><a>Sales</a></li>

                    </ul>
                </details>
            </li>
            <li>
                <details >
                    <summary>Services</summary>
                    <ul>
                        <li><a>Category</a></li>
                        <li><a>Priest</a></li>
                        <li><a>Services Transactions</a></li>
                        <li><a>Sales</a></li>

                    </ul>
                </details>
            </li>
            <li>
                <details >
                    <summary>Shop</summary>
                    <ul>
                        <li><a>Category</a></li>
                        <li><a>Seller</a></li>
                        <li><a>Product</a></li>
                        <li><a>Sales</a></li>

                    </ul>
                </details>
            </li>
            <li>
                <details >
                    <summary>Forecast</summary>
                    <ul>
                        <li><a>Forecast</a></li>

                        <li><a>Sales</a></li>

                    </ul>
                </details>
            </li>
        </ul>
    </aside>
    <main class=" min-w-[calc(100vh-1rem)] max-w-[calc(100svh-18rem)] bg-red-500  h-full p-10">
        {{ $slot }}
    </main>
</div>
