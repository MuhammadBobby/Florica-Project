<x-layouts.layout title="{{ $title }}">

    <x-dashboard.sidebar />

    <div class="p-4 sm:ml-64">
        <div class="p-4 border border-default border-dashed rounded-base my-5">
            {{ $slot }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const form = document.getElementById('logout-form');

            form.addEventListener('submit', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: 'Yakin Ingin Keluar?',
                    text: 'Anda yakin ingin keluar dari akun ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ec4899',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });
    </script>

</x-layouts.layout>
