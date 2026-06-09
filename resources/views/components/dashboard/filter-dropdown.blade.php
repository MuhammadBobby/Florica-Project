@props(['label', 'query', 'options' => []])

@php
    $dropdownId = 'dropdown-' . Str::random(8);

    $currentValue = request($query);

    $selectedLabel = collect($options)->firstWhere('value', $currentValue)['label'] ?? $label;
@endphp

<div class="relative">
    <button id="{{ $dropdownId }}-button" data-dropdown-toggle="{{ $dropdownId }}" data-dropdown-trigger="hover"
        type="button"
        class="inline-flex items-center justify-center
            text-white bg-primary
            hover:bg-pink-700
            focus:ring-4 focus:ring-secondary
            rounded-base text-sm px-4 py-2.5">

        {{ $selectedLabel }}

        <svg class="w-4 h-4 ms-1.5" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="m19 9-7 7-7-7" />
        </svg>
    </button>

    <div id="{{ $dropdownId }}" class="z-50 hidden bg-white border border-default-medium rounded-base shadow-lg w-52">

        <ul class="p-2 text-sm font-medium">

            {{-- Reset --}}
            <li>
                <a href="{{ request()->fullUrlWithQuery([$query => null, 'page' => null]) }}"
                    class="block p-2 rounded hover:bg-secondary hover:text-primary">
                    Semua
                </a>
            </li>

            @foreach ($options as $option)
                <li>
                    <a href="{{ request()->fullUrlWithQuery([$query => $option['value'], 'page' => null]) }}"
                        class="block p-2 rounded
                        {{ $currentValue == $option['value']
                            ? 'bg-secondary text-primary font-semibold'
                            : 'hover:bg-secondary hover:text-primary' }}">
                        {{ $option['label'] }}
                    </a>
                </li>
            @endforeach

        </ul>
    </div>
</div>
