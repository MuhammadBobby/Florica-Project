<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- icon --}}
    <link rel="icon" href="{{ asset('assets/logo_florica.webp') }}" type="image/x-icon">
    <title>Florica Blooms - {{ $title }}</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- swear alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-poppins">
    {{ $slot }}

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    {{-- swear alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // swear alert logout
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
    {{-- toggle password --}}
    <script>
        function togglePassword(id, button) {

            const input = document.getElementById(id);

            const eyeOpen = button.querySelector('.eye-open');
            const eyeClose = button.querySelector('.eye-close');

            if (input.type === 'password') {

                input.type = 'text';

                eyeOpen.classList.add('hidden');
                eyeClose.classList.remove('hidden');

            } else {

                input.type = 'password';

                eyeOpen.classList.remove('hidden');
                eyeClose.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
