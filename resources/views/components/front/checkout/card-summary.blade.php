@props(['subtotal', 'distance_km', 'shipping_cost', 'grand_total'])

<div class="bg-white border shadow-xl rounded-base p-5">
    {{-- Catatan --}}
    <x-forms.textarea label="Catatan" for="shipping_note" name="shipping_note" placeholder="Masukkan catatan tambahan" />

    <h3 class="font-bold mb-5">
        Ringkasan Belanja
    </h3>

    <div class="flex justify-between mb-3">

        <span>Subtotal</span>

        <span>
            Rp {{ number_format($subtotal, 0, ',', '.') }}
        </span>

    </div>

    <div id="shipping-cost" class="flex justify-between mb-3">

        <p>Ongkir <span id="distance-label">({{ $distance_km }} KM)</span></p>

        <span id="shipping-cost-value">
            Rp {{ number_format($shipping_cost, 0, ',', '.') }}
        </span>

    </div>

    <hr class="my-4">

    <div class="flex justify-between font-bold text-lg">

        <span>Total</span>

        <span id="grand-total" class="text-primary">
            Rp {{ number_format($grand_total, 0, ',', '.') }}
        </span>

    </div>

</div>
