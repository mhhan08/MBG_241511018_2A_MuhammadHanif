<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Bagian Sambutan -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold">Selamat Datang, <?= esc(session()->get('name')) ?>!</h1>
        <p class="col-md-8 fs-4">Anda login sebagai <strong><?= ucfirst(esc(session()->get('role'))) ?></strong>. Gunakan menu di bawah untuk navigasi cepat.</p>
    </div>
</div>

<?php
// ambil role dari session
$role = session()->get('role');
?>


//dashboard untuk gudang
<?php if ($role == 'gudang'): ?>

    <!-- Kartu Statistik -->
    <div class="row align-items-md-stretch">
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 text-white bg-primary rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-boxes fa-3x me-4"></i>
                    <div>
                        <h2><?= esc($total_bahan) ?> Bahan Baku</h2>
                        <p>Total jenis bahan baku yang terdaftar di sistem.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 bg-success text-white rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-inbox fa-3x me-4"></i>
                    <div>
                        <h2><?= esc($permintaan_menunggu) ?> Permintaan Baru</h2>
                        <p>Jumlah permintaan bahan baku yang perlu diproses.</p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Tombol Aksi Cepat -->
    <h3 class="mt-4 mb-3">Aksi Cepat Petugas Gudang</h3>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-box-open fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Kelola Bahan Baku</h5>
                    <p class="card-text">Tambah, edit stok, atau hapus data bahan baku.</p>
                    <a href="<?= site_url('admin/bahan-baku') ?>" class="btn btn-primary">Buka Halaman</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-check-square fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Proses Permintaan</h5>
                    <p class="card-text">Setujui atau tolak permintaan bahan dari dapur.</p>
                    <a href="<?= site_url('admin/permintaan') ?>" class="btn btn-primary">Lihat Permintaan</a>
                </div>
            </div>
        </div>
    </div>

//dashboard untuk dapur
<?php elseif ($role == 'dapur'): ?>

    <!-- Kartu Statistik -->
    <div class="row align-items-md-stretch">
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 text-white bg-success rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-history fa-3x me-4"></i>
                    <div>
                        <h2>Riwayat Permintaan</h2>
                        <p>Lihat semua status permintaan bahan baku yang pernah Anda buat.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 bg-info text-dark rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-plus-circle fa-3x me-4"></i>
                    <div>
                        <h2>Buat Permintaan Baru</h2>
                        <p>Ajukan permintaan bahan baku baru untuk kebutuhan memasak.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi Cepat -->
    <h3 class="mt-4 mb-3">Aksi Cepat Petugas Dapur</h3>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-file-alt fa-4x text-success mb-3"></i>
                    <h5 class="card-title">Buat Permintaan Baru</h5>
                    <p class="card-text">Pilih bahan dan ajukan permintaan ke gudang.</p>
                    <a href="<?= site_url('dapur/permintaan/new') ?>" class="btn btn-success">Buat Sekarang</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-tasks fa-4x text-success mb-3"></i>
                    <h5 class="card-title">Lihat Status Permintaan</h5>
                    <p class="card-text">Pantau status permintaan Anda (Menunggu, Disetujui, Ditolak).</p>
                    <a href="<?= site_url('dapur/permintaan') ?>" class="btn btn-success">Lihat Riwayat</a>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?= $this->endSection() ?>
