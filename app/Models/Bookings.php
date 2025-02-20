<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    //
    protected $fillable = [
        'guestName',
        'room_id',
        'email',
        'phone_number',
        'check_in_date',
        'check_out_date',
        'payment_method',
        'total_amount',
        'status',
    ];

    public function rooms()
    {
        return $this->belongsTo(Rooms::class, 'room_id'); // Correct relationship
    }
}
