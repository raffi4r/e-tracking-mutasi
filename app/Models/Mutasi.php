<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{

    protected $fillable = [
        'nip',
        'nama',
        'no_hp',
        'pangkat',
        'jabatan',
        'opd_asal',
        'opd_tujuan',
        'jenis_mutasi',
        'status',
        'kode_tiket',
        'keterangan',
    ];
}
