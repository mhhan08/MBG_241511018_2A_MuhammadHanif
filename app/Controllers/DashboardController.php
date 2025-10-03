<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\PermintaanModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $bahanModel = new BahanBakuModel();
        $permintaanModel = new PermintaanModel();

        $data = [
            'title' => 'Dashboard',
            'total_bahan' => $bahanModel->countAllResults(), // hitung total bahan
            'permintaan_menunggu' => $permintaanModel->where('status', 'menunggu')->countAllResults() //hiitung total permintaan
        ];

        return view('dashboard', $data);
    }
}