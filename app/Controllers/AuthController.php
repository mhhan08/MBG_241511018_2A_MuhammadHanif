<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Jika sudah login redirect ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // cari email user
        $user = $userModel->where('email', $email)->first();

        // cek user dan verifikasi password nya
        if ($user && password_verify($password, $user['password'])) {
            // jika berhasil buat session
            $sessionData = [
                'userId'     => $user['id'],
                'name'       => $user['name'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ];
            //buat session dan redirect ke dashboard
            session()->set($sessionData);
            return redirect()->to('/dashboard');
        } else {
            // kalau gagal
            return redirect()->to('/login')->with('error', 'Email atau password salah.');
        }
    }

    public function logout()
    {
        session()->destroy(); // hapus session
        return redirect()->to('/login');
    }
}