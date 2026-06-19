<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\StoreProfile;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;

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


    // =========== PROCCESS CHECKOUT ===========
    public function process(Request $request)
    {
        $request->validate([
            'address_id' => ['required', 'exists:user_addresses,id'],
            'cart_items' => ['required', 'array'],
            'cart_items.*' => ['integer'],
            'shipping_note' => ['nullable', 'string'],
            'distance_km' => ['required', 'numeric'],
        ]);

        try {

            $address = UserAddress::query()
                ->where('user_id', Auth::id())
                ->findOrFail(
                    $request->address_id
                );

            $cartItems = CartItem::query()
                ->with('product')
                ->whereIn(
                    'id',
                    $request->cart_items
                )
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception(
                    'Produk tidak ditemukan'
                );
            }

            $subtotal = 0;

            foreach ($cartItems as $item) {
                $subtotal +=
                    $item->quantity *
                    $item->product->price;
            }

            $shippingCost = ((float)$request->distance_km) * ((float)StoreProfile::first()->priceKm);

            $grandTotal =
                $subtotal +
                $shippingCost;

            $invoice =
                'FLR-' .
                now()->format('YmdHis') .
                '-' .
                rand(100, 999);

            $order = Order::create([
                'user_id' => Auth::id(),
                'user_address_id' => $address->id,
                'invoice_number' => $invoice,
                'recipient_name' => $address->recipient_name,
                'recipient_phone' => $address->recipient_phone,
                'shipping_address' => $address->address,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $grandTotal,
                'order_status' => 'pending',
                'shipping_note' => $request->shipping_note,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' =>
                    $item->quantity *
                        $item->product->price
                ]);
            }
            $payload = [
                'transaction_details' => [
                    'order_id' => $invoice,
                    'gross_amount' => $grandTotal
                ],

                'customer_details' => [
                    'first_name' => Auth::user()->full_name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone,
                ]
            ];

            MidtransService::init();

            $snapToken =
                Snap::getSnapToken(
                    $payload
                );

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'midtrans',
                'midtrans_order_id' => $invoice,
                'transaction_id' => $invoice,
                'gross_amount' => $grandTotal,
                'payment_status' => 'pending',
                'snap_token' => $snapToken,
            ]);

            $order->update([
                'snap_token' => $snapToken
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // =========== PAYMENT CALLBACK ===========
    public function paymentCallback(Request $request)
    {
        $request->validate([
            'order_id' => ['required'],
            'status' => ['required']
        ]);

        DB::beginTransaction();

        try {

            $payment = Payment::query()
                ->where(
                    'order_id',
                    $request->order_id
                )
                ->firstOrFail();

            $order = Order::query()
                ->where('id', $request->order_id)
                ->firstOrFail();

            switch ($request->status) {

                case 'success':

                    $payment->update([
                        'payment_status' => PaymentStatus::Paid->value,
                        'paid_at' => now(),
                    ]);

                    $order->update([
                        'order_status' => OrderStatus::Success->value,
                        'paid_at' => now(),
                    ]);

                    // hapus item cart
                    CartItem::query()
                        ->where('cart_id', function ($query) use ($order) {

                            $query->select('id')
                                ->from('carts')
                                ->where(
                                    'user_id',
                                    $order->user_id
                                )
                                ->limit(1);
                        })
                        ->whereIn(
                            'product_id',
                            $order->items
                                ->pluck('product_id')
                        )
                        ->delete();

                    break;

                case 'pending':

                    $payment->update([
                        'payment_status' => PaymentStatus::Pending->value
                    ]);

                    $order->update([
                        'order_status' => OrderStatus::Pending->value
                    ]);

                    break;

                case 'failed':

                    $payment->update([
                        'payment_status' => PaymentStatus::Failed->value
                    ]);

                    $order->update([
                        'order_status' => OrderStatus::Cancelled->value
                    ]);

                    break;
            }

            DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
