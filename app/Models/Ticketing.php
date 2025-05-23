<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticketing extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_id',
        'no_surat',
        'nama_pemohon',
        'assigned_By',
        'hp',
        'agent',
        'issued',
        'transport',
        'maskapai',
        'invoice',
        'nominal',
        'beban_biaya',
        'kode_kendaraan',
        'rute',
        'tanggal_keberangkatan',
        'bulan_keberangkatan',
        'waktu_keberangkatan',


    ];
    public function form()
{
    return $this->belongsTo(Form::class, 'form_id', 'id');
}
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }
    public function nama_pegawai()
    {
        return $this->belongsTo(Nama_pegawai::class);
    }
}

