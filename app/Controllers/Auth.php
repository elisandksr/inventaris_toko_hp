<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

// Controller Autentikasi: Login dan Logout
class Auth extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    // Tampilkan halaman login
    public function login()
    {
        if (session()->get('is_admin_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('login_view');
    }

    // Proses login dan buat session
    public function processLogin()
    {
        $session = session();
        $model = new AdminModel();
        // Ambil data dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        // Cek data admin
        $admin = $model->where('username', $username)->first();
        // Cek password
        if ($admin) {
            $pass = $admin['password'];
            if (password_verify($password, $pass)) {
                $ses_data = [
                    'admin_id'       => $admin['id'],
                    'username'       => $admin['username'],
                    'nama_admin'     => $admin['nama_admin'],
                    'is_admin_logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password Salah');
                return redirect()->back()->withInput();
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan');
            return redirect()->back()->withInput();
        }
    }

    // Logout dan hapus session
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
