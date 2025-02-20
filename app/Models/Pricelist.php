<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'stocks',
        'auto_stock',
        'auto_stock_value',
    ];
}
