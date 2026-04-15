<?php
include '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak.");
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Slip_Gaji.xls");

$query = "SELECT s.*, k.nama FROM slip_gaji s JOIN karyawan k ON s.idk = k.id ORDER BY s.tanggal DESC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="../../css/dashboard.css">
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Karyawan</th>
            <th>ID Peminjaman</th>
            <th>Nominal Lembur</th>
            <th>Tanggal Slip</th>
            <th>Gaji Bersih (Total)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td> <td><?= $row['idp'] ?? '-' ?></td>
            <td><?= $row['lembur'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['total'] ?></td>
        </tr>
        <?php
            endwhile;
        }
        ?>
    </tbody>
</table>