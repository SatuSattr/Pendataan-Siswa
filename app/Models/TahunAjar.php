<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahunAjar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tahun_ajar',
        'nama_tahun_ajar',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function kelasDetails()
    {
        return $this->hasMany(KelasDetail::class);
    }
}
