<x-layouts.home title="Profil Saya">

    <div class="max-w-5xl mx-auto py-8">

        {{-- Back --}}
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 mb-6 text-primary font-medium">

            ← Kembali ke Beranda

        </a>

        <div class="bg-white rounded-base shadow-xl border overflow-hidden">

            {{-- Header --}}
            <div class="bg-linear-to-r from-primary to-pink-500 p-8 text-white">

                <div class="flex flex-col md:flex-row items-center gap-6">

                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('/assets/elements/avatar.webp') }}"
                        class="w-28 h-28 rounded-full object-cover border-4 border-white">

                    <div>

                        <h1 class="text-3xl font-bold">

                            {{ $user->full_name }}

                        </h1>

                        <p class="opacity-80">

                            {{ $user->email }}

                        </p>

                    </div>

                    <div class="md:ml-auto">

                        <button data-modal-target="edit-profile-modal" data-modal-toggle="edit-profile-modal"
                            class="px-5 py-2.5 bg-white text-primary rounded-base font-medium">

                            Edit Profil

                        </button>

                    </div>

                </div>

            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-6">

                <div class="bg-secondary/20 rounded-base p-5">

                    <h5 class="text-body">
                        Total Pesanan
                    </h5>

                    <p class="text-3xl font-bold text-primary">

                        {{ $orderCount }}

                    </p>

                </div>

                <div class="bg-secondary/20 rounded-base p-5">

                    <h5 class="text-body">
                        Ulasan
                    </h5>

                    <p class="text-3xl font-bold text-primary">

                        {{ $reviewCount }}

                    </p>

                </div>

                <div class="bg-secondary/20 rounded-base p-5">

                    <h5 class="text-body">
                        Alamat
                    </h5>

                    <p class="text-3xl font-bold text-primary">

                        {{ $addressCount }}

                    </p>

                </div>

            </div>

            {{-- Detail --}}
            <div class="p-6 border-t">

                <div class="grid md:grid-cols-2 gap-5">

                    <div>

                        <label class="text-body text-sm">

                            Nama Lengkap

                        </label>

                        <p class="font-medium mt-1">

                            {{ $user->full_name }}

                        </p>

                    </div>

                    <div>

                        <label class="text-body text-sm">

                            Email

                        </label>

                        <p class="font-medium mt-1">

                            {{ $user->email }}

                        </p>

                    </div>

                    <div>

                        <label class="text-body text-sm">

                            Nomor Telepon

                        </label>

                        <p class="font-medium mt-1">

                            {{ $user->phone ?? '-' }}

                        </p>

                    </div>

                    <div>

                        <label class="text-body text-sm">

                            Bergabung Sejak

                        </label>

                        <p class="font-medium mt-1">

                            {{ $user->created_at->translatedFormat('d F Y') }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Modal --}}
    <div id="edit-profile-modal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50">

        <div class="relative p-4 w-full max-w-xl mx-auto">

            <div class="bg-white rounded-base shadow-xl p-6">

                <h3 class="text-xl font-bold mb-5">

                    Edit Profil

                </h3>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="space-y-4">

                        <div>

                            <label>
                                Nama Lengkap
                            </label>

                            <input type="text" name="full_name" value="{{ $user->full_name }}"
                                class="w-full border rounded-base">

                        </div>

                        <div>

                            <label>
                                Nomor Telepon
                            </label>

                            <input type="text" name="phone" value="{{ $user->phone }}"
                                class="w-full border rounded-base">

                        </div>

                        <div>

                            <label>
                                Foto Profil
                            </label>

                            {{-- Preview --}}
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                    class="w-24 h-24 rounded-full object-cover mb-2">
                            </div>

                            <input type="file" name="avatar" class="w-full">

                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">

                        <button type="button" data-modal-hide="edit-profile-modal"
                            class="px-4 py-2 border rounded-base">

                            Batal

                        </button>

                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-base">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layouts.home>
