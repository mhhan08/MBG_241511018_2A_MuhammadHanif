<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">Selamat Datang, <?= session()->get('fullName') ?>!</h1>
            <p class="col-md-8 fs-4">Anda login sebagai **<?= session()->get('role') ?>**. Gunakan menu di bawah untuk navigasi cepat.</p>
        </div>
    </div>


<?php if (session()->get('role') == 'Admin'): ?>
    <div class="row align-items-md-stretch">
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 text-white bg-primary rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users fa-3x me-4"></i>
                    <div>
                        <h2><?=  ?> Mahasiswa</h2>
                        <p>Total user yang terdaftar di sistem.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 bg-dark text-white rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-book fa-3x me-4"></i>
                    <div>
                        <h2><?= $total_bahan ?> Mata Kuliah</h2>
                        <p>Total bahan yang tersedia di sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4 mb-3">Aksi Cepat</h3>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-user-cog fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Kelola Mahasiswa</h5>
                    <p class="card-text">Tambah, edit, atau hapus data mahasiswa.</p>
                    <a href="<?= site_url('admin/students') ?>" class="btn btn-primary">Buka Halaman</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-clipboard-list fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Kelola Mata Kuliah</h5>
                    <p class="card-text">Tambah, edit, atau hapus data mata kuliah.</p>
                    <a href="<?= site_url('admin/courses') ?>" class="btn btn-primary">Buka Halaman</a>
                </div>
            </div>
        </div>
    </div>


<?php elseif (session()->get('role') == 'Mahasiswa'): ?>
    <div class="row align-items-md-stretch">
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 text-white bg-success rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-3x me-4"></i>
                    <div>
                        <h2><?= $total_bahan ?> Mata Kuliah</h2>
                        <p>Total mata kuliah yang sedang Anda ambil.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 bg-secondary text-white rounded-3 shadow">
                <div class="d-flex align-items-center">
                    <i class="fas fa-star fa-3x me-4"></i>
                    <div>
                        <h2><?=  ?> SKS</h2>
                        <p>dasdada</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4 mb-3">Aksi Cepat</h3>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-book-reader fa-4x text-success mb-3"></i>
                    <h5 class="card-title">Mata Kuliah Saya</h5>
                    <p class="card-text">Lihat daftar lengkap mata kuliah yang telah Anda ambil.</p>
                    <a href="<?= site_url('mahasiswa/myCourses') ?>" class="btn btn-success">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-plus-circle fa-4x text-success mb-3"></i>
                    <h5 class="card-title">Ambil Mata Kuliah Baru</h5>
                    <p class="card-text">Pilih dan daftarkan mata kuliah untuk semester ini.</p>
                    <a href="<?= site_url('mahasiswa/courses') ?>" class="btn btn-success">Ambil Sekarang</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>