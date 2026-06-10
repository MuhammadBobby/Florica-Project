@php
    $avgRating = round($product->reviews->avg('rating') ?? 0, 1);
    $reviewCount = $product->reviews->count();
@endphp

<div class="w-full max-w-sm bg-neutral-primary-soft p-6 border border-default rounded-base shadow-xs">
    <a href="{{ route('product.detail', $product->slug) }}">
        <img class="rounded-base mb-6 max-h-64 w-full object-cover"
            src="{{ asset('storage/' . $product->primaryImage?->image_url) ?? '/assets/products/default_image.webp' }}"
            alt={{ $product->name }} />
    </a>
    <div>

        {{-- Rating --}}
        <div class="flex items-center space-x-3 mb-6">
            <div class="flex items-center space-x-1">

                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= floor($avgRating) ? 'text-fg-yellow' : 'text-gray-300' }}"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">

                        <path
                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                    </svg>
                @endfor

            </div>

            <span
                class="bg-brand-softer border border-brand-subtle text-fg-brand-strong text-xs font-medium px-1.5 py-0.5 rounded-sm">
                {{ $avgRating }}/5
            </span>

            <span class="text-sm text-body">
                ({{ $reviewCount }} review{{ $reviewCount > 1 ? 's' : '' }})
            </span>

        </div>


        <a href="#">
            <h5 class="text-xl text-heading font-semibold tracking-tight">{{ $product->name }}</h5>
            <p class="text-gray-600 mb-4 line-clamp-2 text-sm">{{ $product->description }}</p>
        </a>

        <div class="flex flex-col gap-4 mt-6 sm:flex-row sm:items-center sm:justify-between">

            <span class="text-xl font-bold text-primary">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>

            <button type="button"
                class="flex items-center justify-center px-3 py-1.5 text-sm tracking-widest rounded-full border border-transparent shadow-xs bg-secondary text-primary hover:bg-pink-300 focus:outline-none focus:ring-4 focus:ring-pink-200">
                + Tambah Keranjang
            </button>

        </div>
    </div>
</div>
