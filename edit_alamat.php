<?php
require_once("db.php");

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}
$id = intval($_GET['id']);

$query = "SELECT * FROM alamat WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $kodepos = $_POST['kodepos'];
    $telepon  = $_POST['telepon'];

    $update = "UPDATE alamat SET id='$user_id', alamat='$alamat', kota='$kota', kodepos='$kode_pos' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: AlamatDashboard.php");
        exit;
    } else {
        echo "Gagal mengedit alamat: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Alamat</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            padding: 40px;
        }

        .container {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007BFF;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007BFF;
            outline: none;
        }

        .btn-group {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 500px) {
            .btn-group {
                flex-direction: column;
            }
            .btn-group .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Alamat Pengguna</h2>
        <form method="POST">
            <label for="id">User ID:</label>
            <input type="text" name="id" id="id" value="<?= htmlspecialchars($data['id']) ?>" required>

            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>

            <label for="kota">Kota:</label>
            <input type="text" name="kota" id="kota" value="<?= htmlspecialchars($data['kota']) ?>" required>

            <label for="kode_pos">Kode Pos:</label>
            <input type="text" name="kode_pos" id="kode_pos" value="<?= htmlspecialchars($data['kodepos']) ?>" required>

            <label for="ponsel">Nomor telepon</label>
            <input type="text" name="telepon" id="telepon" value="<?= htmlspecialchars($data['telepon']) ?>" required>

            <div class="btn-group">
                <button type="submit" class="btn btn-save">Simpan</button>
                <a href="AlamatDashboard.php" class="btn btn-cancel"> Batal</a>
            </div>
        </form>
    </div>
</body>
</html>