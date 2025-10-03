<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class BahanBakuModel extends Model
{
    protected $table            = 'bahan_baku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama','kategori','jumlah','satuan','tanggal_masuk','tanggal_kadaluarsa'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];

    //akan dijalankan setiap kita ingin ambil data dari db
    protected $afterFind      = ['setStatusBahanBaku'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    //otomatis set status setiap kali data bahan baku diambil
    protected function setStatusBahanBaku(array $data){

        //kalau data yang diambil atau dicari tidak ada atau bukan array return langsung
        if(!isset($data['data']) || !is_array($data['data'])){
            return $data;
        }

        //mengecek apakah ini satu array atau banyak array
        $is_one_array = isset($data['data']['id']);

        //jika satu array
        if($is_one_array){
            //langsung prosess
            $data['data']['status'] = $this->createStatus($data['data']);
        }
        else {
            //jika banyak maka pakai foreach untuk prosess nya
            foreach($data['data'] as $key => $value){
                $data['data'][$key]['status'] = $this->createStatus($value);
            }
        }
        return $data;
    }

    protected function createStatus(array $bahan){

        $now = new DateTime();
        $expired_date = new DateTime($bahan['tanggal_kadaluarsa']);
        $interval = $now->diff($expired_date);
        $daysRemaining = (int)$interval->format('%R%a'); // kalau sudah kadaluarsa nilai nya negatif

        if ($bahan['jumlah'] <= 0) {
            return 'Habis';
        }

        if ($daysRemaining < 0) {
            return 'Kadaluarsa';
        }

        if ($daysRemaining <= 3) {
            return 'Segera Kadaluarsa';
        }

        return 'Tersedia';
    }
}
