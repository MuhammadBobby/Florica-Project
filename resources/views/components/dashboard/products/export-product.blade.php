<div id="export-product-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    Laporan Penjualan Produk
                </h3>
                <button type="button"
                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="export-product-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('products.report.export') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block mb-2 font-medium text-heading">
                        Produk
                    </label>

                    <select id="product-select" name="product_id"
                        class="w-full rounded-base border border-default-medium bg-white px-3 py-2.5 text-heading shadow-xs transition-all
               focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none
               active:border-primary">

                        <option value="">
                            Semua Produk
                        </option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <x-forms.label-input label="Dari Tanggal" type="date" for="start_date" required />

                <x-forms.label-input label="Sampai Tanggal" type="date" for="end_date" required />

                <button class="mt-5 px-5 py-2 bg-primary text-white rounded-base">

                    Cetak Laporan

                </button>

            </form>
        </div>
    </div>
</div>
