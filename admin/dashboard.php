<?php
include '../config.php';

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM karyawan WHERE id='$id'");
    header("Location: dashboard.php");
    exit();
}


$sql = "SELECT * FROM karyawan";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/sidebar.css">

</head>
<body>
    <?php include 'layout/sidebar.php'; ?>
    <div class="main-content">
        <div class="navbar">
            <h3>Ringkasan Data</h3>
            <div class="user-info">Halo, Admin</div>
            <a href="../index.php" class="logout">Logout</a>
        </div>

        <div class="container">
            <div class="card">
                <div class="search-container">
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari data di tabel..." onkeyup="searchTable()">
                    <a href="karyawan/add.php" class="btn">Tambah Data</a>
                </div>

                <h3>Daftar Karyawan</h3>
                <br>
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) :
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id'])?></td>
                            <td><?= htmlspecialchars($row['nik'])?></td>
                            <td><?= htmlspecialchars($row['nama'])?></td>
                            <td><?= htmlspecialchars($row['jabatan'])?></td>
                            <td>Rp<?= number_format($row['gaji'], 0, ',', '.') ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                                <a href="dashboard.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </tr>
                        <?php
                                endwhile;
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</body>
</html>