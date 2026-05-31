<x-layouts.home title="Home">
    {{-- =========== BERANDA ========== --}}
    <x-landing.header />

    {{-- =========== BEST PRODUCT ========== --}}
    <x-landing.best-product :products="$bouquetProducts" category="Bouquets" />
    <x-landing.best-product :products="$keychainProducts" category="Keychains" />

    {{-- ========== ABOUT & CONTACT ========== --}}
    <x-landing.about-contact />

    {{-- ========== FOOTER ========== --}}
    <x-front.footer />
</x-layouts.home>
