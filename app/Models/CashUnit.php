<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'half',
        'one',
        'two',
        'five',
        'ten',
        'twenty',
        'fifty',
        'hundred',
        'two_hundred',
    ];

    public function cash_register() : BelongsTo {
        return $this->belongsTo(CashRegister::class);
    }
}
