<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nama_pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_id',
        'nama_pegawai',
        'departemen',
        'nik',
        'upload_file',
        'lama_keberangkatan',
        'acc_nm',
        'alasan',
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
