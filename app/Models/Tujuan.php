<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    use HasFactory;
    protected $table = 'tujuans';

    // Tentukan kolom yang boleh diisi
    protected $fillable = ['tujuan_penugasan'];
    
    public function pegawais()
    {
        return $this->hasMany(Nama_pegawai::class);
    }
}
