<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc'); 
    
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }
    
        $auctions = Auction::orderBy($sortField, $sortDirection)->paginate(12);

        return Inertia::render('Auctions/Index', [
            'auctions' => $auctions,
            'filters' => $request->all(),
            'priceRange' => [
                'min' => 0, 
                'max' => 100000, 
            ],
            'sort' => $sortField,
            'direction' => $sortDirection,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $auction = Auction::findOrFail($id);

        return Inertia::render('Auctions/Show', [
            'auction' => $auction,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
