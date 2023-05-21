<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanTingkatKelas extends Model
{
    use HasFactory;

    protected $table = 'jurusan_tingkat_kelas';

    protected $fillable = [
        'id_jurusan',
        'id_tingkat',
        'id_kelas',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'id_tingkat');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function kelasMapel()
    {
        return $this->hasMany(KelasMapel::class, 'id_jurusanTingkatKelas');
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'id_jurusanTingkatKelas');
    }
}
