<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        $this->ensureOrderAccess($order);

        return view('front.payments.create', [
            'order' => $order,
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {
        $this->ensureOrderAccess($order);

        try {
            $stripe = App::make('stripe.client');
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => intval(round($order->total * 100)),
                'currency' => strtolower($order->currency),
                'payment_method_types' => ['card'],
            ]);

            Payment::query()->updateOrCreate(
                [
                    'transaction_id' => $paymentIntent->id,
                ],
                [
                    'order_id' => $order->id,
                    'amount' => $order->total,
                    'currency' => $order->currency,
                    'method' => 'stripe',
                    'status' => 'pending',
                    'transaction_data' => json_encode($paymentIntent),
                ]
            );
        } catch (Throwable $e) {
            Log::error('Unable to create Stripe payment intent.', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => trans('Unable to initialize payment right now. Please try again later.'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function confirm(Request $request, Order $order)
    {
        $this->ensureOrderAccess($order);

        if (!$request->query('payment_intent')) {
            return redirect()->route('orders.payments.create', $order->id)
                ->withErrors(['payment' => trans('Missing payment reference.')]);
        }

        /**
         * @var \Stripe\StripeClient
         */
        try {
            $stripe = App::make('stripe.client');
            $paymentIntent = $stripe->paymentIntents->retrieve(
                $request->query('payment_intent'),
                []
            );
        } catch (Throwable $e) {
            Log::error('Unable to retrieve Stripe payment intent.', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('orders.payments.create', $order->id)
                ->withErrors(['payment' => trans('Unable to verify payment right now.')]);
        }

        if ($paymentIntent->status == 'succeeded') {
            try {
                $payment = Payment::query()->firstOrNew([
                    'transaction_id' => $paymentIntent->id,
                ]);

                $payment->forceFill([
                    'order_id' => $order->id,
                    'amount' => $order->total,
                    'currency' => $order->currency,
                    'method' => 'stripe',
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();

            } catch (Throwable $e) {
                Log::error('Unable to finalize payment.', [
                    'order_id' => $order->id,
                    'message' => $e->getMessage(),
                ]);

                return redirect()->route('orders.payments.create', $order->id)
                    ->withErrors(['payment' => trans('Payment succeeded but storing the result failed.')]);
            }

            event('payment.created', $payment->id);

            return redirect()->route('home', [
                'status' => 'payment-succeeded'
            ])->with('success', trans('Order created successfully'));
        }

        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status,
        ]);

    }

    protected function ensureOrderAccess(Order $order): void
    {
        if (!Auth::check() || ($order->user_id && $order->user_id !== Auth::id())) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
