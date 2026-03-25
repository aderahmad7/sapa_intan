<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaRTipeAlsintanModel extends Model
{
    protected $table = 'sapa_r_tipe_alsintan';
    protected $primaryKey = 'tipeKode';
    protected $allowedFields = ['tipeKode', 'tipeNama', 'tipeSingkatan', 'tipeKalKode'];
    protected $useTimestamps = false;
}
