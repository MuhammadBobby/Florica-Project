@php
    $menus = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Kategori',
            'route' => 'categories.index',
            'icon' => 'category',
        ],
        [
            'label' => 'Produk',
            'route' => 'products.index',
            'icon' => 'product',
        ],
        [
            'label' => 'Pesanan',
            'route' => 'orders.index',
            'icon' => 'order',
        ],
        [
            'label' => 'Pelanggan',
            'route' => 'customers.index',
            'icon' => 'user',
        ],
        [
            'label' => 'Profile Toko',
            'route' => 'store-profile.index',
            'icon' => 'store',
        ],
    ];
@endphp



<button id="sidebar-toggle" type="button"
    class="text-heading bg-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary rounded-base ms-3 mt-3 text-sm p-2 inline-flex sm:hidden">
    <span class="sr-only">Open sidebar</span>

    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
    </svg>
</button>

<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen bg-neutral-primary-soft border-r border-default transition-transform duration-300 -translate-x-full sm:translate-x-0 shadow-xl">
    <div class="h-full px-3 py-4 overflow-y-auto">

        {{-- Tombol Close Mobile --}}
        <div class="flex justify-end sm:hidden mb-4">
            <button id="sidebar-close">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 6L18 18M18 6L6 18" />
                </svg>
            </button>
        </div>

        {{-- LOGO --}}
        <a href="{{ route('landing') }}" class="flex flex-col items-center mb-6">
            <img src="{{ asset('/assets/logo_florica.webp') }}" class="h-12 me-3" alt="Florica Blooms Logo">
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-primary">Florica Blooms</span>
        </a>

        <ul class="space-y-2 font-medium">
            @foreach ($menus as $menu)
                @php
                    $isActive = request()->routeIs($menu['route']);
                @endphp

                <li>
                    <a href="{{ route($menu['route']) }}"
                        class="
                    flex items-center px-3 py-2 rounded-base transition-all

                    {{ $isActive ? 'bg-primary text-white shadow-md' : 'text-body hover:bg-neutral-tertiary hover:text-primary' }}
                ">

                        {{-- ICON --}}
                        @switch($menu['icon'])
                            @case('dashboard')
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z" />
                                    <path
                                        d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z" />
                                </svg>
                            @break

                            @case('category')
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z" />
                                </svg>
                            @break

                            @case('product')
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2 2 7l10 5 10-5-10-5Zm0 8L2 5v12l10 5 10-5V5l-10 5Z" />
                                </svg>
                            @break

                            @case('order')
                                <svg class="w-6 h-6 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                        clip-rule="evenodd" />
                                </svg>
                            @break

                            @case('user')
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.4 0-8 2-8 4.5V21h16v-2.5C20 16 16.4 14 12 14Z" />
                                </svg>
                            @break

                            @case('store')
                                <svg class="w-6 h-6 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z"
                                        clip-rule="evenodd" />
                                </svg>
                            @break
                        @endswitch

                        <span class="ms-3">
                            {{ $menu['label'] }}
                        </span>

                    </a>
                </li>
            @endforeach

            {{-- Logout --}}
            <li class="mt-5">
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-4 text-primary bg-neutral-primary border border-primary hover:bg-primary hover:text-white focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm px-4 py-2 focus:outline-none">
                        <svg class="rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                        </svg>

                        <span class="me-8">Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</aside>
