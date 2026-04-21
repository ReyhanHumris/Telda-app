<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyData extends Model
{
    protected $table = 'survey_data';
    protected $primaryKey = 'id_survey';
    public $timestamps = false;

    protected $fillable = [
        'nama_responden',
        'no_telepon',
        'kriteria',
        'hasil_survey',
        'id_pengguna',
        'tanggal_input',
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
