<?php
include '../config/koneksi.php'; // Path ini tetap benar (keluar dari proses, masuk config)

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM pengguna WHERE id_pengguna='$id'");

    if ($hapus) {
        // PERUBAHAN DISINI:
        // Kita harus keluar dari folder 'proses' (../) lalu masuk ke folder 'pages'
        header("Location: ../pages/daftar_pengguna.php"); 
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }

} else {
    // Redirect jika akses langsung
    header("Location: ../pages/daftar_pengguna.php");
}
?>