<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Make; 
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VehicleController extends Controller
{
    public function index(Request $request): Response
    {
        $vehicles = Vehicle::with(['photos', 'make', 'model'])
            ->when($request->make_id, fn($query) => $query->where('make_id', $request->make_id)) 
            ->when($request->model_id, fn($query) => $query->where('model_id', $request->model_id)) 
            ->when($request->year, fn($query) => $query->whereYear('year', $request->year))
            ->when($request->min_price, fn($query) => $query->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn($query) => $query->where('price', '<=', $request->max_price))
            ->latest()
            ->paginate(12);
    
        $minPrice = Vehicle::min('price') ?? 0;
        $maxPrice = Vehicle::max('price') ?? 100000;
    
        $makes = Make::all();
    
        $models = [];
        if ($request->make_id) {
            $models = VehicleModel::where('make_id', $request->make_id)->get();
        }
    
        return Inertia::render('Vehicles/Index', [
            'vehicles' => $vehicles,
            'filters' => $request->only(['make_id', 'model_id', 'year', 'min_price', 'max_price', 'status']),
            'priceRange' => [
                'min' => $minPrice,
                'max' => $maxPrice,
            ],
            'makes' => $makes,
            'models' => $models, 
        ]);
    }

    public function show(Vehicle $vehicle): Response
    {
        $vehicle->load('photos');

        return Inertia::render('Vehicles/Show', [
            'vehicle' => $vehicle,
        ]);
    }

    public function getVehiclesByMake(Request $request, $make)
    {
        $make = Make::with(['models', 'vehicles'])
                    ->where('name', $make)
                    ->firstOrFail();
    
        $vehicles = $make->vehicles()
                    ->with(['model', 'make', 'photos'])
                    ->when($request->model_id, fn($query) => $query->where('model_id', $request->model_id))
                    ->when($request->year, fn($query) => $query->whereYear('year', $request->year))
                    ->when($request->min_price, fn($query) => $query->where('price', '>=', $request->min_price))
                    ->when($request->max_price, fn($query) => $query->where('price', '<=', $request->max_price))
                    ->latest()
                    ->paginate(12);

        return Inertia::render('Vehicles/ByMake', [
            'make' => $make,
            'models' => $make->models, 
            'vehicles' => $vehicles,
            'filters' => $request->only(['model_id', 'year', 'min_price', 'max_price', 'status']), // Asegúrate de incluir model_id aquí
            'priceRange' => [
                'min' => $make->vehicles()->min('price'),
                'max' => $make->vehicles()->max('price'),
            ],
        ]);
    }

}