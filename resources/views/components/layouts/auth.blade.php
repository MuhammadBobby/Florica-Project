<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Florica Blooms - {{ $title }}</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins">
    <div class="flex justify-center items-center bg-secondary w-full h-full min-w-screen min-h-screen">
        <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-md">
            <div class="text-center">
                <a href="{{ route('landing') }}">
                    <img src="/assets/logo_florica.webp" class="w-1/3 h-auto mx-auto"
                        alt="{{ config('app.name') }} Logo">
                </a>

                <hr class="my-3 border-gray-300" />

                <h1 class="text-3xl font-bold mb-1.5 capitalize">{{ $type }} Form</h1>
                <p class="text-sm text-body">Silahkan
                    {{ $type === 'register' ? 'Daftar untuk Membuat ' : 'Login Menggunakan ' }}
                    Akun Anda</p>
            </div>

            {{-- Form --}}
            {{ $slot }}

            <footer class="mt-5 text-center">
                <p class="text-sm text-body">
                    {{ $type === 'register' ? 'Sudah' : 'Belum' }} punya akun?

                    <a href="{{ route($type === 'register' ? 'login' : 'register') }}"
                        class="text-primary hover:underline">
                        {{ $type === 'register' ? 'Login' : 'Daftar' }} Sekarang
                    </a>
                </p>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>
