<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

    <div class="relative w-full max-w-md p-4">

        <div class="bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-default pb-4">

                <h3 class="text-lg font-medium text-heading">
                    Edit Kategori
                </h3>

                <a href="{{ route('categories.index') }}"
                    class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base p-2">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12" />
                    </svg>

                </a>

            </div>

            {{-- Form --}}
            <form action="{{ route('categories.update', $category) }}" method="POST" class="pt-6">

                @csrf
                @method('PUT')

                {{-- Nama --}}
                <x-forms.label-input label="Nama Kategori" for="name" placeholder="Masukkan nama kategori"
                    :value="old('name', $category->name)" required />

                {{-- Deskripsi --}}
                <x-forms.label-input label="Deskripsi Singkat" for="description"
                    placeholder="Masukkan deskripsi kategori" :value="old('description', $category->description)" />

                <x-forms.button type="submit">
                    Simpan Perubahan
                </x-forms.button>

            </form>

        </div>

    </div>

</div>
