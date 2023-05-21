<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    use HasFactory;

    protected $table = 'kelas_mapel';

    protected $fillable = [
        'id_jurusanTingkatKelas',
        'id_mapel',
    ];

    public function jurusanTingkatKelas()
    {
        return $this->belongsTo(JurusanTingkatKelas::class, 'id_jurusanTingkatKelas');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
