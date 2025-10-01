<?php

namespace App\Controllers;

use App\Models\BahanBakuModel;
use App\Models\PermintaanModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $role = session()->get('role');

        if ($role === 'gudang') {
            $userModel = new UserModel();
            $BahanModel = new BahanBakuModel();

            $data['total_user'] = $userModel->countAllResults();
            $data['total_bahan'] = $BahanModel->countAllResults();

        } elseif ($role === 'dapur') {
            return "Mahasiswa";
        }

        return view('dashboard', $data);
    }
}