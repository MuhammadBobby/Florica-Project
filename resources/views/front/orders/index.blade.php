<x-layouts.home title="Pesanan Saya">

    <div class="max-w-5xl mx-auto mb-10">

        <h1 class="text-3xl font-bold mb-6">
            Pesanan Saya
        </h1>

        <div class="space-y-4">

            @forelse($orders as $order)
                @php
                    $canCancel =
                        $order->order_status->value === 'pending' && $order->created_at->diffInHours(now()) < 24;
                @endphp


                <div class="bg-white border rounded-base shadow-lg p-5">

                    {{-- Header --}}
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-xl">
                                {{ $order->invoice_number }}
                            </h3>

                            <p class="text-body">
                                {{ $order->created_at->format('d M Y H:i') }} WIB
                            </p>

                        </div>

                        <span
                            class="
                        px-4 py-2 rounded-full text-xs font-medium uppercase
                        {{ $order->status_color }}
                        ">
                            {{ $order->order_status }}
                        </span>

                    </div>

                    <hr class="my-4">

                    {{-- Produk pertama --}}
                    @php
                        $firstItem = $order->items->first();
                    @endphp

                    <div class="flex gap-4">

                        <img src="{{ asset('storage/' . $firstItem->product->primaryImage->image_url) }}"
                            class="w-20 h-20 rounded-base object-cover">

                        <div class="flex-1">

                            <h4 class="font-semibold text-lg">
                                {{ $firstItem->product_name }}
                            </h4>

                            <p class="text-body">
                                Qty
                                {{ $firstItem->quantity }}
                            </p>

                            @if ($order->items->count() > 1)
                                <p class="text-sm text-body mt-1">

                                    +
                                    {{ $order->items->count() - 1 }}
                                    produk lainnya

                                </p>
                            @endif

                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-body">
                                Total Belanja
                            </p>

                            <h4 class="font-bold text-primary">
                                Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}
                            </h4>

                        </div>

                        <div class="flex gap-2">

                            <button data-modal-target="order-modal-{{ $order->id }}"
                                data-modal-toggle="order-modal-{{ $order->id }}"
                                class="btn-detail-order text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                Detail Pesanan
                            </button>

                            @if ($order->payment && $order->payment->payment_status->value === 'pending')
                                <button data-token="{{ $order->payment->snap_token }}"
                                    data-order="{{ $order->id }}"
                                    class="btn-pay-again px-4 py-2 bg-primary text-white rounded-base">
                                    Bayar Sekarang
                                </button>
                            @endif

                            @if ($canCancel)
                                <form action="{{ route('my-orders.cancel', $order) }}" method="POST"
                                    class="cancel-order-form inline-block">
                                    @csrf

                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-base hover:bg-red-700 transition">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>

                </div>

            @empty
                <div class="text-center py-20">
                    <h3 class="text-xl font-semibold">
                        Belum Ada Pesanan
                    </h3>

                    <p class="text-body">
                        Yuk mulai belanja bunga favoritmu 🌸
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    @foreach ($orders as $order)
        <x-front.order.detail-modal :order="$order" />
    @endforeach


    @push('scripts')
        <script>
            document.querySelectorAll('.btn-pay-again').forEach(button => {

                button.addEventListener('click', async () => {

                    const snapToken = button.dataset.token;
                    const orderId = button.dataset.order;

                    snap.pay(snapToken, {

                        async onSuccess(result) {
                            await updatePaymentStatus(
                                result.order_id,
                                'success'
                            );

                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil'
                            }).then(() => {
                                location.reload();
                            });

                        },

                        async onPending(result) {
                            await updatePaymentStatus(
                                result.order_id,
                                'pending'
                            );


                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu Pembayaran'
                            }).then(() => {
                                location.reload();
                            });

                        },

                        async onError(result) {
                            await updatePaymentStatus(
                                result.order_id,
                                'failed'
                            );

                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal',
                                text: result.status_message ?? 'Terjadi kesalahan'
                            });

                        },

                        async onClose() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pembayaran Belum Selesai',
                                text: 'Silahkan selesaikan pembayaran Anda'
                            });

                        }
                    });
                });
            });

            // Sweat alert confirmation cancel
            document.querySelectorAll('.cancel-order-form')
                .forEach(form => {

                    form.addEventListener(
                        'submit',
                        function(e) {

                            e.preventDefault();

                            Swal.fire({
                                icon: 'warning',
                                title: 'Batalkan Pesanan?',
                                text: 'Pesanan yang dibatalkan tidak dapat diproses kembali.',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Batalkan',
                                cancelButtonText: 'Tidak'
                            }).then(result => {

                                if (result.isConfirmed) {
                                    form.submit();
                                }

                            });

                        }
                    );

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

        @if (request('transaction_status'))
            <script>
                document.addEventListener(
                    'DOMContentLoaded',
                    () => {

                        const status =
                            "{{ request('transaction_status') }}";

                        if (status === 'expire') {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Pembayaran Kadaluarsa',
                                text: 'Waktu pembayaran telah habis.'
                            });

                        } else if (status === 'settlement') {

                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil'
                            });

                        } else if (status === 'pending') {

                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu Pembayaran'
                            });

                        } else if (
                            status === 'cancel' ||
                            status === 'deny'
                        ) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal'
                            });

                        }

                        // hapus query string
                        window.history.replaceState({},
                            document.title,
                            window.location.pathname
                        );

                    }
                );
            </script>
        @endif
    @endpush

</x-layouts.home>
