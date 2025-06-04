
<?php
require_once("db.php");

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$produk_id = intval($_GET['id']);

$query = "SELECT image FROM products WHERE produk_id = $produk_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("Produk dengan ID $produk_id tidak ditemukan di database.");
}

$data = mysqli_fetch_assoc($result);

if (!empty($data['image_url']) && file_exists("uploads/" . $data['image_url'])) {
    unlink("uploads/" . $data['image_url']);
}   

$delete = "DELETE FROM products WHERE produk_id = $produk_id";
if (mysqli_query($conn, $delete)) {
    header("Location: ProdukDashboard.php");
    exit;
} else {
    echo "Gagal menghapus produk: " . mysqli_error($conn);
}
?>