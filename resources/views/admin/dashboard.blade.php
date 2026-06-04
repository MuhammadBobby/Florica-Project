<x-layouts.dashboard title="Dashboard Admin">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-heading">
            Dashboard
        </h1>

        <p class="mt-2 text-body">
            Selamat datang di dashboard admin Florica.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

        <div class="p-6 bg-white border border-default rounded-base">
            <p class="text-sm text-body">Total Produk</p>
            <h2 class="mt-2 text-3xl font-bold text-heading">
                {{ $totalProducts ?? 0 }}
            </h2>
        </div>

        <div class="p-6 bg-white border border-default rounded-base">
            <p class="text-sm text-body">Total Kategori</p>
            <h2 class="mt-2 text-3xl font-bold text-heading">
                {{ $totalCategories ?? 0 }}
            </h2>
        </div>

        <div class="p-6 bg-white border border-default rounded-base">
            <p class="text-sm text-body">Total Pesanan</p>
            <h2 class="mt-2 text-3xl font-bold text-heading">
                {{ $totalOrders ?? 0 }}
            </h2>
        </div>

        <div class="p-6 bg-white border border-default rounded-base">
            <p class="text-sm text-body">Total Pelanggan</p>
            <h2 class="mt-2 text-3xl font-bold text-heading">
                {{ $totalCustomers ?? 0 }}
            </h2>
        </div>

    </div>

    {{-- Revenue --}}
    <div class="mt-8">
        <div class="p-6 bg-white border border-default rounded-base">
            <h2 class="text-lg font-semibold text-heading">
                Pendapatan Bulan Ini
            </h2>

            <p class="mt-3 text-4xl font-bold text-primary">
                Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">

        {{-- Order Terbaru --}}
        <div class="p-6 bg-white border border-default rounded-base">
            <h2 class="mb-4 text-lg font-semibold text-heading">
                Pesanan Terbaru
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-default">
                            <th class="py-2 text-left">Invoice</th>
                            <th class="py-2 text-left">Customer</th>
                            <th class="py-2 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($latestOrders ?? [] as $order)
                            <tr class="border-b border-default">
                                <td class="py-3">
                                    {{ $order->invoice_number }}
                                </td>

                                <td>
                                    {{ $order->user->full_name }}
                                </td>

                                <td>
                                    {{ ucfirst($order->order_status) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-body">
                                    Belum ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Produk Stok Menipis --}}
        <div class="p-6 bg-white border border-default rounded-base">
            <h2 class="mb-4 text-lg font-semibold text-heading">
                Produk Stok Menipis
            </h2>

            <div class="space-y-3">

                @forelse($lowStockProducts ?? [] as $product)
                    <div class="flex items-center justify-between">

                        <span class="text-heading">
                            {{ $product->name }}
                        </span>

                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">
                            Stok {{ $product->stock }}
                        </span>

                    </div>

                @empty

                    <p class="text-body">
                        Semua stok aman.
                    </p>
                @endforelse

            </div>
        </div>

    </div>

</x-layouts.dashboard>
