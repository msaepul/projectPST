<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cabang extends Model
{
    use HasFactory;
    protected $fillable = [
    'nama_cabang',
    'kode_cabang',
    'alamat_cabang',
    ];
}
