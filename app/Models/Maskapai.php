<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maskapai extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'kode_maskapai',
        'nama_maskapai',
        'jenis_kendaraan',
    ];
}
