<x-layouts.dashboard title="Categories">
    <x-dashboard.header title="Categories" subTitle="Kelola Kategori Produk Florica Blooms." />

    {{-- Create Button --}}
    <div class="flex items-center justify-end">
        <button type="button" data-modal-target="create-category-modal" data-modal-toggle="create-category-modal"
            class="mb-4 px-4 py-2.5 text-sm font-medium text-white bg-primary rounded-base hover:bg-pink-700 focus:ring-4 focus:ring-secondary">
            Tambah Kategori
        </button>
    </div>

    {{-- Table --}}
    <x-dashboard.categories.table :categories="$categories" />

    {{-- Pagination --}}
    <x-dashboard.pagination :paginator="$categories" />

    {{-- Modal --}}
    <x-dashboard.categories.create-modal />
    @if (request()->routeIs('categories.edit'))
        <x-dashboard.categories.edit-modal :category="$category" />
    @endif

    @push('scripts')
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: @json(session('success')),
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
            </script>
        @endif

        @if ($errors->any() && old('form_type') === 'create-category')
            <script>
                document.addEventListener('DOMContentLoaded', () => {

                    const modalElement = document.getElementById('create-category-modal');

                    modalElement.classList.add('bg-black/50');

                    const modal = new Modal(modalElement);

                    modal.show();

                });
            </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelectorAll('.delete-form').forEach(form => {

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Hapus Data?',
                            text: 'Data yang dihapus tidak dapat dikembalikan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal',
                        }).then(result => {

                            if (result.isConfirmed) {
                                form.submit();
                            }

                        });
                    });

                });

            });
        </script>
    @endpush
</x-layouts.dashboard>
