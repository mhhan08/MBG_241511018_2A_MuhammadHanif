<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Kelola Bahan Baku<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Kelola Bahan Baku</h1>
        <a href="<?= site_url('admin/tambah_bahan') ?>" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah bahan baku Baru
        </a>
    </div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
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
                        <th>id</th>
                        <th>Nama</th>
                        <th>kategori</th>
                        <th>Jumlah</th>
                        <th>tanggal-kadaluwarsa</th>
                        <th>Status</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($bahan_baku)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada bahan baku.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bahan_baku as $bahan): ?>
                            <tr>
                                <td><?= esc($bahan['id']) ?></td>
                                <td><?= esc($bahan['nama']) ?></td>
                                <td><?= esc($bahan['kategori']) ?></td>
                                <td><?= esc($bahan['jumlah']) ?></td>
                                <td><?= esc($bahan['tanggal_kadaluarsa']) ?></td>
                                <td><?= esc($bahan['status']) ?></td>
                                <td>
                                    <a href="<?= site_url('admin/edit_bahan/' . $bahan['id']) ?>"
                                       class="btn btn-warning btn-sm">Edit</a>

                                    <form action="<?= site_url('admin/hapus_bahan/' . $bahan['id']) ?>"
                                          method="post" class="d-inline delete-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
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
        document.addEventListener("DOMContentLoaded", function () {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    // Mencegah form dikirim secara langsung
                    event.preventDefault();

                    // Tampilkan dialog konfirmasi
                    const userConfirmed = confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');

                    // Jika pengguna menekan "OK", maka kirim form
                    if (userConfirmed) {
                        form.submit();
                    }
                    // Jika menekan "Cancel", tidak terjadi apa-apa
                });
            });
        });
    </script>
<?= $this->endSection() ?>