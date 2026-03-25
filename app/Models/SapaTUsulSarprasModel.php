<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaTUsulSarprasModel extends Model
{
    protected $table = 'sapa_t_usul_sarpras';
    protected $primaryKey = 'usulKode';
    protected $allowedFields = [
        'usulUsername',
        'usulTipeKode',
        'usulNoMesin',
        'usulNoRangka',
        'usulKomoditi',
        'usulKonKode',
        'usulKepemilikan',
        'usulLuasKinerja',
        'usulLuasJam',
        'usulFoto1',
        'usulFoto2',
        'usulFoto3',
        'usulFoto4',
        'usulInsKode',
        'usulStatus',
        'usulCatatanBpp',
        'usulCatatanKab',
        'usulCatatanProv',
        'usulCatatanBppFeedback',
        'usulCatatanKabFeedback',
        'usulCatatanProvFeedback',
        'usulRekomendasiProv',
        'usulPokKode',
        'usulKoordinat'
    ];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
}
