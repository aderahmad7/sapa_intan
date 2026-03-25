<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SapaTUsulPoktanModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Poktan extends BaseController
{
    public function getIndex()
    {
        // ambil keseluruhan data dari poktan
        $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
        $usulProfilData = $sapaTUsulProfilModel->where('proUsername', session()->get('username'))->first();
        if (!$usulProfilData) {
            if ($this->user["role"] == "PPL" || $this->user["role"] == "KAB")
                return redirect()->to('dashboard/profil')->withInput()->with('info', 'Isi dan update profil terlebih dahulu!');
        }
        $sapaRKategoriAlsintanModel = model('App\Models\SapaRKategoriAlsintanModel');
        $kategoriAlsinList = $sapaRKategoriAlsintanModel->findAll();
        $sapaRKotaModel = model('App\Models\SapaRKotaModel');
        $kotaList = $sapaRKotaModel->findAll();
        $sapaMInstansiModel = model('App\Models\SapaMInstansiModel');
        $instansiList = $sapaMInstansiModel->findAll();

        $data = [
            'title' => 'Usulan Alsintan',
            'user' => $this->user,
            'kabupaten' => $kotaList,
            'instansiList' => $instansiList,
            'kategori' => $kategoriAlsinList
        ];

        return view('poktan/index', $data);
    }

    public function getDatatable()
    {
        $db = db_connect();
        $builder = $db->table('sapa_t_usul_poktan')
            ->select('
            pokKode,
            pokUsername,
            pokPplNama,
            pokPplNamaKetua,
            pokPplFileKTP,
            pokPplTelp,
        ')->where('pokUsername', session()->get('username'))
            ->orderBy('pokKode', 'DESC');
        return DataTable::of($builder)->toJson(true);
    }

    public function postAdd_poktan()
    {
        $sapaTUsulPoktanModel = new SapaTUsulPoktanModel();
        $data = [
            'pokUsername' => session()->get('username'),
            'pokPplNama' => esc($this->request->getPost('pokPplNama')),
            'pokPplNamaKetua' => esc($this->request->getPost('pokPplNamaKetua')),
            'pokPplTelp' => esc($this->request->getPost('pokPplTelp')),
        ];

        $ktp = $this->request->getFile('pokPplFileKTP');
        if ($ktp && $ktp->isValid() && !$ktp->hasMoved()) {
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $ktp->getRandomName();
            $ktp->move($folderPath, $newName);
            $data['pokPplFileKTP'] = $newName;
        }
        $sapaTUsulPoktanModel->insert($data);
        return redirect()->to('poktan')->with('success', 'Data berhasil ditambahkan!');
    }

    public function postEdit_poktan($pokKode)
    {
        $sapaTUsulPoktanModel = new SapaTUsulPoktanModel();
        $poktanData = $sapaTUsulPoktanModel->find($pokKode);

        if (!$poktanData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'pokPplNama' => esc($this->request->getPost('pokPplNamaEdit')),
            'pokPplNamaKetua' => esc($this->request->getPost('pokPplNamaKetuaEdit')),
            'pokPplTelp' => esc($this->request->getPost('pokPplTelpEdit')),
        ];

        $ktp = $this->request->getFile('pokPplFileKTPEdit');
        if ($ktp && $ktp->isValid() && !$ktp->hasMoved()) {
            // Hapus file lama jika ada
            if (!empty($poktanData['pokPplFileKTP'])) {
                $oldFile = FCPATH . 'uploads/' . $poktanData['pokPplFileKTP'];
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }
            $folderPath = 'uploads';
            $newName = $ktp->getRandomName();
            $ktp->move($folderPath, $newName);
            $data['pokPplFileKTP'] = $newName;
        }

        $sapaTUsulPoktanModel->update($pokKode, $data);
        return redirect()->to('poktan')->with('success', 'Data berhasil diperbarui!');
    }

    public function postHapus_poktan()
    {
        $pokKode = $this->request->getPost('pokKode');
        if (!$pokKode) {
            return $this->response->setJSON(['error' => 'pokKode tidak ditemukan']);
        }

        $sapaTUsulPoktanModel = new SapaTUsulPoktanModel();
        $poktanData = $sapaTUsulPoktanModel->find($pokKode);

        if (!$poktanData) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $folderPath = 'uploads';
        // Hapus file KTP jika ada
        if (!empty($poktanData['pokPplFileKTP'])) {
            $filePath = $folderPath . '/' . $poktanData['pokPplFileKTP'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data dari database
        $sapaTUsulPoktanModel->delete($pokKode);

        return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
    }

    public function postGet_poktan_by_pokkode()
    {
        $pokKode = $this->request->getPost('pokKode');
        if (!$pokKode) {
            return $this->response->setJSON(['error' => 'pokKode tidak ditemukan']);
        }
        $sapaTUsulPoktanModel = new SapaTUsulPoktanModel();
        $pokData = $sapaTUsulPoktanModel->find($pokKode);
        if (!$pokData) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($pokData);
    }
}
