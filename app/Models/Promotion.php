<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'applicable_to',
        'start_date',
        'end_date',
    ];

    /**
     * Los atributos que deberían ser convertidos a fechas.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date', 'deleted_at'];

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
