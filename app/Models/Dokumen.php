<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumen extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'file',
        ];

    public function ticketing()
    {
        return $this->belongsTo(ticketing::class, 'ticket_id', 'id');
    }
}
