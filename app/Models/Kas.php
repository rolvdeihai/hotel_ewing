<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    //

    protected $fillable = [
        'description',
        'qty',
        'transaction',
        'saldo',
    ];
}
