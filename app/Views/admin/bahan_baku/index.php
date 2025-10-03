<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><?= esc($title) ?></h1>
    <a href="<?= site_url('admin/bahan-baku/new') ?>" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm"></i> Tambah Bahan Baku
    </a>
</div>

<!-- Menampilkan pesan sukses atau error (flash message) -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger shadow-sm" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0 fw-bold">Daftar Bahan Baku</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tgl Kadaluarsa</th>
                    <th>Status</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($bahan_baku)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data bahan baku.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bahan_baku as $bahan): ?>
                        <tr>
                            <td><?= esc($bahan['nama']) ?></td>
                            <td><?= esc($bahan['kategori']) ?></td>
                            <td><?= esc($bahan['jumlah']) ?></td>
                            <td><?= esc($bahan['satuan']) ?></td>
                            <td><?= esc(date('d M Y', strtotime($bahan['tanggal_kadaluarsa']))) ?></td>
                            <td>
                                <?= esc($bahan['status']) ?>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/bahan-baku/edit/' . $bahan['id']) ?>" class="btn btn-success btn-sm">Edit</a>

                                <!-- Form untuk tombol Hapus agar menggunakan method POST -->
                                <form action="<?= site_url('admin/bahan-baku/delete/' . $bahan['id']) ?>" method="post" class="d-inline delete-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Menambahkan dialog konfirmasi sebelum menghapus
    document.addEventListener("DOMContentLoaded", function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Mencegah form dikirim langsung
                const userConfirmed = confirm('Apakah Anda yakin ingin menghapus data ini?');
                if (userConfirmed) {
                    form.submit(); // Jika dikonfirmasi, kirim form
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

