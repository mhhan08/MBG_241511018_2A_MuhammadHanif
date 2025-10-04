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

    //menampilkan detail permintaan dan  untuk terima atau tolak permintaan
    public function detail($id)
    {
        // ambil data permintaan dan gabung dengan nama pemohon
        $permintaan = $this->permintaanModel
            ->select('permintaan.*, user.name as pemohon_name')
            ->join('user', 'user.id = permintaan.pemohon_id')
            ->find($id);

        if (!$permintaan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Permintaan tidak ditemukan.');
        }

        // ambil detail bahan dan gabungkan dengan data bahan baku untuk lihat stock dari bahan baku saat ini
        $detailBahan = $this->permintaanDetailModel
            ->select('permintaan_detail.*, bahan_baku.nama, bahan_baku.satuan, bahan_baku.jumlah as stok_saat_ini')
            ->join('bahan_baku', 'bahan_baku.id = permintaan_detail.bahan_id')
            ->where('permintaan_id', $id)
            ->findAll();

        $data = [
            'title'      => 'Detail Permintaan',
            'permintaan' => $permintaan,
            'detailBahan' => $detailBahan
        ];

        return view('admin/permintaan/detail', $data);
    }

    //kalau gudang approve atau terima
    public function approve($id)
    {
        $db = \Config\Database::connect();
        $db->transStart(); // mulai atomic transaction

        try {
            // ambil semua bahan yang diminta
            $items = $this->permintaanDetailModel->where('permintaan_id', $id)->findAll();

            // loop untuk cek ketersediaan dan kurangi stock
            foreach ($items as $item) {
                $bahan = $this->bahanModel->find($item['bahan_id']);

                // cek ketersediaan
                if (!$bahan || $bahan['jumlah'] < $item['jumlah_diminta']) {
                    throw new \Exception("Stok untuk bahan '{$bahan['nama']}' tidak mencukupi.");
                }

                // kurangi stock yg ada
                $stokBaru = $bahan['jumlah'] - $item['jumlah_diminta'];

                // update stock
                $this->bahanModel->update($item['bahan_id'], ['jumlah' => $stokBaru]);
            }

            // update status permintaan jadi disetujui
            $this->permintaanModel->update($id, ['status' => 'disetujui']);

            $db->transComplete(); // end transaction

            return redirect()->to('admin/permintaan')->with('success', 'Permintaan berhasil disetujui dan stok telah diperbarui.');

        } catch (\Exception $e) {
            $db->transRollback(); // batalkan semua query kalau error
            return redirect()->to('admin/permintaan/detail/' . $id)->with('error', $e->getMessage());
        }
    }

    //kalau gudang tolak
    public function reject($id)
    {
        //update status permintaan
        $this->permintaanModel->update($id, [
            'status' => 'ditolak'
        ]);

        return redirect()->to('admin/permintaan')->with('success', 'Permintaan telah ditolak.');
    }

}

