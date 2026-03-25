<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaRKotaModel extends Model
{
    protected $table = 'sapa_r_kota';
    protected $primaryKey = 'kotaKode';
    protected $allowedFields = ['kotaKode', 'kotaNama', 'kotaPropKode'];
    protected $useTimestamps = false;
}
