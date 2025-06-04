<?php
include 'db.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'Data transaksi kosong']);
    exit;
}

$order_id = $input['order_id'] ?? '';
$transaction_status = $input['transaction_status'] ?? '';
$gross_amount = $input['gross_amount'] ?? 0;
$payment_type = $input['payment_type'] ?? '';
$transaction_time = $input['transaction_time'] ?? '';
$transaction_id = $input['transaction_id'] ?? '';

// Ganti: data user dikirim dari frontend, bukan dari session
$name = $input['name'] ?? 'Pembeli';
$email = $input['email'] ?? 'guest@example.com';
$phone = $input['phone'] ?? '';

// Simpan ke tabel transaksi
$stmt = $conn->prepare("INSERT INTO transaksi (order_id, name, email, phone, transaction_status, gross_amount, payment_type, transaction_time, transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param(
    "ssssssdss",
    $order_id,
    $name,
    $email,
    $phone,
    $transaction_status,
    $gross_amount,
    $payment_type,
    $transaction_time,
    $transaction_id
);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal simpan transaksi: ' . $stmt->error]);
}
