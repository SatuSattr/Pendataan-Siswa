<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'level_kelas',
        'tahun_ajar_id',
        'jurusan_id',
    ];

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function kelasDetails()
    {
        return $this->hasMany(KelasDetail::class);
    }
}
