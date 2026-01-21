<?php
// PENGATURAN PATH OTOMATIS
// Ini untuk mencegah error jika $base_url belum diset di file config/koneksi.php
// Jika file ini di-include dari folder 'pages', kita harus mundur satu langkah (../)
// Jika dari index.php utama, kita tidak perlu mundur.
$base_url = isset($base_url) ? $base_url : '../'; 

// Cek posisi file saat ini untuk menentukan 'active' state menu
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    
    <div class="sidebar-profile">
        <?php 
            $logo_path = 'assets/logo.png'; 
            // Cek apakah diakses dari folder pages atau root
            if(file_exists('../assets/logo.png')) { 
                $logo_path = '../assets/logo.png'; 
            }
        ?>
        <img src="<?= $logo_path ?>" alt="Logo" width="60" class="mb-3">
        <h5 class="mb-0 fw-bold">DKP3 Inventaris</h5>
    </div>

    <div class="mt-2">
        <small class="text-white-50 px-4 text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Menu Utama</small>
        
        <a href="<?= $base_url ?>index.php" class="<?= $current_page == 'index.php' || $current_page == 'index1.php' ? 'active' : '' ?>">
            <i class="bi bi-grid-fill me-2"></i> Dashboard
        </a>
        
        <a href="<?= $base_url ?>pages/barang.php" class="<?= $current_page == 'barang.php' ? 'active' : '' ?>">
            <i class="bi bi-box-seam-fill me-2"></i> Data Barang
        </a>

        <?php if($_SESSION['level'] == 'admin') : ?>
        <a href="<?= $base_url ?>pages/daftar_pengguna.php" class="<?= $current_page == 'daftar_pengguna.php' || $current_page == 'tambah_pengguna.php' ? 'active' : '' ?>">
            <i class="bi bi-people-fill me-2"></i> Data Pengguna
        </a>
        <?php endif; ?>

        <small class="text-white-50 px-4 mt-4 d-block text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Transaksi</small>

        <a href="<?= $base_url ?>pages/barang_masuk.php" class="<?= $current_page == 'barang_masuk.php' ? 'active' : '' ?>">
            <i class="bi bi-arrow-down-circle-fill me-2"></i> Barang Masuk
        </a>
        
        <a href="<?= $base_url ?>pages/barang_keluar.php" class="<?= $current_page == 'barang_keluar.php' ? 'active' : '' ?>">
            <i class="bi bi-arrow-up-circle-fill me-2"></i> Barang Keluar
        </a>

        <small class="text-white-50 px-4 mt-4 d-block text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Lainnya</small>
         
        <a href="<?= $base_url ?>pages/laporan.php" class="<?= $current_page == 'laporan.php' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Laporan
        </a>

        <?php if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas') : ?>   
        <a href="<?= $base_url ?>pages/riwayat.php" class="<?= $current_page == 'riwayat.php' ? 'active' : '' ?>">
            <i class="bi bi-clock-history me-2"></i> Riwayat
        </a>
        <?php endif; ?>

        <div style="margin-top: 50px;">
            <a href="<?= $base_url ?>proses/logout.php" class="text-danger mt-4" onclick="return confirm('Yakin ingin keluar?')">
                <i class="bi bi-power me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

<div class="content flex-grow-1">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 p-3">
        <div class="container-fluid">
            <button class="btn btn-light border shadow-sm text-primary" id="menu-toggle">
                <i class="bi bi-list fs-5"></i>
            </button> 

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                id="dropdownUser"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                    <div class="me-2 text-end d-none d-md-block">
                        <small class="text-muted d-block" style="font-size: 10px;">Halo,</small>
                        <span class="fw-bold text-dark" style="font-size: 14px;"><?= $_SESSION['nama_admin']; ?></span>
                    </div>

                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center"
                        style="width:42px;height:42px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow p-3"
                    aria-labelledby="dropdownUser"
                    style="min-width: 260px; border-radius: 12px;">

                    <li class="text-center mb-2">
                        <div class="mb-2">
                             <div class="rounded-circle bg-light d-inline-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-person fs-2 text-secondary"></i>
                             </div>
                        </div>
                        <strong><?= $_SESSION['nama_admin']; ?></strong><br>
                        
                        <span class="badge bg-primary mb-1"><?= ucfirst($_SESSION['level']); ?></span>
                        
                        <div class="small text-muted">NIP: <?= isset($_SESSION['nip']) ? $_SESSION['nip'] : '-'; ?></div>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item py-2" href="<?= $base_url ?>pages/profile.php">
                            <i class="bi bi-person-gear me-2 text-primary"></i> Edit Profil
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item py-2 text-danger" href="<?= $base_url ?>proses/logout.php" onclick="return confirm('Yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>