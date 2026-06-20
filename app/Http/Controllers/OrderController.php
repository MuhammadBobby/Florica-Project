<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with([
                'user',
                'items.product.primaryImage',
                'payment'
            ])

            ->when(
                $request->filled('order_status'),
                fn($query) =>
                $query->where(
                    'order_status',
                    $request->order_status
                )
            )

            ->when(
                $request->filled('date'),
                fn($query) =>
                $query->whereDate(
                    'created_at',
                    Carbon::parse(
                        $request->date
                    )
                )
            )

            ->when(
                $request->search,
                fn($q, $search)
                => $q->where(
                    'invoice_number',
                    'like',
                    "%{$search}%"
                )
            )

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }


    // =========== UPDATE ORDER STATUS =============
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'confirmed',
                    'packed',
                    'shipped',
                    'completed',
                    'cancelled'
                ])
            ]
        ]);

        $currentStatus = $order->order_status->value;

        $allowedTransitions = [
            'success' => ['confirmed'],
            'confirmed' => ['packed'],
            'packed' => ['shipped'],
            'shipped' => ['completed'],
            'pending' => ['cancelled'],
        ];

        if (
            !isset($allowedTransitions[$currentStatus]) ||
            !in_array(
                $validated['status'],
                $allowedTransitions[$currentStatus]
            )
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Perubahan status tidak valid.'
            ], 422);
        }

        $order->update([
            'order_status' => $validated['status']
        ]);

        // Update stock apabila Cancel
        if ($validated['status'] == 'cancelled') {
            foreach ($order->items as $item) {
                Product::query()
                    ->where('id', $item->product_id)
                    ->increment(
                        'stock',
                        $item->quantity
                    );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }


    // ========== EXPORT ORDER ==============
    public function export(Request $request)
    {
        $orders = Order::query()
            ->with([
                'user',
                'items.product',
                'payment'
            ])

            ->when(
                $request->filled('order_status'),
                fn($q) =>
                $q->where(
                    'order_status',
                    $request->order_status
                )
            )

            ->when(
                $request->filled('date'),
                fn($q) =>
                $q->whereDate(
                    'created_at',
                    Carbon::parse(
                        $request->date
                    )
                )
            )

            ->latest()
            ->get();

        $completedOrders =
            $orders->where(
                'order_status',
                OrderStatus::Completed->value
            );

        $processOrders =
            $orders->filter(
                fn($order) =>
                in_array(
                    $order->order_status->value,
                    [
                        OrderStatus::Confirmed->value,
                        OrderStatus::Packed->value,
                        OrderStatus::Shipped->value
                    ]
                )
            );

        $pendingOrders =
            $orders->where(
                'order_status',
                OrderStatus::Pending->value
            );

        $failedOrders =
            $orders->where(
                'order_status',
                OrderStatus::Cancelled->value
            );

        return view(
            'admin.orders.export',
            compact(
                'completedOrders',
                'processOrders',
                'pendingOrders',
                'failedOrders'
            )
        );
    }


    // ========= REKAP ORDER ===========
    public function rekap(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $query = Order::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        $orders = $query
            ->whereIn('order_status', [
                OrderStatus::Success->value,
                OrderStatus::Confirmed->value,
                OrderStatus::Packed->value,
                OrderStatus::Shipped->value,
                OrderStatus::Completed->value,
            ])
            ->with('payment')
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        return view('admin.orders.rekap', compact(
            'orders',
            'start',
            'end',
            'totalRevenue',
            'totalOrders'
        ));
    }
}
