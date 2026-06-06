<div id="create-category-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    Tambah Kategori
                </h3>
                <button type="button"
                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="create-category-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <form action="{{ route('categories.store') }}" method="POST" class="pt-4 md:pt-6">
                @csrf

                <input type="hidden" name="form_type" value="create-category">

                {{-- Name Kategori --}}
                <x-forms.label-input label="Nama Kategori" for="name" type="text" name="name"
                    placeholder="Masukkan nama kategori" required />

                {{-- Deskripsi --}}
                <x-forms.label-input label="Deskripsi Singkat" for="description" type="text" name="description"
                    placeholder="Masukkan deskripsi kategori" />

                <x-forms.button type="submit">
                    + Tambah
                </x-forms.button>
            </form>
        </div>
    </div>
</div>
