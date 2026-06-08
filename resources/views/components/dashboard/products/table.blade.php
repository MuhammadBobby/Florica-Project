@props(['products'])

<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
            <tr class="text-center">
                <th scope="col" class="px-2 py-3 font-medium">
                    No.
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Produk
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Deskripsi
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Harga
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Stok
                </th>
                <th scope="col" class="px-6 py-3 font-medium text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                    <th scope="row" class="w-fit px-2 py-4 font-medium text-heading">
                        {{ $index + 1 + ($products->currentPage() - 1) * $products->perPage() }}.
                    </th>
                    <td class="px-6 py-4 font-semibold flex justify-start items-center gap-3">
                        <img src="{{ asset('storage/' . $product->primaryImage?->image_url) ?? '/assets/products/default_image.webp' }}"
                            alt="Image {{ $product->name }}" class="w-20 shadow-xs rounded-base">
                        <p>
                            {{ $product->name }}
                        </p>
                    </td>
                    <td class="px-6 py-4 max-w-sm">
                        <p class="line-clamp-2 wrap-break-words">
                            {{ $product->description ?? '-' }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="whitespace-nowrap">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        {{ $product->stock }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-4">

                            {{-- Detail --}}
                            <a href="{{ route('products.show', $product) }}"
                                class="text-yellow-500 hover:text-yellow-600" title="Detail">
                                <svg class="w-6 h-6 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('products.edit', $product) }}" class="text-primary hover:text-pink-700"
                                title="Edit">

                                <svg class="w-6 h-6 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 hover:text-red-700 cursor-pointer"
                                    title="Hapus">

                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 3V4H4V6H5V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V6H20V4H15V3H9ZM7 6H17V19H7V6Z" />
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
