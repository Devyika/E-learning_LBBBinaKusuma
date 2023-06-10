<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'pertemuan';

    protected $fillable = [
        'nama',
        'id_kelasMapelGuru',
    ];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class, 'id_kelasMapelGuru');
    }

    public function tugas()
    {
        return $this->hasMany(Pertemuan::class, 'id_pertemuan');
    }
}
