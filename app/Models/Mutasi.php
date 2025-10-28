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
        'tanggal_1',
        'tanggal_2',
        'tanggal_3',
        'tanggal_4',
        'tanggal_5',
        'tanggal_6',
        'tanggal_7'
    ];

    protected $casts = [
        'tanggal_1' => 'datetime',
        'tanggal_2' => 'datetime',
        'tanggal_3' => 'datetime',
        'tanggal_4' => 'datetime',
        'tanggal_5' => 'datetime',
        'tanggal_6' => 'datetime',
        'tanggal_7' => 'datetime',
    ];
}
