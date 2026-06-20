<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductReview;
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

                        // update stock
                        foreach ($order->items as $item) {
                            Product::query()
                                ->where('id', $item->product_id)
                                ->decrement(
                                    'stock',
                                    $item->quantity
                                );
                        }

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
                'payment',
                'reviews'
            ])
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        $reviewedProductIds =
            ProductReview::query()
            ->where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return view(
            'front.orders.index',
            compact('orders', 'reviewedProductIds')
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

        // update stock
        foreach ($order->items as $item) {
            Product::query()
                ->where('id', $item->product_id)
                ->increment(
                    'stock',
                    $item->quantity
                );
        }

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

    // ========= REVIEWS=============
    public function storeOrderReview(
        Request $request
    ) {

        $order = Order::query()
            ->where(
                'user_id',
                Auth::id()
            )
            ->findOrFail(
                $request->order_id
            );

        // cek apakah sudah pernah review
        $alreadyReviewed = ProductReview::query()
            ->where(
                'user_id',
                Auth::id()
            )
            ->where(
                'order_id',
                $order->id
            )
            ->exists();

        if ($alreadyReviewed) {
            return back()->with(
                'error',
                'Pesanan ini sudah pernah direview.'
            );
        }


        foreach ($request->reviews as $review) {
            ProductReview::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'product_id' => $review['product_id'],
                ],

                [
                    'rating' => $review['rating'],
                    'review' => $review['review'],
                ]
            );
        }

        return back()->with(
            'success',
            'Terima kasih atas ulasan Anda.'
        );
    }
}
