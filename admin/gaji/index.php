<?php
include '../../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}



$sql = "SELECT * FROM slip_gaji";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/sidebar.css">

</head>
<body>
    <?php include '../layout/sidebar.php'; ?>
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
                    <a href="add.php" class="btn">Tambah Data</a>
                    <a href="export_excel.php" class="btn-export" style="padding: 10px 15px; background: #2e7d32; color: white; text-decoration: none; border-radius: 5px;">
                        📥 Export ke Excel
                    </a>
                </div>

                <h3>Daftar Karyawan</h3>
                <br>
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Karyawan</th>
                            <th>ID Peminjaman</th>
                            <th>Lembur</th>
                            <th>Tanggal</th>
                            <th>Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) :
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id'])?></td>
                            <td><?= htmlspecialchars($row['idk'])?></td>
                            <td><?= $row['idp'] ?? 'Tidak Ada Peminjaman'?></td>
                            <td>Rp<?= number_format($row['lembur'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['tanggal'])?></td>
                            <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
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