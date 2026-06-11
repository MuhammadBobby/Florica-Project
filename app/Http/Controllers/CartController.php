<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        // Use Cart model to retrieve the authenticated user's cart
        $cart = Cart::with([
            'items.product.primaryImage',
            'items.product.category',
        ])->where('user_id', Auth::id())->first();

        return view('front.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ],
            [
                'product_id.required' => 'Produk harus dipilih',
                'product_id.exists' => 'Produk tidak ditemukan',
                'quantity.required' => 'Jumlah harus diisi',
                'quantity.integer' => 'Jumlah harus berupa angka',
                'quantity.min' => 'Jumlah minimal adalah 1',
            ]
        );

        // Use Cart model to retrieve the authenticated user's cart
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
            ]);
        }

        // Check if the product is already in the cart
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        // If the product is already in the cart, update the quantity
        if ($item) {
            $item->increment(
                'quantity',
                $validated['quantity']
            );
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return back();
    }

    public function update(
        Request $request,
        CartItem $cartItem
    ) {

        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return back();
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return back()
            ->with('success', 'Produk dihapus dari keranjang');
    }
}
