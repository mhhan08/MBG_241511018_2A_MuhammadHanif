<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminController extends BaseController
{
    protected $bahanModel;

    public function __construct()
    {
        $this->bahanModel = new BahanBakuModel();
    }

    public function index()
    {
        $data = [
            'bahan_baku' => $this->bahanModel->findAll()
        ];

        return view('admin/bahan_baku', $data);
    }

    public function new()
    {
        return view('admin\bahan_form', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function create()
    {
        $rules = [
            'nama'       => 'required|min_length[3]',
            'jumlah'     => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $this->bahanModel->save([
            'nama' => $this->request->getPost('nama'),
            'jumlah'     => $this->request->getPost('jumlah')
        ]);

        return redirect()->to('/admin/bahan_baku')
            ->with('success', 'bahan baku berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $bahan = $this->bahanModel->find($id);

        if (!$bahan) {
            throw new PageNotFoundException('bahan baku dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('admin/stock_form', [
            'bahan_baku'     => $bahan,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id = null)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'jumlah'     => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $this->courseModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'jumlah'     => $this->request->getPost('jumlah')
        ]);

        return redirect()->to('/admin/bahan_baku')
            ->with('success', 'bahan baku berhasil diubah.');
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
