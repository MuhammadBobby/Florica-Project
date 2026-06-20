@props(['order'])

<div id="order-modal-{{ $order->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[95vh] max-h-full my-3">

    <div class="relative p-4 w-full max-w-4xl max-h-full">

        <div class="relative bg-white border border-default rounded-base shadow-xl">

            {{-- HEADER --}}
            <div class="flex items-center justify-between p-5 border-b">

                <div>
                    <h3 class="text-xl font-bold">
                        Detail Pesanan
                    </h3>

                    <p class="text-sm text-body">
                        {{ $order->invoice_number }}
                    </p>
                </div>

                <button type="button" data-modal-hide="order-modal-{{ $order->id }}"
                    class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100">

                    ✕
                </button>

            </div>

            {{-- BODY --}}
            <div class="p-6 space-y-6 max-h-[65vh] overflow-y-auto">

                {{-- STATUS --}}
                <div>

                    <h4 class="font-semibold mb-4">
                        Status Pesanan
                    </h4>

                    <div class="flex items-center justify-between">

                        @php
                            $steps = [
                                'pending' => 1,
                                'success' => 2,
                                'confirmed' => 3,
                                'packed' => 3,
                                'shipped' => 4,
                                'completed' => 5,
                                'cancelled' => 0,
                            ];

                            $current = $steps[$order->order_status->value] ?? 1;
                        @endphp

                        @if ($order->order_status->value === 'cancelled')
                            <div class="bg-red-50 border border-red-200 rounded-base p-4">
                                <p class="font-semibold text-red-600">
                                    Pesanan Dibatalkan
                                </p>

                                <p class="text-sm text-red-500 mt-1">
                                    Pesanan ini telah dibatalkan dan tidak dapat diproses lebih lanjut.
                                </p>
                            </div>
                        @else
                            @foreach (['Menunggu Pembayaran', 'Dibayar', 'Diproses', 'Dikirim', 'Selesai'] as $index => $label)
                                <div class="flex-1 text-center">
                                    <div
                                        class="
                                    mx-auto w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $index + 1 <= $current ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }}
                                ">
                                        {{ $index + 1 }}
                                    </div>

                                    <p class="mt-2 text-xs">
                                        {{ $label }}
                                    </p>
                                </div>
                            @endforeach

                        @endif

                    </div>

                </div>

                {{-- PENERIMA --}}
                <div class="border rounded-base p-4">

                    <h4 class="font-semibold mb-3">
                        Informasi Pengiriman
                    </h4>

                    <p class="font-medium">
                        {{ $order->recipient_name }}
                    </p>

                    <p>
                        {{ $order->recipient_phone }}
                    </p>

                    <p class="text-body mt-2">
                        {{ $order->shipping_address }}
                    </p>

                </div>

                {{-- PRODUK --}}
                <div>

                    <h4 class="font-semibold mb-3">
                        Produk Dipesan
                    </h4>

                    <div class="space-y-4">

                        @foreach ($order->items as $item)
                            @if ($item->product)
                                <a href="{{ route('product.detail', $item->product->slug ?? '#') }}"
                                    class="flex gap-4 border rounded-base p-4 hover:bg-secondary/20 hover:scale-[1.01] hover:shadow-xl transition-all">
                                @else
                                    <div class="flex gap-4 border rounded-base p-4 opacity-75">
                            @endif

                            <img src="{{ asset('storage/' . ($item->product?->primaryImage?->image_url ?? 'products/default_image.webp')) }}"
                                class="w-20 h-20 object-cover rounded-base">

                            <div class="flex-1">

                                <h5 class="font-medium">
                                    {{ $item->product_name }}
                                </h5>

                                <p class="text-body text-sm">
                                    Qty: {{ $item->quantity }}
                                </p>

                                <p class="text-xs text-body">
                                    Rp {{ number_format($item->product_price, 0, ',', '.') }}
                                    x
                                    {{ $item->quantity }}
                                </p>

                            </div>

                            <div class="flex flex-col justify-between font-semibold text-primary text-right">
                                Rp
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>

                            @if ($item->product)
                                </a>
                            @else
                    </div>
                    @endif
                    @endforeach

                </div>

            </div>

            {{-- PEMBAYARAN --}}
            <div class="border rounded-base p-4">

                <h4 class="font-semibold mb-4">
                    Ringkasan Pembayaran
                </h4>

                <div class="space-y-2">

                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>
                            Rp
                            {{ number_format($order->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Ongkir</span>
                        <span>
                            Rp
                            {{ number_format($order->shipping_cost, 0, ',', '.') }}
                        </span>
                    </div>

                    <hr>

                    <div class="flex justify-between text-lg font-bold">

                        <span>Total</span>

                        <span class="text-primary">
                            Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>

                    </div>

                </div>

            </div>

            {{-- CATATAN --}}
            @if ($order->shipping_note)
                <div class="border rounded-base p-4">

                    <h4 class="font-semibold mb-2">
                        Catatan
                    </h4>

                    <p class="text-body">
                        {{ $order->shipping_note }}
                    </p>

                </div>
            @endif

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-end gap-3 p-5 border-t">

            @if ($order->order_status === 'pending' && optional($order->payment)->snap_token)
                <button type="button" class="pay-order-btn bg-primary text-white px-5 py-2.5 rounded-base"
                    data-token="{{ $order->payment->snap_token }}">

                    Bayar Sekarang

                </button>
            @endif

            <button data-modal-hide="order-modal-{{ $order->id }}" type="button"
                class="px-5 py-2.5 border rounded-base">

                Tutup

            </button>

        </div>

    </div>

</div>

</div>
