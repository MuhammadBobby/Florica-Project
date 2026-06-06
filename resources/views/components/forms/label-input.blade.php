@props([
    'label',
    'for',
    'type' => 'text',
    'placeholder' => '',
    'isRequired' => false,
    'isFocus' => false,
    'value' => '',
])

<div class="mb-5">
    <label for="{{ $for }}" class="block mb-2.5 text-sm font-medium text-heading">
        {{ $label }}
    </label>

    <input type="{{ $type }}" id="{{ $for }}" name="{{ $for }}" value="{{ old($for, $value) }}"
        placeholder="{{ $placeholder }}" @required($isRequired) @if ($isFocus) autofocus @endif
        @if ($type === 'file') accept="image/*" @endif
        {{ $attributes->merge([
            'class' =>
                'border border-default-medium bg-white text-heading text-sm rounded-base focus:ring-primary focus:border-primary block w-full px-3 py-2.5 shadow-xs placeholder:text-body',
        ]) }}>

    @error($for)
        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>
