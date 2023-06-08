<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;
    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'id_siswa',
        'id_tugas',
        'file',
        'nilai'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }
}
