@php
    $menus = [
        [
            'label' => 'Beranda',
            'url' => '/',
            'active' => request()->is('/'),
        ],
        [
            'label' => 'Produk',
            'url' => '/products',
            'active' => request()->is('products*'),
        ],
    ];
@endphp


<nav class="fixed w-full z-20 top-0 insert-s-0 border-b border-default backdrop-blur-xl">
    <div class="max-w-screen flex flex-wrap items-center justify-between mx-auto px-3 md:px-8 py-1">
        <a href="{{ route('landing') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/assets/logo_florica.webp" class="w-12 h-auto" alt="{{ config('app.name') }} Logo">
            <h6 class="self-center text-xl text-primary font-semibold whitespace-nowrap">Florica <span
                    class="text-primary/70">Blooms</span>
            </h6>
        </a>

        {{-- AUTH BUTTON --}}
        <div class="flex justify-center items-center gap-2 md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @auth
                <div class="hidden md:flex items-center justify-end gap-3">
                    {{-- WISHLIST --}}
                    <a href="{{ route('wishlist.index') }}" class="relative" title="Wishlist Produk">
                        <svg class="w-10 h-10 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                        </svg>

                        @auth
                            @if (auth()->user()->wishlists()->count())
                                <span
                                    class="absolute -top-2 -right-2 text-xs bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center">

                                    {{ auth()->user()->wishlists()->count() }}

                                </span>
                            @endif
                        @endauth

                    </a>

                    {{-- CART --}}
                    <a href="{{ route('cart.index') }}"
                        class="relative text-white bg-primary box-border border border-transparent hover:bg-pink-700 focus:ring-4 focus:ring-secondary shadow-xs font-medium leading-5 rounded-full text-sm p-2 focus:outline-none">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                        </svg>

                        <span class="sr-only">Notifications Cart</span>
                        @if ($cartCount >= 0)
                            <div
                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-danger border-2 border-buffer rounded-full -top-2 -inset-e-2">
                                {{ $cartCount }}
                            </div>
                        @endif
                    </a>


                    <x-front.profile-navbar />
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="hidden text-primary font-bold tracking-wider shadow-xs leading-5 rounded-base text-sm px-3 py-2 focus:outline-none hover:text-pink-700 md:block cursor-pointer">Login</a>
                <a href="{{ route('register') }}"
                    class="hidden text-white bg-primary hover:bg-pink-700 box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none md:block cursor-pointer">Register</a>
            @endauth
            <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
                aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
        </div>

        {{-- MENUS --}}
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul
                class="flex flex-col justify-center md:p-0 p-4 mt-4 font-medium border bg-secondary/20 backdrop-blur-xl border-default rounded-base md:space-x-8 rtl:space-x-reverse md:bg-transparent md:flex-row md:mt-0 md:border-0">

                @foreach ($menus as $menu)
                    <li>
                        <a href="{{ url($menu['url']) }}" @class([
                            'block rounded-sm',
                            'py-2 px-3 font-medium tracking-wide',
                        
                            // Active
                            'text-white bg-primary md:bg-secondary md:text-primary' => $menu['active'],
                        
                            // Inactive
                            'text-heading hover:bg-primary md:hover:bg-transparent md:hover:text-primary' => !$menu[
                                'active'
                            ],
                        ])>

                            {{ $menu['label'] }}

                        </a>
                    </li>
                @endforeach

                @auth
                    {{-- Cart --}}
                    <li class="w-full flex md:hidden mt-8">
                        <a href="{{ route('cart.index') }}"
                            class="relative w-full rounded-base py-2 px-3 font-medium tracking-wide text-white bg-primary md:bg-secondary md:text-primary">
                            Keranjang Belanja 🛒
                            @if ($cartCount >= 0)
                                <div
                                    class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-danger border-2 border-buffer rounded-full -top-2 -inset-e-2">
                                    {{ $cartCount }}
                                </div>
                            @endif
                        </a>
                    </li>

                    {{-- Profile, alamat, pesanan --}}
                    <li class="md:hidden mt-3">
                        <div class="space-y-1">

                            {{-- Profile --}}
                            <a href="{{ route('profile.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-base hover:bg-neutral-secondary-medium transition">

                                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8a7 7 0 1 1 14 0" />
                                </svg>

                                <span class="font-medium">
                                    Profile Saya
                                </span>

                            </a>

                            {{-- Address --}}
                            <a href="{{ route('my-addresses.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-base hover:bg-neutral-secondary-medium transition">

                                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z" />
                                    <circle cx="12" cy="10" r="2" stroke="currentColor" stroke-width="2" />
                                </svg>

                                <span class="font-medium">
                                    Alamat Saya
                                </span>

                            </a>

                            {{-- Orders --}}
                            <a href="{{ route('my-orders.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-base hover:bg-neutral-secondary-medium transition">

                                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 7.5 12 3l9 4.5M3 7.5 12 12m-9-4.5V16.5L12 21m0-9 9-4.5V16.5L12 21m0-9v9" />
                                </svg>

                                <span class="font-medium">
                                    Pesanan Saya
                                </span>

                            </a>

                            {{-- Wishlist --}}
                            <a href="{{ route('wishlist.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-base hover:bg-neutral-secondary-medium transition">

                                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21s-7-4.35-9-8.5A5.5 5.5 0 0 1 12 5a5.5 5.5 0 0 1 9 7.5C19 16.65 12 21 12 21Z" />
                                </svg>

                                <span class="font-medium">
                                    Wishlist
                                </span>

                            </a>

                        </div>
                    </li>
                @endauth


                <li class="md:hidden mt-3">
                    @auth
                        <form class="w-full" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-primary border border-primary hover:bg-pink-700 box-border focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm py-2 px-3 focus:outline-none flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="rotate-180 text-xs" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block rounded-base py-2 px-3 font-bold tracking-wide border border-primary text-primary hover:bg-primary hover:text-white">
                            Login / Register
                        </a>

                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
