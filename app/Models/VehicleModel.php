<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'make_id',
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    protected $table = 'models';

    /**
     * Get the make that owns the model.
     */
    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
