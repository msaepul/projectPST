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
    'lama',
    'form_id',
    ];
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function cabang()
    {
        return $this->belongsTo(Cabang::class); // misal memiliki foreign key 'cabang_id'
    }

    // Relasi ke tabel tujuan
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class); // misal memiliki foreign key 'tujuan_id'
    }

}
