<x-layouts.dashboard title="Detail Customer">

    <div class="flex flex-col w-fit justify-center gap-4">
        {{-- tombol kembali --}}
        <a href="{{ back()->getTargetUrl() }}"
            class="w-fit px-4 py-2.5 text-sm font-medium text-white bg-primary rounded-base hover:bg-pink-700 focus:ring-4 focus:ring-secondary flex items-center">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14M5 12l4-4m-4 4 4 4" />
            </svg>

            Kembali </a>

        <x-dashboard.header title="Detail Customer" subTitle="Informasi lengkap customer Florica." />
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- PROFILE --}}
        <div class="lg:col-span-1">

            <div class="bg-white rounded-base border border-default p-6">

                <div class="flex flex-col items-center">

                    <img src="{{ $customer->avatar ? asset('storage/' . $customer->avatar) : asset('assets/elements/avatar.webp') }}"
                        class="w-28 h-28 rounded-full object-cover border shadow-sm">

                    <h2 class="mt-4 text-xl font-semibold">
                        {{ $customer->full_name }}
                    </h2>

                    <p class="text-body">
                        {{ $customer->email }}
                    </p>

                </div>

                <div class="mt-6 space-y-4">

                    <div>
                        <p class="text-xs text-body">
                            Nomor HP
                        </p>

                        <p class="font-medium">
                            {{ $customer->phone ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-body">
                            Bergabung
                        </p>

                        <p class="font-medium">
                            {{ $customer->created_at->format('d M Y') }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STATS --}}
            <div class="grid md:grid-cols-4 gap-4">

                <div class="border border-default rounded-base p-4">
                    <p class="text-body text-sm">
                        Total Pesanan
                    </p>
                    <h3 class="text-3xl font-bold">
                        {{ $stats['orders'] }}
                    </h3>
                </div>

                <div class="border border-default rounded-base p-4">
                    <p class="text-body text-sm">
                        Alamat
                    </p>
                    <h3 class="text-3xl font-bold">
                        {{ $stats['addresses'] }}
                    </h3>
                </div>

                <div class="border border-default rounded-base p-4">
                    <p class="text-body text-sm">
                        Review
                    </p>
                    <h3 class="text-3xl font-bold">
                        {{ $stats['reviews'] }}
                    </h3>
                </div>

                <div class="border border-default rounded-base p-4">
                    <p class="text-body text-sm">
                        Wishlist
                    </p>
                    <h3 class="text-3xl font-bold">
                        {{ $stats['wishlists'] }}
                    </h3>
                </div>

            </div>

            {{-- ADDRESS --}}
            <div class="bg-white rounded-base border border-default">

                <div class="p-4 border-b border-default">
                    <h3 class="font-semibold">
                        Daftar Alamat
                    </h3>
                </div>

                <div class="divide-y">

                    @forelse($customer->addresses as $address)
                        <div class="p-4">

                            <h4 class="font-semibold">
                                {{ $address->label }}
                            </h4>

                            <p class="text-body mt-1">
                                {{ $address->recipient_name }}
                            </p>

                            <p class="text-body">
                                {{ $address->phone }}
                            </p>

                            <p class="mt-2">
                                {{ $address->address }}
                            </p>

                            <div class="mt-2 text-sm text-body">
                                Jarak ke toko:
                                {{ number_format($address->distance_km, 2) }}
                                km
                            </div>

                        </div>

                    @empty

                        <div class="p-8 text-center text-body">
                            Customer belum memiliki alamat.
                        </div>
                    @endforelse

                </div>

            </div>

            {{-- RECENT ORDER --}}
            <div class="bg-white rounded-base border border-default">

                <div class="p-4 border-b border-default">
                    <h3 class="font-semibold">
                        Pesanan Terakhir
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    Invoice
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Total
                                </th>

                                <th class="px-4 py-3 text-left">
                                    Tanggal
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($customer->orders as $order)
                                <tr class="border-t">

                                    <td class="px-4 py-3">
                                        {{ $order->invoice_number }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ ucfirst($order->order_status) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center py-8 text-body">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-layouts.dashboard>
