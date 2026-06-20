<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
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
                            'payment_status' => PaymentStatus::Paid->value
                        ]);

                        $order->update([
                            'order_status' => OrderStatus::Success->value
                        ]);

                        break;

                    case 'pending':

                        $payment->update([
                            'payment_status' => PaymentStatus::Pending->value
                        ]);

                        break;

                    case 'expire':

                        $payment->update([
                            'payment_status' => PaymentStatus::Failed->value
                        ]);

                        $order->update([
                            'order_status' => OrderStatus::Cancelled->value
                        ]);

                        break;

                    case 'deny':
                    case 'cancel':

                        $payment->update([
                            'payment_status' => PaymentStatus::Failed->value
                        ]);

                        $order->update([
                            'order_status' => OrderStatus::Cancelled->value
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

    // ========== RECEIPT ===========
    public function receipt(Order $order)
    {
        abort_if(
            $order->user_id !== Auth::id(),
            403
        );

        $order->load([
            'items',
            'payment'
        ]);

        return view(
            'front.orders.receipt',
            compact('order')
        );
    }
}
