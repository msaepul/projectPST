<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nama_pegawai_t extends Model
{
        use HasFactory;
        protected $fillable = [
            'ticket_id',
            'nama_pegawai',
            'departemen',
            'file_name',
            'flight_number',
            'flight_date',
            'departure_time',
            'asal',
            'tujuan',
        ];
    public function ticketing()
    {
        return $this->belongsTo(Ticketing::class, 'ticket_id', 'id');
    }
}
