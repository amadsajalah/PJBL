<?php
session_start();
require_once 'db.php'; // arahkan ke file koneksi kamu

$data = json_decode(file_get_contents("php://input"), true);

$order_id = $data['order_id'];
$total = $data['total'];

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "User belum login."]);
    exit;
}

foreach ($cart as $item) {
    $nama = $item['name'];
    $jumlah = $item['qty'];
    $harga = $item['price'];
    $subtotal = $jumlah * $harga;   

    $query = "INSERT INTO data_pesanan (order_id, nama_produk, jumlah, harga, total, user_id)
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiiii", $order_id, $nama, $jumlah, $harga, $subtotal, $user_id);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
?>