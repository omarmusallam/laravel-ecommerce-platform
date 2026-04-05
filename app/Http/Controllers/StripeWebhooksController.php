<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhooksController extends Controller
{
    public function handle(Request $request)
    {
        $secret = config('services.stripe.webhook_secret');

        if (!$secret) {
            Log::warning('Stripe webhook secret is not configured.');

            return response()->json([
                'message' => 'Webhook signing secret is not configured.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                (string) $request->header('Stripe-Signature'),
                $secret
            );
        } catch (\UnexpectedValueException|\Stripe\Exception\SignatureVerificationException $e) {
            Log::warning('Invalid Stripe webhook payload.', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Invalid webhook payload.',
            ], Response::HTTP_BAD_REQUEST);
        }

        Log::debug('Webhook event', [$event->type]);

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                Log::debug('Payment succeeded', [$paymentIntent->id]);
                break;
        }

        return response()->json(['received' => true]);
    }
}
