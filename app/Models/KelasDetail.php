<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajar_id',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }
}
