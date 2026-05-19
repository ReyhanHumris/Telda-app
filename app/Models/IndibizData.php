<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndibizData extends Model
{
    use SoftDeletes;
    protected $table = 'indibiz_data';
    protected $primaryKey = 'id_indibiz';
    public $timestamps = false;

    protected $fillable = [
        'nama_perusahaan',
        'alamat_perusahaan',
        'jenis_layanan',
        'status_langganan',
        'id_pengguna',
        'tanggal_input',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
