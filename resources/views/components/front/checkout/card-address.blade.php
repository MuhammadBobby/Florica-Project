@props(['address'])

<button type="button" id="change-address-btn"
    class="w-full block border rounded-base p-4 shadow-xl hover:bg-secondary/20 hover:scale-105 transition duration-300">
    <div id="checkout-address-card" class="w-full flex flex-col md:flex-row items-start gap-4 md:gap-5">
        <span>
            <svg class="w-6 h-6 text-primary shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                    clip-rule="evenodd" />
            </svg>
        </span>

        <div class="w-full">
            <div>
                <h2 class="font-semibold tracking-wider text-left text-sm md:text-base">Alamat pengiriman</h2>

                <div class="w-full flex justify-between items-center mt-2">
                    <h4 class="flex flex-wrap gap-2 items-center text-sm md:text-base">
                        <span id="checkout-recipient-name"
                            class="font-medium uppercase tracking-wider">{{ $address->recipient_name }}</span>
                        <span class="opacity-60">|</span>
                        <span id="checkout-recipient-phone" class="font-light">{{ $address->recipient_phone }}</span>
                    </h4>
                </div>

                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <p id="checkout-label"
                        class="text-body border border-default rounded-xs px-2 text-xs md:text-sm font-medium">
                        {{ $address->label }}
                    </p>

                    @if ($address->is_default)
                        <span id="checkout-default" class="text-xs bg-primary text-white px-2 py-1 rounded-full">
                            Utama
                        </span>
                    @endif
                </div>
            </div>

            <p id="checkout-address" class="text-sm text-body mt-2 text-left">
                {{ $address->address }}
            </p>

            <p id="checkout-city" class="text-xs md:text-sm uppercase text-body text-left">
                {{ $address->district }}, {{ $address->city }}, {{ $address->province }}, ID {{ $address->postal_code }}
            </p>
        </div>
    </div>
</button>
