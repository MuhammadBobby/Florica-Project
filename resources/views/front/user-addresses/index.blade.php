<x-layouts.home title="My Addresses">
    <div>
        <div class="grid md:grid-cols-2 gap-4 p-6">
            @forelse($addresses as $address)
                <div class="border rounded-base p-4">
                    <div class="flex justify-between">
                        <div>
                            <h4 class="font-bold">
                                {{ $address->label }}
                            </h4>

                            @if ($address->is_default)
                                <span class="text-xs bg-primary text-white px-2 py-1 rounded-full">
                                    Utama
                                </span>
                            @endif
                        </div>
                    </div>

                    <p class="mt-3">
                        {{ $address->recipient_name }}
                    </p>

                    <p>
                        {{ $address->phone }}
                    </p>

                    <p class="text-body mt-2">
                        {{ $address->address }}
                    </p>

                    @if ($address->distance_km)
                        <p class="mt-3 text-primary font-semibold">
                            {{ $address->distance_km }} KM
                        </p>
                    @endif
                </div>

            @empty
                <div class="col-span-full border-2 border-dashed rounded-base p-12 text-center">
                    <div class="text-6xl">📍</div>
                    <h3 class="font-bold mt-3">Belum Ada Alamat</h3>
                    <p class="text-body">Tambahkan alamat pertamamu</p>
                </div>
            @endforelse
        </div>

        <div class="px-6 pb-6">
            <button id="show-address-form" class="bg-primary text-white px-5 py-2.5 rounded-base w-full mx-auto">
                + Tambah Alamat
            </button>
        </div>

        <div id="address-form" class="hidden border border-default rounded-base p-6 shadow-xl mb-5">

            <div class="mb-5">
                <h1 class="text-2xl font-bold">Masukkan Alamat Baru</h1>
            </div>

            <form action="{{ route('my-addresses.store') }}" method="POST" class="grid grid-cols-2 gap-3">
                @csrf

                <div class="col-span-2">
                    <x-forms.label-input label="Label" for="label" placeholder="Rumah / Kantor / etc." isRequired />

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_default" value="" class="sr-only peer"
                            @if ($addresses->isEmpty()) checked @endif>
                        <div
                            class="relative w-9 h-5 bg-neutral-quaternary peer-focus:outline-none peer-focus:ring-1 peer-focus:ring-secondary dark:peer-focus:ring-secondary rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-0.5 after:inset-s-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary">
                        </div>
                        <span class="select-none ms-3 text-sm font-medium text-heading">Atur sebagai Alamat Utama</span>
                    </label>

                </div>

                <x-forms.label-input label="Nama Penerima" for="recipient_name" isRequired />

                <x-forms.label-input label="Nomor HP" for="phone" isRequired />

                <div class="col-span-2">
                    <x-forms.textarea label="Alamat Lengkap" for="address" isRequired />
                </div>

                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <input type="hidden" name="province" id="province">
                <input type="hidden" name="city" id="city">
                <input type="hidden" name="district" id="district">
                <input type="hidden" name="postal_code" id="postal_code">

                <div id="address-map" class="col-span-2 h-100 rounded-base border mt-5">
                </div>

                <button class="w-fit mt-5 bg-primary text-white px-5 py-2.5 rounded-base">
                    Simpan Alamat
                </button>
            </form>
        </div>
    </div>


    @push('scripts')
        <script>
            let map;
            let marker;
            let mapInitialized = false;
            let lastValidLat = null;
            let lastValidLng = null;

            const btn = document.getElementById('show-address-form');
            const form = document.getElementById('address-form');

            btn.addEventListener('click', () => {

                form.classList.toggle('hidden');

                // form dibuka pertama kali
                if (
                    !form.classList.contains('hidden') &&
                    !mapInitialized
                ) {
                    const medanBounds = L.latLngBounds(
                        [3.4500, 98.5000],
                        [3.7500, 98.8500]
                    );

                    map = L.map('address-map', {
                        maxBounds: medanBounds,
                        maxBoundsViscosity: 1.0
                    });

                    L.tileLayer(
                        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        }
                    ).addTo(map);

                    // cek lokasi
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(

                            async function(position) {
                                    const lat = position.coords.latitude;
                                    const lng = position.coords.longitude;

                                    map.setView([lat, lng], 16);

                                    marker = L.marker([lat, lng])
                                        .addTo(map)
                                        .bindPopup('Lokasi Anda Saat Ini')
                                        .openPopup();

                                    lastValidLat = lat;
                                    lastValidLng = lng;

                                    document.getElementById('latitude').value = lat;
                                    document.getElementById('longitude').value = lng;

                                    await reverseGeocode(lat, lng);
                                },

                                function(error) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Peringatan',
                                        text: error.message
                                    });
                                }
                        );

                    }

                    map.on('click', async function(e) {

                        const lat = e.latlng.lat;
                        const lng = e.latlng.lng;

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;

                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker([lat, lng]).addTo(map);

                        await reverseGeocode(lat, lng);
                    });

                    mapInitialized = true;

                    setTimeout(() => {
                        map.invalidateSize();
                    }, 300);

                }

                // form dibuka lagi setelah pernah ditutup
                else if (!form.classList.contains('hidden')) {
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 300);
                }
            });


            // Func get Address Detail
            async function reverseGeocode(lat, lng) {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`
                );

                const data = await response.json();

                const city =
                    data.address.city ??
                    data.address.county ??
                    '';

                if (!city.toLowerCase().includes('medan') && !city.toLowerCase().includes('deli serdang')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Area Tidak Didukung',
                        text: 'Saat ini kami hanya melayani wilayah Kota Medan dan Deli Serdang.'
                    });

                    // balik ke posisi valid sebelumnya
                    if (lastValidLat && lastValidLng) {
                        map.flyTo(
                            [lastValidLat, lastValidLng],
                            16
                        );

                        if (marker) {
                            marker.setLatLng([
                                lastValidLat,
                                lastValidLng
                            ]);
                        }
                    }

                    return;
                }


                document.getElementById('province').value =
                    data.address.state ?? '';

                document.getElementById('city').value = city;

                document.getElementById('district').value =
                    data.address.city_district ?? '';

                document.getElementById('postal_code').value =
                    data.address.postcode ?? '';
            }
        </script>
    @endpush

</x-layouts.home>
