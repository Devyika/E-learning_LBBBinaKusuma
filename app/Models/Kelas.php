<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'id_jurusan',
        'hapus',
    ];

    public function jurusanTingkatKelas()
    {
        return $this->hasMany(JurusanTingkatKelas::class, 'id_kelas');
    }
}
