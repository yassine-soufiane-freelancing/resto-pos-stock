<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_status',
        'is_paid',
        'payment_type',
        'order_note',
        'order_discount',
        'order_tip',
    ];

    protected $appends = [ 'by' ];
    protected $hidden  = ['cashier']; // so it does not return when calling 'by' attribute

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
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
        return $this->belongsToMany(ItemVariation::class)->withPivot([
            'item_quantity',
            'item_note',
        ]);
    }

    public function getByAttribute() {
        return $this->cashier ? $this->cashier->name : null;
    }
}
