<?php
include '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST['submit'])) {
    $_SESSION['captcha_a'] = rand(1, 10);
    $_SESSION['captcha_b'] = rand(1, 10);
}

if (isset($_POST['submit'])) {
    $jawaban_user = $_POST['captcha_answer'];
    $jawaban_benar = $_SESSION['captcha_a'] + $_SESSION['captcha_b'];

    if ($jawaban_user != $jawaban_benar) {
        echo "<script>alert('Captcha Salah! Hasil dari {$_SESSION['captcha_a']} + {$_SESSION['captcha_b']} bukan $jawaban_user'); window.history.back();</script>";
        exit();
    }

    $idk = mysqli_real_escape_string($conn, $_POST['idk']);
    $lembur_input = mysqli_real_escape_string($conn, $_POST['lembur']);
    $gaji_pokok = $_POST['gaji_pokok_hidden'];
    $potongan = $_POST['potongan_hidden'];
    $tanggal = date('Y-m-d');

    $nominal_lembur = $lembur_input * 50000;
    $gaji_bersih = ($gaji_pokok + $nominal_lembur) - $potongan;

    $sql_slip = "INSERT INTO slip_gaji (idk, lembur, tanggal, total) 
                 VALUES ('$idk', '$nominal_lembur', '$tanggal', '$gaji_bersih')";

    if (mysqli_query($conn, $sql_slip)) {
        echo "<script>alert('Slip Gaji Berhasil Disimpan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Slip Gaji</title>
    <link rel="stylesheet" href="../../css/input.css">
    <style>
        .calc-box { background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 15px; border: 1px solid #90caf9; }
        .calc-row { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.95em; }
        .total-row { border-top: 2px solid #1e88e5; padding-top: 5px; margin-top: 5px; font-weight: bold; color: #1565c0; }
        .captcha-label { background: #eee; padding: 5px 10px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-card">
        <h3>Input Slip Gaji</h3>
        
        <form action="" method="POST">
            <div class="form-group">
                <label>Pilih Karyawan:</label>
                <select name="idk" id="idk" onchange="updateInfo()" required>
                    <option value="" data-gaji="0" data-pinjam="0">-- Pilih Karyawan --</option>
                    <?php
                    $q = mysqli_query($conn, "SELECT k.id, k.nama, k.gaji, 
                        (SELECT pinjaman FROM peminjaman WHERE idk = k.id AND status = 'approve' LIMIT 1) as pinjam 
                        FROM karyawan k");
                    while($row = mysqli_fetch_assoc($q)) {
                        $p = $row['pinjam'] ?? 0;
                        echo "<option value='{$row['id']}' data-gaji='{$row['gaji']}' data-pinjam='$p'>{$row['nama']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Lembur:</label>
                <input type="number" name="lembur" id="lembur" value="0" oninput="hitungTotal()" required>
            </div>

            <div class="calc-box">
                <div class="calc-row"><span>Gaji Pokok:</span> <span id="view_gaji">Rp0</span></div>
                <div class="calc-row"><span>Bonus Lembur:</span> <span id="view_lembur">Rp0</span></div>
                <div class="calc-row"><span>Potongan Pinjaman:</span> <span id="view_potongan" style="color:red;">- Rp0</span></div>
                <div class="total-row calc-row"><span>Gaji Bersih:</span> <span id="view_total">Rp0</span></div>
            </div>

            <input type="hidden" name="gaji_pokok_hidden" id="gaji_pokok_hidden">
            <input type="hidden" name="potongan_hidden" id="potongan_hidden">

            <hr>
            <div class="form-group">
                <label>Keamanan: Berapa hasil dari <span class="captcha-label"><?= $_SESSION['captcha_a'] ?> + <?= $_SESSION['captcha_b'] ?></span> ?</label>
                <input type="number" name="captcha_answer" placeholder="Jawab di sini..." required>
            </div>

            <button type="submit" name="submit">Proses Slip Gaji</button>
        </form>
    </div>

    <script>
    function updateInfo() {
        const select = document.getElementById('idk');
        const selectedOption = select.options[select.selectedIndex];
        
        const gaji = parseInt(selectedOption.getAttribute('data-gaji'));
        const pinjam = parseInt(selectedOption.getAttribute('data-pinjam'));

        document.getElementById('gaji_pokok_hidden').value = gaji;
        document.getElementById('potongan_hidden').value = pinjam;
        
        hitungTotal();
    }

    function hitungTotal() {
        const gaji = parseInt(document.getElementById('gaji_pokok_hidden').value) || 0;
        const pinjam = parseInt(document.getElementById('potongan_hidden').value) || 0;
        const lemburJml = parseInt(document.getElementById('lembur').value) || 0;
        
        const nominalLembur = lemburJml * 50000;
        const total = (gaji + nominalLembur) - pinjam;

        document.getElementById('view_gaji').innerText = "Rp" + gaji.toLocaleString('id-ID');
        document.getElementById('view_lembur').innerText = "Rp" + nominalLembur.toLocaleString('id-ID');
        document.getElementById('view_potongan').innerText = "- Rp" + pinjam.toLocaleString('id-ID');
        document.getElementById('view_total').innerText = "Rp" + total.toLocaleString('id-ID');
    }
    </script>
</body>
</html>