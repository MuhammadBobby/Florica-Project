@props(['label', 'for', 'options' => [], 'placeholder' => 'Pilih Data', 'isRequired' => false, 'value' => null])

<div class="mb-5">
    <label for="{{ $for }}" class="block mb-2.5 text-sm font-medium text-heading">
        {{ $label }}
    </label>

    <select id="{{ $for }}" name="{{ $for }}" {{ $isRequired ? 'required' : '' }}
        {{ $attributes->merge([
            'class' =>
                'border border-default-medium bg-white text-heading text-sm rounded-base focus:ring-primary focus:border-primary block w-full px-3 py-2.5 shadow-xs',
        ]) }}>

        <option value="">
            {{ $placeholder }}
        </option>

        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @selected(old($for, $value) == $key)>
                {{ $option }}
            </option>
        @endforeach

    </select>

    @error($for)
        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>
