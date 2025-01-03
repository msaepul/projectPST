<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cabang_tujuan extends Model
{
    use HasFactory;
    protected $fillable = [
    'tujuan',
    'cabang',
    'form_id',
    ];
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

}
