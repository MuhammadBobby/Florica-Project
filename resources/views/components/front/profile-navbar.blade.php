<div class="relative">

    <button id="profileDropdownButton" data-dropdown-toggle="profileDropdown"
        class="flex items-center gap-3 px-2 py-1 rounded-full hover:bg-neutral-secondary-medium">

        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('/assets/elements/avatar.webp') }}"
            class="w-10 h-10 rounded-full object-cover">

        <div class="hidden md:block text-left">
            <p class="text-sm font-semibold text-heading">
                {{ Auth::user()->full_name }}
            </p>

            <p class="text-xs text-body">
                Customer
            </p>
        </div>

        <svg class="w-4 h-4 text-body" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2" d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div id="profileDropdown"
        class="hidden absolute right-0 mt-3 w-72 bg-white border border-default rounded-xl shadow-xl overflow-hidden z-50">

        {{-- HEADER --}}
        <div class="p-4 bg-linear-to-r from-pink-50 to-rose-50">

            <div class="flex items-center gap-3">

                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('/assets/elements/avatar.webp') }}"
                    alt="{{ Auth::user()->full_name }}" class="w-14 h-14 rounded-full object-cover border">

                <div>
                    <h4 class="font-semibold text-heading">
                        {{ Auth::user()->full_name }}
                    </h4>

                    <p class="text-xs text-body">
                        {{ Auth::user()->email }}
                    </p>
                </div>

            </div>

        </div>

        {{-- MENU --}}
        <div class="p-2">

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-neutral-secondary-medium">

                <span>👤</span>
                <span>Profile Saya</span>

            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-neutral-secondary-medium">

                <span>📍</span>
                <span>Alamat Saya</span>

            </a>

            <a href="{{ route('orders.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-neutral-secondary-medium">

                <span>📦</span>
                <span>Pesanan Saya</span>

            </a>

        </div>

        {{-- FOOTER --}}
        <div class="border-t border-default p-2">
            <form id="logout-form" class="w-full" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full hidden text-white bg-primary hover:bg-pink-700 box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none md:flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="rotate-180 text-xs" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

</div>
