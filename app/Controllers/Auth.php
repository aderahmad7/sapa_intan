<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    

    public function getIndex()
    {
        return view('auth/login');
    }

    public function postLogin()
    {
        $username = esc($this->request->getPost('username'));
        $password = esc($this->request->getPost('password'));

        $roleFullname = [
            "PPL"=>"PPL",
            "BPP"=>"BPP",
            "KAB"=>"Dinas Kab/Kota",
            "PROV"=>"Provinsi",
        ];

        // Validate the credentials (this is just a placeholder)
        $sapaTAccountModel = model('App\Models\SapaTAccountModel');
        $account = $sapaTAccountModel->where('accUsername', $username)
                                      ->where('accPasswd', md5($password)) // Assuming passwords are stored as MD5 hashes
                                      ->first();
        if ($account) {
            // Set session data
            session()->set([
                'logged_in' => true,
                'username' => $account['accUsername'],
                'role' => $account['accRole'],
                'roleFullname' => $roleFullname[$account['accRole']],
                'nama' => $account['accNama'],
                'noWhatsapp' => $account['accNoWhatsapp'],
                'kcmKode' => $account['accKcmKode'],
                'kotaKode' => $account['accKotaKode'],
                'desa' => $account['accDesa'],
                'insKode' => $account['accInsKode']
            ]);
            if ($account['accRole']=="PPL" || $account['accRole']=="KAB")
                return redirect()->to('/dashboard/usul_sapras');
            elseif ($account['accRole']=="BPP" || $account['accRole']=="PROV")
                return redirect()->to('/dashboard/usul_sapras');
        } else {
            session()->setFlashdata('error', 'Username atau password salah');
            return redirect()->to('/auth')->withInput();
        }
    }

    public function getLogout()
    {
        session()->destroy();
        return redirect()->to('/auth')->with('success', 'Anda telah berhasil logout');
    }
}
