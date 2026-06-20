@php
    $avgRating = round($product->reviews->avg('rating') ?? 0, 1);
    $reviewCount = $product->reviews->count();
    $stockAvailable = $product->stock > 0;
@endphp

<x-layouts.home title="{{ $product->name }}">
    <div class="container mx-auto px-4 py-8 max-w-6xl">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Gallery --}}
            <div>
                <x-front.gallery-product :primaryImage="$product->primaryImage" :images="$product->images" />
            </div>

            {{-- Product Detail --}}
            <div>

                <div class="flex justify-between items-center">
                    {{-- Category --}}
                    @if ($product->category)
                        <span class="inline-block bg-pink-100 text-primary text-xs font-medium px-3 py-1 rounded-full">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    <button id="btn-wishlist" data-product="{{ $product->id }}"
                        class="w-12 h-12 flex items-center justify-center" title="Wishlist">

                        <svg id='wishlist-icon'
                            class="w-6 h-6 text-gray-800 {{ $isWishlist ? 'text-red-500 fill-current' : 'text-gray-500' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                        </svg>
                    </button>
                </div>

                {{-- Product Name --}}
                <h1 class="text-3xl md:text-4xl font-bold mt-3">
                    {{ $product->name }}
                </h1>

                {{-- Rating --}}
                <div class="flex items-center gap-2 mt-4">
                    <div class="flex text-yellow-400 text-lg">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($avgRating))
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>

                    <span class="text-sm text-gray-600">
                        {{ $avgRating }} ({{ $reviewCount }} ulasan)
                    </span>
                </div>

                {{-- Price --}}
                <div class="mt-6">
                    <span class="text-3xl font-bold text-primary">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Stock --}}
                <div class="mt-3">
                    <span class="text-sm {{ $stockAvailable ? 'text-green-600' : 'text-red-500' }} font-medium">
                        {{ $stockAvailable ? 'Stok tersedia' : 'Stok habis' }}
                    </span>
                </div>

                {{-- Description --}}
                <div class="mt-6">
                    <h3 class="font-semibold text-lg">
                        Deskripsi Produk
                    </h3>

                    <p class="text-gray-600 leading-relaxed mt-2">
                        {{ $product->description }}
                    </p>
                </div>

                {{-- Quantity --}}
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="mt-6">
                        <label class="block text-sm font-medium mb-2">
                            Jumlah
                        </label>

                        <input type="number" min="1" value="1" name="quantity"
                            class="w-24 border border-gray-300 rounded-lg px-3 py-2 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- Action Button --}}
                    <div class="flex flex-col sm:flex-row gap-3 mt-8">
                        <button type="submit"
                            class="flex-1 bg-secondary hover:bg-pink-300 text-primary font-semibold py-3 rounded-full transition">
                            Tambah ke Keranjang
                        </button>

                        {{-- <button
                            class="flex-1 bg-primary hover:bg-pink-700 text-white font-semibold py-3 rounded-full transition">
                            Beli Sekarang
                        </button> --}}
                    </div>
                </form>

                {{-- Additional Info --}}
                <div class="mt-8 border-t pt-6">

                    <div class="flex items-center gap-2 mb-3">
                        🚚
                        <span class="text-sm text-gray-600">
                            Pengiriman ke Seluruh Kota Medan, Sumatera Utara
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mb-3">
                        🔒
                        <span class="text-sm text-gray-600">
                            Pembayaran aman
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        ♻️
                        <span class="text-sm text-gray-600">
                            Garansi produk sesuai deskripsi
                        </span>
                    </div>

                </div>

            </div>

        </div>

        {{-- Reviews --}}
        <section class="mt-20">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">
                    Ulasan Pelanggan
                </h2>

                <span class="text-sm text-gray-500">
                    {{ $product->reviews->count() }} Ulasan
                </span>
            </div>

            @forelse ($product->reviews as $review)
                <div class="border border-gray-200 rounded-xl p-5 mb-4">

                    <div class="flex items-start justify-between">

                        <div>
                            <h4 class="font-semibold text-gray-900">
                                {{ $review->user->full_name ?? 'Pelanggan' }}
                            </h4>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <span>
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                </span>
                            @endfor
                        </div>

                    </div>

                    @if ($review->review)
                        <p class="text-gray-600 mt-3 leading-relaxed">
                            {{ $review->review }}
                        </p>
                    @endif

                </div>
            @empty
                <div class="border border-dashed rounded-xl p-8 text-center">
                    <p class="text-gray-500">
                        Belum ada ulasan untuk produk ini.
                    </p>
                </div>
            @endforelse
        </section>

        <section class="mt-20">
            <h2 class="text-2xl font-bold mb-6">
                Produk Terkait
            </h2>

            @if ($relatedProducts->count())
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('product.detail', $related->slug) }}" class="group">
                            <div class="overflow-hidden rounded-xl border border-gray-100">

                                <img src="{{ asset('storage/' . $related->primaryImage?->image_url) ?? '/assets/products/default_image.webp' }}"
                                    alt="{{ $related->name }}"
                                    class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">

                            </div>

                            <div class="mt-3">
                                <h3 class="font-medium line-clamp-2">
                                    {{ $related->name }}
                                </h3>

                                <p class="text-primary font-bold mt-1">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach

                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    Belum ada produk terkait.
                </div>
            @endif
        </section>


        {{-- Kembali --}}
        <a href="{{ back()->getTargetUrl() }}"
            class="fixed top-20 left-6 z-50
           flex items-center gap-2
           px-4 py-3
           bg-primary text-white
           rounded-full
           shadow-lg
           border border-gray-200
           hover:shadow-xl
           hover:-translate-y-0.5
           transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>

            <span class="text-sm font-medium">
                Kembali
            </span>
        </a>
    </div>

    @push('scripts')
        <script>
            document
                .getElementById('btn-wishlist')
                ?.addEventListener('click', async function() {

                    const productId =
                        this.dataset.product;

                    const response =
                        await fetch(
                            `/wishlist/toggle/${productId}`, {
                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content
                                }
                            }
                        );

                    const result =
                        await response.json();

                    const icon =
                        document.getElementById(
                            'wishlist-icon'
                        );

                    if (result.action === 'added') {

                        icon.setAttribute(
                            'fill',
                            'currentColor'
                        );

                        icon.classList.add(
                            'text-red-500'
                        );

                        Swal.fire({
                            icon: 'success',
                            title: 'Ditambahkan ke favorit',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });

                    } else {

                        icon.setAttribute(
                            'fill',
                            'none'
                        );

                        icon.classList.remove(
                            'text-red-500'
                        );

                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus dari favorit',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    }

                });
        </script>
    @endpush
</x-layouts.home>
