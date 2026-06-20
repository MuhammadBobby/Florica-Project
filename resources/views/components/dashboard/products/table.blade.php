@props(['products'])

@php
    $categoryColors = [
        'bouquet' => 'text-primary',
        'flower box' => 'text-purple-600',
        'standing flower' => 'text-amber-600',
    ];
@endphp

<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">

    <table class="w-full min-w-[900px] text-sm text-left text-body">

        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
            <tr class="text-center">
                <th class="px-2 py-3 font-medium">No.</th>
                <th class="px-6 py-3 font-medium">Produk</th>
                <th class="px-6 py-3 font-medium">Deskripsi</th>
                <th class="px-6 py-3 font-medium">Harga</th>
                <th class="px-6 py-3 font-medium">Stok</th>
                <th class="px-6 py-3 font-medium">Kategori</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($products as $index => $product)
                @php
                    $color = $categoryColors[strtolower($product->category->name ?? '')] ?? 'text-emerald-700';
                @endphp

                <tr
                    class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition">

                    {{-- NO --}}
                    <td class="px-2 py-4 font-medium text-heading text-center whitespace-nowrap">
                        {{ $index + 1 + ($products->currentPage() - 1) * $products->perPage() }}.
                    </td>

                    {{-- PRODUCT --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3 min-w-[220px]">
                            <img src="{{ asset('storage/' . $product->primaryImage?->image_url) ?? '/assets/products/default_image.webp' }}"
                                alt="Image {{ $product->name }}"
                                class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-base shadow-xs shrink-0">

                            <p class="font-semibold text-heading leading-tight">
                                {{ $product->name }}
                            </p>
                        </div>
                    </td>

                    {{-- DESC --}}
                    <td class="px-6 py-4 max-w-[250px]">
                        <p class="line-clamp-2 break-words text-xs sm:text-sm">
                            {{ $product->description ?? '-' }}
                        </p>
                    </td>

                    {{-- PRICE --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    {{-- STOCK --}}
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        {{ $product->stock }}
                    </td>

                    {{-- CATEGORY --}}
                    <td class="px-6 py-4 font-bold {{ $color }} whitespace-nowrap">
                        {{ $product->category->name ?? '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4">
                        @if ($product->is_active)
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 mr-1.5 bg-emerald-500 rounded-full"></span>
                                Aktif
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                <span class="w-2 h-2 mr-1.5 bg-red-500 rounded-full"></span>
                                Tidak Aktif
                            </span>
                        @endif
                    </td>

                    {{-- ACTION --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-3">

                            {{-- DETAIL --}}
                            <a href="{{ route('products.show', $product) }}"
                                class="text-yellow-500 hover:text-yellow-600 transition" title="Detail">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('products.edit', $product) }}"
                                class="text-primary hover:text-pink-700 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 hover:text-red-700 transition"
                                    title="Hapus">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
</div>
