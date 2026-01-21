<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<style>
    #contextMenu {
        display: none;
        position: absolute;
        z-index: 1000;
        width: 160px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        border: 1px solid #dee2e6;
        padding: 5px 0;
        overflow: hidden;
    }

    #contextMenu a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        transition: background 0.2s;
        font-weight: 500;
    }

    #contextMenu a:hover {
        background-color: #f8f9fa;
    }

    #contextMenu a.delete-option {
        color: #dc3545; /* Merah */
    }
    
    #contextMenu a.delete-option:hover {
        background-color: #ffeef0;
    }

    /* Efek highlight baris saat diklik */
    .table-hover tbody tr.active-context {
        background-color: #e2e6ea !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold">Riwayat Aktivitas</h1>
                    <p class="text-muted small mb-0">Log transaksi barang masuk dan keluar</p>
                    
                    <?php if($_SESSION['level'] == 'admin') : ?>
                        <small class="text-danger fw-bold"><i class="fas fa-user-shield me-1"></i> Mode Admin: Klik Kanan untuk Hapus</small>
                    <?php endif; ?>
                    
                </div>
                <div class="col-sm-6 text-end">
                    <a href="cetak_riwayat.php" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tableRiwayat">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width:50px;">#</th>
                                    <th>Petugas</th>
                                    <th>NIP</th>
                                    <th class="text-center">Status</th>
                                    <th>Nama Barang</th>
                                    <th class="text-end">Masuk</th>
                                    <th class="text-end">Keluar</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id_riwayat, nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal
                                        FROM riwayat_barang
                                        ORDER BY tanggal DESC, id_riwayat DESC";

                                $no = 1;
                                $result = mysqli_query($koneksi, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id_riwayat = $row['id_riwayat'];
                                        $nama   = $row['nama_user'] ?: '-';
                                        $nip    = $row['nip'] ?: '-';
                                        $aksi   = strtolower($row['jenis_aktivitas']);
                                        $barang = $row['nama_barang'] ?: '-';
                                        $jumlah = (int)$row['jumlah'];
                                        $tgl    = date('d-m-Y H:i', strtotime($row['tanggal']));

                                        $isMasuk  = $aksi === 'masuk';
                                        $isKeluar = $aksi === 'keluar';

                                        $badgeClass = $isMasuk ? 'bg-success' : 'bg-danger';
                                        $aksiLabel  = $isMasuk ? 'Masuk' : 'Keluar';
                                        ?>
                                        <tr class="riwayat-row" data-id="<?= $id_riwayat; ?>">
                                            <td class="text-center text-muted"><?= $no++; ?></td>
                                            <td class="fw-semibold"><?= htmlspecialchars($nama); ?></td>
                                            <td class="text-muted small"><?= htmlspecialchars($nip); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?= $badgeClass; ?> rounded-pill">
                                                    <?= $aksiLabel; ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($barang); ?></td>
                                            <td class="text-end">
                                                <?php if ($isMasuk): ?>
                                                    <span class="text-success fw-semibold">+<?= number_format($jumlah); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if ($isKeluar): ?>
                                                    <span class="text-danger fw-semibold">-<?= number_format($jumlah); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-muted small"><?= $tgl; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                                <p class="mb-0">Belum ada riwayat aktivitas</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if($_SESSION['level'] == 'admin') : ?>
    <div id="contextMenu">
        <div class="px-3 py-2 border-bottom bg-light">
            <small class="text-muted fw-bold">ADMIN ACTIONS</small>
        </div>
        
        <a href="#" id="btnHapus" class="delete-option" onclick="return confirm('PERINGATAN ADMIN:\n\nYakin ingin menghapus log aktivitas ini?\nData yang dihapus tidak bisa dikembalikan.')">
            <i class="fas fa-trash-alt me-2"></i> Hapus 
        </a>
        
        <a href="#" onclick="hideMenu()">
            <i class="fas fa-times me-2"></i> Batal
        </a>
    </div>
<?php endif; ?>

<script>
    // Ambil Level User dari PHP ke JS
    const userLevel = "<?= $_SESSION['level']; ?>";
    
    const contextMenu = document.getElementById("contextMenu");
    const tableRows = document.querySelectorAll(".riwayat-row");
    const btnHapus = document.getElementById("btnHapus");

    tableRows.forEach(row => {
        row.addEventListener("contextmenu", function(e) {
            
            // --- LOGIKA KUNCI ---
            // Jika BUKAN admin, hentikan proses (jangan tampilkan menu)
            if (userLevel !== 'admin') {
                return; // Biarkan menu klik kanan browser biasa yang muncul
            }
            // --------------------

            e.preventDefault(); // Matikan menu browser bawaan (hanya untuk admin)
            
            const id = this.getAttribute("data-id");
            
            // Set link hapus
            if(btnHapus) {
                btnHapus.href = "../proses/hapus_riwayat.php?id=" + id;
            }

            // Posisi Menu
            let x = e.pageX;
            let y = e.pageY;
            
            if(contextMenu) {
                contextMenu.style.left = `${x}px`;
                contextMenu.style.top = `${y}px`;
                contextMenu.style.display = "block";
            }

            // Highlight Baris
            document.querySelectorAll('.riwayat-row').forEach(r => r.classList.remove('active-context'));
            this.classList.add('active-context');
        });
    });

    // Tutup menu jika klik di tempat lain
    document.addEventListener("click", function(e) {
        if (contextMenu && !contextMenu.contains(e.target)) {
            hideMenu();
        }
    });

    function hideMenu() {
        if(contextMenu) contextMenu.style.display = "none";
        document.querySelectorAll('.riwayat-row').forEach(r => r.classList.remove('active-context'));
    }
</script>

<style>
    .content-wrapper { background-color: #f8f9fa; }
    .card { border-radius: 12px; overflow: hidden; }
    .table thead th { font-weight: 600; font-size: 0.875rem; color: #495057; border-bottom: 2px solid #dee2e6; padding: 1rem; }
    .table tbody td { padding: 1rem; border-bottom: 1px solid #f0f0f0; }
    .table tbody tr:last-child td { border-bottom: none; }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
    .badge { padding: 0.35rem 0.75rem; font-weight: 500; font-size: 0.75rem; }
    .btn { padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 500; }
</style>

<?php include '../layout/footer.php'; ?>