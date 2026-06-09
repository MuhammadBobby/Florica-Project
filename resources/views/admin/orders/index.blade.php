<x-layouts.dashboard title="Orders">
    <x-dashboard.header title="Pesanan Pelanggan" subTitle="Lihat semua pesanan pelanggan Florica Blooms." />


    {{-- Table --}}
    @if ($orders->isEmpty())
        <x-dashboard.table-empty title="Belum Ada Pesanan">
            Saat ini belum ada pesanan yang masuk.
            Pesanan pelanggan akan muncul di halaman ini setelah checkout berhasil dilakukan.
        </x-dashboard.table-empty>
    @else
        <x-dashboard.orders.table :orders="$orders" />
    @endif

    {{-- Pagination --}}
    <x-dashboard.pagination :paginator="$orders" />

    {{-- Modal --}}
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
