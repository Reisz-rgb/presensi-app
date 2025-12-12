<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'jabatan',
        'divisi'
    ];

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }
}