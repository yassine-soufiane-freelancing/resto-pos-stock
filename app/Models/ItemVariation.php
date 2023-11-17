<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemVariation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_size',
        'item_price',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
