<x-layouts.layout title="{{ $title }}">
    <x-front.navbar />

    <div class="container mx-auto px-4 md:px-6 lg:px-8 pt-24">
        {{ $slot }}
    </div>

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

                document.querySelectorAll('.delete-form-cart').forEach(form => {

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Hapus Produk?',
                            text: 'Anda yakin ingin menghapus produk ini dari keranjang?',
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
</x-layouts.layout>
