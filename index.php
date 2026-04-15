<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
            
            $_SESSION['user_id']  = $row['idk']; 
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($row['role'] == 'karyawan') {
                header("Location: user/dashboard.php");
            }
            exit(); 
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='index.php';</script>";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f7f6;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
}

.form-card {
    width: 350px;
    background: white;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative;
}

.form-card::before {
    display: block;
    font-weight: bold;
    font-size: 18px;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
}

.form-card::after {
    content: "Pastikan data sudah benar.";
    display: block;
    font-size: 11px;
    color: #7f8c8d;
    margin-top: 15px;
    text-align: center;
}

.form-card input  {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box; 
    outline: none;
    transition: 0.3s;
}

.form-card input:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
}

.form-card button {
    width: 100%;
    padding: 12px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
}

.form-card button:hover {
    background-color: #34495e;
}

.form-card a {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
    text-decoration: none;
    background-color: #e74c3c;
    text-align: center; 
    box-sizing: border-box; 
}

.form-card a:hover {
    background-color: #c0392b;
}

    </style>
</head>
<body>
    <div class="form-card">
        <form action="" method="POST">
            <h2>Login</h2>
            <input type="text" placeholder="Username" name="username">
            <input type="password" placeholder="Password" name="password">
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    
</body>
</html>