<x-layouts.home title="My Addresses">
    <div>
        <div class="ms-5 -mb-8">
            <x-dashboard.header title="Alamat Saya" subTitle="Kelola alamat anda untuk pengiriman produk." />
        </div>

        {{-- Addresses --}}
        <x-front.user-addresses.adress :addresses="$addresses" />

        {{-- Add New Address --}}
        <div class="px-6 pb-6">
            <button id="show-address-form" class="bg-primary text-white px-5 py-2.5 rounded-base w-full mx-auto">
                + Tambah Alamat
            </button>
        </div>

        <x-front.user-addresses.form-add :addresses="$addresses" :editingAddress="$editingAddress" />
    </div>


    {{-- Kembali --}}
    <a href="{{ route('products') }}"
        class="fixed bottom-8 left-10 z-50
           flex items-center gap-2
           px-4 py-3
           bg-primary text-white
           rounded-full
           shadow-lg
           border border-gray-200
           hover:shadow-xl
           hover:-translate-y-0.5
           transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>

        <span class="text-sm font-medium">
            Kembali
        </span>
    </a>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelectorAll('.delete-form-address').forEach(form => {

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Hapus Alamat?',
                            text: 'Alamat yang dihapus tidak dapat dikembalikan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal',
                        }).then(result => {

                            if (result.isConfirmed) {
                                form.submit();
                            }

                        });
                    });

                });

            });
        </script>

        <script>
            let map;
            let marker;
            let mapInitialized = false;
            let lastValidLat = null;
            let lastValidLng = null;
            const editLat = "{{ $editingAddress?->latitude }}";
            const editLng = "{{ $editingAddress?->longitude }}";

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
                    if (editLat && editLng) {

                        map.setView(
                            [editLat, editLng],
                            16
                        );

                        marker = L.marker([
                            editLat,
                            editLng
                        ]).addTo(map);

                    } else if (navigator.geolocation) {
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


                    // Klik map untuk ubah lokasi
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


            // buka form apabila edit
            @if ($editingAddress)
                btn.click();
            @endif


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
