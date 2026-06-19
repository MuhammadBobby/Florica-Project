<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    // ========== INDEX ===========
    public function index(Request $request)
    {
        if (
            $request->filled('order_id') &&
            $request->filled('transaction_status')
        ) {

            $payment = Payment::where(
                'midtrans_order_id',
                $request->order_id
            )->first();

            if ($payment) {

                $order = $payment->order;

                switch ($request->transaction_status) {

                    case 'settlement':
                    case 'capture':

                        $payment->update([
                            'payment_status' => 'success'
                        ]);

                        $order->update([
                            'order_status' => 'success'
                        ]);

                        break;

                    case 'pending':

                        $payment->update([
                            'payment_status' => 'pending'
                        ]);

                        break;

                    case 'expire':

                        $payment->update([
                            'payment_status' => 'failed'
                        ]);

                        $order->update([
                            'order_status' => 'cancelled'
                        ]);

                        break;

                    case 'deny':
                    case 'cancel':

                        $payment->update([
                            'payment_status' => 'failed'
                        ]);

                        $order->update([
                            'order_status' => 'cancelled'
                        ]);

                        break;
                }
            }
        }


        $orders = Order::query()
            ->with([
                'items.product.primaryImage',
                'payment'
            ])
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'front.orders.index',
            compact('orders')
        );
    }

    // ========== CANCEL ===========
    public function cancel(Order $order)
    {
        $order->update([
            'order_status' => 'cancelled'
        ]);

        $order->payment()->update([
            'payment_status' => 'failed'
        ]);

        return back()
            ->with('success', 'Order cancelled successfully');
    }
}
