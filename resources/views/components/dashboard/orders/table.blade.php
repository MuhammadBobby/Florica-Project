@props(['orders'])

<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
            <tr>
                <th scope="col" class="p-1 px-3 font-medium">
                    No.
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    No. Invoice
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Pelanggan
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Alamat
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Tanggal / Waktu
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Total harga
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 font-medium text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                    <th scope="row" class="w-fit p-1 px-3 text-center font-medium text-heading max-w-xs">
                        {{ $index + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                    </th>
                    <td class="px-6 py-4 font-semibold">
                        {{ $order->invoice_number }}
                    </td>
                    <td class="px-6 py-4 font-semibold flex flex-col uppercase">
                        <span>{{ $order->recipient_name }}</span>
                        <span
                            class="text-xs font-normal tracking-wider text-primary">{{ $order->recipient_phone }}</span>
                    </td>
                    <td class="px-6 py-4">
                        {{ Str::limit($order->shipping_address, 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $order->created_at->format('d M Y H:i') }} WIB
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center text-xs font-medium px-1.5 py-0.5 rounded-sm mx-auto {{ $order->status_color }}">
                            {{ $order->order_status->value }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button id="dropdownMenuButton{{ $order->id }}"
                            data-dropdown-toggle="dropdownMenu{{ $order->id }}" class="mx-auto" type="button">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M12 6h.01M12 12h.01M12 18h.01" />
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div id="dropdownMenu{{ $order->id }}"
                            class="z-20 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44 space-y-3">
                            <ul class="p-2 text-sm text-body font-medium"
                                aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                {{-- Konfirmasi --}}
                                @if ($order->order_status->value === 'success')
                                    <li>
                                        <button type="button" data-order="{{ $order->id }}" data-status="confirmed"
                                            data-label="Konfirmasi Pemesanan"
                                            class="order-status-btn w-full text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Konfirmasi
                                            Pemesanan</button>
                                    </li>
                                @endif

                                {{-- Packing --}}
                                @if ($order->order_status->value === 'confirmed')
                                    <li>
                                        <button type="button" data-order="{{ $order->id }}" data-status="packed"
                                            data-label="Packing Pemesanan"
                                            class="order-status-btn w-full text-white bg-indigo-500 box-border border border-transparent hover:bg-indigo-700 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Packing
                                            Pemesanan</button>
                                    </li>
                                @endif

                                {{-- Pengantaran --}}
                                @if ($order->order_status->value === 'packed')
                                    <li>
                                        <button type="button" data-order="{{ $order->id }}" data-status="shipped"
                                            data-label="Proses Pengantaran"
                                            class="order-status-btn w-full text-white bg-yellow-300 box-border border border-transparent hover:bg-yellow-500 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Proses
                                            Pengantaran</button>
                                    </li>
                                @endif

                                {{-- Selesai --}}
                                @if ($order->order_status->value === 'shipped')
                                    <li>
                                        <button type="button" data-order="{{ $order->id }}" data-status="completed"
                                            data-label="Selesaikan Pesanan"
                                            class="order-status-btn w-full text-white bg-green-500 box-border border border-transparent hover:bg-green-700 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Pesanan
                                            Selesai</button>
                                    </li>
                                @endif


                                {{-- Cancle --}}
                                @if ($order->order_status->value === 'pending')
                                    <li>
                                        <button type="button" data-order="{{ $order->id }}" data-status="cancelled"
                                            data-label="Batalkan Pesanan"
                                            class="order-status-btn w-full text-white bg-red-500 box-border border border-transparent hover:bg-red-700 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Batalkan
                                            Pemesanan</button>
                                    </li>
                                @endif

                                {{-- Detail --}}
                                <li>
                                    <button type="button" data-modal-target="order-modal-{{ $order->id }}"
                                        data-modal-toggle="order-modal-{{ $order->id }}"
                                        class="w-full text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none mt-2">Detail
                                        Pemesanan</button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach ($orders as $order)
    <x-front.order.detail-modal :order="$order" />
@endforeach
