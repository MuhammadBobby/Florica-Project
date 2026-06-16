@props(['cart_items'])

<div class="bg-white border shadow-xl rounded-base my-5">
    @foreach ($cart_items as $item)
        <div class="flex gap-4 p-5">

            <img src="{{ asset('storage/' . $item->product->primaryImage->image_url) }}"
                class="w-24 h-24 rounded-base object-cover">

            <div class="flex-1">

                <h4 class="font-semibold">
                    {{ $item->product->name }}
                </h4>

                <p class="text-body mt-2">
                    Qty:
                    {{ $item->quantity }}
                </p>
            </div>

            <div class="font-bold text-primary">
                Rp
                {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
            </div>
        </div>
    @endforeach
</div>
