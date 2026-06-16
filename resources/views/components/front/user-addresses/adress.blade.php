@props(['addresses'])

<div class="grid md:grid-cols-2 gap-4 p-6">
    @forelse($addresses as $address)
        <div class="border rounded-base p-4">
            <div class="w-full">
                <div>
                    {{-- Nama Penerima --}}
                    <div class="w-full flex justify-between items-center">
                        <h4 class="flex gap-2 items-center">
                            <span class="font-semibold uppercase tracking-wider">{{ $address->recipient_name }}</span>

                            |

                            <span class="font-light">{{ $address->recipient_phone }}</span>
                        </h4>

                        <div class="flex">
                            <a href="{{ route('my-addresses.index', ['edit' => $address->id]) }}"
                                class="text-primary hover:underline hover:text-pink-700 hover:font-medium cursor-pointer">Ubah
                            </a>

                            <span class="mx-2">|</span>

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

                    <div class="flex items-center gap-2">
                        <p class="text-body border border-default rounded-xs px-2 text-sm font-medium">
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

            <p class="text-body mt-2">
                {{ $address->address }}
            </p>

            <p class="mt-3 uppercase">
                {{ $address->district }}, {{ $address->city }}, {{ $address->province }}, ID
                {{ $address->postal_code }}
            </p>
        </div>

    @empty
        <div class="col-span-full border-2 border-dashed rounded-base p-12 text-center">
            <div class="text-6xl">📍</div>
            <h3 class="font-bold mt-3">Belum Ada Alamat</h3>
            <p class="text-body">Tambahkan alamat pertamamu</p>
        </div>
    @endforelse
</div>
