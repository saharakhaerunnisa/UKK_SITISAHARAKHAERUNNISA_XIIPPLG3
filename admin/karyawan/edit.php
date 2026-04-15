<?php
include '../../config.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM karyawan WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $gaji = $_POST['gaji'];

    $sql = "UPDATE karyawan SET nik='$nik', nama='$nama', jabatan='$jabatan', gaji='$gaji' WHERE id='$id'";

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='../dashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <div class="form-card">
        <form action="" method="POST">
            <h2>Tambah Data Karyawan</h2>
            <input type="text" placeholder="NIK" name="nik" value="<?= htmlspecialchars($row['nik'])?>">
            <input type="text" placeholder="Nama Lengkap" name="nama" value="<?= htmlspecialchars($row['nama'])?>">
            <input type="text" placeholder="Jabatan" name="jabatan" value="<?= htmlspecialchars($row['jabatan'])?>">
            <input type="number" placeholder="Gaji" name="gaji" value="<?= htmlspecialchars($row['gaji'])?>">
            <button type="submit" name="update">Update Data</button>
            <br>
            <a href="../dashboard.php">Batal</a>
        </form>
    </div>
    
</body>
</html>