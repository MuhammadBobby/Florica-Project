@props(['label', 'for', 'placeholder' => '', 'rows' => 4, 'isRequired' => false, 'isFocus' => false, 'value' => ''])

<div class="mb-5">
    <label for="{{ $for }}" class="block mb-2.5 text-sm font-medium text-heading">
        {{ $label }}
    </label>

    <textarea id="{{ $for }}" name="{{ $for }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        {{ $isRequired ? 'required' : '' }} {{ $isFocus ? 'autofocus' : '' }}
        {{ $attributes->merge([
            'class' =>
                'border border-default-medium bg-white text-heading text-sm rounded-base focus:ring-primary focus:border-primary block w-full px-3 py-2.5 shadow-xs placeholder:text-body',
        ]) }}>{{ old($for, $value) }}</textarea>

    @error($for)
        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>
