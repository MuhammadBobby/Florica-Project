<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

// use Illuminate\Http\Request;

class HomeController extends Controller
{
    //============ LANDING PAGE =============
    public function index()
    {
        // Get product category bouquet
        $bouquetProducts = Product::query()
            ->with([
                'category',
                'primaryImage',
            ])
            ->whereHas('category', function ($query) {
                $query->where('slug', 'bouquet');
            })
            ->where('is_active', true)
            ->take(3)
            ->get();

        // Get product category keychain
        $keychainProducts = Product::query()
            ->with([
                'category',
                'primaryImage',
            ])
            ->whereHas('category', function ($query) {
                $query->where('slug', 'keychain');
            })
            ->where('is_active', true)
            ->take(3)
            ->get();

        $cartCount = 0;


        return view('landing.index', compact('bouquetProducts', 'keychainProducts'));
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
    public function productDetail($slug)
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

        return view('landing.product-detail', compact('product', 'relatedProducts'));
    }
}
