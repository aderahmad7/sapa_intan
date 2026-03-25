<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use \Hermawan\DataTables\DataTable;

class Rekomendasi extends BaseController
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

        $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
        $usulProfilData = $sapaTUsulProfilModel->where('proUsername', session()->get('username'))->first();
        if (!$usulProfilData) {
            if ($this->user["role"] != "PROV")
                return redirect()->to('dashboard/profil')->withInput()->with('info', 'Isi dan update profil terlebih dahulu!');
        }
        $data = [
            'title' => 'Rekomendasi Sarpras',
            'user' => $this->user,
        ];
        return view('rekomendasi/rekomendasi', $data);
    }

    public function getPrint_rekomendasi()
    {
        // Ambil nilai query string rekomendasi
        $rekomendasi = $this->request->getGet('rekomendasi');

        // Dapatkan nama dinas
        $sapaMInstansiModel = model('App\Models\SapaMInstansiModel');
        $namaInstansi = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insNamaLengkap'];
        $namaPendekInstansi = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insNamaLengkap'];
        $namaKabid = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKabidNama'];
        $namaKepala = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKepalaNama'];
        $nipKabid = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKabidNip'];
        $nipKepala = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKepalaNip'];
        $ttdKabid = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKabidTtd'];
        $ttdKepala = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKepalaTtd'];

        // jika user ppl, ambil nama kecamatan, desa, dan nama penyuluh di profil
        if ($this->user['role'] == 'PPL') {
            // nama kecamatan
            $sapaRKecamatanModel = model('App\Models\SapaRKecamatanModel');
            $kecamatan = $sapaRKecamatanModel->where('kcmKode', $this->user['kcmKode'])->first()['kcmNama'];
            $kcmKotaKode = $sapaRKecamatanModel->where('kcmKode', $this->user['kcmKode'])->first()['kcmKotaKode'];
            // nama kota
            $sapaRKotaModel = model('App\Models\SapaRKotaModel');
            $namaKota = $sapaRKotaModel->where('kotaKode', $kcmKotaKode)->first()['kotaNama'];
            // nama desa
            $desa = $this->user['desa'] ?? 'Tidak diketahui';

            // nama penyuluh (proPplPenyuluhNama)
            $sapaTUsulProfilModel = model('App\Models\SapaTUsulProfilModel');
            $profilData = $sapaTUsulProfilModel->where('proUsername', $this->user['username'])->first();

            // ambil data sapras yang usulRekomendasiProv = $rekomendasi, jika rekomenasi tidak ada, ambil semua
            // join untuk ambil tipeNama dari sapa_r_tipe_alsintan berdasarkan usulTipeKode = tipeKode
            $sapaTUsulSarprasModel = model('App\Models\SapaTUsulSarprasModel');
            if ($rekomendasi) {
                $data = $sapaTUsulSarprasModel->select('sapa_t_usul_sarpras.*, 
                    sapa_r_tipe_alsintan.tipeNama,sapa_r_kategori_alsintan.kalNama')
                    ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
                    ->join('sapa_r_kategori_alsintan', 'sapa_r_tipe_alsintan.tipeKalKode = sapa_r_kategori_alsintan.kalKode', 'left')
                    ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
                    ->where('usulStatus', 6) // hanya ambil yang sudah direkomendasikan
                    ->where('usulRekomendasiProv', $rekomendasi)
                    ->where('usulUsername', session()->get('username'))
                    ->findAll();
            } else {
                $data = $sapaTUsulSarprasModel->select('sapa_t_usul_sarpras.*, 
                    sapa_r_tipe_alsintan.tipeNama,sapa_r_kategori_alsintan.kalNama')
                    ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
                    ->join('sapa_r_kategori_alsintan', 'sapa_r_tipe_alsintan.tipeKalKode = sapa_r_kategori_alsintan.kalKode', 'left')
                    ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
                    ->where('usulStatus', 6) // hanya ambil yang sudah direkomendasikan
                    ->findAll();
            }

            // ambil hanya beberapa field yang diperlukan
            $rekomendasiData = [];
            foreach ($data as $item) {
                $rekomendasiData[] = [
                    'usulKode' => $item['usulKode'],
                    'namaPoktan' => $profilData['proPplNama'] ?? 'Tidak diketahui',
                    'tipeNama' => $item['kalNama']."<br>".$item['tipeNama'],
                    'usulNoMesin' => $item['usulNoMesin'] ?? 'Tidak diketahui',
                    'usulNoRangka' => $item['usulNoRangka'] ?? 'Tidak diketahui',
                    'usulStatus' => 'Disetujui',
                    'usulKomoditi' => $item['usulKomoditi'] ?? 'Tidak diketahui',
                    'catatan' => $item['usulCatatanBpp'] ?? 'Tidak diketahui',
                ];
            }
        } else {
            // ambil insKota Kode dari sapaMInstansiModel
            $insKotaKode = $sapaMInstansiModel->where('insKode', $this->user['insKode'])->first()['insKotaKode'];
            // nama kota
            $sapaRKotaModel = model('App\Models\SapaRKotaModel');
            $namaKota = $sapaRKotaModel->where('kotaKode', $insKotaKode)->first()['kotaNama'];

            // ambil data sapras yang usulRekomendasiProv = $rekomendasi, jika rekomenasi tidak ada, ambil semua
            // join untuk ambil tipeNama dari sapa_r_tipe_alsintan berdasarkan usulTipeKode = tipeKode
            $sapaTUsulSarprasModel = model('App\Models\SapaTUsulSarprasModel');
            if ($rekomendasi) {
                if ($this->user['role'] == 'KAB') {
                    $data = $sapaTUsulSarprasModel->select('sapa_t_usul_sarpras.*, 
                    sapa_r_tipe_alsintan.tipeNama,sapa_r_kategori_alsintan.kalNama')
                    ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
                    ->join('sapa_r_kategori_alsintan', 'sapa_r_tipe_alsintan.tipeKalKode = sapa_r_kategori_alsintan.kalKode', 'left')
                    ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
                    ->where('usulStatus', 6) // hanya ambil yang sudah direkomendasikan
                    ->where('usulRekomendasiProv', $rekomendasi)
                    ->where('usulInsKode', session()->get('insKode'))
                    ->findAll();
                } else {
                    $data = $sapaTUsulSarprasModel->select('sapa_t_usul_sarpras.*, 
                    sapa_r_tipe_alsintan.tipeNama,sapa_r_kategori_alsintan.kalNama')
                    ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
                    ->join('sapa_r_kategori_alsintan', 'sapa_r_tipe_alsintan.tipeKalKode = sapa_r_kategori_alsintan.kalKode', 'left')
                    ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
                    ->where('usulStatus', 6) // hanya ambil yang sudah direkomendasikan
                    ->where('usulRekomendasiProv', $rekomendasi)
                    ->findAll();
                }
            } else {
                if ($this->user['role'] == 'KAB') {
                    $data = $sapaTUsulSarprasModel->select('sapa_t_usul_sarpras.*, 
                    sapa_r_tipe_alsintan.tipeNama,sapa_r_kategori_alsintan.kalNama')
                    ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
                    ->join('sapa_r_kategori_alsintan', 'sapa_r_kategori_alsintan.kalKode = sapa_r_tipe_alsintan.tipeKalKode', 'left')
                    ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
                    ->where('usulStatus', 6) // hanya ambil yang sudah direkomendasikan
                    ->where('usulInsKode', session()->get('insKode'))
                    ->findAll();
                } else {
                    $data = $sapaTUsulSarprasModel->select('sapa_t_usul_sarpras.*, 
                    sapa_r_tipe_alsintan.tipeNama,sapa_r_kategori_alsintan.kalNama')
                    ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
                    ->join('sapa_r_kategori_alsintan', 'sapa_r_tipe_alsintan.tipeKalKode = sapa_r_kategori_alsintan.kalKode', 'left')
                    ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
                    ->where('usulStatus', 6) // hanya ambil yang sudah direkomendasikan
                    ->findAll();
                }
            }

            // ambil hanya beberapa field yang diperlukan
            $rekomendasiData = [];
            foreach ($data as $item) {
                $rekomendasiData[] = [
                    'usulKode' => $item['usulKode'],
                    'tipeNama' => $item['kalNama']."<br>".$item['tipeNama'],
                    'usulNoMesin' => $item['usulNoMesin'] ?? 'Tidak diketahui',
                    'usulNoRangka' => $item['usulNoRangka'] ?? 'Tidak diketahui',
                    'usulStatus' => 'Disetujui',
                    'usulKomoditi' => $item['usulKomoditi'] ?? 'Tidak diketahui',
                    'catatan' => $this->user['role'] == 'BPP' ? $item['usulCatatanBpp'] ?? 'Tidak diketahui' : ($this->user['role'] == 'KAB' ? $item['usulCatatanKab'] ?? 'Tidak diketahui' : $item['usulCatatanProv'] ?? 'Tidak diketahui'),
                ];
            }
        }

        $tempat = $namaKota;
        // tanggal bulan tahun hari ini, bulan dalam format Indonesia
        $tanggal = date('d');
        $bulan = date('F');
        $tahun = date('Y');
        $bulanIndonesia = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
        $bulan = $bulanIndonesia[$bulan] ?? $bulan; // jika bulan tidak ditemukan, gunakan nama bulan asli
        $tempat .= ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun;
        $data = [
            'title' => 'Laporan Rekomendasi',
            'user' => $this->user,
            'namaInstansi' => $namaInstansi,
            'namaKota' => $namaKota ?? 'Tidak diketahui',
            'namaKecamatan' => $kecamatan ?? 'Tidak diketahui',
            'namaPenyuluh' => $profilData['proPplPenyuluhNama'] ?? 'Tidak diketahui',
            'rekomendasi' => $rekomendasi,
            'namaDesa' => $desa ?? 'Tidak diketahui',
            'rekomendasiData' => $rekomendasiData,
            'tempat' => $tempat,
            'namaPendekInstansi' => $namaPendekInstansi,
            'namaKabid' => $namaKabid ?? 'Tidak diketahui',
            'namaKepala' => $namaKepala ?? 'Tidak diketahui',
            'nipKabid' => $nipKabid ?? 'Tidak diketahui',
            'nipKepala' => $nipKepala ?? 'Tidak diketahui',
            'ttdKabid' => $ttdKabid ? base_url('uploads/' . $ttdKabid) : 'Tidak diketahui',
            'ttdKepala' => $ttdKepala ? base_url('uploads/' . $ttdKepala) : 'Tidak diketahui'
        ];

        // Render view menjadi HTML
        $html = view('rekomendasi/rekomendasi_pdf', $data);

        // Setup Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // jika butuh load gambar dari internet
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // (Optional) Ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (dari HTML)
        $dompdf->render();

        // Download atau tampilkan di browser
        $dompdf->stream('laporan.pdf', ['Attachment' => false]);
        exit();
    }

    public function getDatatable_rekomendasi()
    {
        $db = db_connect();
        $builder = $db->table('sapa_t_usul_sarpras')
            ->select('sapa_t_usul_sarpras.usulKode, 
                    sapa_t_usul_sarpras.usulUsername,
                    sapa_t_usul_sarpras.usulTipeKode, 
                    sapa_t_usul_sarpras.usulKonKode, 
                    sapa_t_usul_sarpras.usulKepemilikan, 
                    sapa_t_usul_sarpras.usulStatus,
                    sapa_t_usul_sarpras.usulRekomendasiProv,
                    sapa_r_kategori_alsintan.kalNama, 
                    sapa_r_tipe_alsintan.tipeNama,
                    sapa_t_usul_profil.proTipeUsul,
                    sapa_t_usul_profil.proPplNama,
                    sapa_t_usul_profil.proPplNamaKetua,
                    sapa_t_usul_profil.proKabNamaLengkap,
                    sapa_m_instansi.insNamaLengkap')

            ->join('sapa_r_tipe_alsintan', 'sapa_r_tipe_alsintan.tipeKode = sapa_t_usul_sarpras.usulTipeKode', 'left')
            ->join('sapa_r_kategori_alsintan', 'sapa_r_kategori_alsintan.kalKode = sapa_r_tipe_alsintan.tipeKalKode', 'left')
            ->join('sapa_t_usul_profil', 'sapa_t_usul_profil.proUsername = sapa_t_usul_sarpras.usulUsername', 'left')
            ->join('sapa_m_instansi', 'sapa_m_instansi.insKode = sapa_t_usul_profil.proInsKode', 'left');

        $role = session()->get('role');
        if ($role == 'PROV') {
            $builder->where('usulStatus', 6);
        } elseif ($role == 'KAB') {
            $builder->where('usulStatus', 6);
            $builder->where('usulInsKode', session()->get('insKode'));
        } elseif ($role == 'PPL') {
            $builder->where('usulStatus', 6);
            $builder->where('usulUsername', session()->get('username'));
        }

        // Atur filter usulStatus = 6
        

        return DataTable::of($builder)->toJson(true);
    }

    public function postUpdate_rekomendasi()
    {
        $usulKode = $this->request->getPost('usulKode');
        $rekomendasi = $this->request->getPost('usulRekomendasiProv');

        if (!$usulKode || !$rekomendasi) {
            // rediredect ke halaman rekomendasi dengan pesan error, bukan 
            return redirect()->to('rekomendasi')->withInput()->with('error', 'Kode usulan atau rekomendasi tidak ditemukan!');
        }

        $sapaTUsulSarprasModel = model('App\Models\SapaTUsulSarprasModel');
        // Update rekomendasi
        $sapaTUsulSarprasModel->update($usulKode, ['usulRekomendasiProv' => esc($rekomendasi)]);

        // redirect ke halaman rekomendasi dengan pesan sukses
        return redirect()->to('rekomendasi')->with('success', 'Rekomendasi berhasil diperbarui!');
    }
}
