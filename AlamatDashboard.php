<?php
require_once("db.php");

$query = "SELECT * FROM alamat ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Alamat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #fdfdfd;
        }

        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px #ccc;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #EBD96B;
            color: #000;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .btn {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .btn-edit {
            background-color: #3498db;
            color: white;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-back {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            background: #EBD96B;
            color: black;
            text-decoration: none;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            font-weight: bold;
            z-index: 1000;
            transition: opacity 0.3s ease;
        }

        .btn-edit:hover,
        .btn-delete:hover,
        .btn-back:hover {
            opacity: 0.85;
        }

        h2 {
            text-align: center;
            margin-top: 80px;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>

<body>

    <a href="admin-panel.php" class="btn-back">← Kembali</a>

    <h2>Data Alamat Pengguna</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>No HP</th>
                <th>Provinsi</th>
                <th>Kota</th>
                <th>Kecamatan</th>
                <th>Kode Pos</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['telepon']) ?></td>
                        <td><?= htmlspecialchars($row['provinsi']) ?></td>
                        <td><?= htmlspecialchars($row['kota']) ?></td>
                        <td><?= htmlspecialchars($row['kecamatan']) ?></td>
                        <td><?= htmlspecialchars($row['kodepos']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td>
                            <a href="edit_alamat.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus_alamat.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Tidak ada data alamat</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>
