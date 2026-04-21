<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = true;
    protected $keyType = 'int';

    public const ROLE_ADMIN = 'admin';
    public const ROLE_OFFICER = 'officer';

    // ERD pakai "dibuat_pada" bukan created_at/updated_at
    public $timestamps = false;
    public const CREATED_AT = 'dibuat_pada';

    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'dibuat_pada' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
