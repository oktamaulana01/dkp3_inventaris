<?php 
include '../layout/header.php'; 
include '../layout/sidebar.php'; 
include '../config/koneksi.php';

// --- LOGIKA DETEKSI USER (Admin vs Pengguna) ---
$level = $_SESSION['level'];

if ($level == 'admin') {
    // Jika Admin, ambil dari tabel 'admin'
    $id_user = $_SESSION['id_admin'];
    $query   = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_user'");
} else {
    // Jika Petugas/Pimpinan, ambil dari tabel 'pengguna'
    $id_user = $_SESSION['id_pengguna'];
    $query   = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna = '$id_user'");
}

$data = mysqli_fetch_assoc($query);
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Pengaturan Profil</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h3 class="card-title fw-bold">Edit Profil Saya</h3>
                        </div>
                        <form action="../proses/profile_proses.php" method="POST">
                            <div class="card-body">
                                
                                <?php if(isset($_GET['pesan'])): ?>
                                    <?php if($_GET['pesan'] == 'sukses'): ?>
                                        <div class="alert alert-success">Profil berhasil diperbarui!</div>
                                    <?php elseif($_GET['pesan'] == 'gagal'): ?>
                                        <div class="alert alert-danger">Gagal memperbarui profil.</div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="<?= $data['nama_lengkap'] ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control bg-light" value="<?= isset($data['nip']) ? $data['nip'] : '-' ?>" disabled>
                                    <small class="text-muted fst-italic">*Hubungi Admin jika ingin mengubah NIP</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                                </div>
                                
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label text-primary fw-bold">Ganti Password</label>
                                    <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
                                    <small class="text-muted">Biarkan kosong jika password tidak ingin diubah.</small>
                                </div>
                            </div>
                            <div class="card-footer bg-white text-end">
                                <button type="submit" name="update_profil" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../layout/footer.php'; ?>