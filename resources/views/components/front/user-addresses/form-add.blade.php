@props(['addresses', 'editingAddress' => null])

<div id="address-form" class="hidden border border-default rounded-base p-6 shadow-xl mb-5">

    <div class="mb-5 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ $editingAddress ? 'Ubah Alamat' : 'Masukkan Alamat Baru' }}</h1>

        @if ($editingAddress)
            <a href="{{ route('my-addresses.index') }}"
                class="text-primary hover:underline hover:text-pink-700 hover:font-medium cursor-pointer">Batal
                Update</a>
        @endif
    </div>

    <form action="{{ $editingAddress ? route('my-addresses.update', $editingAddress) : route('my-addresses.store') }}"
        method="POST" class="grid md:grid-cols-2 gap-3">
        @csrf

        @if ($editingAddress)
            @method('PUT')
        @endif

        <div class="col-span-2">
            <x-forms.label-input label="Label" for="label" :value="$editingAddress?->label" placeholder="Rumah / Kantor / etc."
                isRequired />

            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_default" value="1" class="sr-only peer"
                    @checked($addresses->isEmpty() || $editingAddress?->is_default)>
                <div
                    class="relative w-9 h-5 bg-neutral-quaternary peer-focus:outline-none peer-focus:ring-1 peer-focus:ring-secondary dark:peer-focus:ring-secondary rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-0.5 after:inset-s-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary">
                </div>
                <span class="select-none ms-3 text-sm font-medium text-heading">Atur sebagai Alamat Utama</span>
            </label>

        </div>

        <x-forms.label-input label="Nama Penerima" for="recipient_name" :value="$editingAddress?->recipient_name" isRequired />

        <x-forms.label-input label="Nomor HP" for="recipient_phone" :value="$editingAddress?->recipient_phone" isRequired />

        <div class="col-span-2">
            <x-forms.textarea label="Alamat Lengkap" for="address" :value="$editingAddress?->address" isRequired />
        </div>

        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $editingAddress?->latitude) }}">
        <input type="hidden" id="longitude" name="longitude"
            value="{{ old('longitude', $editingAddress?->longitude) }}">
        <input type="hidden" name="province" id="province" value="{{ old('province', $editingAddress?->province) }}">
        <input type="hidden" name="city" id="city" value="{{ old('city', $editingAddress?->city) }}">
        <input type="hidden" name="district" id="district" value="{{ old('district', $editingAddress?->district) }}">
        <input type="hidden" name="postal_code" id="postal_code"
            value="{{ old('postal_code', $editingAddress?->postal_code) }}">

        <div id="address-map" class="col-span-2 h-100 rounded-base border mt-5 z-10">
        </div>

        <div class="flex justify-end col-span-2">
            <button class="w-full md:w-fit mt-5 bg-primary text-white px-5 py-2.5 rounded-base">
                {{ $editingAddress ? 'Update Alamat' : 'Simpan Alamat' }}
            </button>
        </div>
    </form>
</div>
