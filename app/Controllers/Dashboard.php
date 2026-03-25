<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SapaMInstansiModel;
use App\Models\SapaRKotaModel;
use App\Models\SapaTUsulPoktanModel;
use App\Models\SapaTUsulSarprasModel;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Dashboard extends BaseController
{

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
        //print_r($this->user);
        return redirect()->to('dashboard/profil');
    }

    public function getProfil()
    {
        $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
        $usulProfilData = $sapaTUsulProfilModel->where('proUsername', session()->get('username'))->first();
        //print_r($this->user);exit;
        $sapaMInstansiModel = new SapaMInstansiModel();
        $namaInstasi = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insNamaLengkap'];

        $sapaRKotaModel = new SapaRKotaModel();
        $namaKota = $sapaRKotaModel->select('sapa_r_kota.kotaNama, sapa_r_kecamatan.kcmNama')->join('sapa_r_kecamatan', 'sapa_r_kecamatan.kcmKotaKode = sapa_r_kota.kotaKode', 'left')->where('sapa_r_kecamatan.kcmKode', $this->user['kcmKode'])->first();

        if (!$usulProfilData) {
            // set data profil null
            $usulProfilData = [
                'proTipeUsul' => session()->get('role'),
                'proUsername' => session()->get('username'),
                'proInsKode' => session()->get('insKode'),
                'proPplNama' => '',
                'proPplNamaKetua' => '',
                'proPplFileKTP' => '',
                'proPplTelp' => '',
                'proPplKcmKode' => session()->get('kcmKode'),
                'proPplDesa' => session()->get('desa'),
                'proPplPenyuluhNama' => '',
                'proPplPenyuluhTelp' => '',
                'proKabNamaLengkap' => '',
                'proKabTelp' => '',
                'proKabJabatan' => '',
                'proKabFileTTd' => '',
                'proKabKotaKode' => session()->get('kotaKode')
            ];
            // tambahkan data profil ke user
            $this->user['profil'] = $usulProfilData;
        } else {
            // jika data profil ada, ambil data tersebut, untuk file KTP dan TTD, tambahkan URL lengkapnya
            $usulProfilData['proPplFileKTP'] = base_url('uploads/' . $usulProfilData['proPplFileKTP']);
            $usulProfilData['proKabFileTTd'] = base_url('uploads/' . $usulProfilData['proKabFileTTd']);

            // tambahkan data profil ke user
            $this->user['profil'] = $usulProfilData;
        }
        $data = [
            'title' => 'Profil Pengusul',
            'kcmKota' => $namaKota,
            'instansi' => $namaInstasi,
            'user' => $this->user
        ];
        return view('dashboard/profil', $data);
    }

    public function getProfil_dinas()
    {
        //print_r($this->user);
        $sapaMInstansiModel = new SapaMInstansiModel();
        $profil = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first();


        $data = [
            'title' => 'Profil Instansi',
            'profil' => $profil,
            'user' => $this->user
        ];
        return view('dashboard/profil_dinas', $data);
    }

    public function getProfil_pengusul($id)
    {
        $sapaTUsulSarprasModel = model('App\Models\SapaTUsulSarprasModel');
        $usulSarprasData = $sapaTUsulSarprasModel->where('usulKode', $id)->first();
        if (!$usulSarprasData) {
            $return = ["status" => false, "message" => "Data tidak ditemukan", "data" => null];
            return $this->response->setJSON($return);
        }
        $sapaTUsulPoktanModel = new SapaTUsulPoktanModel();
        $poktanData = $sapaTUsulPoktanModel->find($usulSarprasData['usulPokKode']);
        $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
        $usulProfilData = $sapaTUsulProfilModel->getProfileAll($usulSarprasData["usulUsername"]);
        // tambahkan poktanData ke usulProfilData
        $usulProfilData->poktan = $poktanData;
        $return = ["status" => true, "message" => "Data ditemukan", "data" => $usulProfilData];


        return $this->response->setJSON($return);
    }

    public function postUpdate_profil()
    {
        $oldUsername = esc($this->request->getPost('proUsername'));
        $newUsername = esc($this->request->getPost('accUsername'));

        // dapatkan id dari sapa_t_profil berdasarkan username lama
        $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
        $profilData = $sapaTUsulProfilModel->where('proUsername', $oldUsername)->first();
        $idProfil = $profilData ? $profilData['proKode'] : null;

        // Cek apakah username diubah
        if ($newUsername !== $oldUsername) {
            // Username diubah, cek keunikan
            $sapaTAccountModel = model('App\Models\SapaTAccountModel');
            $isTaken = $sapaTAccountModel->where('accUsername', $newUsername)->first();
            if ($isTaken) {
                return redirect()->back()->withInput()->with('error', 'Username sudah dipakai!');
            }
        }

        // ambil data dari input pake esc
        $data = [
            'accUsername' => esc($this->request->getPost('accUsername')),
            'accNama' => esc($this->request->getPost('accName')),
            'accNoWhatsapp' => esc($this->request->getPost('accNoWhatsapp')),
            'accRole' => esc($this->request->getPost('accRole')),
            'accInsKode' => esc($this->request->getPost('accInsKode')),
            'proTipeUsul' => esc($this->request->getPost('accRole')),
            'proUsername' => esc($this->request->getPost('accUsername')),
            'accKotaKode' => esc($this->request->getPost('accKotaKode')),
            'proInsKode' => esc($this->request->getPost('accInsKode')),
            'accKcmKode' => esc($this->request->getPost('accKcmKode')),
            'accDesa' => esc($this->request->getPost('accDesa')),
            'proPplNama' => esc($this->request->getPost('proPplNama')),
            'proPplNamaKetua' => esc($this->request->getPost('proPplNamaKetua')),
            'proPplTelp' => esc($this->request->getPost('proPplTelp')),
            'proPplKcmKode' => esc($this->request->getPost('accKcmKode')),
            'proPplDesa' => esc($this->request->getPost('proPplDesa')),
            'proPplPenyuluhNama' => esc($this->request->getPost('proPplPenyuluhNama')),
            'proPplPenyuluhTelp' => esc($this->request->getPost('proPplPenyuluhTelp')),
            'proKabNamaLengkap' => esc($this->request->getPost('proKabNamaLengkap')),
            'proKabTelp' => esc($this->request->getPost('proKabTelp')),
            'proKabJabatan' => esc($this->request->getPost('proKabJabatan')),
            'proKabKotaKode' => esc($this->request->getPost('proKabKotaKode')),
        ];

        // jika ada file KTP, upload dan simpan pathnya. Hapus file lama jika ada
        $fileKTP = $this->request->getFile('proPplFileKTP');
        if ($fileKTP && $fileKTP->isValid() && !$fileKTP->hasMoved()) {
            // Hapus file lama jika ada
            if ($profilData) {
                if (!empty($profilData['proPplFileKTP']) || file_exists($profilData['proPplFileKTP'])) {
                    unlink('uploads/' . $profilData['proPplFileKTP']);
                }
            }
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $fileKTP->getRandomName();
            $fileKTP->move($folderPath, $newName);
            $data['proPplFileKTP'] = $newName;
        }

        // jika ada file TTD, upload dan simpan pathnya. Hapus file lama jika ada
        $fileTTD = $this->request->getFile('proKabFileTTd');
        if ($fileTTD && $fileTTD->isValid() && !$fileTTD->hasMoved()) {
            // Hapus file lama jika ada
            if ($profilData) {
                if (!empty($profilData['proKabFileTTd']) || file_exists($profilData['proKabFileTTd'])) {
                    unlink('uploads/' . $profilData['proKabFileTTd']);
                }
            }
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $fileTTD->getRandomName();
            $fileTTD->move($folderPath, $newName);
            $data['proKabFileTTd'] = $newName;
        }

        // jika ada id profil, update data, jika tidak, insert data baru
        if ($idProfil) {
            // update data profil
            $sapaTUsulProfilModel->update($idProfil, $data);
        } else {
            // insert data profil baru
            $sapaTUsulProfilModel->insert($data);
        }
        // update data akun
        $sapaTAccountModel = model('App\Models\SapaTAccountModel');
        $sapaTAccountModel->update($oldUsername, [
            'accUsername' => $data['accUsername'],
            'accNama' => $data['accNama'],
            'accNoWhatsapp' => $data['accNoWhatsapp'],
            'accRole' => $data['accRole'],
            'accInsKode' => $data['accInsKode'],
            'accKotaKode' => isset($data['accKotaKode']) ? $data['accKotaKode'] : null,
            'accKcmKode' => isset($data['accKcmKode']) ? $data['accKcmKode'] : null,
            'accDesa' => isset($data['accDesa']) ? $data['accDesa'] : null
        ]);
        // update session
        session()->set([
            'username' => $data['accUsername'],
            'role' => $data['accRole'],
            'nama' => $data['accNama'],
            'noWhatsapp' => $data['accNoWhatsapp'],
            'kcmKode' => isset($data['accKcmKode']) ? $data['accKcmKode'] : null,
            'kotaKode' => isset($data['accKotaKode']) ? $data['accKotaKode'] : null,
            'desa' => isset($data['accDesa']) ? $data['accDesa'] : null,
            'insKode' => isset($data['proInsKode']) ? $data['proInsKode'] : null
        ]);
        // redirect ke halaman profil dengan pesan sukses
        return redirect()->to('dashboard/profil')->with('success', 'Profil berhasil diperbarui!');

    }
    public function postUpdate_profildinas()
    {


        // ambil data dari input pake esc
        $data["insKode"] = esc($this->request->getPost('insKode'));
        $data["insKepalaNama"] = esc($this->request->getPost('insKepalaNama'));
        $data["insKepalaNip"] = esc($this->request->getPost('insKepalaNip'));
        $data["insKabidNama"] = esc($this->request->getPost('insKabidNama'));
        $data["insKabidNip"] = esc($this->request->getPost('insKabidNip'));
        if ($this->user["role"] == "BPP") {
            $data["insBppNama"] = esc($this->request->getPost('insBppNama'));
            $data["insBppNip"] = esc($this->request->getPost('insBppNip'));
        }


        // update data akun
        $sapaMInstansiModel = new SapaMInstansiModel();
        $sapaMInstansiModel->save($data);
        // update session

        // redirect ke halaman profil dengan pesan sukses
        return redirect()->to('dashboard/profil_dinas')->with('success', 'Profil Instansi berhasil diperbarui!');

    }

    public function getDaftar_akun()
    {
        $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
        $usulProfilData = $sapaTUsulProfilModel->where('proUsername', session()->get('username'))->first();
        // if (!$usulProfilData) {
        //     return redirect()->to('dashboard/profil')->withInput()->with('info', 'Isi dan update profil terlebih dahulu!');
        // }
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
        // ambil data instansi
        $sapaMInstansiModel = model('App\Models\SapaMInstansiModel');
        $instansiList = $sapaMInstansiModel->findAll();
        $data = [
            'title' => 'Profil Pengguna',
            'user' => $this->user,
            'kotaList' => $kotaList,
            'instansiList' => $instansiList,
            'kecamatanList' => $kecamatanList
        ];
        return view('dashboard/akun', $data);
    }

    public function getUsul_sapras()
    {

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

        // ambil data poktan berdasarkan username, namun jangan ambil data poktan yang pokKode-nya sudah ada di sapa_t_usul_sarpras
        $username = session()->get('username');
        $db = \Config\Database::connect();
        $builder = $db->table('sapa_t_usul_poktan');
        $builder->where('pokUsername', $username);
        $builder->whereNotIn('pokKode', function ($sub) {
            $sub->select('usulPokKode')
                ->from('sapa_t_usul_sarpras')
                ->where('usulPokKode IS NOT NULL');
        });
        $poktanList = $builder->get()->getResultArray();
        if (empty($poktanList) && ($this->user["role"] == "PPL" || $this->user["role"] == "KAB")) {
            return redirect()->to('poktan')->withInput()->with('info', 'Anda belum membuat kelompok tani! Silakan buat kelompok tani terlebih dahulu.');
        }

        $data = [
            'title' => 'Usulan Alsintan',
            'user' => $this->user,
            'kabupaten' => $kotaList,
            'instansiList' => $instansiList,
            'kategori' => $kategoriAlsinList,
            'poktanList' => $poktanList
        ];

        return view('dashboard/usul_sapras', $data);
    }


    public function getDatatable()
    {
        $db = db_connect();
        $builder = $db->table('sapa_t_usul_sarpras')
            ->select('sapa_t_usul_sarpras.usulKode, 
                    sapa_t_usul_sarpras.usulTipeKode, 
                    sapa_t_usul_sarpras.usulKonKode, 
                    sapa_t_usul_sarpras.usulKepemilikan, 
                    sapa_t_usul_sarpras.usulStatus,
                    sapa_r_kategori_alsintan.kalNama, 
                    sapa_r_tipe_alsintan.tipeNama,
                    sapa_t_usul_profil.proTipeUsul,
                    sapa_t_usul_profil.proPplNama,
                    sapa_t_usul_profil.proPplNamaKetua,
                    sapa_t_usul_profil.proKabNamaLengkap,
                    sapa_m_instansi.insNamaLengkap,
                    sapa_t_account.accRole')

            ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
            ->join('sapa_r_kategori_alsintan', 'sapa_r_kategori_alsintan.kalKode = sapa_r_tipe_alsintan.tipeKalKode', 'left')
            ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
            ->join('sapa_t_account', 'sapa_t_account.accUsername = sapa_t_usul_profil.proUsername', 'left')
            ->join('sapa_m_instansi', 'sapa_m_instansi.insKode = sapa_t_usul_profil.proInsKode', 'left');

        $role = session()->get('role');

        // Atur filter usulStatus berdasarkan role
        if ($role == 'PPL') {
            $builder->where('usulUsername', $this->user["username"]);
        } elseif ($role == 'BPP') {
            $builder->where('usulInsKode', $this->user["insKode"]);
            $builder->whereNotIn('usulStatus', [0]);
            $builder->whereNotIn('accRole', ['KAB']);
        } elseif ($role == 'KAB') {
            $builder->where('usulInsKode', $this->user["insKode"]);
            $builder->whereNotIn('usulStatus', [0, 1, 3]);
        } elseif ($role == 'PROV') {
            $builder->whereNotIn('usulStatus', [0, 1, 2, 3, 5]);
        }

        if ($role == 'KAB' || $role == 'PROV') {
            $filter = $this->request->getGet("filter");
            //print_r($filter);
            $first = true;
            foreach ($filter as $f => $val) {
                if ($val["value"] != "") {
                    $kolom = explode("_", $val["name"])[0];
                    //print_r($kolom);
                    if ($first) {
                        $builder->Where($kolom, $val["value"]);
                    } else {
                        $builder->OrWhere($kolom, $val["value"]);
                    }
                }
            }
        }



        return DataTable::of($builder)->toJson(true);
    }


    public function getDatatable_akun()
    {
        $db = db_connect();
        $builder = $db->table('sapa_t_account')
            ->select('  accUsername, 
                                    accNama, 
                                    accNoWhatsapp, 
                                    accRole, 
                                    accDesa, accInsKode,sapa_m_instansi.insNamaLengkap,sapa_t_account.accKotaKode,sapa_r_kota.kotaNama,sapa_r_kecamatan.kcmNama')
            ->join('sapa_m_instansi', 'sapa_t_account.accInsKode = sapa_m_instansi.insKode', 'left')
            ->join('sapa_r_kota', 'sapa_t_account.accKotaKode = sapa_r_kota.kotaKode', 'left')
            ->join('sapa_r_kecamatan', 'sapa_t_account.accKcmKode = sapa_r_kecamatan.kcmKode', 'left');
        // Tambahkan kondisi untuk filter berdasarkan role
        // jika role = prov, tampilkan kab, bpp, ppl
        // jika role = kab, tampilkan bpp, ppl
        // jika role = bpp, tampilkan ppl
        $role = session()->get('role');
        if ($role == 'PROV') {
            $builder->whereIn('accRole', ['KAB', 'BPP', 'PPL']);
        } elseif ($role == 'KAB') {
            $builder->whereIn('accRole', ['BPP', 'PPL']);
            $builder->where('accInsKode', session()->get('insKode'));
        } elseif ($role == 'BPP') {
            $builder->where('accRole', 'PPL');
            $builder->where('accInsKode', session()->get('insKode'));
        } else {
            // jika role tidak sesuai, tampilkan kosong
            $builder->where('accUsername', '');
        }
        return DataTable::of($builder)->toJson(true);
    }

    public function postGet_kecamatan_by_kota()
    {
        $kotaKode = $this->request->getPost('kotaKode');
        if (!$kotaKode) {
            return $this->response->setJSON(['error' => 'Kota kode tidak ditemukan']);
        }
        $sapaRKecamatanModel = model('App\Models\SapaRKecamatanModel');
        $kecamatanList = $sapaRKecamatanModel->where('kcmKotaKode', $kotaKode)->findAll();
        return $this->response->setJSON($kecamatanList);
    }

    public function postAdd_akun()
    {
        $sapaTAccountModel = model('App\Models\SapaTAccountModel');
        // ambil data dari input pake esc, jika ada yang kosong, set null
        $data = [
            'accUsername' => esc($this->request->getPost('accUsername')),
            // password di-hash dengan md5
            'accPasswd' => md5(esc($this->request->getPost('accPasswd'))),
            'accNama' => esc($this->request->getPost('accName')),
            'accNoWhatsapp' => esc($this->request->getPost('accNoWhatsapp')),
            'accRole' => esc($this->request->getPost('accRole')),
            'accInsKode' => esc($this->request->getPost('accInsKode')),
            'accKotaKode' => esc($this->request->getPost('accKotaKode')) ?: null,
            'accKcmKode' => esc($this->request->getPost('accKcmKode')) ?: null,
            'accDesa' => esc($this->request->getPost('accDesa')) ?: null
        ];

        // Cek keunikan username
        $isTaken = $sapaTAccountModel->where('accUsername', $data['accUsername'])->first();
        if ($isTaken) {
            return redirect()->to('dashboard/daftar_akun')->withInput()->with('error', 'Username sudah dipakai!');
        }

        if ($this->user["role"] == "PROV") {
            $sapaMInstansiModel = model('App\Models\SapaMInstansiModel');
            $ins = $sapaMInstansiModel->where('insKode', $data['accInsKode'])->first();
            $data["accKotaKode"] = $ins["insKotaKode"];
        }

        // Insert data akun
        $sapaTAccountModel->insert($data);
        return redirect()->to('dashboard/daftar_akun')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function postEdit_akun($username)
    {
        $sapaTAccountModel = model('App\Models\SapaTAccountModel');
        // ambil data dari input pake esc
        $data = [
            'accUsername' => esc($this->request->getPost('accUsernameEdit')),
            'accNama' => esc($this->request->getPost('accNameEdit')),
            'accNoWhatsapp' => esc($this->request->getPost('accNoWhatsappEdit')),
            'accRole' => esc($this->request->getPost('accRoleEdit')),
            'accInsKode' => esc($this->request->getPost('accInsKodeEdit')),
            'accKotaKode' => esc($this->request->getPost('accKotaKodeEdit')) ?: null,
            'accKcmKode' => esc($this->request->getPost('accKcmKodeEdit')) ?: null,
            'accDesa' => esc($this->request->getPost('accDesaEdit')) ?: null
        ];
        // jika accPasswdEdit ada, hash passwordnya
        $accPasswdEdit = esc($this->request->getPost('accPasswdEdit'));
        if ($accPasswdEdit) {
            $data['accPasswd'] = md5(esc($accPasswdEdit));
        }

        // Cek keunikan username
        $isTaken = $sapaTAccountModel->where('accUsername', $data['accUsername'])->where('accUsername !=', $username)->first();
        if ($isTaken) {
            return redirect()->to('dashboard/daftar_akun')->withInput()->with('error', 'Username sudah dipakai!');
        }

        if ($this->user["role"] == "PROV") {
            $sapaMInstansiModel = model('App\Models\SapaMInstansiModel');
            $ins = $sapaMInstansiModel->where('insKode', $data['accInsKode'])->first();
            $data["accKotaKode"] = $ins["insKotaKode"];
        }

        //print_r($data);exit;

        // Update data akun
        $sapaTAccountModel->update($username, $data);
        return redirect()->to('dashboard/daftar_akun')->with('success', 'Akun berhasil diperbarui!');
    }

    public function postGet_akun_by_username()
    {
        $username = $this->request->getPost('accUsername');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Username tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaTAccountModel');
        $akunData = $sapaTAccountModel->where('accUsername', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Akun tidak ditemukan']);
        }
        return $this->response->setJSON($akunData);
    }

    public function postHapus_akun()
    {
        $username = $this->request->getPost('accUsername');
        if (!$username) {
            return $this->response->setJSON(['error' => 'Username tidak ditemukan']);
        }
        $sapaTAccountModel = model('App\Models\SapaTAccountModel');
        // Cek apakah akun ada
        $akunData = $sapaTAccountModel->where('accUsername', $username)->first();
        if (!$akunData) {
            return $this->response->setJSON(['error' => 'Akun tidak ditemukan']);
        }
        // Hapus akun
        $sapaTAccountModel->delete($username);
        return $this->response->setJSON(['success' => 'Akun berhasil dihapus']);
    }

    public function postGet_tipe_kode()
    {
        // Mendapatkan tipe kode dari request berdasarkan tipeKalKode = sapa_r_kategori_alsintan.kalKode
        $tipeKalKode = $this->request->getPost('kalKode');
        if (!$tipeKalKode) {
            return $this->response->setJSON(['error' => 'Tipe kode tidak ditemukan']);
        }
        $sapaRTipeAlsintanModel = model('App\Models\SapaRTipeAlsintanModel');
        $tipeList = $sapaRTipeAlsintanModel->where('tipeKalKode', $tipeKalKode)->findAll();
        if (!$tipeList) {
            return $this->response->setJSON(['error' => 'Tipe kode tidak ditemukan']);
        }
        return $this->response->setJSON($tipeList);
    }

    public function postAdd_sapras()
    {
        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();

        // ambil data dari input pake esc, jika ada yang kosong, set null
        $data = [
            'usulUsername' => esc($this->request->getPost('usulUsername')),
            'usulTipeKode' => esc($this->request->getPost('usulTipeKode')),
            'usulNoMesin' => esc($this->request->getPost('usulNoMesin')),
            'usulNoRangka' => esc($this->request->getPost('usulNoRangka')),
            'usulKomoditi' => esc($this->request->getPost('usulKomoditi')),
            'usulInsKode' => esc($this->request->getPost('usulInsKode')),
            'usulKonKode' => esc($this->request->getPost('usulKonKode')),
            'usulKepemilikan' => esc($this->request->getPost('usulKepemilikan')),
            'usulLuasKinerja' => esc($this->request->getPost('usulLuasKinerja')),
            'usulKoordinat' => esc($this->request->getPost('usulKoordinat')),
            'usulLuasJam' => esc($this->request->getPost('usulLuasJam')),
            'usulPokKode' => esc($this->request->getPost('usulPokKode')),
            'usulStatus' => ($this->user["role"] == "KAB" ? 4 : 0),
        ];

        $foto1 = $this->request->getFile('usulFoto1');
        if ($foto1 && $foto1->isValid() && !$foto1->hasMoved()) {
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $foto1->getRandomName();
            $foto1->move($folderPath, $newName);
            $data['usulFoto1'] = $newName;
        }
        $foto2 = $this->request->getFile('usulFoto2');
        if ($foto2 && $foto2->isValid() && !$foto2->hasMoved()) {
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $foto2->getRandomName();
            $foto2->move($folderPath, $newName);
            $data['usulFoto2'] = $newName;
        }
        $foto3 = $this->request->getFile('usulFoto3');
        if ($foto3 && $foto3->isValid() && !$foto3->hasMoved()) {
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $foto3->getRandomName();
            $foto3->move($folderPath, $newName);
            $data['usulFoto3'] = $newName;
        }
        $foto4 = $this->request->getFile('usulFoto4');
        if ($foto4 && $foto4->isValid() && !$foto4->hasMoved()) {
            $folderPath = 'uploads';
            // Upload file baru
            $newName = $foto4->getRandomName();
            $foto4->move($folderPath, $newName);
            $data['usulFoto4'] = $newName;
        }

        // Insert data
        $sapaTUsulSarprasModel->insert($data);
        return redirect()->to('dashboard/usul_sapras')->with('success', 'Data berhasil ditambahkan!');
    }

    public function postEdit_sapras($usulKode)
    {
        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();
        $usulData = $sapaTUsulSarprasModel->find($usulKode);

        if (!$usulData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'usulTipeKode' => esc($this->request->getPost('usulTipeKodeEdit')),
            'usulNoMesin' => esc($this->request->getPost('usulNoMesinEdit')),
            'usulNoRangka' => esc($this->request->getPost('usulNoRangkaEdit')),
            'usulKomoditi' => esc($this->request->getPost('usulKomoditiEdit')),
            'usulKonKode' => esc($this->request->getPost('usulKonKodeEdit')),
            'usulKepemilikan' => esc($this->request->getPost('usulKepemilikanEdit')),
            'usulLuasKinerja' => esc($this->request->getPost('usulLuasKinerjaEdit')),
            'usulKoordinat' => esc($this->request->getPost('usulKoordinatEdit')),
            'usulLuasJam' => esc($this->request->getPost('usulLuasJamEdit')),
        ];

        $folderPath = 'uploads';

        // Cek dan update foto1
        $foto1 = $this->request->getFile('usulFoto1Edit');
        if ($foto1 && $foto1->isValid() && !$foto1->hasMoved()) {
            if (!empty($usulData['usulFoto1']) && file_exists($folderPath . '/' . $usulData['usulFoto1'])) {
                unlink($folderPath . '/' . $usulData['usulFoto1']);
            }
            $newName = $foto1->getRandomName();
            $foto1->move($folderPath, $newName);
            $data['usulFoto1'] = $newName;
        }

        // Cek dan update foto2
        $foto2 = $this->request->getFile('usulFoto2Edit');
        if ($foto2 && $foto2->isValid() && !$foto2->hasMoved()) {
            if (!empty($usulData['usulFoto2']) && file_exists($folderPath . '/' . $usulData['usulFoto2'])) {
                unlink($folderPath . '/' . $usulData['usulFoto2']);
            }
            $newName = $foto2->getRandomName();
            $foto2->move($folderPath, $newName);
            $data['usulFoto2'] = $newName;
        }

        // Cek dan update foto3
        $foto3 = $this->request->getFile('usulFoto3Edit');
        if ($foto3 && $foto3->isValid() && !$foto3->hasMoved()) {
            if (!empty($usulData['usulFoto3']) && file_exists($folderPath . '/' . $usulData['usulFoto3'])) {
                unlink($folderPath . '/' . $usulData['usulFoto3']);
            }
            $newName = $foto3->getRandomName();
            $foto3->move($folderPath, $newName);
            $data['usulFoto3'] = $newName;
        }

        // Cek dan update foto4
        $foto4 = $this->request->getFile('usulFoto4Edit');
        if ($foto4 && $foto4->isValid() && !$foto4->hasMoved()) {
            if (!empty($usulData['usulFoto4']) && file_exists($folderPath . '/' . $usulData['usulFoto4'])) {
                unlink($folderPath . '/' . $usulData['usulFoto4']);
            }
            $newName = $foto4->getRandomName();
            $foto4->move($folderPath, $newName);
            $data['usulFoto4'] = $newName;
        }

        $sapaTUsulSarprasModel->update($usulKode, $data);
        return redirect()->to('dashboard/usul_sapras')->with('success', 'Data berhasil diperbarui!');
    }

    public function postGet_sapras_by_usulkode()
    {
        $usulKode = $this->request->getPost('usulKode');
        if (!$usulKode) {
            return $this->response->setJSON(['error' => 'usulKode tidak ditemukan']);
        }
        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();
        $usulData = $sapaTUsulSarprasModel
            ->select('sapa_t_usul_sarpras.*,
        sapa_r_tipe_alsintan.tipeNama,
        sapa_r_tipe_alsintan.tipeKalKode,
        sapa_r_kategori_alsintan.kalNama')
            ->join('sapa_r_tipe_alsintan', 'sapa_t_usul_sarpras.usulTipeKode = sapa_r_tipe_alsintan.tipeKode', 'left')
            ->join('sapa_r_kategori_alsintan', 'sapa_r_tipe_alsintan.tipeKalKode = sapa_r_kategori_alsintan.kalKode', 'left')
            ->where('sapa_t_usul_sarpras.usulKode', $usulKode)
            ->first();
        if (!$usulData) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($usulData);
    }

    public function postHapus_sapras()
    {
        $usulKode = $this->request->getPost('usulKode');
        if (!$usulKode) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();

        // Ambil data berdasarkan kode
        $data = $sapaTUsulSarprasModel->where('usulKode', $usulKode)->first();
        if (!$data) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $folderPath = 'uploads';
        $fotoFields = ['usulFoto1', 'usulFoto2', 'usulFoto3', 'usulFoto4'];

        // Hapus file jika ada
        foreach ($fotoFields as $fotoField) {
            if (!empty($data[$fotoField])) {
                $filePath = $folderPath . '/' . $data[$fotoField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Hapus data dari database
        $sapaTUsulSarprasModel->delete($usulKode);

        return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
    }

    public function postKirim_sapras()
    {
        $usulKode = $this->request->getPost('usulKode');
        if (!$usulKode) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();
        // Ambil data berdasarkan kode
        $data = $sapaTUsulSarprasModel->where('usulKode', $usulKode)->first();
        if (!$data) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $data = [
            'usulStatus' => 1
        ];
        $sapaTUsulSarprasModel->update($usulKode, $data);
        return redirect()->to('dashboard/usul_sapras')->with('success', 'Usul berhasil dikirim!');
    }

    public function postTerima_usul()
    {
        $usulKode = $this->request->getPost('usulKode');
        if (!$usulKode) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();
        $data = $sapaTUsulSarprasModel->where('usulKode', $usulKode)->first();
        if (!$data) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        // Tentukan status berdasarkan role
        $status = null;
        switch ($this->user['role']) {
            case 'BPP':
                $status = 2;
                break;
            case 'KAB':
                $status = 4;
                break;
            case 'PROV':
                $status = 6;
                break;
            default:
                return $this->response->setJSON(['error' => 'Role tidak dikenali']);
        }

        $sapaTUsulSarprasModel->update($usulKode, ['usulStatus' => $status]);

        return $this->response->setJSON(['success' => 'Usul berhasil diterima.']);
    }

    public function postTolak_usul()
    {
        $usulKode = $this->request->getPost('usulKode');
        if (!$usulKode) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();
        $data = $sapaTUsulSarprasModel->where('usulKode', $usulKode)->first();
        if (!$data) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        // Tentukan status berdasarkan role
        $status = null;
        switch ($this->user['role']) {
            case 'BPP':
                $status = 3;
                break;
            case 'KAB':
                $status = 5;
                break;
            case 'PROV':
                $status = 7;
                break;
            default:
                return $this->response->setJSON(['error' => 'Role tidak dikenali']);
        }

        $sapaTUsulSarprasModel->update($usulKode, ['usulStatus' => $status]);

        return $this->response->setJSON(['success' => 'Usul berhasil ditolak.']);
    }

    public function postAdd_komentar()
    {
        $usulKode = $this->request->getPost('usulKodeKomentar');
        if (!$usulKode) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $sapaTUsulSarprasModel = new SapaTUsulSarprasModel();

        // Ambil data
        $data = $sapaTUsulSarprasModel->where('usulKode', $usulKode)->first();
        if (!$data) {
            return redirect()->back()->with('error', 'Data usulan tidak ditemukan.');
        }

        // Persiapkan update sesuai role
        $updateData = [];

        switch ($this->user['role']) {
            case 'BPP':
                $catatan = esc($this->request->getPost('usulCatatanBPP'));
                $updateData['usulCatatanBpp'] = $catatan;
                break;

            case 'KAB':
                $catatan = esc($this->request->getPost('usulCatatanKab'));
                $updateData['usulCatatanKab'] = $catatan;
                break;

            case 'PROV':
                $catatan = esc($this->request->getPost('usulCatatanProv'));
                $updateData['usulCatatanProv'] = $catatan;
                break;

            default:
                return redirect()->back()->with('error', 'Role tidak dikenali.');
        }

        // Simpan komentar
        $sapaTUsulSarprasModel->update($usulKode, $updateData);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function postAdd_feedback()
    {
        $usulKode = $this->request->getPost('usulKodeKomentar');
        $role = $this->user['role'];
        $model = new SapaTUsulSarprasModel();

        $updateData = [];

        if ($role == 'PPL') {
            if ($this->request->getPost('usulCatatanBppFeedback')) {
                $updateData['usulCatatanBppFeedback'] = esc($this->request->getPost('usulCatatanBppFeedback'));
            }
            if ($this->request->getPost('usulCatatanKabFeedback')) {
                $updateData['usulCatatanKabFeedback'] = esc($this->request->getPost('usulCatatanKabFeedback'));
            }
            if ($this->request->getPost('usulCatatanProvFeedback')) {
                $updateData['usulCatatanProvFeedback'] = esc($this->request->getPost('usulCatatanProvFeedback'));
            }
        }

        if ($updateData && $usulKode) {
            $model->update($usulKode, $updateData);
            return redirect()->back()->with('success', 'Feedback berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Data feedback tidak valid.');
        }
    }
}
