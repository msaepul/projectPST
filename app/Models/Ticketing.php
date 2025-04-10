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
        'pegawai',
        'issued',
        'maskapai',
        'lampiran',
        'invoice',
        'transport',
        'beban_biaya',
        'keberangkatan',
        'nominal',
        'waktu',
        'rute',
        'rute_tujuan',
        'tiket',

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
}

