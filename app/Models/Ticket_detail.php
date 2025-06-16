<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'file_name',
        'passenger_name',
        'flight_number',
        'flight_date',
        'departure_time',
        'departure_airport',
        'arrival_airport',
    ];
    public function ticketing()
    {
        return $this->belongsTo(Ticketing::class, 'ticket_id', 'id');
    }
    
    
    
}
