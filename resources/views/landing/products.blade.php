<x-layouts.home title="Products">
    <header class="py-3 font-montserrat">
        <h1 class="text-5xl font-light -tracking-wider text-center mb-4">Produk <span
                class="text-primary font-semibold">Florica Blooms</span></h1>
        <p class="text-center text-gray-600 mb-8">Discover our wide range of products that cater to your needs.</p>
    </header>


    {{-- Filter Product --}}
    <x-front.filter-product :categories="$categories" />


    <div class="grid grid-cols-1 gap-3 md:gap-8 mt-8 sm:grid-cols-2 lg:grid-cols-3 md:ms-2 md:mx-10">
        @foreach ($products as $product)
            <x-front.card-product :product="$product" />
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="my-8">
        {{ $products->withQueryString()->links() }}
    </div>
</x-layouts.home>
