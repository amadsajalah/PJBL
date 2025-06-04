<?php
require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['price'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image_url = '';

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $namaFile = $_FILES['gambar']['name'];
            $tmpFile = $_FILES['gambar']['tmp_name'];
            $folder = 'uploads/';

            $ext = pathinfo($namaFile, PATHINFO_EXTENSION);
            $gambarBaru = uniqid() . '.' . $ext;

            if (move_uploaded_file($tmpFile, $folder . $gambarBaru)) {
                $image_url = $folder . $gambarBaru;
            } else {
                die("Gagal mengunggah gambar.");
            }
        }

        $stmt = $conn->prepare("INSERT INTO products (name, price, image_url) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $price, $image_url);
            if ($stmt->execute()) {
                header("Location: ProdukDashboard.php");
                exit;
            } else {
                echo "Gagal menambahkan produk: " . $stmt->error;
            }
        } else {
            echo "Prepare statement gagal: " . $conn->error;
        }
    } else {
        echo "Field nama produk dan harga wajib diisi.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }

        .btn-group button,
        .btn-group a {
            padding: 10px 18px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
        }

        .btn-save:hover,
        .btn-cancel:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Produk</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Nama Produk:</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Harga:</label>
            <input type="number" name="price" id="price" required>

            <label for="gambar">Gambar Produk:</label>
            <input type="file" name="gambar" id="gambar" accept="image/*">

            <div class="btn-group">
                <button type="submit" class="btn-save">Simpan</button>
                <a href="ProdukDashboard.php" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>