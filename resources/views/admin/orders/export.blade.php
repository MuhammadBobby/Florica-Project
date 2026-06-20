<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemesanan Florica Blooms</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #222;
            margin: 15px;
            background: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #ec4899;
        }

        h2 {
            margin: 25px 0 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #ec4899;
            color: #ec4899;
            font-size: 16px;
        }

        .order-card {
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 10px;
            background: #fff;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .invoice {
            font-size: 13px;
            font-weight: bold;
        }

        .customer {
            color: #666;
            margin-top: 2px;
        }

        .status {
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: bold;
            background: #ecfdf5;
            color: #047857;
        }

        .address {
            background: #fafafa;
            border-left: 3px solid #ec4899;
            padding: 6px 10px;
            margin-bottom: 8px;
            font-size: 10px;
            color: #555;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .product-table th {
            background: #f8f8f8;
            border-bottom: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }

        .product-table td {
            padding: 5px 6px;
            border-bottom: 1px solid #eee;
            font-size: 10px;
        }

        .product-table tr:last-child td {
            border-bottom: none;
        }

        .total {
            text-align: right;
            margin-top: 8px;
            font-size: 12px;
            font-weight: bold;
            color: #ec4899;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .summary-box {
            text-align: center;
            flex: 1;
        }

        .summary-title {
            color: #666;
            font-size: 10px;
        }

        .summary-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 4px;
        }

        @media print {

            body {
                margin: 10px;
            }

            .order-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            h2 {
                page-break-after: avoid;
            }

            .summary {
                break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 10mm;
            }
        }
    </style>
</head>

<body>

    <h1>
        Laporan Pesanan Florica Blooms
    </h1>

    @if (!$completedOrders->isEmpty())
        @include('components.dashboard.orders.export-table', [
            'title' => 'Pesanan Selesai',
            'orders' => $completedOrders,
        ])
    @endif

    @if (!$processOrders->isEmpty())
        @include('components.dashboard.orders.export-table', [
            'title' => 'Pesanan Dalam Proses',
            'orders' => $processOrders,
        ])
    @endif

    @if (!$pendingOrders->isEmpty())
        @include('components.dashboard.orders.export-table', [
            'title' => 'Pesanan Menunggu Pembayaran',
            'orders' => $pendingOrders,
        ])
    @endif

    @if (!$failedOrders->isEmpty())
        @include('components.dashboard.orders.export-table', [
            'title' => 'Pesanan Gagal / Dibatalkan',
            'orders' => $failedOrders,
        ])
    @endif


    <script>
        const backUrl =
            "{{ route('orders.index', request()->query()) }}";

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
