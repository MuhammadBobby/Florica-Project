<x-layouts.layout title="{{ $title }}">
    <div class="flex justify-end items-center pe-30 bg-secondary w-full h-full min-w-screen min-h-screen bg-center bg-no-repeat bg-[url('/assets/elements/bg-auth-new.webp')] bg-blend-multiply bg-cover"
        loading="eager" style="background-image:url('/assets/elements/bg-auth-new.webp')">
        <div class="bg-white/80 border border-slate-400 p-10 rounded-lg shadow-lg w-full max-w-xl">
            <div class="text-center">
                <a href="{{ route('landing') }}">
                    <img src="/assets/logo_florica.webp" class="w-1/4 h-auto mx-auto" alt="{{ config('app.name') }} Logo">
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

</x-layouts.layout>
