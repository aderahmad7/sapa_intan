<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaRKecamatanModel extends Model
{
    protected $table = 'sapa_r_kecamatan';
    protected $primaryKey = 'kcmKode';
    protected $allowedFields = ['kcmKode', 'kcmNama', 'kcmKotaKode'];
    protected $useTimestamps = false;
}
