<?php
namespace App\Controllers\dapur;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\PermintaanModel;
use App\Models\PermintaanDetailModel;
use CodeIgniter\Database\Exceptions\DatabaseException;//import untuk debug error db

class PermintaanController extends BaseController
{
    protected $permintaanModel;
    protected $permintaanDetailModel;
    protected $bahanBakuModel;

    public function __construct()
    {
        $this->permintaanModel = new PermintaanModel();
        $this->permintaanDetailModel = new PermintaanDetailModel();
        $this->bahanBakuModel = new BahanBakuModel();
    }

    // form untuk kirim permintaan
    public function new()
    {
        // ambil semua bahan baku yang tidak kadaluarasa dan stok nya lebih dari nol
        $bahanTersedia = $this->bahanBakuModel
            ->where('jumlah >', 0)
            ->where('tanggal_kadaluarsa >', date('Y-m-d'))
            ->findAll();

        $data = [
            'title' => 'Buat Permintaan Bahan Baku',
            'bahan_tersedia' => $bahanTersedia,
        ];
        return view('dapur/form', $data);
    }

    //proses simpan data
    public function create()
    {
        //aturan input user
        $rules = [
            'tgl_masak'         => 'required|valid_date',
            'menu_makan'        => 'required',
            'jumlah_porsi'      => 'required|numeric|greater_than[0]',
            'bahan_id.*'        => 'required|numeric',
            'jumlah_diminta.*'  => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('dapur/permintaan/new')->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();

        try {
            // mulai transaction
            $db->transBegin();

            // buat data permintaan utama
            $dataPermintaan = [
                'pemohon_id'   => session()->get('userId'),
                'tgl_masak'    => $this->request->getPost('tgl_masak'),
                'menu_makan'   => $this->request->getPost('menu_makan'),
                'jumlah_porsi' => $this->request->getPost('jumlah_porsi'),
                'status'       => 'menunggu'
            ];

            // insert akan mengembalikan id kalau berhasil
            $permintaanId = $this->permintaanModel->insert($dataPermintaan);

            // verifikasi apakah id permintaan berhasil dibuat
            if ($permintaanId === false || $permintaanId <= 0) {
                // Jika gagal, paksa transaksi untuk dibatalkan
                throw new \Exception('Gagal menyimpan data permintaan utama. Periksa Model atau Database.');
            }

            // buat data detail bahan
            $bahanIds = $this->request->getPost('bahan_id');
            $jumlahDiminta = $this->request->getPost('jumlah_diminta');
            $detailData = [];

            foreach ($bahanIds as $key => $bahanId) {
                if (!empty($bahanId) && !empty($jumlahDiminta[$key]) && $jumlahDiminta[$key] > 0) {
                    $detailData[] = [
                        'permintaan_id'  => $permintaanId,
                        'bahan_id'       => $bahanId,
                        'jumlah_diminta' => $jumlahDiminta[$key]
                    ];
                }
            }

            // memastikan ada detail data yg valid
            if (empty($detailData)) {
                throw new \Exception('Tidak ada detail bahan yang valid untuk disimpan.');
            }

            // simpan semua data
            $this->permintaanDetailModel->insertBatch($detailData);

            // kalau semua query berhasil commit
            $db->transCommit();

            return redirect()->to('dashboard')->with('success', 'Permintaan berhasil dibuat.');

        } catch (DatabaseException $e) {
            // kalau ada error spesifikd dari db
            $db->transRollback(); // batalkan perubahan
            return redirect()->to('dapur/permintaan/new')->withInput()
                ->with('error', 'Terjadi error database: ' . $e->getMessage());
        } catch (\Exception $e) {
            // kalau ada error lainnya
            $db->transRollback(); // batalkan perubahan
            return redirect()->to('dapur/permintaan/new')->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}