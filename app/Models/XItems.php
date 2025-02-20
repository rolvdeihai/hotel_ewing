<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XItems extends Model
{
    //
    protected $fillable = [
        'booking_id',
        'pricelist_id',
        'qty',
    ];

    public function pricelists()
    {
        return $this->belongsTo(Pricelist::class, 'pricelist_id'); // Correct relationship
    }
}
