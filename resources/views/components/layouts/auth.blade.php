<x-layouts.layout title="{{ $title }}">
    <div class="flex justify-center md:justify-end items-center px-4 md:pe-16 lg:pe-30 w-full min-h-screen bg-secondary bg-center bg-no-repeat bg-cover bg-blend-multiply bg-[url('/assets/elements/bg-auth-new.webp')]"
        style="background-image: url('/assets/elements/bg-auth-new.webp')">
        <div
            class="bg-white/80 border border-slate-400 p-6 sm:p-8 md:p-10 rounded-lg shadow-lg w-full max-w-md sm:max-w-lg">

            <div class="text-center">
                <a href="{{ route('landing') }}">
                    <img src="/assets/logo_florica.webp" class="w-24 sm:w-28 md:w-1/4 h-auto mx-auto"
                        alt="{{ config('app.name') }} Logo">
                </a>

                <hr class="my-3 border-gray-300" />

                <h1 class="text-2xl sm:text-3xl font-bold mb-1.5 capitalize">
                    {{ $type }} Form
                </h1>

                <p class="text-xs sm:text-sm text-body leading-relaxed">
                    Silahkan
                    {{ $type === 'register' ? 'Daftar untuk Membuat ' : 'Login Menggunakan ' }}
                    Akun Anda
                </p>
            </div>

            {{-- Form --}}
            <div class="mt-5">
                {{ $slot }}
            </div>

            <footer class="mt-5 text-center">
                <p class="text-xs sm:text-sm text-body">
                    {{ $type === 'register' ? 'Sudah' : 'Belum' }} punya akun?

                    <a href="{{ route($type === 'register' ? 'login' : 'register') }}"
                        class="text-primary hover:underline font-medium">
                        {{ $type === 'register' ? 'Login' : 'Daftar' }} Sekarang
                    </a>
                </p>
            </footer>

        </div>
    </div>
</x-layouts.layout>
