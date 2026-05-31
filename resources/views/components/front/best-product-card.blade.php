@props(['product'])

<div class="block w-full max-w-sm border-2 border-default rounded-base shadow-xl md:w-1/3">
    <div class="h-full flex flex-col justify-between pb-3">
        <div class="h-full">
            <a href="#">
                <img class="rounded-t-base h-72 w-full object-cover"
                    src="/assets/products/{{ $product->primaryImage?->image_url ?? 'default_image.webp' }}"
                    alt="Image {{ $product->name }}" />
            </a>
            <div class="p-6 text-center">
                <span
                    class="inline-flex items-center bg-secondary border border-pink-200 text-primary text-xs font-medium px-1.5 py-0.5 rounded-sm">
                    <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.122 17.645a7.185 7.185 0 0 1-2.656 2.495 7.06 7.06 0 0 1-3.52.853 6.617 6.617 0 0 1-3.306-.718 6.73 6.73 0 0 1-2.54-2.266c-2.672-4.57.287-8.846.887-9.668A4.448 4.448 0 0 0 8.07 6.31 4.49 4.49 0 0 0 7.997 4c1.284.965 6.43 3.258 5.525 10.631 1.496-1.136 2.7-3.046 2.846-6.216 1.43 1.061 3.985 5.462 1.754 9.23Z" />
                    </svg>
                    Trending
                </span>

                {{-- Product Name --}}
                <div class="mt-3 text-center">
                    <h5 class="text-2xl font-bold tracking-tight text-primary">{{ $product->name }}</h5>

                    <p class="mt-2 text-sm font-light text-gray-400 line-clamp-2">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Product Price --}}
        <div class="mx-auto">
            <p class="text-primary text-2xl font-medium tracking-wide text-center">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <a href="#"
                class="block text-sm text-primary tracking-widest bg-secondary box-border border border-transparent hover:bg-pink-300 focus:ring-4 focus:ring-pink-200 shadow-xs leading-5 rounded-full px-4 py-2.5 mt-5 focus:outline-none">
                + Tambah Keranjang
            </a>
        </div>
    </div>
</div>
