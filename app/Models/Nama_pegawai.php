<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nama_pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_id',
        'nama_pegawai',
        'departemen',
        'nik',
        'upload_file',
        'lama_keberangkatan',       
    ];
    public function form()
    {
        return $this->belongsTo(Form::class);
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
