@props(['products', 'category'])


<section id="bestProduct" class="my-40">
    <header class="my-12">
        <h2 class="font-montserrat text-5xl  text-center -tracking-wider">Best Seller {{ $category }}</h2>
    </header>

    {{-- List Product --}}
    <div class="flex justify-center gap-5">
        @foreach ($products as $product)
            <x-front.best-product-card :product="$product" />
        @endforeach
    </div>

    {{-- Button Lainnya --}}
    <a href="#"
        class="block w-fit mx-auto text-lg font-semibold text-primary tracking-widest bg-secondary box-border border border-transparent hover:bg-pink-300 focus:ring-4 focus:ring-pink-200 shadow-xs leading-5 rounded-full px-4 py-2.5 mt-10 focus:outline-none">
        Lihat produk {{ $category }} Lainnya >>
    </a>
</section>
