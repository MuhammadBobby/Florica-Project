<header class="flex items-center justify-between gap-3 ms-5 mb-5">
    {{-- Kembali --}}
    <a href="{{ route('cart.index') }}"
        class="hidden w-fit md:flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-full shadow-lg border border-gray-200 hover:shadow-xl hover:-translate-y-0.5 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>

        <span class="text-sm font-medium">
            Kembali
        </span>
    </a>

    <h1 class="text-2xl md:text-4xl font-bold font-montserrat tracking-wide text-primary text-shadow-2xs">
        Checkout Produk
    </h1>
</header>
