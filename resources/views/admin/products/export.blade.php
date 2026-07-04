<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Produk</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #222;
            padding: 24px;
            font-size: 13px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ec4899;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }

        .company {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .company img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .company h1 {
            font-size: 24px;
            color: #ec4899;
            margin-bottom: 4px;
        }

        .company p {
            color: #666;
            font-size: 12px;
            line-height: 1.6;
        }

        .title {
            text-align: right;
        }

        .title h2 {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .badge {
            display: inline-block;
            background: #fce7f3;
            color: #be185d;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .filter {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin: 28px 0;
        }

        .filter-card {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 16px;
        }

        .filter-card small {
            display: block;
            color: #888;
            margin-bottom: 5px;
        }

        .filter-card strong {
            font-size: 15px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .summary-card {
            background: linear-gradient(135deg, #ec4899, #db2777);
            color: #fff;
            border-radius: 12px;
            padding: 20px;
        }

        .summary-card small {
            opacity: .85;
            display: block;
            margin-bottom: 8px;
        }

        .summary-card h2 {
            font-size: 28px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background: #ec4899;
            color: white;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ececec;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 12px;
        }

        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border: none;
                max-width: 100%;
                padding: 0;
            }

        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">

            <div class="company">

                <img src="{{ asset('/assets/logo_florica.webp') }}" alt="Florica Blooms Logo">

                <div>
                    <h1>Florica Blooms</h1>
                    <p>
                        Flower & Gift Shop <br>
                        Laporan Penjualan Produk
                    </p>
                </div>

            </div>

            <div class="title">

                <h2>LAPORAN PRODUK</h2>

                <span class="badge">
                    {{ now()->translatedFormat('d F Y') }}
                </span>

            </div>

        </div>

        <div class="filter">

            <div class="filter-card">
                <small>Periode</small>

                <strong>

                    {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}

                    -

                    {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}

                </strong>

            </div>

            <div class="filter-card">

                <small>Produk</small>

                <strong>

                    {{ $product?->name ?? 'Semua Produk' }}

                </strong>

            </div>

        </div>

        <div class="summary">

            <div class="summary-card">

                <small>Total Terjual</small>

                <h2>

                    {{ $items->sum('quantity') }}

                </h2>

            </div>

            <div class="summary-card">

                <small>Total Omzet</small>

                <h2>

                    Rp {{ number_format($items->sum('subtotal'), 0, ',', '.') }}

                </h2>

            </div>

            <div class="summary-card">

                <small>Total Transaksi</small>

                <h2>

                    {{ $items->pluck('order_id')->unique()->count() }}

                </h2>

            </div>

        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th width="8%">Qty</th>
                    <th width="15%">Harga</th>
                    <th width="15%">Subtotal</th>
                    <th>Pelanggan</th>

                </tr>

            </thead>

            <tbody>

                @forelse($items as $item)
                    <tr>

                        <td class="text-center">

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $item->order->invoice_number }}

                        </td>

                        <td>

                            {{ $item->order->created_at->format('d/m/Y') }}

                        </td>

                        <td>

                            {{ $item->product_name }}

                        </td>

                        <td class="text-center">

                            {{ $item->quantity }}

                        </td>

                        <td class="text-right">

                            Rp {{ number_format($item->product_price, 0, ',', '.') }}

                        </td>

                        <td class="text-right">

                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}

                        </td>

                        <td>

                            {{ $item->order->recipient_name }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center">

                            Tidak ada data.

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

        <div class="footer">

            <div>

                Dicetak :
                {{ now()->translatedFormat('d F Y H:i') }}

            </div>

            <div>

                Florica Blooms © {{ date('Y') }}

            </div>

        </div>

    </div>

    <script>
        const backUrl = "{{ route('products.index') }}";

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
