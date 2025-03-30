<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
class CheckoutController extends Controller
{
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['photos', 'make', 'model']);

        $vehicleMake = $vehicle->make->name;
        $vehicleModel = $vehicle->model->name;

        return Inertia::render('Checkout/Index', [
            'vehicle' => $vehicle,
            'vehicleMake' => $vehicleMake,
            'vehicleModel' => $vehicleModel,
        ]);
    }

    public function completePayment(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'No tienes permiso para acceder a esta orden.');
        }

        $order->load(['vehicle.photos', 'vehicle.make', 'vehicle.model']);

        return Inertia::render('Checkout/CompletePayment', [
            'order' => $order,
            'vehicle' => $order->vehicle,
        ]);
    }

    public function createOrder(Request $request, Vehicle $vehicle)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'vehicle_id' => $vehicle->id,
            'total_amount' => $vehicle->price,
            'status' => 'pendiente',
        ]);

        $vehicle->load(['photos', 'make', 'model']);

        return redirect()->route('vehicles.checkout.completePayment', ['order' => $order->id]);
    }

    public function checkout(Request $request, Vehicle $vehicle)
    {
        $stripePriceId = $vehicle->stripe_price_id;
        $quantity = 1;

        return Inertia::location($request->user()->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel'),
        ])->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
 
        if ($sessionId === null) {
            return;
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

        
        if ($session->payment_status !== 'paid') {
            return;
        }

        return Inertia::render('Checkout/Success', [
            'checkoutSession' => $session,
        ]);

        return view('checkout.success');
    }

    public function cancel()
    {
        return Inertia::render('Checkout/Cancel');
    }

    public function processAlternativePayment(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string',
            'accountNumber' => 'required|string',
            'amount' => 'required|numeric',
            'reference' => 'required|string',
            'order_id' => 'required|exists:orders,id',
            'vehicle_id' => 'required|exists:vehicles,id',
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

            return response()->json([
                'message' => 'Pago procesado con éxito',
                'transaction' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al procesar el pago: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar el pago'], 500);
        }
    }
}