<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionVehicle;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;

class AuctionCheckoutController extends Controller
{
    public function show(Auction $auction)
    {
        $auction->load(['images']); 

        return Inertia::render('Checkout/AuctionIndex', [
            'auction' => $auction,
        ]);
    }

    public function completePayment(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(404);
        }

        $order->load(['auctionVehicle']); 

        return Inertia::render('Checkout/AuctionCompletePayment', [
            'order' => $order,
            'auction' => $order->auctionVehicle,
        ]);
    }

    public function createOrder(Request $request, Auction $auction)
    {
        $auction_vehicle = AuctionVehicle::create([
            'user_id' => $request->user()->id,
            'auction_id' => $auction->id,
        ]); 

        $order = Order::create([
            'user_id' => $request->user()->id,
            'auction_vehicle_id' => $auction_vehicle->id,
            'total_amount' => $auction->current_price,
            'status' => 'pendiente',
        ]);

        $auction->load(['images']); 

        return redirect()->route('auctions.checkout.completePayment', ['order' => $order->id]);
    }

    public function checkout(Request $request, Auction $auction)
    {
        $stripePriceId = $auction->reserve_fee_stripe_price_id;
        $quantity = 1;
        
        $maxBid = $request->query('max_bid');

        return Inertia::location($request->user()->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel'),
            'metadata' => [
                'max_bid' => $maxBid, 
                'auction_id' => $auction->id, 
            ],
        ])->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId === null) {
            return redirect()->route('auctions.checkout.cancel'); 
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('auctions.checkout.cancel');
        }

        return Inertia::render('Checkout/AuctionSuccess', [
            'checkoutSession' => $session,
        ]);
    }

    public function processAlternativePayment(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string',
            'accountNumber' => 'required|string',
            'amount' => 'required|numeric',
            'reference' => 'required|string',
            'auction_id' => 'required|exists:auctions,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        try {
            $transaction = Transaction::create([
                'order_id' => $validatedData['order_id'],
                'amount' => $validatedData['amount'],
                'type' => 'deposit', 
                'status' => 'pending', 
                'payment_method' => $validatedData['payment_method'],
                'transaction_date' => now(), 
            ]);

            $order = Order::find($validatedData['order_id']);
            $order->status = 'completado'; 
            $order->save();

            return redirect('/')->with('success', 'Pago procesado con éxito');
        } catch (\Exception $e) {
            Log::error('Error al procesar el pago: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar el pago'], 500);
        }
    }

    public function cancel()
    {
        return Inertia::render('Checkout/AuctionCancel');
    }
}