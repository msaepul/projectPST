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
        'invoice',
        'issued',
        'nominal',
        'beban_biaya',
        'agent',
        'transport',
        'maskapai',
        'class',


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
    public function Nama_pegawai_t()
    {
        return $this->hasMany(Nama_pegawai_t::class);
    }

    public function Detail_ticket()
{
    return $this->hasMany(Detail_ticket::class, 'ticket_id');
}

}

