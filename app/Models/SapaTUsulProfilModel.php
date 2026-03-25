<?php

namespace App\Models;

use CodeIgniter\Model;

class SapaTUsulProfilModel extends Model
{
    protected $table = 'sapa_t_usul_profil';
    protected $primaryKey = 'proKode';
    protected $allowedFields = [
        'proTipeUsul',
        'proUsername',
        'proInsKode',
        'proPplNama',
        'proPplNamaKetua',
        'proPplFileKTP',
        'proPplTelp',
        'proPplKcmKode',
        'proPplDesa',
        'proPplPenyuluhNama',
        'proPplPenyuluhTelp',
        'proKabNamaLengkap',
        'proKabTelp',
        'proKabJabatan',
        'proKabFileTTd',
        'proKabKotaKode'
    ];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    function getProfileAll($username){   
        $builder = $this->db->table('sapa_t_usul_profil')
            ->select('*')
            ->join('sapa_t_account', 'sapa_t_account.accUsername = sapa_t_usul_profil.proUsername')
            ->join('sapa_m_instansi', 'sapa_t_account.accInsKode = sapa_m_instansi.insKode')
            ->join('sapa_r_kota', 'sapa_r_kota.kotaKode = sapa_t_account.accKotaKode','left')
            ->join('sapa_r_kecamatan', 'sapa_r_kecamatan.kcmKode = sapa_t_account.accKcmKode','left');
        $builder->where("accUsername",$username);
        $query = $builder->get();
        return $query->getRow();
    }
}
