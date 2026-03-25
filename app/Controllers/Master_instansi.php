<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SapaMInstansiModel;
use App\Models\SapaRKotaModel;
use App\Models\SapaTUsulSarprasModel;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Master_instansi extends BaseController
{
    protected $user;
    public function __construct()
    {
        if (!session()->get('logged_in')) {
            session_destroy();
            redirect()->to('/')->with('error', 'Silakan login dulu')->send();
            exit;
        }

        
    }

    

    public function getIndex()
    {
        $sapaRKotaModel = model('App\Models\SapaRKotaModel');
        $kotaList = $sapaRKotaModel->findAll();
        // ambil data kecamatan, lalu tambahkan ke kotaList berdasarkan kotaKode
        $sapaRKecamatanModel = model('App\Models\SapaRKecamatanModel');
        $kecamatanList = $sapaRKecamatanModel->findAll();
        foreach ($kotaList as &$kota) {
            $kota['kecamatan'] = [];
            foreach ($kecamatanList as $kecamatan) {
                if ($kecamatan['kcmKotaKode'] == $kota['kotaKode']) {
                    $kota['kecamatan'][] = $kecamatan;
                }
            }
        }
        $data = [
            'title' => 'Master Instansi',
            'kotaList' => $kotaList,
            'user' => $this->user
        ];
        return view('instansi/index', $data);
    }

   
    public function getDatatable()
    {
        $db = db_connect();
        $builder = $db->table('sapa_m_instansi')
            ->select('insKode, insNamaLengkap, insNamaPendek, kotaNama')
            ->join('sapa_r_kota', 'sapa_m_instansi.insKotaKode = sapa_r_kota.kotaKode', 'left');
        $builder->where("insKode<>","PROV");
        return DataTable::of($builder)->toJson(true);
    }

    public function postHapus_instansi()
    {
        $username = $this->request->getPost('insKode');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Instansi tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaMInstansiModel');
        // Cek apakah akun ada
        $akunData = $sapaTAccountModel->where('insKode', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Instansi tidak ditemukan']);
        }
        // Hapus akun
        $sapaTAccountModel->delete($username);
        return $this->response->setJSON(['success' => 'Instansi berhasil dihapus']);
    }

    public function postGet_data_by_id()
    {
        $username = $this->request->getPost('insKode');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Instansi tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaMInstansiModel');
        $akunData = $sapaTAccountModel->where('insKode', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Instansi tidak ditemukan']);
        }
        return $this->response->setJSON($akunData);
    }


   
    public function postAdd_instansi()
    {
        $model = model('App\Models\SapaMInstansiModel');
        // ambil data dari input pake esc, jika ada yang kosong, set null
        $data = [
            'insKode' => esc($this->request->getPost('insKode')),
            // password di-hash dengan md5
            'insNamaLengkap' => esc($this->request->getPost('insNamaLengkap')),
            'insNamaPendek' => esc($this->request->getPost('insNamaPendek')),
            'insKotaKode' => esc($this->request->getPost('insKotaKode')),
        ];

        // Cek keunikan username
        $isTaken = $model->where('insKode', $data['insKode'])->first();
        if ($isTaken) {
            return redirect()->to('master_instansi')->withInput()->with('error', 'Kode Instansi sudah dipakai!');
        }

        // Cek keunikan kota
        $isTaken = $model->where('insKotaKode', $data['insKotaKode'])->first();
        if ($isTaken) {
            return redirect()->to('master_instansi')->withInput()->with('error', 'Kota untuk instansi sudah dipakai!');
        }

        // Insert data akun
        $model->insert($data);
        return redirect()->to('master_instansi')->with('success', 'Instansi berhasil ditambahkan!');
    }

    public function postEdit_instansi()
    {
        $model = model('App\Models\SapaMInstansiModel');
        // ambil data dari input pake esc
        $data = [
            'insKode' => esc($this->request->getPost('insKodeEdit')),
            // password di-hash dengan md5
            'insNamaLengkap' => esc($this->request->getPost('insNamaLengkapEdit')),
            'insNamaPendek' => esc($this->request->getPost('insNamaPendekEdit')),
            'insKotaKode' => esc($this->request->getPost('insKotaKodeEdit')),
        ];

    
        // Update data akun
        $model->save($data);
        return redirect()->to('master_instansi')->with('success', 'Instansi berhasil diperbarui!');
    }

 
}
