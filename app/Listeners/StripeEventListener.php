<?php
 
namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Laravel\Cashier\Events\WebhookReceived;
 
class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        Log::info('Stripe Webhook Received:', $payload);

        if ($payload['type'] === 'checkout.session.completed') {
            $session = $payload['data']['object'];
            Log::info('Payment successful for session:', $session);
        }
    }
}