@php
    use App\Enums\OrderStatus;

    $statusOptions = [
        [
            'value' => OrderStatus::Pending->value,
            'label' => OrderStatus::Pending->name,
        ],
        [
            'value' => OrderStatus::Success->value,
            'label' => OrderStatus::Success->name,
        ],
        [
            'value' => OrderStatus::Confirmed->value,
            'label' => OrderStatus::Confirmed->name,
        ],
        [
            'value' => OrderStatus::Packed->value,
            'label' => OrderStatus::Packed->name,
        ],
        [
            'value' => OrderStatus::Shipped->value,
            'label' => OrderStatus::Shipped->name,
        ],
        [
            'value' => OrderStatus::Completed->value,
            'label' => OrderStatus::Completed->name,
        ],
        [
            'value' => OrderStatus::Cancelled->value,
            'label' => OrderStatus::Cancelled->name,
        ],
    ];
@endphp


<x-layouts.dashboard title="Orders">
    <x-dashboard.header title="Pesanan Pelanggan" subTitle="Lihat semua pesanan pelanggan Florica Blooms." />

    {{-- Filter --}}
    <div class="flex flex-col gap-5 my-5">
        <div class="flex flex-col md:flex-row items-center gap-3">
            {{-- Status --}}
            <x-dashboard.filter-dropdown label="Status Pemesanan" query="order_status" :options="$statusOptions" />

            {{-- Date --}}
            <x-dashboard.orders.filter />
        </div>

        <div class="flex gap-3 items-center">
            {{-- Export --}}
            <a id="btn-export-order" href="#"
                class="px-4 py-2 bg-white border border-primary text-primary rounded-base hover:bg-primary hover:text-white w-fit">
                Export PDF Pesanan
            </a>

            {{-- Rekap --}}
            <button type="button" data-modal-target="rekap-modal" data-modal-toggle="rekap-modal"
                class="px-4 py-2 bg-white border border-primary text-primary rounded-base hover:bg-primary hover:text-white w-fit">
                Rekap Pesanan
            </button>
        </div>
    </div>

    {{-- Table --}}
    @if ($orders->isEmpty())
        <x-dashboard.table-empty title="Belum Ada Pesanan">
            Saat ini belum ada pesanan yang masuk.
            Pesanan pelanggan akan muncul di halaman ini setelah checkout berhasil dilakukan.
        </x-dashboard.table-empty>
    @else
        <x-dashboard.orders.table :orders="$orders" />
    @endif

    {{-- Pagination --}}
    <x-dashboard.pagination :paginator="$orders" />

    {{-- Modal --}}
    <x-dashboard.orders.rekap-modal />
    @if (request()->routeIs('categories.edit'))
        <x-dashboard.categories.edit-modal :category="$category" />
    @endif

    @push('scripts')
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: @json(session('success')),
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
            </script>
        @endif


        <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelectorAll('.delete-form').forEach(form => {

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Hapus Data?',
                            text: 'Data yang dihapus tidak dapat dikembalikan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ec4899',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal',
                        }).then(result => {

                            if (result.isConfirmed) {
                                form.submit();
                            }

                        });
                    });

                });

            });
        </script>

        <script>
            document
                .querySelectorAll('.order-status-btn')
                .forEach(button => {

                    button.addEventListener(
                        'click',
                        async function() {

                            const orderId =
                                this.dataset.order;

                            const status =
                                this.dataset.status;

                            const label =
                                this.dataset.label;

                            const result =
                                await Swal.fire({

                                    title: label + '?',

                                    text: 'Status pesanan akan diperbarui.',

                                    icon: status === 'cancelled' ?
                                        'warning' : 'question',

                                    showCancelButton: true,

                                    confirmButtonText: 'Ya',

                                    cancelButtonText: 'Batal'
                                });

                            if (!result.isConfirmed) {
                                return;
                            }

                            try {

                                const response =
                                    await fetch(
                                        `/dashboard/orders/${orderId}/status`, {
                                            method: 'PATCH',

                                            headers: {
                                                'Content-Type': 'application/json',

                                                'X-CSRF-TOKEN': document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]'
                                                    )
                                                    .content
                                            },

                                            body: JSON.stringify({
                                                status
                                            })
                                        }
                                    );

                                const data =
                                    await response.json();

                                if (!data.success) {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: data.message
                                    });

                                    return;
                                }

                                await Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message
                                });

                                location.reload();

                            } catch (error) {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan'
                                });

                                console.error(error);

                            }

                        }
                    );

                });
        </script>

        {{-- handle export --}}
        <script>
            document
                .getElementById('btn-export-order')
                .addEventListener('click', function(e) {

                    e.preventDefault();

                    const params =
                        new URLSearchParams(
                            window.location.search
                        );

                    window.location.href =
                        "{{ route('orders.export') }}?" +
                        params.toString();
                });
        </script>
    @endpush
</x-layouts.dashboard>
