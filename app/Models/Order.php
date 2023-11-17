<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_status',
        'is_paid',
        'is_take_away',
        'payment_type',
        'order_note',
    ];

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
    public function tables(): BelongsToMany
    {
        return $this->belongsToMany(Table::class);
    }
    public function delivered_order(): HasOne
    {
        return $this->hasOne(DeliveredOrder::class);
    }
    public function imported_order(): HasOne
    {
        return $this->hasOne(ImportedOrder::class);
    }
    public function item_variations(): BelongsToMany
    {
        return $this->belongsToMany(ItemVariation::class);
    }
}
