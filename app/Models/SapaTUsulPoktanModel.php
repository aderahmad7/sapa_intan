<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaTUsulPoktanModel extends Model
{
    protected $table = 'sapa_t_usul_poktan';
    protected $primaryKey = 'pokKode';
    protected $allowedFields = [
        'pokTipeUsul',
        'pokUsername',
        'pokInsKode',
        'pokPplNama',
        'pokPplNamaKetua',
        'pokPplFileKTP',
        'pokPplTelp',
        'pokPplKcmKode',
        'pokPplDesa',
        'pokPplPenyuluhNama',
        'pokPplPenyuluhTelp',
        'pokKabNamaLengkap',
        'pokKabTelp',
        'pokKabJabatan',
        'pokKabFileTTd',
        'pokKabKotaKode'
    ];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
}
