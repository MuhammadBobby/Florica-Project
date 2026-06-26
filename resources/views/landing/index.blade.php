<x-layouts.home title="Home">
    {{-- =========== BERANDA ========== --}}
    <x-landing.header />

    {{-- =========== BEST PRODUCT ========== --}}
    @foreach ($categories as $category)
        @if ($category->products->isNotEmpty())
            <x-landing.best-product :category="$category" :products="$category->products" />
        @endif
    @endforeach

    {{-- ========== ABOUT & CONTACT ========== --}}
    <x-landing.about-contact />

    {{-- ========== FOOTER ========== --}}
    <x-front.footer />
</x-layouts.home>
