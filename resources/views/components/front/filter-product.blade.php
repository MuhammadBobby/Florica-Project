@props(['categories'])

<form method="GET" action="{{ route('products') }}" class="max-w-2xl mx-auto">
    <div class="flex shadow-xs rounded-base -space-x-0.5">
        <label for="search-dropdown" class="block mb-2.5 text-sm font-medium text-heading sr-only ">Search
            product</label>
        <button id="dropdown-button" data-dropdown-toggle="dropdown" type="button"
            class="w-24 md:w-auto inline-flex items-center shrink-0 z-10 text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-s-base text-left px-2 py-0.5 md:text-center text-xs md:text-sm md:px-4 md:py-2.5 focus:outline-none">
            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
            </svg>
            {{-- ambil sesuai parameter --}}
            {{ $categories->firstWhere('slug', request()->query('category'))?->name ?: 'All Categories' }}
            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 9-7 7-7-7" />
            </svg>
        </button>
        <div id="dropdown"
            class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-fit md:w-44">
            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdown-button">
                <li>
                    <a href="{{ route('products') }}"
                        class="block p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">All
                        Categories</a>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('products', ['category' => $category->slug]) }}"
                            class="block p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- ambil sesuai parameter --}}
        @if (request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        <input type="search" name="search" id="search-dropdown" value="{{ request('search') }}"
            class="px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm focus:ring-default-medium focus:border-default-medium block w-full placeholder:text-body"
            placeholder="Search products">
        <button type="submit"
            class="inline-flex items-center  text-white bg-primary hover:bg-pink-700 box-border border border-transparent focus:ring-4 focus:ring-primary-medium shadow-xs font-medium leading-5 rounded-e-base text-sm px-4 py-2.5 focus:outline-none">
            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
            Search
        </button>
    </div>
</form>
