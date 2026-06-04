<?php

namespace App\Http\Controllers;

use App\Enums\RoleUser;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
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
}
