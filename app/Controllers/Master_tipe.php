<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SapaRKategoriAlsintanModel;
use App\Models\SapaRTipeAlsintanModel;
use App\Models\SapaTUsulSarprasModel;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Master_tipe extends BaseController
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
        $sapaRKecamatanModel = model('App\Models\SapaRKategoriAlsintanModel');
        $kecamatanList = $sapaRKecamatanModel->findAll();
       
        $data = [
            'title' => 'Master Instansi',
            'katlist' => $kecamatanList,
            'user' => $this->user
        ];
        return view('tipe/index', $data);
    }

   
    public function getDatatable()
    {
        $db = db_connect();
        $builder = $db->table('sapa_r_tipe_alsintan')
            ->select('tipeKode,tipeNama, kalNama')
            ->join('sapa_r_kategori_alsintan', 'sapa_r_kategori_alsintan.kalKode = sapa_r_tipe_alsintan.tipeKalKode', 'left');

        return DataTable::of($builder)->toJson(true);
    }

    public function postHapus_tipe()
    {
        $username = $this->request->getPost('tipeKode');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Tipe Alsintan tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaRTipeAlsintanModel');
        // Cek apakah akun ada
        $akunData = $sapaTAccountModel->where('tipeKode', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Tipe Alsintan tidak ditemukan']);
        }
        // Hapus akun
        $sapaTAccountModel->delete($username);
        return $this->response->setJSON(['success' => 'Tipe Alsintan berhasil dihapus']);
    }

    public function postGet_data_by_id()
    {
        $username = $this->request->getPost('tipeKode');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Tipe Alsintan tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaRTipeAlsintanModel');
        $akunData = $sapaTAccountModel->where('tipeKode', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Tipe Alsintan tidak ditemukan']);
        }
        return $this->response->setJSON($akunData);
    }


   
    public function postAdd_tipe()
    {
        $model = model('App\Models\SapaRTipeAlsintanModel');
        // ambil data dari input pake esc, jika ada yang kosong, set null
        $data = [
            'tipeKode' => esc($this->request->getPost('tipeKode')),
            // password di-hash dengan md5
            'tipeNama' => esc($this->request->getPost('tipeNama')),
            'tipeKalKode' => esc($this->request->getPost('tipeKalKode'))
        ];

        // Cek keunikan username
        $isTaken = $model->where('tipeKode', $data['tipeKode'])->first();
        if ($isTaken) {
            return redirect()->to('master_tipe')->withInput()->with('error', 'Kode Instansi sudah dipakai!');
        }

        

        // Insert data akun
        $model->insert($data);
        return redirect()->to('master_tipe')->with('success', 'Instansi berhasil ditambahkan!');
    }

    public function postEdit_tipe()
    {
        $model = model('App\Models\SapaRTipeAlsintanModel');
        // ambil data dari input pake esc
        $data = [
            'tipeKode' => esc($this->request->getPost('tipeKodeEdit')),
            // password di-hash dengan md5
            'tipeNama' => esc($this->request->getPost('tipeNamaEdit')),
            'tipeKalKode' => esc($this->request->getPost('tipeKalKodeEdit'))
        ];

    
        // Update data akun
        $model->save($data);
        return redirect()->to('master_tipe')->with('success', 'Instansi berhasil diperbarui!');
    }

 
}
