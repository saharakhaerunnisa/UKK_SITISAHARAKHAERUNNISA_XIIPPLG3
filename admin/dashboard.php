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
                </div>

                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</body>
</html>