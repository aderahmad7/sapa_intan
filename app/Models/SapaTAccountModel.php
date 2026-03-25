<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaTAccountModel extends Model
{
    protected $table = 'sapa_t_account';
    protected $primaryKey = 'accUsername';
    protected $allowedFields = [
        'accUsername',
        'accPasswd',
        'accNama',
        'accNoWhatsapp',
        'accRole',
        'accKcmKode',
        'accKotaKode',
        'accDesa',
        'accInsKode'
    ];
    protected $useTimestamps = false;
}
