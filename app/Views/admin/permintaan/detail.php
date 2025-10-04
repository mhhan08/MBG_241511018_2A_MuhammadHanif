<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Notifikasi Error (misal: stok tidak cukup) -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Permintaan #<?= esc($permintaan['id']) ?></h5>
                <?php
                $statusClass = 'bg-secondary'; // Status default: Menunggu
                if ($permintaan['status'] == 'disetujui') $statusClass = 'bg-success';
                if ($permintaan['status'] == 'ditolak') $statusClass = 'bg-danger';
                ?>
                <span class="badge <?= $statusClass ?> fs-6"><?= ucfirst(esc($permintaan['status'])) ?></span>
            </div>
            <div class="card-body">
                <!-- Informasi Utama Permintaan -->
                <table class="table table-bordered table-sm mb-4">
                    <tbody>
                    <tr>
                        <th style="width: 200px;">Pemohon</th>
                        <td><?= esc($permintaan['pemohon_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Permintaan</th>
                        <td><?= esc(date('d M Y H:i', strtotime($permintaan['created_at']))) ?></td>
                    </tr>
                    <tr>
                        <th>Rencana Tanggal Masak</th>
                        <td><?= esc(date('d M Y', strtotime($permintaan['tgl_masak']))) ?></td>
                    </tr>
                    <tr>
                        <th>Menu</th>
                        <td><?= esc($permintaan['menu_makan']) ?> (<?= esc($permintaan['jumlah_porsi']) ?> Porsi)</td>
                    </tr>
                    </tbody>
                </table>

                <!-- Tabel Rincian Bahan -->
                <h6 class="mb-3">Rincian Bahan Baku yang Diminta:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>Nama Bahan</th>
                            <th class="text-end">Jumlah Diminta</th>
                            <th class="text-end">Stok Gudang Saat Ini</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($detailBahan as $bahan): ?>
                            <!-- Beri warna merah jika stok kurang dari yang diminta -->
                            <tr class="<?= ($bahan['stok_saat_ini'] < $bahan['jumlah_diminta']) ? 'table-danger' : '' ?>">
                                <td><?= esc($bahan['nama']) ?></td>
                                <td class="text-end"><?= esc($bahan['jumlah_diminta']) ?> <?= esc($bahan['satuan']) ?></td>
                                <td class="text-end"><?= esc($bahan['stok_saat_ini']) ?> <?= esc($bahan['satuan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Aksi (Hanya muncul jika status masih 'menunggu') -->
                <?php if ($permintaan['status'] == 'menunggu'): ?>
                    <hr>
                    <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                        <p class="mb-0 me-2"><b>Aksi Persetujuan:</b></p>

                        <!-- Tombol Tolak Langsung -->
                        <form action="<?= site_url('admin/permintaan/reject/' . $permintaan['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin MENOLAK permintaan ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i> Tolak
                            </button>
                        </form>

                        <!-- Tombol Setujui -->
                        <form action="<?= site_url('admin/permintaan/approve/' . $permintaan['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI permintaan ini? Stok akan otomatis berkurang.')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i> Setujui
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Menampilkan alasan penolakan jika ada -->
                <?php if ($permintaan['status'] == 'ditolak' && !empty($permintaan['alasan_penolakan'])): ?>
                    <hr>
                    <div class="alert alert-warning mt-3">
                        <strong>Alasan Penolakan:</strong><br>
                        <?= esc($permintaan['alasan_penolakan']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-footer bg-light">
                <a href="<?= site_url('admin/permintaan') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

