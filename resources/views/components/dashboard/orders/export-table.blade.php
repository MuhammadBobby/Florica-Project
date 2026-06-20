<h2
    style="
        margin-top:40px;
        margin-bottom:20px;
        padding-bottom:10px;
        border-bottom:3px solid #ec4899;
        color:#ec4899;
    ">
    {{ $title }}
</h2>

<div class="summary">

    <div class="summary-box">
        <div class="summary-title">
            Total Pesanan
        </div>

        <div class="summary-value">
            {{ $orders->count() }}
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-title">
            Total Omzet
        </div>

        <div class="summary-value">
            Rp {{ number_format($orders->sum('total_amount')) }}
        </div>
    </div>

</div>

@forelse($orders as $order)

    <div
        style="
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:12px;
        padding:20px;
        margin-bottom:20px;
        box-shadow:0 2px 8px rgba(0,0,0,.05);
        page-break-inside:avoid;
    ">

        {{-- Header --}}
        <table width="100%" style="border:none;margin-bottom:15px;">
            <tr>

                <td style="border:none;padding:0;">

                    <div
                        style="
                        font-size:18px;
                        font-weight:bold;
                        color:#111827;
                    ">
                        {{ $order->invoice_number }}
                    </div>

                    <div
                        style="
                        color:#6b7280;
                        margin-top:4px;
                    ">
                        {{ $order->recipient_name }}
                    </div>

                </td>

                <td align="right" style="border:none;padding:0;">

                    <span
                        style="
                        display:inline-block;
                        padding:6px 12px;
                        border-radius:999px;
                        background:#dcfce7;
                        color:#166534;
                        font-size:12px;
                        font-weight:bold;
                    ">
                        {{ strtoupper($order->order_status->value) }}
                    </span>

                </td>

            </tr>
        </table>

        {{-- Alamat --}}
        <div
            style="
            background:#f9fafb;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        ">

            <div style="
                font-weight:bold;
                margin-bottom:5px;
            ">
                Alamat Pengiriman
            </div>

            <div style="
                color:#4b5563;
                line-height:1.6;
            ">
                {{ $order->shipping_address }}
            </div>

        </div>

        {{-- Produk --}}
        <table width="100%" style="
            border-collapse:collapse;
        ">

            <thead>

                <tr style="
                    background:#f3f4f6;
                ">

                    <th align="left"
                        style="
                        padding:10px;
                        border:1px solid #e5e7eb;
                    ">
                        Produk
                    </th>

                    <th
                        style="
                        padding:10px;
                        border:1px solid #e5e7eb;
                    ">
                        Qty
                    </th>

                    <th
                        style="
                        padding:10px;
                        border:1px solid #e5e7eb;
                    ">
                        Harga
                    </th>

                    <th
                        style="
                        padding:10px;
                        border:1px solid #e5e7eb;
                    ">
                        Subtotal
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach ($order->items as $item)
                    <tr>

                        <td
                            style="
                            padding:10px;
                            border:1px solid #e5e7eb;
                        ">
                            {{ $item->product_name }}
                        </td>

                        <td align="center"
                            style="
                            padding:10px;
                            border:1px solid #e5e7eb;
                        ">
                            {{ $item->quantity }}
                        </td>

                        <td
                            style="
                            padding:10px;
                            border:1px solid #e5e7eb;
                        ">
                            Rp {{ number_format($item->product_price) }}
                        </td>

                        <td
                            style="
                            padding:10px;
                            border:1px solid #e5e7eb;
                        ">
                            Rp {{ number_format($item->subtotal) }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

        {{-- Footer --}}
        <div
            style="
            text-align:right;
            margin-top:15px;
            font-size:18px;
            font-weight:bold;
            color:#ec4899;
        ">

            Total :
            Rp {{ number_format($order->total_amount) }}

        </div>

    </div>

@empty

    <div
        style="
        text-align:center;
        padding:30px;
        color:#6b7280;
        border:1px dashed #d1d5db;
        border-radius:12px;
    ">

        Tidak ada data pesanan

    </div>

@endforelse
