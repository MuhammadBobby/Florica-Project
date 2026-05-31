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
    <div class="max-w-screen flex flex-wrap items-center justify-between mx-auto px-4 py-1">
        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/assets/logo_florica.webp" class="w-12 h-auto" alt="{{ config('app.name') }} Logo">
            <h6 class="self-center text-xl text-primary font-semibold whitespace-nowrap">Florica <span
                    class="text-primary/70">Blooms</span>
            </h6>
        </a>

        {{-- AUTH BUTTON --}}
        <div class="flex justify-center items-center gap-2 md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button"
                class="hidden text-primary font-bold tracking-wider shadow-xs leading-5 rounded-base text-sm px-3 py-2 focus:outline-none hover:text-pink-700 md:block cursor-pointer">Login</button>
            <button type="button"
                class="hidden text-white bg-primary hover:bg-pink-700 box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none md:block cursor-pointer">Register</button>
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

            </ul>
        </div>
    </div>
</nav>
