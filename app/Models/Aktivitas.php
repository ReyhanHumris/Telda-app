<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitas extends Model
{
    use SoftDeletes;
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
        'tanggal_aktivitas' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
