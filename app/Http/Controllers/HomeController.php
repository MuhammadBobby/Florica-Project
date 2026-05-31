<?php

namespace App\Http\Controllers;

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


        return view('landing.index', compact('bouquetProducts', 'keychainProducts'));
    }
}
