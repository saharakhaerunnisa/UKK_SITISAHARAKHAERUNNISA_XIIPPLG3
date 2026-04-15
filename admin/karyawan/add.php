<?php
include '../../config.php';

if(isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $gaji = $_POST['gaji'];

    $sql_karyawan = "INSERT INTO karyawan (nik, nama, jabatan, gaji) VALUES ('$nik', '$nama', '$jabatan', '$gaji')";

    if ($conn->query($sql_karyawan) === TRUE) {
        $last_id = $conn->insert_id;

        $hashed_password = password_hash($nik, PASSWORD_DEFAULT);
        
        $sql_user = "INSERT INTO user (idk, username, password) 
                    VALUES ('$last_id', '$nama', '$hashed_password')";
        
        if ($conn->query($sql_user) === TRUE) {
            echo "<script>alert('Karyawan berhasil ditambahkan!'); window.location='../dashboard.php';</script>";
        } else {
            echo "Error: " . $sql_user . "<br>" . $conn->error;
        }
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
            <input type="text" placeholder="NIK" name="nik">
            <input type="text" placeholder="Nama Lengkap" name="nama">
            <input type="text" placeholder="Jabatan" name="jabatan">
            <input type="number" placeholder="Gaji" name="gaji">
            <button type="submit" name="submit">Simpan Data</button>
            <br>
            <a href="../dashboard.php">Batal</a>
        </form>
    </div>
    
</body>
</html>