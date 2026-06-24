<x-layouts.home title="Home">
    {{-- =========== BERANDA ========== --}}
    <x-landing.header />

    {{-- =========== BEST PRODUCT ========== --}}
    @foreach ($categories as $category)
        <x-landing.best-product :products="$bouquetProducts" :category="$category" />
    @endforeach

    {{-- ========== ABOUT & CONTACT ========== --}}
    <x-landing.about-contact />

    {{-- ========== FOOTER ========== --}}
    <x-front.footer />
</x-layouts.home>
