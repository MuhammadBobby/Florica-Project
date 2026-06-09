@props(['orders'])

<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    No.
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Pelanggan
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Alamat
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Tanggal
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Total harga
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Catatan
                </th>
                <th scope="col" class="px-6 py-3 font-medium text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                    <th scope="row" class="w-fit px-6 py-4 font-medium text-heading max-w-xs">
                        {{ $index + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                    </th>
                    <td class="px-6 py-4 font-semibold flex flex-col">
                        <span>{{ $order->recipient_name }}</span>
                        <span class="text-xs text-body-soft">{{ $order->recipient_phone }}</span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->recipient_address }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->paid_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->total_amount }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center bg-success-soft border border-success-subtle text-fg-success-strong text-xs font-medium px-1.5 py-0.5 rounded-sm">
                            <span class="w-2 h-2 me-1 bg-success rounded-full"></span>
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 line-clamp-1">
                        {{ $order->shipping_note ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-4">

                            {{-- Detail --}}
                            <a href="{{ route('orders.show', $order) }}" class="text-yellow-500 hover:text-yellow-600"
                                title="Detail">
                                <svg class="w-6 h-6 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="delete-form">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 hover:text-red-700 cursor-pointer"
                                    title="Hapus">

                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 3V4H4V6H5V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V6H20V4H15V3H9ZM7 6H17V19H7V6Z" />
                                    </svg>

                                </button>

                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
