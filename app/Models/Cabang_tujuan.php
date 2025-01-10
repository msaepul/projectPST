<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang_tujuan extends Model
{
    use HasFactory;

    protected $table = 'cabang_tujuans'; 

    protected $fillable = [
        'ct',
        'tp',
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
