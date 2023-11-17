<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveredOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'delivery_man',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
