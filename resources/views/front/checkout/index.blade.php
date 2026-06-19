@php
    $cartItemIds = $cart_items->pluck('id');
@endphp

<x-layouts.home title="Checkout">
    <form action="" class="max-w-3xl mx-auto mb-5">
        <input type="hidden" name="address_id" id="selected-address-id" value="{{ $address->id }}">
        <input type="hidden" name="distance_km" id="distance-km" value="{{ $distance_km }}" />

        {{-- header --}}
        <x-front.checkout.header-checkout />

        {{-- Alamat --}}
        <x-front.checkout.card-address :address="$address" />

        {{-- Produk --}}
        <x-front.checkout.card-products :cart_items="$cart_items" />

        {{-- Ringkasan --}}
        <x-front.checkout.card-summary :subtotal="$subtotal" :distance_km="$distance_km" :shipping_cost="$shipping_cost" :grand_total="$grand_total" />

        {{-- Checkout Button --}}
        <button type="button" id="btn-checkout"
            class="my-5 w-full px-6 py-3 bg-primary text-white rounded-full shadow-lg border border-gray-200 hover:shadow-xl hover:-translate-y-0.5 transition">
            Checkout
        </button>
    </form>

    {{-- Modal Change Address --}}
    <x-front.checkout.modal-change-address />


    {{-- Push --}}
    @push('scripts')
        <script>
            const subtotal = {{ $subtotal }};
            const modal = document.getElementById('address-modal');

            document
                .getElementById('btn-checkout')
                .addEventListener('click', async () => {

                    try {

                        Swal.fire({
                            title: 'Memproses Pesanan',
                            text: 'Mohon tunggu...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const response = await fetch(
                            '/checkout/process', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .content
                                },
                                body: JSON.stringify({

                                    address_id: document
                                        .getElementById(
                                            'selected-address-id'
                                        )
                                        .value,
                                    cart_items: @json($cartItemIds),
                                    shipping_note: document
                                        .getElementById(
                                            'shipping_note'
                                        )?.value ?? null,
                                    distance_km: Number(
                                        document
                                        .getElementById(
                                            'distance-km'
                                        ).value
                                    )
                                })
                            }
                        );

                        const result =
                            await response.json();

                        Swal.close();

                        if (!result.success) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: result.message
                            });

                            return;
                        }

                        snap.pay(
                            result.snap_token,

                            {
                                async onSuccess(midtransResult) {

                                    await updatePaymentStatus(
                                        result.order_id,
                                        'success'
                                    );

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Pembayaran Berhasil Terkonfirmasi'
                                    }).then(() => {

                                        window.location.href =
                                            `/my-orders`;

                                    });
                                },

                                async onPending(midtransResult) {

                                    await updatePaymentStatus(
                                        result.order_id,
                                        'pending'
                                    );

                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Menunggu Pembayaran Produk'
                                    }).then(() => {

                                        window.location.href =
                                            `/my-orders`;

                                    });
                                },

                                async onError(midtransResult) {

                                    await updatePaymentStatus(
                                        result.order_id,
                                        'failed'
                                    );

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Pembayaran Gagal'
                                    });
                                },

                                onClose() {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pembayaran Belum Selesai',
                                        text: 'Pesanan tetap tersimpan dan dapat dibayar nanti.'
                                    }).then(() => {

                                        window.location.href =
                                            '/my-orders';

                                    });
                                }
                            }
                        );

                    } catch (error) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan'
                        });

                        console.error(error);
                    }

                });

            document
                .getElementById('change-address-btn')
                .addEventListener('click', () => {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });

            document
                .getElementById('close-address-modal')
                .addEventListener('click', () => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                });

            document
                .querySelectorAll('.select-address')
                .forEach(button => {
                    button.addEventListener('click', async function() {
                        const addressId =
                            this.dataset.id;

                        try {
                            const response = await fetch(
                                "{{ route('checkout.change-address') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]'
                                        ).content
                                    },
                                    body: JSON.stringify({
                                        address_id: addressId
                                    })
                                }
                            );

                            const data = await response.json();

                            // hidden input
                            document.getElementById(
                                'selected-address-id'
                            ).value = addressId;

                            // card
                            document.getElementById(
                                    'checkout-recipient-name'
                                ).textContent =
                                data.address.recipient_name;

                            document.getElementById(
                                    'checkout-recipient-phone'
                                ).textContent =
                                data.address.recipient_phone;

                            document.getElementById(
                                    'checkout-label'
                                ).textContent =
                                data.address.label;

                            document.getElementById(
                                'checkout-default'
                            ).classList.toggle(
                                'hidden',
                                !data.address.is_default
                            )

                            document.getElementById(
                                    'checkout-address'
                                ).textContent =
                                data.address.address;

                            document.getElementById(
                                    'checkout-city'
                                ).textContent =
                                `${data.address.district}, ${data.address.city}, ${data.address.province}, ID ${data.address.postal_code}`;

                            // distance
                            document.getElementById(
                                    'distance-label'
                                ).textContent =
                                `(${data.distance_km} KM)`;

                            document.getElementById(
                                'distance-km'
                            ).value = data.distance_km;

                            // ongkir
                            document.getElementById(
                                    'shipping-cost-value'
                                ).textContent =
                                'Rp ' +
                                Number(
                                    data.shipping_cost
                                ).toLocaleString('id-ID');

                            // total
                            const grandTotal =
                                subtotal +
                                Number(data.shipping_cost);

                            document.getElementById(
                                    'grand-total'
                                ).textContent =
                                'Rp ' +
                                grandTotal.toLocaleString('id-ID');

                            // close modal
                            modal.classList.remove(
                                'flex'
                            );
                            modal.classList.add(
                                'hidden'
                            );

                        } catch (error) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops',
                                text: 'Gagal mengganti alamat'
                            });

                        }

                    });

                });



            // HELPER
            async function updatePaymentStatus(
                orderId,
                status
            ) {

                return fetch(
                    '/checkout/payment-callback', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',

                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },

                        body: JSON.stringify({
                            order_id: orderId,
                            status: status
                        })
                    }
                );
            }
        </script>
    @endpush
</x-layouts.home>
