<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $table = 'kelas_siswa';

    protected $fillable = [
        'id_jurusanTingkatKelas',
        'id_siswa',
    ];


    public function jurusanTingkatKelas()
    {
        return $this->belongsTo(JurusanTingkatKelas::class, 'id_jurusanTingkatKelas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
