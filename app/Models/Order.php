<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'vehicle_id',
        'auction_vehicle_id',
        'total_amount',
        'status',
    ];

    /**
     * Los atributos que deberían ser convertidos a fechas.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Relación con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo Vehicle.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relación con el modelo AuctionVehicle.
     */
    public function auctionVehicle()
    {
        return $this->belongsTo(AuctionVehicle::class);
    }

    /**
     * Relación con el modelo BrokerFee.
     */
    public function brokerFees()
    {
        return $this->hasMany(BrokerFee::class);
    }

    /**
     * Método para obtener el estado de la orden.
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pendiente':
                return 'Pendiente';
            case 'completado':
                return 'Completado';
            case 'cancelado':
                return 'Cancelado';
            default:
                return 'Desconocido';
        }
    }
}
