<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Stripe Webhook Received:', $payload);

        if ($payload['type'] === 'checkout.session.completed') {
            $session = $payload['data']['object'];
            Log::info('Payment successful for session:', $session);
        }

        return response()->json(['status' => 'success']);
    }
}
