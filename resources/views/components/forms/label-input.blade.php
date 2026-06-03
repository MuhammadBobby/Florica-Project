@props(['label', 'for', 'type' => 'text', 'placeholder' => '', 'isRequired' => false, 'isFocus' => false])

<div class="mb-5">
    <label for={{ $for }} class="block mb-2.5 text-sm font-medium text-heading">{{ $label }}</label>
    <input type={{ $type }} id={{ $for }}
        class="border border-default-medium text-heading text-sm rounded-base focus:ring-primary focus:border-primary block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
        placeholder={{ $placeholder }} {{ $isRequired ? 'required' : '' }} {{ $isFocus ? 'autofocus' : '' }}
        @if ($type === 'file') accept="image/*" @endif />
</div>
