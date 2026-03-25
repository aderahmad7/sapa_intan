<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SapaRKategoriAlsintanModel;
use App\Models\SapaRKotaModel;
use App\Models\SapaTUsulSarprasModel;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Master_kategori extends BaseController
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
            'title' => 'Master Kategori Alsintan',
            'kotaList' => $kotaList,
            'user' => $this->user
        ];
        return view('kategori/index', $data);
    }

   
    public function getDatatable()
    {
        $db = db_connect();
        $builder = $db->table('sapa_r_kategori_alsintan')
            ->select('kalKode, kalNama, kalSingkatan');

        return DataTable::of($builder)->toJson(true);
    }

    public function postHapus_kategori()
    {
        $username = $this->request->getPost('kalKode');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Kategori tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaRKategoriAlsintanModel');
        // Cek apakah akun ada
        $akunData = $sapaTAccountModel->where('kalKode', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Kategori tidak ditemukan']);
        }
        // Hapus akun
        $sapaTAccountModel->delete($username);
        return $this->response->setJSON(['success' => 'Kategori berhasil dihapus']);
    }

    public function postGet_data_by_id()
    {
        $username = $this->request->getPost('kalKode');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Kategori tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaRKategoriAlsintanModel');
        $akunData = $sapaTAccountModel->where('kalKode', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Kategori tidak ditemukan']);
        }
        return $this->response->setJSON($akunData);
    }


   
    public function postAdd_kategori()
    {
        $model = model('App\Models\SapaRKategoriAlsintanModel');
        // ambil data dari input pake esc, jika ada yang kosong, set null
        $data = [
            'kalKode' => esc($this->request->getPost('kalKode')),
            // password di-hash dengan md5
            'kalNama' => esc($this->request->getPost('kalNama')),
            'kalSingkatan' => esc($this->request->getPost('kalSingkatan'))
        ];

        // Cek keunikan username
        $isTaken = $model->where('kalKode', $data['kalKode'])->first();
        if ($isTaken) {
            return redirect()->to('master_kategori')->withInput()->with('error', 'Kode Kategori sudah dipakai!');
        }

       

        // Insert data akun
        $model->insert($data);
        return redirect()->to('master_kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function postEdit_kategori()
    {
        $model = model('App\Models\SapaRKategoriAlsintanModel');
        // ambil data dari input pake esc
        $data = [
            'kalKode' => esc($this->request->getPost('kalKodeEdit')),
            // password di-hash dengan md5
            'kalNama' => esc($this->request->getPost('kalNamaEdit')),
            'kalSingkatan' => esc($this->request->getPost('kalSingkatanEdit'))
        ];

    
        // Update data akun
        $model->save($data);
        return redirect()->to('master_kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

 
}
