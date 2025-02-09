<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'discount_type',
        'amount',
        'applicable_to',
        'valid_from',
        'valid_until',
    ];

    /**
     * Los atributos que deberían ser convertidos a fechas.
     *
     * @var array
     */
    protected $dates = ['valid_from', 'valid_until', 'deleted_at'];

    /**
     * Obtener la etiqueta del tipo de descuento.
     */
    public function getDiscountTypeLabelAttribute()
    {
        return $this->discount_type === 'porcentaje' ? 'Porcentaje' : 'Monto Fijo';
    }

    /**
     * Obtener la etiqueta del tipo aplicable.
     */
    public function getApplicableToLabelAttribute()
    {
        switch ($this->applicable_to) {
            case 'dealer':
                return 'Dealer';
            case 'broker':
                return 'Broker';
            case 'ambos':
                return 'Ambos';
            default:
                return 'Desconocido';
        }
    }
}
