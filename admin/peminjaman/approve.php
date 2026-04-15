<?php
include '../../config.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$id_pinjaman = $_GET['id'];

if(isset($_POST['update'])) {
    $status_baru = $_POST['status']; 

    $sql_update = "UPDATE peminjaman SET status = '$status_baru' WHERE id = '$id_pinjaman'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Status pinjaman berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$query_data = mysqli_query($conn, "SELECT p.*, k.nama FROM peminjaman p JOIN karyawan k ON p.idk = k.id WHERE p.id = '$id_pinjaman'");
$data = mysqli_fetch_assoc($query_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Pinjaman</title>
    <link rel="stylesheet" href="../../css/input.css">
    <style>
      select  {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box; 
        outline: none;
        transition: 0.3s;
    }
    </style>
</head>
<body>
    <div class="form-card">
        <h3>Persetujuan Pinjaman</h3>
        <hr>
        <p><strong>Nama Karyawan:</strong> <?php echo $data['nama']; ?></p>
        <p><strong>Total Pinjam:</strong> Rp <?php echo number_format($data['pinjaman'], 0, ',', '.'); ?></p>
        <p><strong>Tenor:</strong> <?php echo $data['lama']; ?> Bulan</p>
        
        <form action="" method="POST">
            <div class="form-group">
                <label>Pilih Status:</label><br>
                    <select name="status" class="form-control" required>
                        <option value="pending" <?php if($data['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        
                        <option value="approve" <?php if($data['status'] == 'approve') echo 'selected'; ?>>Setujui (Approved)</option>
                        
                        <option value="rejected" <?php if($data['status'] == 'rejected') echo 'selected'; ?>>Tolak (Rejected)</option>
                    </select>
            </div>
            
            <button type="submit" name="update">Simpan Perubahan</button>
            <a href="index.php" style="display:block; text-align:center; margin-top:10px; color:gray; text-decoration:none;">Batal</a>
        </form>
    </div>
</body>
</html>