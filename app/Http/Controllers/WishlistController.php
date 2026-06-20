<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ========== WISHLIST INDEX =============
    public function index()
    {
        $wishlists = Wishlist::query()
            ->with([
                'product.primaryImage'
            ])
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(12);

        return view(
            'front.wishlist.index',
            compact('wishlists')
        );
    }


    // ========== WISHLIST TOGGLE =============
    public function toggle(Product $product)
    {
        $wishlist = Wishlist::query()
            ->where(
                'user_id',
                Auth::id()
            )
            ->where(
                'product_id',
                $product->id
            )
            ->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'success' => true,
                'action' => 'removed'
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ]);

        return response()->json([
            'success' => true,
            'action' => 'added'
        ]);
    }
}
