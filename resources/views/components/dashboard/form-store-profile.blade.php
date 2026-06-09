<form action="{{ route('store-profile.update') }}" method="POST"
    class="update-profile bg-white border border-default rounded-base p-6">

    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-2 gap-5">

        <x-forms.label-input label="Nama Toko" for="store_name" :value="$storeProfile->store_name" />

        <x-forms.label-input label="Telepon" for="phone" :value="$storeProfile->phone" />

        <x-forms.label-input label="WhatsApp" for="whatsapp" :value="$storeProfile->whatsapp" />

        <x-forms.label-input label="Email" for="email" :value="$storeProfile->email" />

        <x-forms.label-input label="Latitude" for="latitude" :value="$storeProfile->latitude" />

        <x-forms.label-input label="Longitude" for="longitude" :value="$storeProfile->longitude" />

        <x-forms.label-input label="Kecamatan" for="district" :value="$storeProfile->district" />

        <x-forms.label-input label="Kota" for="city" :value="$storeProfile->city" />

        <x-forms.label-input label="Provinsi" for="province" :value="$storeProfile->province" />

        <x-forms.label-input label="Harga Per KM" for="priceKm" :value="$storeProfile->priceKm" />

    </div>

    <div class="mt-5">

        <x-forms.textarea label="Alamat" for="address" value="{{ $storeProfile->address }}" />

    </div>

    <div class="mt-5">

        <x-forms.textarea label="Deskripsi" for="description" value="{{ $storeProfile->description }}" />
    </div>

    <div class="flex justify-end mt-6">

        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-base">

            Simpan Perubahan

        </button>

    </div>

</form>
