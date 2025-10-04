<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><?= esc($title) ?></h1>
    <a href="<?= site_url('dapur/permintaan/new') ?>" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm"></i> Buat Permintaan Baru
    </a>
</div>

<!-- Notifikasi Sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (empty($permintaan_list)): ?>
    <div class="text-center p-5 card shadow-sm">
        <p class="mb-0">Anda belum pernah membuat riwayat permintaan.</p>
    </div>
<?php else: ?>
    <?php foreach ($permintaan_list as $permintaan): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h6 class="mb-0 fw-bold">Permintaan Tgl: <?= esc(date('d M Y, H:i', strtotime($permintaan['created_at']))) ?></h6>
                    <small>Menu: <?= esc($permintaan['menu_makan']) ?></small>
                </div>
                <?php
                $statusClass = 'bg-secondary'; // Status default: Menunggu
                if ($permintaan['status'] == 'disetujui') $statusClass = 'bg-success';
                if ($permintaan['status'] == 'ditolak') $statusClass = 'bg-danger';
                ?>
                <span class="badge <?= $statusClass ?> fs-6 mt-2 mt-md-0"><?= ucfirst(esc($permintaan['status'])) ?></span>
            </div>
            <div class="card-body">
                <p><strong>Rencana Masak:</strong> <?= esc(date('d M Y', strtotime($permintaan['tgl_masak']))) ?> untuk <strong><?= esc($permintaan['jumlah_porsi']) ?></strong> porsi.</p>

                <h6 class="mt-3"><u>Detail Bahan yang Diminta:</u></h6>
                <?php if (empty($permintaan['detail_bahan'])): ?>
                    <p class="text-muted">Tidak ada detail bahan untuk permintaan ini.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($permintaan['detail_bahan'] as $bahan): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <?= esc($bahan['nama']) ?>
                                <span class="badge bg-primary rounded-pill"><?= esc($bahan['jumlah_diminta']) ?> <?= esc($bahan['satuan']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?= $this->endSection() ?>

