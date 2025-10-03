<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\PermintaanDetailModel;
use App\Models\PermintaanModel;
use CodeIgniter\Controller;

class PermintaanController extends BaseController {
    protected $permintaanModel;
    protected $bahanModel;
    protected $permintaanDetailModel;

    public function __construct()
    {
        $this->permintaanModel = new PermintaanModel();
        $this->permintaanDetailModel = new PermintaanDetailModel();
        $this->bahanModel = new BahanBakuModel();
    }

    //menampilkan daftar permintaan dari dapur
    public function index()
    {
        $permintaan = $this->permintaanModel
            ->select('id, status,tgl_masak,menu_makan,status,created_at',false)
            ->where('status', 'menunggu' )
            ->orderBy('tgl_masak', 'ASC')
            ->findAll();

        $data = [
            'title'      => 'Daftar Permintaan Bahan Baku',
            'permintaan' => $permintaan
        ];
        return view('admin/permintaan/index', $data);
    }
}

