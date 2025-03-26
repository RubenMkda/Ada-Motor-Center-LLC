<?php

use App\Http\Controllers\AuctionCheckoutController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuctionVehicleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\ShareInertiaData;
use App\Models\AuctionVehicle;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([ShareInertiaData::class])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/vehicles/make/{make}', [VehicleController::class, 'getVehiclesByMake'])->name('vehicles.byMake');

    Route::resource('auctions', AuctionController::class);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', ShareInertiaData::class])->group(function () {
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout-cancel');
    
    Route::get('/checkout/vehicles/{vehicle}', [CheckoutController::class, 'show'])->name('vehicles.checkout.show');
    Route::post('/checkout/vehicles/{vehicle}', [CheckoutController::class, 'createOrder'])->name('vehicles.checkout.createOrder');
    Route::get('/checkout/vehicles/{vehicle}/process', [CheckoutController::class, 'checkout'])->name('vehicles.checkout.process');
    Route::get('/checkout/vehicles/complete-payment/{order}', [CheckoutController::class, 'completePayment'])->name('vehicles.checkout.completePayment');

    Route::get('/checkout/auctions/{auction}', [AuctionCheckoutController::class, 'show'])->name('auctions.checkout.show');
    Route::post('/checkout/auctions/{auction}', [AuctionCheckoutController::class, 'createOrder'])->name('auctions.checkout.createOrder');
    Route::get('/checkout/auctions/{auction}/process', [AuctionCheckoutController::class, 'checkout'])->name('auctions.checkout.process');
    Route::get('/checkout/auctions/complete-payment/{order}', [AuctionCheckoutController::class, 'completePayment'])->name('auctions.checkout.completePayment');
    Route::post('/auctions/checkout/process-alternative-payment', [AuctionCheckoutController::class, 'processAlternativePayment'])
    ->name('auctions.checkout.processAlternativePayment');
    Route::post('/vehicles/checkout/process-alternative-payment', [AuctionCheckoutController::class, 'processAlternativePayment'])
    ->name('vehicles.checkout.processAlternativePayment');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [AuctionVehicleController::class, 'index'])->name('dashboard');
});