<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Http\Request;

class HomeController extends Controller
{
    //============ LANDING PAGE =============
    public function index()
    {
        $categories = Category::whereHas('products', function ($query) {
            $query->where('is_active', true);
        })
            ->with([
                'products' => function ($query) {
                    $query->with('primaryImage')
                        ->where('is_active', true)
                        ->latest()
                        ->take(3);
                }
            ])
            ->get();

        return view('landing.index', compact('categories'));
    }

    // =========== PRODUCTS PAGE =============
    public function products()
    {
        $query = Product::query()
            ->with([
                'category',
                'primaryImage',
            ])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_active', true);

        // Filter Category
        if ($category = request('category')) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Search Product
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();

        return view('landing.products', compact('products', 'categories'));
    }

    // =========== PRODUCT DETAIL PAGE =============
    public function productDetail(String $slug)
    {
        $product = Product::query()
            ->with([
                'category',
                'primaryImage',
                'images',
                'reviews',
            ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with([
            'primaryImage'
        ])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        // wishlist
        $isWishlist = false;

        if (Auth::check()) {
            $isWishlist = Wishlist::query()
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->where(
                    'product_id',
                    $product->id
                )
                ->exists();
        }

        return view('landing.product-detail', compact('product', 'relatedProducts', 'isWishlist'));
    }
}
