<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Buat Permintaan') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= esc($title ?? 'Buat Permintaan') ?></h5>
                </div>
                <div class="card-body">
                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger" role="alert">
                            <p class="mb-1 fw-bold">Terjadi Kesalahan Validasi:</p>
                            <ul>
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('dapur/permintaan') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tgl_masak" class="form-label fw-semibold">Tanggal Masak</label>
                                <input type="date" class="form-control" id="tgl_masak" name="tgl_masak" value="<?= old('tgl_masak', date('Y-m-d')) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="menu_makan" class="form-label fw-semibold">Menu yang Akan Dibuat</label>
                                <input type="text" class="form-control" id="menu_makan" name="menu_makan" value="<?= old('menu_makan') ?>" placeholder="Contoh: Nasi Ayam Goreng">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jumlah_porsi" class="form-label fw-semibold">Jumlah Porsi</label>
                                <input type="number" class="form-control" id="jumlah_porsi" name="jumlah_porsi" value="<?= old('jumlah_porsi') ?>" placeholder="Contoh: 200">
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">Daftar Bahan Baku yang Diminta</h6>
                        <div id="bahan-list">
                        </div>

                        <button type="button" id="add-bahan" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-plus"></i> Tambah Bahan Lain
                        </button>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <template id="bahan-template">
        <div class="row align-items-center bahan-item mb-2">
            <div class="col-md-6">
                <select name="bahan_id[]" class="form-select" required>
                    <option value="">-- Pilih Bahan --</option>
                    <?php if(!empty($bahan_tersedia)): ?>
                        <?php foreach($bahan_tersedia as $bahan): ?>
                            <option value="<?= $bahan['id'] ?>"><?= esc($bahan['nama']) ?> (Stok: <?= $bahan['jumlah'] ?> <?= $bahan['satuan'] ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="jumlah_diminta[]" class="form-control" placeholder="Jumlah" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-bahan">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addButton = document.getElementById('add-bahan');
            const bahanList = document.getElementById('bahan-list');
            const template = document.getElementById('bahan-template');

            // untuk tambah input bahan baru
            function addBahanRow() {
                const clone = template.content.cloneNode(true);
                bahanList.appendChild(clone);
            }

            // tambah 1 input bahan saat pertama dimuat
            addBahanRow();

            // event listener untuk tombol tambah bahan
            addButton.addEventListener('click', addBahanRow);

            // event listener untuk tombol hapus
            bahanList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-bahan') || e.target.closest('.remove-bahan')) {
                    // bisa hapus kalau kolom input nya lebih dari 1
                    if (bahanList.querySelectorAll('.bahan-item').length > 1) {
                        e.target.closest('.bahan-item').remove();
                    } else {
                        alert('Minimal harus ada satu bahan yang diminta.');
                    }
                }
            });
        });
    </script>
<?= $this->endSection() ?>