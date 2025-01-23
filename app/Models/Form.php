<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_surat',
        'nama_pemohon',
        'cabang_asal',
        'cabang_tujuan',
        'tujuan',
        'tanggal_keberangkatan',
        'acc_bm',
        'acc_hrd',
        'acc_ho',
        'acc_cabang',
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
