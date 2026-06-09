@props(['categories', 'statusProductOptions'])

<div class="flex items-center gap-3">
    {{-- Kategori --}}
    <x-dashboard.filter-dropdown label="Kategori" query="category" :options="$categories
        ->map(
            fn($cat) => [
                'label' => $cat->name,
                'value' => $cat->slug,
            ],
        )
        ->toArray()" />

    {{-- Status Produk --}}
    <x-dashboard.filter-dropdown label="Status Produk" query="status" :options="$statusProductOptions" />

    {{-- Search --}}
    <form method="GET" action="{{ route('products.index') }}" class="w-96 max-w-sm">
        <label for="search" class="block mb-2.5 text-sm font-medium text-heading sr-only ">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="search" name="search" value="{{ request('search') }}"
                class="block w-full p-2.5 ps-9 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-primary focus:border-primary shadow-xs placeholder:text-body"
                placeholder="Nama Produk..." />
            <button type="submit"
                class="absolute inset-e-1.5 bottom-1.5 text-white bg-primary hover:bg-primary-strong box-border border border-transparent focus:ring-4 focus:ring-primary-medium shadow-xs font-medium leading-5 rounded text-xs px-3 py-1 focus:outline-none">Search</button>
        </div>
    </form>
</div>
