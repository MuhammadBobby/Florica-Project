@php
    $menus = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'dashboard'],
        ['label' => 'Kategori', 'route' => 'categories.index', 'icon' => 'category'],
        ['label' => 'Produk', 'route' => 'products.index', 'icon' => 'product'],
        ['label' => 'Pesanan', 'route' => 'orders.index', 'icon' => 'order'],
        ['label' => 'Pelanggan', 'route' => 'customers.index', 'icon' => 'user'],
        ['label' => 'Profile Toko', 'route' => 'store-profile.index', 'icon' => 'store'],
    ];
@endphp

{{-- TOGGLE BUTTON MOBILE --}}
<button id="sidebar-toggle" type="button"
    class="sm:hidden text-heading bg-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary rounded-base ms-3 mt-3 text-sm p-2 inline-flex">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
    </svg>
</button>

<aside id="sidebar"
    class="fixed top-0 left-0 z-50 w-64 h-screen bg-neutral-primary-soft/95 backdrop-blur border-r border-default shadow-xl transition-transform duration-300 -translate-x-full sm:translate-x-0">

    <div class="h-full px-3 py-4 overflow-y-auto pb-20">

        {{-- CLOSE BUTTON MOBILE --}}
        <div class="flex justify-end sm:hidden mb-4">
            <button id="sidebar-close"
                class="p-2 rounded-base hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 6L18 18M18 6L6 18" />
                </svg>
            </button>
        </div>

        {{-- LOGO --}}
        <a href="{{ route('landing') }}" class="flex flex-col items-center mb-6">
            <img src="{{ asset('/assets/logo_florica.webp') }}" class="h-12" alt="Florica Blooms Logo">
            <span class="text-xl font-semibold text-primary mt-2">Florica Blooms</span>
        </a>

        {{-- MENU --}}
        <ul class="space-y-2 font-medium">

            @foreach ($menus as $menu)
                @php
                    $isActive = request()->routeIs($menu['route']);
                @endphp

                <li>
                    <a href="{{ route($menu['route']) }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-base transition
                        {{ $isActive ? 'bg-primary text-white shadow-md' : 'text-body hover:bg-neutral-tertiary hover:text-primary' }}">

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
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 2l14 0 0 20-14 0z" />
                                </svg>
                            @break

                            @case('user')
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.4 0-8 2-8 4.5V21h16v-2.5C20 16 16.4 14 12 14Z" />
                                </svg>
                            @break

                            @case('store')
                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 10h16v10H4z" />
                                </svg>
                            @break
                        @endswitch

                        <span>{{ $menu['label'] }}</span>
                    </a>
                </li>
            @endforeach

            {{-- LOGOUT --}}
            <li class="mt-6">
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 text-primary bg-neutral-primary border border-primary hover:bg-primary hover:text-white rounded-base text-sm px-4 py-2 transition">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('sidebar-close');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);

        // optional: klik luar sidebar untuk close (UX lebih enak)
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !openBtn.contains(e.target)) {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            }
        });
    });
</script>
