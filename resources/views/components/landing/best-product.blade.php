@props(['products'])


<section id="bestProduct" class="my-32">
    <header class="my-12">
        <h2 class="font-montserrat text-5xl  text-center -tracking-wider">Best Seller Bouquets</h2>
    </header>

    {{-- List Product --}}
    <div class="flex justify-center gap-5">
        @foreach ($products as $product)
            <x-front.best-product-card :product="$product" />
        @endforeach
    </div>
</section>
