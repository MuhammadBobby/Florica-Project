@php
    $statusProductOptions = [
        [
            'label' => 'Aktif',
            'value' => 'active',
        ],
        [
            'label' => 'Tidak Aktif',
            'value' => 'inactive',
        ],
    ];
@endphp

<x-layouts.dashboard title="Products">
    <x-dashboard.header title="Produk" subTitle="Kelola Produk Florica Blooms." />

    {{-- Create Button --}}
    <div class="flex flex-col sm:flex-row md:items-center justify-between mt-12">
        {{-- Filter --}}
        <x-dashboard.products.filter :categories="$categories" :statusProductOptions="$statusProductOptions" />

        <button type="button" data-modal-target="create-product-modal" data-modal-toggle="create-product-modal"
            class="mt-3 md:mt-0 px-4 py-2.5 text-sm font-medium text-white bg-primary rounded-base hover:bg-pink-700 focus:ring-4 focus:ring-secondary">
            Tambah Produk
        </button>
    </div>

    <div class="flex gap-3 items-center mb-8 ">
        {{-- Export --}}
        <button type="button" data-modal-target="export-product-modal" data-modal-toggle="export-product-modal"
            class="px-4 py-2 bg-white border border-primary text-primary rounded-base hover:bg-primary hover:text-white w-fit">
            Laporan Penjualan Produk
        </button>
    </div>

    {{-- Table --}}
    @if ($products->isEmpty())
        <x-dashboard.table-empty title="Belum Ada Produk">
            Saat ini belum ada produk yang anda tambahkan.
        </x-dashboard.table-empty>
    @else
        <x-dashboard.products.table :products="$products" />
    @endif

    {{-- Pagination --}}
    <x-dashboard.pagination :paginator="$products" />

    {{-- Modal --}}
    <x-dashboard.products.export-product :products="$productsDropdown" />
    <x-dashboard.products.create-modal :categories="$categories" />
    @if (request()->routeIs('products.edit'))
        <x-dashboard.products.edit-modal :product="$product" :categories="$categories" />
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

        @if ($errors->any() && old('form_type') === 'create-product')
            <script>
                document.addEventListener('DOMContentLoaded', () => {

                    const modalElement = document.getElementById('create-product-modal');

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
