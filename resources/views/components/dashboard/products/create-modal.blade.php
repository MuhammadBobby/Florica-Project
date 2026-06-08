<div id="create-product-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    Tambah Produk
                </h3>
                <button type="button"
                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="create-product-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                class="pt-4 md:pt-6">

                @csrf

                {{-- Kategori --}}
                <x-forms.select label="Kategori" for="category_id" :options="$categories->pluck('name', 'id')->toArray()" required />

                {{-- Nama Produk --}}
                <x-forms.label-input label="Nama Produk" for="name" type="text"
                    placeholder="Masukkan nama produk" required />

                {{-- Deskripsi --}}
                <x-forms.textarea label="Deskripsi" for="description" placeholder="Masukkan deskripsi produk" />

                {{-- Harga --}}
                <x-forms.label-input label="Harga" for="price" type="number" placeholder="Contoh: 150000"
                    required />

                {{-- Stock --}}
                <x-forms.label-input label="Stok" for="stock" type="number" placeholder="Masukkan stok"
                    required />

                {{-- Berat --}}
                <x-forms.label-input label="Berat (gram)" for="weight" type="number" placeholder="Contoh: 500" />

                {{-- Status --}}
                <div class="mb-5">
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Status Produk
                    </label>

                    <select name="is_active"
                        class="w-full border border-default-medium rounded-base px-3 py-2.5 bg-white active:border-primary focus:ring-primary focus:border-primary ">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                {{-- Gambar Utama --}}
                <div class="mb-5">
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Gambar Utama (Max. 2MB)
                    </label>

                    <input type="file" name="primary_image" accept="image/*" required
                        class="w-full border border-default-medium rounded-base px-3 py-2.5">
                </div>

                {{-- Galeri Produk --}}
                <div class="mb-5">
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Gambar Tambahan
                    </label>

                    <input type="file" name="gallery_images[]" accept="image/*" multiple
                        class="w-full border border-default-medium rounded-base px-3 py-2.5">

                    <small class="text-body">
                        Bisa upload beberapa gambar sekaligus.
                    </small>
                </div>

                <x-forms.button type="submit">
                    + Tambah Produk
                </x-forms.button>
            </form>
        </div>
    </div>
</div>
