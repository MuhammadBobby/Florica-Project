<x-layouts.dashboard title="Customers">
    <x-dashboard.header title="Data Pelanggan" subTitle="Lihat semua data pelanggan Florica Blooms." />


    {{-- Table --}}
    @if ($customers->isEmpty())
        <x-dashboard.table-empty title="Belum Ada Pelanggan">
            Saat ini belum ada pelanggan yang mendaftar.
        </x-dashboard.table-empty>
    @else
        <x-dashboard.customers.table :customers="$customers" />
    @endif

    {{-- Pagination --}}
    <x-dashboard.pagination :paginator="$customers" />


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

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: @json(session('error')),
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
