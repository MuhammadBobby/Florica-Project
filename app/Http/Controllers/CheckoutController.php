<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\StoreProfile;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;

class CheckoutController extends Controller
{
    // =========== CHECKOUT INDEX =============
    public function index(Request $request)
    {
        $itemIds = json_decode(
            $request->items,
            true
        );

        if (empty($itemIds)) {
            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Pilih minimal 1 produk.'
                );
        }

        $cartItems = CartItem::query()
            ->with(['product.primaryImage',])
            ->whereIn('id', $itemIds)
            ->whereHas(
                'cart',
                fn($q) =>
                $q->where('user_id', Auth::id())
            )
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $address = UserAddress::query()
            ->where('user_id', Auth::id())
            ->where('is_default', true)
            ->first();

        $subtotal = $cartItems->sum(
            fn($item) =>
            $item->quantity *
                $item->product->price
        );

        $shippingCost = 0;
        $distanceKm = null;

        $store = StoreProfile::first();

        if (
            $store &&
            $store->latitude &&
            $store->longitude
        ) {

            $distanceKm = $this->calculateDistance(
                $store->latitude,
                $store->longitude,
                $address->latitude,
                $address->longitude
            );
        }

        if ($address) {
            $priceKm = StoreProfile::first()?->priceKm ?? 0;

            $shippingCost = $distanceKm * $priceKm;
        }

        $grandTotal = $subtotal + $shippingCost;

        return view('front.checkout.index', [
            'cart_items' => $cartItems,
            'address' => $address,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'distance_km' => $distanceKm,
        ]);
    }


    // ========== CHANGE ADDRESS =============
    public function changeAddress(Request $request)
    {
        $address = UserAddress::query()
            ->where('user_id', Auth::id())
            ->findOrFail($request->address_id);

        $distanceKm = 0;

        $store = StoreProfile::first();

        if (
            $store &&
            $store->latitude &&
            $store->longitude
        ) {

            $distanceKm = $this->calculateDistance(
                $store->latitude,
                $store->longitude,
                $address->latitude,
                $address->longitude
            );
        }

        $priceKm = $store->priceKm ?? 0;

        $shippingCost = round(
            $distanceKm * $priceKm
        );

        return response()->json([
            'address' => $address,
            'distance_km' => $distanceKm,
            'shipping_cost' => $shippingCost,
        ]);
    }

    // ============ FUNC CALCULATE DISTANCE =========
    private function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {

        $earthRadius = 6371;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);

        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle =
            2 * asin(
                sqrt(
                    pow(sin($latDelta / 2), 2)
                        +
                        cos($latFrom)
                        * cos($latTo)
                        * pow(sin($lonDelta / 2), 2)
                )
            );

        return round(
            $earthRadius * $angle,
            2
        );
    }
}
