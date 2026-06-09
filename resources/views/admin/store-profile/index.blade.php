<x-layouts.dashboard title="Profile Store">

    <x-dashboard.header title="Profile Toko" subTitle="Kelola informasi toko Florica Blooms." />

    <x-dashboard.form-store-profile :storeProfile="$storeProfile" />

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

                document.querySelectorAll('.update-profile').forEach(form => {

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Update Data?',
                            text: 'Anda yakin ingin memperbarui data ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Update',
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
