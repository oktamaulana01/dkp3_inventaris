<?php
session_start();
include '../config/koneksi.php';

// --- PENGAMAN UTAMA ---
// Jika level BUKAN 'admin', tolak paksa!
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    echo "<script>
            alert('AKSES DITOLAK! Anda tidak memiliki izin menghapus riwayat.');
            window.location='../pages/riwayat.php';
          </script>";
    exit; // Stop program di sini
}
// ----------------------

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM riwayat_barang WHERE id_riwayat='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: ../pages/riwayat.php");
    } else {
        echo "Gagal menghapus: " . mysqli_error($koneksi);
    }
} else {
    header("Location: ../pages/riwayat.php");
}
?>