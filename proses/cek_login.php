<?php 
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// ====================================================
// 1. CEK UNTUK ADMIN (Tabel admin)
// ====================================================
$login_admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
$cek_admin = mysqli_num_rows($login_admin);

if($cek_admin > 0){
    $row = mysqli_fetch_assoc($login_admin);

    if(password_verify($password, $row['password'])){
        
        // SET SESSION ADMIN
        $_SESSION['id_admin']   = $row['id_admin'];
        $_SESSION['username']   = $row['username'];
        $_SESSION['nama_admin'] = $row['nama_lengkap'];
        
        // PASTIIN INI ADA (Agar NIP Admin terbaca)
        $_SESSION['nip']        = $row['nip']; 
        
        $_SESSION['level']      = "admin"; 
        $_SESSION['status']     = "login";

        header("location:../index.php");
        exit;
    }
}

// ====================================================
// 2. CEK UNTUK PETUGAS/PIMPINAN (Tabel pengguna)
// ====================================================
$login_pengguna = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
$cek_pengguna = mysqli_num_rows($login_pengguna);

if($cek_pengguna > 0){
    $row = mysqli_fetch_assoc($login_pengguna);

    if(password_verify($password, $row['password'])){
        
        // SET SESSION PETUGAS/PIMPINAN
        $_SESSION['id_pengguna'] = $row['id_pengguna'];
        $_SESSION['username']    = $row['username'];
        $_SESSION['nama_admin']  = $row['nama_lengkap']; 
        
        // PASTIIN INI JUGA ADA (Agar NIP Petugas terbaca)
        $_SESSION['nip']         = $row['nip']; 
        
        $_SESSION['level']       = $row['level']; 
        $_SESSION['status']      = "login";

        header("location:../index.php");
        exit;
    }
}

// Jika gagal di kedua tabel
header("location:../login.php?pesan=gagal");
exit;
?>