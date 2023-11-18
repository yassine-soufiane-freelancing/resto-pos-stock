<?php

namespace App\Enums;
// a Laravel specific base class
use Spatie\Enum\Laravel\Enum;



/**
 * @method static self PENDING()
 * @method static self COMPLETED()
 * @method static self RETURNED()
 */
final class OrderStatus extends Enum
{
}
