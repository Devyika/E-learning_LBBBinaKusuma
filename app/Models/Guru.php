<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'username',
        'name',
        'email',
        'foto',
        'hapus',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function kelasMapel()
    {
        return $this->hasMany(KelasMapel::class, 'id_guru');
    }
}
