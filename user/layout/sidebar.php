<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>
<body>
    <?php
        $url = "http://localhost/UKK_SITISAHARAKH_XIIPPLG3/user/"
    ?>
    <div class="sidebar">
        <h2>AdminPanel</h2>
        <nav>
            <a href="<?= $url;?>dashboard.php">Dashboard</a>
            <a href="<?= $url;?>">Pengaturan</a>
        </nav>
    </div>
</body>
</html>