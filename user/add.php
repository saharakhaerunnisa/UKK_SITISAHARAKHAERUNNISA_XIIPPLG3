<?php
include '../config.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'karyawan') {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['submit'])) {
    $idk = $_SESSION['user_id'];
    $pinjaman = $_POST['pinjaman'];
    $tanggal = $_POST['tanggal'];
    $lama = $_POST['lama'];
    $status = 'pending';

    $sql_pinjaman = "INSERT INTO peminjaman (idk, pinjaman, tanggal, lama, status) VALUES ('$idk', '$pinjaman', '$tanggal', '$lama', '$status')";

    if (mysqli_query($conn, $sql_pinjaman)) {
        echo "<script>alert('Pinjaman berhasil diajukan!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $sql_pinjaman . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Pinjam Uang</title>
    <link rel="stylesheet" href="../css/input.css">
</head>
<body>
    <div class="form-card">
        <form action="add.php" method="POST">
            <div class="form-group">
                <label>Nama Karyawan:</label>
                <br>
                <input type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly><br>
                <input type="hidden" name="idk" value="<?php echo $_SESSION['user_id']; ?>">
                <label for="tanggal">Tanggal Pinjaman:</label>
                <br>
                <input type="date" name="tanggal" required>
                <label for="lama">Lama Pinjam (bulan):</label>
                <br>
                <input type="number" name="lama" placeholder="Lama Pinjam (bulan)" required>

            </div>

            <div class="form-group">
                <label>Pinjaman:</label><br>
                <input type="number" name="pinjaman" required>
            </div>
            
            <button type="submit" name="submit">Ajukan Pinjaman</button>
        </form>
    </div>
    
</body>
</html>