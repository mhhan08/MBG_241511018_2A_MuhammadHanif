<?= $this->extend('layout/template') ?>

<?php
// untuk cek apakah ini foorm untuk edit atau tambah baru
$isEdit = isset($bahan);
$formAction = $isEdit ? site_url('admin/bahan-baku/update/' . $bahan['id']) : site_url('admin/bahan-baku');
$pageTitle = $isEdit ? 'Update Stok Bahan Baku' : 'Tambah Bahan Baku Baru';
?>

<?= $this->section('title') ?><?= esc($pageTitle) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= esc($pageTitle) ?></h5>
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

                    <?php if ($isEdit): ?>
                        <!-- untuk mode edit -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Bahan Baku</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($bahan['nama']) ?>" readonly>
                            <div class="form-text">Nama bahan baku tidak dapat diubah saat mengedit stok.</div>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label fw-semibold">Update Jumlah (Stok)</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah', $bahan['jumlah']) ?>" placeholder="Masukkan jumlah stok baru" required>
                        </div>

                    <?php else: ?>
                        <!-- untuk mode create -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Bahan Baku</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="Contoh: Beras Pandan Wangi">
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-semibold">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="<?= old('kategori') ?>" placeholder="Contoh: Karbohidrat, Protein, Sayuran">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah" class="form-label fw-semibold">Jumlah (Stok)</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="satuan" class="form-label fw-semibold">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" value="<?= old('satuan') ?>" placeholder="Contoh: Kg, Liter, Pcs">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= old('tanggal_masuk') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_kadaluarsa" class="form-label fw-semibold">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="<?= old('tanggal_kadaluarsa') ?>">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= site_url('admin/bahan-baku') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update Stok' : 'Simpan' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

