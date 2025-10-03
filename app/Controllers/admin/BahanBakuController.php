<?php
namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BahanBakuController extends BaseController
{
    protected $bahanModel;

    public function __construct()
    {
        $this->bahanModel = new BahanBakuModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Bahan Baku',
            'bahan_baku' => $this->bahanModel->findAll()
        ];

        return view('admin/bahan_baku/index', $data);
    }

    public function new()
    {
        $data = [
            'title'      => 'Tambah Bahan Baku Baru',
            'validation' => \Config\Services::validation()
        ];

        // untuk create dan edit
        return view('admin/bahan_baku/form', $data);
    }

    public function create()
    {
        // aturan input
        $rules = [
            'nama'               => 'required|min_length[3]',
            'jumlah'             => 'required|numeric|greater_than_equal_to[0]',
            'satuan'             => 'required',
            'tanggal_masuk'      => 'required|valid_date',
            'tanggal_kadaluarsa' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            // Jika tidak sesuai aturan kembali ke form
            return redirect()->to('/admin/bahan-baku/new')->withInput();
        }

        // simpan data
        $this->bahanModel->save([
            'nama'               => $this->request->getPost('nama'),
            'kategori'           => $this->request->getPost('kategori'),
            'satuan'             => $this->request->getPost('satuan'),
            'jumlah'             => $this->request->getPost('jumlah'),
            'tanggal_masuk'      => $this->request->getPost('tanggal_masuk'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa')
        ]);

        return redirect()->to('/admin/bahan-baku')->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bahan = $this->bahanModel->find($id);
        if (!$bahan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bahan baku tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Bahan Baku',
            'bahan'      => $bahan,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/bahan_baku/form', $data);
    }

    /**
     * Memproses pembaruan data bahan baku dari form edit.
     */
    public function update($id)
    {
        // Aturan validasi hanya untuk field 'jumlah'
        $rules = [
            'jumlah' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Menyiapkan data yang akan diupdate, hanya field 'jumlah'
        $dataToUpdate = [
            'jumlah' => $this->request->getPost('jumlah')
        ];

        $this->bahanModel->update($id, $dataToUpdate);

        return redirect()->to('admin/bahan-baku')->with('success', 'Stok bahan baku berhasil diupdate.');
    }

    public function delete($id = null)
    {
        $bahan = $this->bahanModel->find($id);

        if (!$bahan) {
            return redirect()->to('/admin/bahan_baku')
                ->with('error', 'bahan tidak ditemukan.');
        }

        $this->bahanModel->delete($id);

        return redirect()->to('/admin/bahan_baku')
            ->with('success', 'bahan berhasil dihapus.');
    }
}
