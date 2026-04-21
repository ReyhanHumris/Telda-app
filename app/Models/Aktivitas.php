<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktivitas extends Model
{
    protected $table = 'aktivitas';
    protected $primaryKey = 'id_aktivitas';
    public $timestamps = false;

    protected $fillable = [
        'nama_aktivitas',
        'tanggal_aktivitas',
        'keterangan',
        'id_pengguna',
    ];

    protected $casts = [
        'tanggal_aktivitas' => 'date',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
