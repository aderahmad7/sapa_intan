<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaRKategoriAlsintanModel extends Model
{
    protected $table = 'sapa_r_kategori_alsintan';
    protected $primaryKey = 'kalKode';
    protected $allowedFields = ['kalKode', 'kalNama', 'kalSingkatan'];
    protected $useTimestamps = false;
}
