<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id', 'no_surat', 'nama_pemohon', 'assigned_By', 'invoice', 'issued',
        'nominal', 'beban_biaya', 'agent', 'transport', 'maskapai', 'kereta', 'bus', 'class'
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

    // jika ini untuk 1 pegawai utama
    public function pegawai()
    {
        return $this->belongsTo(Nama_pegawai::class);
    }

    // relasi ke banyak pegawai di form tiket
    public function daftarPegawai()
    {
        return $this->hasMany(Nama_pegawai_t::class, 'ticket_id');
    }

    public function detailTiket()
    {
        return $this->hasMany(Ticket_detail::class, 'ticket_id');
    }

        public function detail_ticket()
    {
        return $this->hasMany(Ticket_detail::class, 'ticket_id', 'id');
    }
}

