<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('name');
        $password = $this->request->getPost('password');

        $user = $userModel->where('name', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Jika login berhasil, siapkan data session
            $sessionData = [
                'userId'     => $user['id'], // Menggunakan 'id' sesuai migrasi
                'fullName'   => $user['full_name'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ];
            session()->set($sessionData);
            return redirect()->to('/dashboard');
        } else {
            // Jika gagal, kembali ke halaman login dengan pesan error
            return redirect()->to('/login')->with('error', 'Username atau password salah.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}