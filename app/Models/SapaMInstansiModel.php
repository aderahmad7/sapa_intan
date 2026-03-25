<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaMInstansiModel extends Model
{
    protected $table = 'sapa_m_instansi';
    protected $primaryKey = 'insKode';
    protected $allowedFields = [
        'insKode',
        'insNamaLengkap',
        'insNamaPendek',
        'insKotaKode',
        'insKepalaNama',
        'insKepalaNip',
        'insJabatan',
        'insUpdateAt',
        'insTtd',
        'insKop',
        'insCreateAt',
        'insPangkat',
        'insKabidNama',
        'insKabidNip',
        'insBppNama',
        'insBppNip',
        'insKabidJabatan',
        'insKabidTtd'
    ];
    protected $useTimestamps = false;
}
