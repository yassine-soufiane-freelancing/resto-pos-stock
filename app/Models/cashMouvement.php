<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class cashMouvement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount',
        'mouvement_type',
        'mouvement_description',
        'image_url',
    ];

    public function orders(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
