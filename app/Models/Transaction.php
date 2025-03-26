<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'amount',
        'type',
        'status',
        'payment_method',
        'transaction_date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}