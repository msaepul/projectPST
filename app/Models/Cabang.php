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
    public function pegawais()
    {
        return $this->hasMany(Nama_pegawai::class);
    }
    public function tujuans()
    {
        return $this->hasMany(Cabang_tujuan::class);
    }
}


