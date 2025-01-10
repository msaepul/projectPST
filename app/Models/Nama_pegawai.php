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
    'ct',
    'tp',
    'form_id',
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
