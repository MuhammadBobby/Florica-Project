<x-layouts.dashboard title="Profile Store">

    <x-dashboard.header title="Profile Toko" subTitle="Kelola informasi toko Florica Blooms." />

    <x-dashboard.form-store-profile :storeProfile="$storeProfile" />

    @push('scripts')
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: @json(session('success')),
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
            </script>
        @endif

        <script>
            let map;
            let marker;

            document.addEventListener('DOMContentLoaded', async () => {

                map = L.map('address-map-store');

                L.tileLayer(
                    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }
                ).addTo(map);

                const storeLat = "{{ $storeProfile->latitude }}";
                const storeLng = "{{ $storeProfile->longitude }}";

                // Jika toko sudah punya koordinat
                if (storeLat && storeLng) {

                    map.setView([storeLat, storeLng], 16);

                    marker = L.marker([storeLat, storeLng])
                        .addTo(map)
                        .bindPopup('Lokasi Toko')
                        .openPopup();

                    document.getElementById('latitude').value = storeLat;
                    document.getElementById('longitude').value = storeLng;

                    await reverseGeocode(storeLat, storeLng);

                } else if (navigator.geolocation) {

                    // Ambil lokasi saat ini jika belum ada lokasi toko
                    navigator.geolocation.getCurrentPosition(

                        async function(position) {

                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;

                                map.setView([lat, lng], 16);

                                marker = L.marker([lat, lng])
                                    .addTo(map)
                                    .bindPopup('Lokasi Saat Ini')
                                    .openPopup();

                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;

                                await reverseGeocode(lat, lng);

                            },

                            function(error) {

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal Mengambil Lokasi',
                                    text: error.message
                                });

                                map.setView([-6.2, 106.816666], 13);
                            }
                    );

                } else {

                    map.setView([-6.2, 106.816666], 13);

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

                    marker = L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup('Lokasi Toko')
                        .openPopup();

                    await reverseGeocode(lat, lng);

                });

                // penting supaya tile tidak pecah
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);

            });

            async function reverseGeocode(lat, lng) {

                try {

                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`
                    );

                    const data = await response.json();

                    const city =
                        data.address.city ??
                        data.address.county ??
                        '';

                    document.getElementById('province').value =
                        data.address.state ?? '';

                    document.getElementById('city').value =
                        city;

                    document.getElementById('district').value =
                        data.address.city_district ??
                        data.address.suburb ??
                        '';

                } catch (error) {

                    console.error(error);

                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelectorAll('.update-profile').forEach(form => {

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Update Data?',
                            text: 'Anda yakin ingin memperbarui data ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Update',
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
    @endpush

</x-layouts.dashboard>
