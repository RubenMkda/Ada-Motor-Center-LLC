<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'make_id', 
        'model_id',
        'year',
        'price',
        'stripe_price_id',
        'VIN',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the vehicle's make and model combined.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->make . ' ' . $this->model;
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'vehicle_feature', 'vehicle_id', 'feature_id');
    }

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_feature', 'feature_id', 'vehicle_id');
    }

    public function photos()
    {
        return $this->hasMany(VehiclePhoto::class);
    }
}
