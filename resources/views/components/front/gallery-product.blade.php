@props(['primaryImage', 'images'])

<div class="space-y-4">

    {{-- Main Image --}}
    <div class="overflow-hidden rounded-xl border border-gray-100">
        <img class="w-full h-112.5 object-cover" src="/assets/products/{{ $primaryImage->image_url }}"
            alt="{{ $primaryImage->image_url }}">
    </div>

    {{-- Thumbnails --}}
    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach ($images as $image)
            <div class="shrink-0">
                <img class="w-24 h-24 object-cover rounded-lg border border-gray-200 hover:border-primary cursor-pointer transition"
                    src="/assets/products/{{ $image->image_url }}" alt="{{ $image->image_url }}">
            </div>
        @endforeach
    </div>

</div>
