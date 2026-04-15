<?php
include '../../config.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['username'];

$id = "SELECT id FROM user WHERE username='$user'";

$sql = "SELECT * FROM peminjaman";
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
    <style>
        .edit-btn {
            padding: 6px 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include '../layout/sidebar.php'; ?>
    <div class="main-content">
        <div class="navbar">
            <h3>Ringkasan Data</h3>
            <div class="user-info">Halo, Admin</div>
            <a href="../../index.php" class="logout">Logout</a>
        </div>

        <div class="container">
            <div class="card">
                <div class="search-container">
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari data di tabel..." onkeyup="searchTable()">
                </div>

                <h3>Daftar Peminjaman</h3>
                <br>
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Karyawan</th>
                            <th>Total Pinjaman</th>
                            <th>Tanggal</th>
                            <th>Lama Pinjam</th>
                            <th>Status</th>
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
                            <td><?= htmlspecialchars($row['idk'])?></td>
                            <td>Rp <?= number_format($row['pinjaman'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['tanggal'])?></td>
                            <td><?= htmlspecialchars($row['lama'])?></td>
                            <td><?= htmlspecialchars($row['status'])?></td>
                            <td>
                                <a href="approve.php?id=<?= $row['id']; ?>" class="edit-btn">konfirmasi</a>
                            </td>
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