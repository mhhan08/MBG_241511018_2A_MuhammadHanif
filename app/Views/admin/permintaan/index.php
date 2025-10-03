<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><?= esc($title) ?></h1>
</div>

<!-- Tempat untuk notifikasi (jika ada) -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0 fw-bold">Permintaan yang Menunggu Persetujuan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>Tanggal Masak</th>
                    <th>Menu Masak</th>
                    <th>Tanggal Permohonan</th>
                    <th>Status</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($permintaan)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada permintaan yang menunggu persetujuan saat ini.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($permintaan as $item): ?>
                        <tr>
                            <!-- Menampilkan Tanggal Masak -->
                            <td><?= esc(date('d M Y', strtotime($item['tgl_masak']))) ?></td>

                            <!-- Menampilkan Menu Masak -->
                            <td><?= esc($item['menu_makan']) ?></td>

                            <!-- Menampilkan Tanggal Permohonan dibuat -->
                            <td><?= esc(date('d M Y, H:i', strtotime($item['created_at']))) ?></td>

                            <!-- Menampilkan Status (pasti 'menunggu') -->
                            <td>
                                <span class="badge bg-secondary"><?= ucfirst(esc($item['status'])) ?></span>
                            </td>

                            <!-- Kolom Aksi dengan Tombol Lihat Detail -->
                            <td>
                                <a href="<?= site_url('admin/permintaan/detail/' . $item['id']) ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

