<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'cabang',
        'tujuan',
        'status_verifikasi',
        ];
    public function Nama_pegawais()
    {
        return $this->hasMany(Nama_pegawai::class);
    }
    public function Cabang_tujuans()
    {
        return $this->hasMany(Cabang_tujuan::class);
    }
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
