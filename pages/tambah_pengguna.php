<?php
include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama_lengkap'];
    $nip      = $_POST['nip'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level    = $_POST['level'];

    mysqli_query($koneksi, "
        INSERT INTO pengguna (nama_lengkap, nip, username, password, level)
        VALUES ('$nama', '$nip', '$username', '$password', '$level')
    ");

    header("Location: daftar_pengguna.php");
}
?>
<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h3 class="mb-3">Tambah Pengguna</h3>

    <form method="post">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

         <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Level</label>
            <select name="level" class="form-control" required>
                <option value="">-- Pilih Level --</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="pimpinan">Pimpinan</option>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">
            Simpan
        </button>
        <a href="daftar_pengguna.php" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

</body>
</html>
<?php include '../layout/footer.php'; ?>