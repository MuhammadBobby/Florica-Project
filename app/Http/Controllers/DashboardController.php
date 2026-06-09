<?php

namespace App\Http\Controllers;

use App\Enums\RoleUser;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreProfile;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // =========== DASHBOARD PAGE =============
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', RoleUser::Customer)->count();

        $monthlyRevenue = Order::query()
            ->where('order_status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        $latestOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::query()
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'monthlyRevenue' => $monthlyRevenue,
            'latestOrders' => $latestOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    // =========== STORE PROFILE PAGE =============
    public function storeProfile()
    {
        $storeProfile = StoreProfile::first();

        if (!$storeProfile) {
            $storeProfile = StoreProfile::create([
                'store_name' => 'Florica Blooms',
            ]);
        }

        return view(
            'admin.store-profile.index',
            compact('storeProfile')
        );
    }

    // ========== UPDATE STORE PROFILE =============
    public function updateStoreProfile(Request $request)
    {
        $validated = $request->validate([
            'store_name' => ['required'],
            'phone' => ['nullable'],
            'whatsapp' => ['nullable'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'district' => ['nullable'],
            'city' => ['nullable'],
            'province' => ['nullable'],
            'priceKm' => ['nullable', 'numeric'],
            'description' => ['nullable'],
        ], [
            'store_name.required' => 'Nama toko harus diisi.',
            'phone.numeric' => 'Nomor telepon harus berupa angka.',
            'whatsapp.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'email.email' => 'Format email tidak valid.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'priceKm.numeric' => 'Harga per kilometer harus berupa angka.',
        ]);

        StoreProfile::first()->update(
            $validated
        );

        return back()->with(
            'success',
            'Profil toko berhasil diperbarui.'
        );
    }
}
