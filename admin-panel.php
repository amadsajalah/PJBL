<?php
require_once("db.php");

$jumlah_user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$jumlah_alamat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM alamat"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fdfdfd;
        }

        .sidebar {
            width: 220px;
            background: #EBD96B;
            color: #000;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px 0;
            margin: 0;
            border-bottom: 2px solid #d6c25a;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: #000;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #f5e98b;
        }

        .content {
            margin-left: 220px;
            padding: 30px;
        }

        .card {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            border-left: 5px solid #EBD96B;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            margin: 0 0 10px;
            font-size: 20px;
            color: #333;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #000;
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin-panel.php">Dashboard</a>
        <a href="ProdukDashboard.php">Data Produk</a>
        <a href="LoginDashboard.php">Data Pengguna</a>
        <a href="TransaksiDashboard.php">Transaksi</a>
        <a href="AlamatDashboard.php">Alamat</a>
    </div>

    <div class="content">
        <h1>Selamat Datang, Admin!</h1>

        <div class="card">
            <h3>Total Pengguna</h3>
            <p><?= $jumlah_user ?></p>
        </div>

        <div class="card">
            <h3>Total Produk</h3>
            <p><?= $jumlah_produk ?></p>
        </div>

        <div class="card">
            <h3>Total Alamat</h3>
            <p><?= $jumlah_alamat ?></p>
        </div>
    </div>
</body>
</html>
