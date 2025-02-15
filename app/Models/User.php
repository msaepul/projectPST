<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'departemen',
        'cabang_asal',
        'no_hp',
        'nama_lengkap',
        'ttd',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mutator for setting the role attribute in lowercase.
     *
     * @param string $value
     */
    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = strtolower($value);
    }

    public function isRole($role)
    {
        return $this->role === strtolower($role);
    }

    public function cabang()
{
    return $this->belongsTo(Cabang::class);
}
}
