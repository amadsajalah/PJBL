<?php
require_once("db.php");

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$produk_id = intval($_GET['id']);

// Ambil data produk
$query = "SELECT * FROM products WHERE produk_id = $produk_id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Produk tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (empty($name) || empty($price)) {
        echo "Nama produk dan harga wajib diisi.";
    } else {
        $query = "UPDATE products SET 
                    name = '$name',
                    price = '$price'
                  WHERE produk_id = $produk_id";

        if (mysqli_query($conn, $query)) {
            header("Location:ProdukDashboard.php");
            exit;
        } else {
            echo "Gagal mengupdate produk: " . mysqli_error($conn);
        }
    }
}
?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Edit Produk</title>
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
            input[type="number"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 18px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .button-group {
                display: flex;
                justify-content: space-between;
            }

            .button-group button,
            .button-group a {
                padding: 10px 18px;
                text-decoration: none;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-save {
                background-color: #4CAF50;
                color: white;
            }

            .btn-cancel {
                background-color: #f44336;
                color: white;
            }

            .btn-cancel:hover,
            .btn-save:hover {
                opacity: 0.9;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Edit Produk</h2>
            <form method="POST">
                <label for="name">Nama Produk:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($data['name']) ?>" required>

                <label for="price">Harga:</label>
                <input type="number" name="price" id="price" value="<?= $data['price'] ?>" required>

                <div class="button-group">
                    <button type="submit" class="btn-save">Simpan</button>
                    <a href="produkdashboard.php" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </body>
    </html>