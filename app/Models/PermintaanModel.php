<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanModel extends Model
{
    protected $table            = 'permintaan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Kolom yang diizinkan untuk diisi dari controller
    protected $allowedFields    = [
        'pemohon_id',
        'tgl_masak',
        'menu_makan',
        'jumlah_porsi',
        'status'
    ];

    // Mengaktifkan timestamps untuk mengisi 'created_at' secara otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    // Dinonaktifkan karena tidak ada kolom 'updated_at' di tabel Anda
    protected $updatedField  = '';
}
