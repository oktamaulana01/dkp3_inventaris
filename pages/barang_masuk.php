<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
    .card-custom { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
    .card-header-success {
        background: white; padding: 20px 25px; border-bottom: 2px solid #10b981; /* Emerald border */
        display: flex; justify-content: space-between; align-items: center;
    }
    .table-custom thead th { background-color: #ecfdf5; color: #047857; border: none; padding: 15px; }
    .table-custom tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f9f9f9; }
    .btn-add-success {
        background: #10b981; color: white; border-radius: 50px; padding: 10px 25px; border: none; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); transition: 0.2s;
    }
    .btn-add-success:hover { background: #059669; transform: translateY(-2px); color: white; }
    .text-emerald { color: #059669; }
</style>

<div class="container-fluid p-4">
    <div class="card card-custom">
        <div class="card-header-success">
            <div>
                <h4 class="mb-0 fw-bold text-dark">Barang Masuk</h4>
                <small class="text-muted">Riwayat penambahan stok inventaris</small>
            </div>
            <?php if($_SESSION['level'] != 'pimpinan') : ?>
            <button type="button" class="btn-add-success" data-bs-toggle="modal" data-bs-target="#modalMasuk">
                <i class="bi bi-plus-lg me-2"></i>Input Barang Masuk
            </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0 table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <?php if($_SESSION['level'] != 'pimpinan') : ?>
                            <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT m.*, b.nama_barang, b.satuan 
                                  FROM barang_masuk m 
                                  JOIN barang b ON m.id_barang = b.id_barang 
                                  ORDER BY m.tanggal DESC, m.id_masuk DESC";
                        $result = mysqli_query($koneksi, $query);
                        $no = 1;
                        if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-emerald-50 text-emerald rounded p-2 me-2">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <?= date('d M Y', strtotime($row['tanggal'])); ?>
                                </div>
                            </td>
                            <td class="fw-medium"><?= $row['nama_barang']; ?></td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    + <?= $row['jumlah'] . ' ' . $row['satuan']; ?>
                                </span>
                            </td>
                            <td class="text-muted small fst-italic"><?= $row['keterangan'] ?: '-'; ?></td>
                            <?php if($_SESSION['level'] != 'pimpinan') : ?>
                            <td class="text-center">
                                <a href="hapus_masuk.php?id=<?= $row['id_masuk']; ?>&idb=<?= $row['id_barang']; ?>&qty=<?= $row['jumlah']; ?>" 
                                   class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" 
                                   style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;"
                                   onclick="return confirm('Hapus data ini? Stok akan dikembalikan.')">
                                   <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-5 text-muted'>Belum ada data barang masuk.</td></tr>";
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMasuk">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white p-4 rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-box-arrow-in-down me-2"></i>Input Barang Masuk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="../proses/proses_masuk.php" method="POST">
                <div class="modal-body p-4">
                    <div class="form-floating mb-3">
                        <input type="date" name="tanggal" class="form-control" id="tglMasuk" value="<?= date('Y-m-d'); ?>" required>
                        <label for="tglMasuk">Tanggal Penerimaan</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <select name="id_barang" class="form-select" id="pilihBrg" required>
                            <option value="">-- Pilih --</option>
                            <?php
                            $brg = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
                            while ($b = mysqli_fetch_assoc($brg)) {
                                echo "<option value='{$b['id_barang']}'>{$b['nama_barang']} (Stok: {$b['stok']})</option>";
                            }
                            ?>
                        </select>
                        <label for="pilihBrg">Nama Barang</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" name="jumlah" class="form-control" id="jmlMasuk" min="1" placeholder="Jumlah" required>
                        <label for="jmlMasuk">Jumlah Masuk</label>
                    </div>

                    <div class="form-floating">
                        <textarea name="keterangan" class="form-control" id="ketMasuk" placeholder="Ket" style="height: 100px"></textarea>
                        <label for="ketMasuk">Keterangan (Sumber/Asal)</label>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-top-0 rounded-bottom-4">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_masuk" class="btn btn-success px-4 rounded-pill">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>