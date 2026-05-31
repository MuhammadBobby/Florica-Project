<x-layouts.home title="Home">
    {{-- =========== BERANDA ========== --}}
    <x-landing.header />

    {{-- =========== BEST PRODUCT ========== --}}
    <x-landing.best-product :products="$bouquetProducts" />

</x-layouts.home>
