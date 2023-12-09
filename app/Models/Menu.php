<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'menu_name',
        'slug',
        'image_url',
    ];
    protected $with = [
        'items',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
