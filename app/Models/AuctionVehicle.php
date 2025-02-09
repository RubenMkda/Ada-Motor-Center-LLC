<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuctionVehicle extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'auction_id',
        'VIN',
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
     * Relación con el modelo Auction.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Método para obtener el estado del vehículo en la subasta.
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pendiente':
                return 'Pendiente';
            case 'en_proceso':
                return 'En Proceso';
            case 'comprado':
                return 'Comprado';
            default:
                return 'Desconocido';
        }
    }
}
