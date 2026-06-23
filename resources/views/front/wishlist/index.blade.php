<x-layouts.home title="Wishlist Saya">

    <div class="container mx-auto py-10">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold">
                favorit Saya
            </h1>

            <a href="{{ route('landing') }}" class="px-4 py-2 bg-primary text-white rounded-base">

                Kembali
            </a>

        </div>

        <div class="grid md:grid-cols-4 gap-6">

            @forelse($wishlists as $wishlist)
                <a href="{{ route('product.detail', $wishlist->product->slug) }}"
                    class="bg-white rounded-base shadow hover:shadow-xl transition relative">

                    @if ($wishlist->product->trashed())
                        <span class="text-xs font-medium text-red-500 absolute top-2 right-2 bg-white rounded-full px-2">
                            Produk Sudah Tidak Tersedia
                        </span>
                    @endif

                    <img src="{{ asset('storage/' . $wishlist->product->primaryImage->image_url) }}"
                        class="w-full h-60 object-cover rounded-t-base">

                    <div class="p-4">

                        <h4 class="font-semibold">

                            {{ $wishlist->product->name }}

                        </h4>

                        <p class="text-primary font-bold mt-2">

                            Rp
                            {{ number_format($wishlist->product->price, 0, ',', '.') }}

                        </p>

                    </div>

                </a>

            @empty

                <div class="col-span-full text-center py-20">

                    <h3 class="text-xl font-semibold">

                        Belum ada produk favorit

                    </h3>

                </div>
            @endforelse

        </div>

        <div class="mt-8">

            {{ $wishlists->links() }}

        </div>

    </div>

</x-layouts.home>
