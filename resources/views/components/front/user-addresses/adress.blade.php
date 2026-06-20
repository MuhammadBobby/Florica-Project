@props(['addresses'])

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 p-4 sm:p-6">
    @forelse($addresses as $address)
        <div class="border rounded-base p-4 sm:p-5 hover:shadow-xs transition">
            <div class="w-full">
                <div>
                    {{-- Nama Penerima --}}
                    <div class="w-full flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <h4 class="flex flex-wrap gap-1 sm:gap-2 items-center text-sm sm:text-base">
                            <span class="font-semibold uppercase tracking-wider">
                                {{ $address->recipient_name }}
                            </span>
                            <span class="opacity-60">|</span>
                            <span class="font-light">
                                {{ $address->recipient_phone }}
                            </span>
                        </h4>

                        <div class="flex items-center text-xs sm:text-sm">
                            <a href="{{ route('my-addresses.index', ['edit' => $address->id]) }}"
                                class="text-primary hover:underline hover:text-pink-700 hover:font-medium cursor-pointer">
                                Ubah
                            </a>

                            <span class="mx-2 text-gray-400">|</span>

                            <form action="{{ route('my-addresses.destroy', $address) }}" method="POST"
                                class="delete-form-address">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="text-primary hover:underline hover:text-pink-700 hover:font-medium cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <p class="text-body border border-default rounded-xs px-2 text-xs sm:text-sm font-medium">
                            {{ $address->label }}
                        </p>

                        @if ($address->is_default)
                            <span class="text-xs bg-primary text-white px-2 py-1 rounded-full">
                                Utama
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <p class="text-body mt-3 text-sm sm:text-base leading-relaxed">
                {{ $address->address }}
            </p>

            <p class="mt-3 uppercase text-xs sm:text-sm text-body">
                {{ $address->district }}, {{ $address->city }}, {{ $address->province }}, ID {{ $address->postal_code }}
            </p>
        </div>

    @empty
        <div class="col-span-full border-2 border-dashed rounded-base p-8 sm:p-12 text-center">
            <div class="text-5xl sm:text-6xl">📍</div>
            <h3 class="font-bold mt-3 text-base sm:text-lg">Belum Ada Alamat</h3>
            <p class="text-body text-sm sm:text-base">Tambahkan alamat pertamamu</p>
        </div>
    @endforelse
</div>
