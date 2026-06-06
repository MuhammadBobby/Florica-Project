<x-layouts.dashboard title="Products">
    <x-dashboard.header title="Produk" subTitle="Kelola Produk Florica Blooms." />

    {{-- Create Button --}}
    <div class="flex items-center justify-end">
        <button type="button" data-modal-target="create-category-modal" data-modal-toggle="create-category-modal"
            class="mb-4 px-4 py-2.5 text-sm font-medium text-white bg-primary rounded-base hover:bg-pink-700 focus:ring-4 focus:ring-secondary">
            Tambah Produk
        </button>
    </div>

    {{-- Table --}}
    <x-dashboard.products.table :products="$products" />

    {{-- Pagination --}}
    <x-dashboard.pagination :paginator="$products" />

</x-layouts.dashboard>
