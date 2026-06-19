<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query()
            ->with([
                'user',
                'items.product.primaryImage',
                'payment'
            ])->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }


    // =========== UPDATE ORDER STATUS =============
    public function updateStatus(
        Request $request,
        Order $order
    ) {

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

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }
}
