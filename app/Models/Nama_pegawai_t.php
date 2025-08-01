<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nama_pegawai_t extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'nama_pegawai', 'departemen'];


    public function ticketing()
    {
        return $this->belongsTo(Ticketing::class, 'ticket_id');
    }
}