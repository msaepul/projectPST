<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nama_pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
    'nama',
    'nik',
    'departemen',
    ];
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang'); // Menghubungkan dengan model Cabang
    }

    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class, 'tujuan'); // Menghubungkan dengan model Tujuan
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen');
    }

}
