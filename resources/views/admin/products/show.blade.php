<x-layouts.dashboard title="{{ $product->name }}">

    <div class="flex items-center gap-4">
        {{-- tombol kembali --}}
        <a href="{{ back()->getTargetUrl() }}"
            class="mb-10 px-4 py-2.5 text-sm font-medium text-white bg-primary rounded-base hover:bg-pink-700 focus:ring-4 focus:ring-secondary flex items-center">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14M5 12l4-4m-4 4 4 4" />
            </svg>

            Kembali </a>

        <x-dashboard.header title="Detail Produk" subTitle="" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        {{-- Image --}}
        <div>

            <img src="{{ asset('storage/' . $product->primaryImage?->image_url) }}"
                class="w-full aspect-square object-cover rounded-3xl shadow">

            {{-- Gallery --}}
            <div class="grid grid-cols-4 gap-3 mt-4">

                @foreach ($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_url) }}"
                        class="aspect-square object-cover rounded-xl border cursor-pointer hover:opacity-80">
                @endforeach

            </div>

        </div>

        {{-- Content --}}
        <div>

            <span class="inline-block px-3 py-1 rounded-full bg-secondary text-primary text-sm">
                {{ $product->category->name }}
            </span>

            <h1 class="text-4xl font-bold mt-4">
                {{ $product->name }}
            </h1>

            @php
                $rating = round($product->reviews->avg('rating') ?? 0, 1);
            @endphp

            <div class="flex items-center gap-2 mt-4">

                <span class="text-yellow-500">
                    ⭐
                </span>

                <span>
                    {{ $rating }}
                </span>

                <span class="text-body">
                    ({{ $product->reviews->count() }} ulasan)
                </span>

            </div>

            <h2 class="text-4xl font-bold text-primary mt-6">

                Rp {{ number_format($product->price, 0, ',', '.') }}

            </h2>

            <div class="mt-6 text-body">

                {!! nl2br(e(Str::limit($product->description, 250))) !!}

            </div>

            <div class="mt-6">

                <p>
                    <strong>Stok:</strong>
                    {{ $product->stock }}
                </p>

                <p>
                    <strong>Berat:</strong>
                    {{ $product->weight }} gram
                </p>

            </div>
        </div>

    </div>

    {{-- Review --}}
    <section class="mt-8">

        <h2 class="text-2xl font-bold mb-8">
            Review Pelanggan
        </h2>

        <div class="space-y-6">

            @forelse($product->reviews as $review)
                <div class="p-5 border rounded-2xl">

                    <div class="flex justify-between">

                        <h4 class="font-semibold">
                            {{ $review->user->full_name }}
                        </h4>

                        <span>
                            ⭐ {{ $review->rating }}
                        </span>

                    </div>

                    <p class="mt-3 text-body">
                        {{ $review->review }}
                    </p>

                </div>

            @empty

                <p class="text-body">
                    Belum ada review.
                </p>
            @endforelse

        </div>

    </section>


</x-layouts.dashboard>
