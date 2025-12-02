<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'jurusan_id',
        'tahun_ajar_id',
        'foto_path',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function kelasDetails()
    {
        return $this->hasMany(KelasDetail::class);
    }
}
