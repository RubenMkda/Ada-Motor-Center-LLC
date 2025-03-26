<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AuctionVehicle;

class AuctionVehicleController extends Controller
{
    public function index()
    {
        $auctionVehicles = AuctionVehicle::with(['user', 'auction'])->get();

        return Inertia::render('Dashboard', [
            'auctionVehicles' => $auctionVehicles,
        ]);
    }
}