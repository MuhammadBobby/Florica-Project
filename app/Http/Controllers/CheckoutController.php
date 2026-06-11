<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // =========== CHECKOUT INDEX =============
    public function index(Request $request)
    {
        $itemIds = json_decode(
            $request->items,
            true
        );

        $cartItems = CartItem::query()
            ->whereIn('id', $itemIds)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            abort(403);
        }

        return view(
            'front.checkout.index',
            compact('cartItems')
        );
    }
}
