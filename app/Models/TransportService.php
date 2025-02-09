<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportService extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'pickup_address',
        'delivery_address',
        'scheduled_date',
        'status',
    ];

    /**
     * Los atributos que deberían ser convertidos a fechas.
     *
     * @var array
     */
    protected $dates = ['scheduled_date', 'deleted_at'];

    /**
     * Relación con el modelo Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Obtener la etiqueta del estado.
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pendiente':
                return 'Pendiente';
            case 'en_transito':
                return 'En Tránsito';
            case 'completado':
                return 'Completado';
            default:
                return 'Desconocido';
        }
    }
}
