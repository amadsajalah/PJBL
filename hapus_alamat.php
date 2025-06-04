<?php
require_once("db.php");

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}
$id = intval($_GET['id']);

$query = "DELETE FROM alamat WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: AlamatDashboard.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>