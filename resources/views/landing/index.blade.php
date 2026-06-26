<x-layouts.home title="Home">
    {{-- =========== BERANDA ========== --}}
    <x-landing.header />

    {{-- =========== BEST PRODUCT ========== --}}
    @foreach ($categories as $category)
        <x-landing.best-product
        :category="$category"
        :products="$category->slug === 'bouquet'
            ? $bouquetProducts
            : $keychainProducts" />
    @endforeach

    {{-- ========== ABOUT & CONTACT ========== --}}
    <x-landing.about-contact />

    {{-- ========== FOOTER ========== --}}
    <x-front.footer />
</x-layouts.home>
