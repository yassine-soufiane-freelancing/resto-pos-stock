<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_name',
        'item_description',
        'unit',
    ];
    protected $with = [
        'item_variations',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
    public function item_variations(): HasMany
    {
        return $this->hasMany(ItemVariation::class);
    }
}
