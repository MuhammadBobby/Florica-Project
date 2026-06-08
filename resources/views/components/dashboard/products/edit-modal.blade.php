@if (isset($product))
    <div class="fixed inset-0 z-50 bg-black/50">

        {{-- Container scroll --}}
        <div class="flex items-start justify-center w-full h-full overflow-y-auto p-4">

            {{-- Modal --}}
            <div class="relative w-full max-w-xl my-8">

                <div class="bg-neutral-primary-soft border border-default rounded-base shadow-xl">

                    {{-- Header --}}
                    <div
                        class=" z-10 flex items-center justify-between p-5 border-b border-default bg-neutral-primary-soft rounded-t-base">
                        <h3 class="text-lg font-medium text-heading">
                            Edit Produk
                        </h3>

                        <a href="{{ route('products.index') }}"
                            class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 inline-flex justify-center items-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>

                    {{-- Body --}}
                    <div class="p-5">
                        <form action="{{ route('products.update', $product) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            {{-- Category --}}
                            <x-forms.select label="Kategori" for="category_id" :options="$categories->pluck('name', 'id')->toArray()" :value="$product->category_id"
                                required />

                            {{-- Nama --}}
                            <x-forms.label-input label="Nama Produk" for="name"
                                value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk" required />

                            {{-- Deskripsi --}}
                            <x-forms.textarea label="Deskripsi" for="description"
                                placeholder="Masukkan deskripsi produk"
                                value="{{ old('description', $product->description) }}">

                            </x-forms.textarea>

                            {{-- Harga --}}
                            <x-forms.label-input label="Harga" for="price" type="number"
                                value="{{ old('price', $product->price) }}" required />

                            {{-- Stok --}}
                            <x-forms.label-input label="Stok" for="stock" type="number"
                                value="{{ old('stock', $product->stock) }}" required />

                            {{-- Berat --}}
                            <x-forms.label-input label="Berat (gram)" for="weight" type="number"
                                value="{{ old('weight', $product->weight) }}" />

                            {{-- Status --}}
                            <div class="mb-5">
                                <label class="block mb-2.5 text-sm font-medium text-heading">
                                    Status Produk
                                </label>

                                <select name="is_active"
                                    class="w-full border border-default-medium rounded-base px-3 py-2.5 bg-white">

                                    <option value="1" @selected(old('is_active', $product->is_active) == 1)>
                                        Aktif
                                    </option>

                                    <option value="0" @selected(old('is_active', $product->is_active) == 0)>
                                        Nonaktif
                                    </option>
                                </select>
                            </div>

                            {{-- Primary Image Lama --}}
                            @if ($product->primaryImage)
                                <div class="mb-5">
                                    <label class="block mb-2 text-sm font-medium text-heading">
                                        Gambar Utama Saat Ini
                                    </label>

                                    <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                        class="w-32 h-32 object-cover rounded-base border">
                                </div>
                            @endif

                            {{-- Upload Primary Baru --}}
                            <div class="mb-5">
                                <label class="block mb-2.5 text-sm font-medium text-heading">
                                    Ganti Gambar Utama (Max. 2MB)
                                </label>

                                <input type="file" name="primary_image" accept="image/*"
                                    class="w-full border border-default-medium rounded-base px-3 py-2.5">

                                @error('primary_image')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Gallery Lama --}}
                            @if ($product->images->count())
                                <div class="mb-5">
                                    <label class="block mb-2 text-sm font-medium text-heading">
                                        Gallery Saat Ini
                                    </label>

                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach ($product->images->where('is_primary', false) as $image)
                                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                                class="w-full h-24 object-cover rounded-base border">
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Upload Gallery Baru --}}
                            <div class="mb-5">
                                <label class="block mb-2.5 text-sm font-medium text-heading">
                                    Tambah Gambar Gallery
                                </label>

                                <input type="file" name="gallery_images[]" multiple accept="image/*"
                                    class="w-full border border-default-medium rounded-base px-3 py-2.5">

                                <small class="text-body">
                                    Gambar lama tidak akan terhapus.
                                </small>
                            </div>

                            <x-forms.button type="submit">
                                Simpan Perubahan
                            </x-forms.button>

                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endif
