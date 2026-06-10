@props([
    'label',
    'for',
    'type' => 'text',
    'placeholder' => '',
    'isRequired' => false,
    'isFocus' => false,
    'value' => '',
    'maxLength' => null,
    'minLength' => null,
])

<div class="mb-5">
    <label for="{{ $for }}" class="block mb-2.5 text-sm font-medium text-heading">
        {{ $label }}
    </label>

    <div class="relative">

        <input type="{{ $type }}" id="{{ $for }}" name="{{ $for }}"
            value="{{ old($for, $value) }}" placeholder="{{ $placeholder }}" maxlength="{{ $maxLength }}"
            minlength="{{ $minLength }}" @required($isRequired) @if ($isFocus) autofocus @endif
            @if ($type === 'file') accept="image/*" @endif
            {{ $attributes->merge([
                'class' =>
                    'border border-default-medium bg-white text-heading text-sm rounded-base focus:ring-primary focus:border-primary block w-full px-3 py-2.5 shadow-xs placeholder:text-body ' .
                    ($type === 'password' ? 'pr-12' : ''),
            ]) }}>

        @if ($type === 'password')
            <button type="button"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-body hover:text-heading"
                onclick="togglePassword('{{ $for }}', this)">

                {{-- Eye --}}
                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z" />
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                </svg>

                {{-- Eye Slash --}}
                <svg class="eye-close hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M3 3l18 18" />
                    <path stroke="currentColor" stroke-width="2"
                        d="M10.73 5.08A12.3 12.3 0 0 1 12 5c7 0 11 7 11 7a21.8 21.8 0 0 1-5.17 5.94M6.61 6.63C3.46 8.73 1 12 1 12s4 7 11 7c1.89 0 3.57-.51 5.03-1.32" />
                </svg>

            </button>
        @endif

    </div>

    @error($for)
        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>
