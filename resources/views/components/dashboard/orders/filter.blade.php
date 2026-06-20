<form action="{{ route('orders.index') }}" method="GET"
    class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3 w-full">

    {{-- DATE --}}
    <div class="relative w-full sm:w-56">

        <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-body" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
            </svg>
        </div>

        <input datepicker datepicker-autohide type="text" name="date" value="{{ request('date') }}"
            placeholder="Filter tanggal"
            class="block w-full ps-10 pe-4 py-2.5 border border-default rounded-base bg-neutral-secondary-medium text-sm focus:ring-primary focus:border-primary">
    </div>

    {{-- SEARCH --}}
    <div class="relative w-full sm:flex-1 min-w-0">

        <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-body" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
        </div>

        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari No Invoice..."
            class="block w-full ps-10 pe-4 py-2.5 border border-default rounded-base bg-neutral-secondary-medium text-sm focus:ring-primary focus:border-primary">
    </div>

    {{-- BUTTON GROUP --}}
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">

        {{-- SUBMIT --}}
        <button type="submit"
            class="w-full sm:w-auto px-4 py-2.5 bg-primary text-white rounded-base hover:bg-primary-strong transition">
            Filter
        </button>

        {{-- RESET --}}
        @if (request()->filled('order_status') || request()->filled('date') || request()->filled('search'))
            <a href="{{ route('orders.index') }}"
                class="w-full sm:w-auto px-4 py-2.5 bg-red-500 text-white rounded-base hover:bg-red-600 transition text-center">
                Reset
            </a>
        @endif

    </div>

</form>
