<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pesanan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 30px;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
            letter-spacing: 1px;
        }

        .header p {
            margin: 4px 0;
            font-size: 13px;
            color: #666;
        }

        .meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .meta div {
            padding: 6px 0;
        }

        .table-wrapper {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead {
            background: #f3f4f6;
        }

        th {
            text-align: left;
            padding: 12px;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #f1f1f1;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .status {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            display: inline-block;
        }

        .summary {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
        }

        .summary-box {
            font-size: 14px;
        }

        .summary-box strong {
            display: block;
            font-size: 16px;
            margin-top: 4px;
        }

        .total-revenue {
            text-align: right;
        }

        .print-btn {
            margin-bottom: 15px;
            padding: 10px 14px;
            border: none;
            background: #111;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button class="print-btn" onclick="window.print()">Print / Save PDF</button>

    {{-- HEADER --}}
    <div class="header">
        <h1>LAPORAN PESANAN</h1>
        <p>Florica Blooms Admin Report</p>
    </div>

    {{-- META --}}
    <div class="meta">
        <div><b>Rentang:</b> {{ $start ?? '-' }} s/d {{ $end ?? '-' }}</div>
        <div><b>Tanggal Export:</b> {{ now()->format('d M Y H:i') }}</div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->invoice_number }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="status">
                                {{ $order->order_status }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- SUMMARY (DI BAWAH) --}}
    <div class="summary">

        <div class="summary-box">
            Total Order
            <strong>{{ $totalOrders }} pesanan</strong>
        </div>

        <div class="summary-box total-revenue">
            Total Pendapatan
            <strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
        </div>

    </div>

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
