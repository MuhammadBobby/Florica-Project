<!DOCTYPE html>
<html>

<head>

    <title>
        Struk {{ $order->invoice_number }}
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
        }

        .receipt {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, .08);
        }

        /* =========================
       HEADER
    ========================= */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;
            padding-bottom: 24px;
            margin-bottom: 30px;
            border-bottom: 3px solid #ec4899;
        }

        .company {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .logo {
            width: 85px;
            height: 85px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand {
            color: #ec4899;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 2px;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .company-detail {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.7;
        }

        .invoice {
            text-align: right;
            min-width: 260px;
        }

        .invoice h2 {
            margin: 0 0 12px;
            font-size: 24px;
            color: #111827;
        }

        .invoice-meta {
            width: auto;
            margin-left: auto;
            border-collapse: collapse;
            font-size: 13px;
        }

        .invoice-meta td {
            border: none;
            padding: 4px 0 4px 10px;
            vertical-align: top;
        }

        .invoice-meta td:first-child {
            color: #6b7280;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            background: #dcfce7;
            color: #166534;
        }

        /* =========================
       SECTION
    ========================= */

        .section {
            margin-bottom: 28px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .customer-box {
            background: #fafafa;
            border: 1px solid #ececec;
            border-radius: 12px;
            padding: 16px;
            line-height: 1.8;
        }

        /* =========================
       TABLE
    ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            padding: 14px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .text-right {
            text-align: right;
        }

        /* =========================
       SUMMARY
    ========================= */

        .summary {
            width: 380px;
            margin-left: auto;
            margin-top: 25px;
            background: #fafafa;
            border: 1px solid #ececec;
            border-radius: 12px;
            padding: 18px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .grand-total {
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            font-size: 22px;
            font-weight: 700;
            color: #ec4899;
        }

        /* =========================
       FOOTER
    ========================= */

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px dashed #d1d5db;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.8;
        }

        /* =========================
       PRINT
    ========================= */

        @media print {

            body {
                padding: 0;
                background: white;
            }

            .receipt {
                max-width: 100%;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            @page {
                size: A4;
                margin: 12mm;
            }
        }
    </style>

</head>

<body>

    <div class="receipt">

        <div class="header">

            <div class="company">

                <img src="{{ asset('/assets/logo_florica.webp') }}" alt="Florica Blooms" class="logo">

                <div>

                    <div class="brand">
                        FLORICA BLOOMS
                    </div>

                    <div class="company-detail">
                        Flower & Gift Shop
                        <br>
                        Medan, Sumatera Utara
                        <br>
                        +62 812-3456-7890
                        <br>
                        floricablooms@gmail.com
                    </div>

                </div>

            </div>

            <div class="invoice">

                <h2>
                    INVOICE
                </h2>

                <table class="invoice-meta">

                    <tr>
                        <td>No. Invoice</td>
                        <td>: {{ $order->invoice_number }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal</td>
                        <td>:
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>
                            :
                            <span class="badge">
                                {{ strtoupper($order->order_status->value) }}
                            </span>
                        </td>
                    </tr>

                </table>

            </div>

        </div>


        <div class="section">

            <div class="section-title">
                Informasi Penerima
            </div>

            <strong>
                {{ $order->recipient_name }}
            </strong>

            <br>

            {{ $order->recipient_phone }}

            <br><br>

            {{ $order->shipping_address }}

        </div>


        <div class="section">

            <div class="section-title">
                Detail Produk
            </div>

            <table>

                <thead>

                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($order->items as $item)
                        <tr>

                            <td>
                                {{ $item->product_name }}
                            </td>

                            <td>
                                {{ $item->quantity }}
                            </td>

                            <td>
                                Rp {{ number_format($item->product_price) }}
                            </td>

                            <td>
                                Rp {{ number_format($item->subtotal) }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>


        <div class="summary">

            <div class="summary-row">

                <span>Subtotal</span>

                <span>
                    Rp {{ number_format($order->subtotal) }}
                </span>

            </div>

            <div class="summary-row">

                <span>Ongkir</span>

                <span>
                    Rp {{ number_format($order->shipping_cost) }}
                </span>

            </div>

            <div class="summary-row grand-total">

                <span>Total</span>

                <span>
                    Rp {{ number_format($order->total_amount) }}
                </span>

            </div>

        </div>

        <div class="footer">

            Terima kasih telah berbelanja di Florica Blooms 🌷

            <br>

            Dicetak pada
            {{ now()->timezone('Asia/Jakarta')->format('d M Y H:i') }}

        </div>

    </div>

    <script>
        const backUrl =
            "{{ route('my-orders.index') }}";

        window.onload = () => {
            window.print();
        };

        window.onafterprint = () => {
            window.location.href = backUrl;
        };

        setTimeout(() => {
            window.location.href = backUrl;
        }, 5000);
    </script>

</body>

</html>
