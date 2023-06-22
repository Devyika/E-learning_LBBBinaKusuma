<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'nama',
        'id_pertemuan',
        'deadline',
        'deskripsi',
    ];

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'id');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }
}
