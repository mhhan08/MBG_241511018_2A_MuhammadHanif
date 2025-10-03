<?= $this->extend('layout/template') ?>

<?php
// Menentukan apakah form ini dalam mode 'edit' atau 'tambah baru'
$isEdit = isset($bahan);
// Menentukan URL tujuan form berdasarkan mode
$formAction = $isEdit ? site_url('admin/bahan-baku/update/' . $bahan['id']) : site_url('admin/bahan-baku');
?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= esc($title) ?></h5>
            </div>
            <div class="card-body">
                <!-- Menampilkan daftar error validasi jika ada -->
                <?php if(session()->has('errors')): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= $formAction ?>" method="post">
                    <?= csrf_field() // Token keamanan CodeIgniter ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Bahan Baku</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $bahan['nama'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" value="<?= old('kategori', $bahan['kategori'] ?? '') ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jumlah" class="form-label fw-semibold">Jumlah (Stok)</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah', $bahan['jumlah'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="satuan" class="form-label fw-semibold">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" value="<?= old('satuan', $bahan['satuan'] ?? '') ?>" placeholder="Contoh: Kg, Liter, Pcs">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= old('tanggal_masuk', $bahan['tanggal_masuk'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kadaluarsa" class="form-label fw-semibold">Tanggal Kadaluarsa</label>
                            <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="<?= old('tanggal_kadaluarsa', $bahan['tanggal_kadaluarsa'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= site_url('admin/bahan-baku') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Simpan' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

