<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function login()
    {
        if (session()->get('is_admin_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('login_view');
    }

    public function processLogin()
    {
        $session = session();
        $model = new AdminModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $admin = $model->where('username', $username)->first();
        
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

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
