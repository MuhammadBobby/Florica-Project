@props(['rolesOptions'])

<div class="mb-6 sm:mb-8 mt-8 sm:mt-12 w-full flex flex-col sm:flex-row sm:items-center justify-start gap-3 sm:gap-4">

    {{-- ROLE --}}
    <x-dashboard.filter-dropdown label="Jenis Pengguna" query="role" :options="$rolesOptions" />

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('customers.index') }}" class="w-full sm:w-80 md:w-96">

        <label for="search" class="sr-only">Search</label>

        <div class="relative w-full">

            <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 1 1 14 0Z" />
                </svg>
            </div>

            <input type="search" id="search" name="search" value="{{ request('search') }}"
                class="block w-full p-2.5 ps-10 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-primary focus:border-primary shadow-xs placeholder:text-body"
                placeholder="Data Pelanggan..." />

            <button type="submit"
                class="absolute inset-e-1.5 bottom-1.5 text-white bg-primary hover:bg-primary-strong border border-transparent focus:ring-4 focus:ring-primary-medium shadow-xs font-medium rounded text-xs px-3 py-1 focus:outline-none">
                Search
            </button>

        </div>
    </form>

</div>
