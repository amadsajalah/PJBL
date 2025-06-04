<?php


// Aktifkan error reporting (hapus atau matikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai session supaya bisa akses data user
session_start();

// Debug (sementara, hapus di production)
file_put_contents('session-debug.txt', print_r($_SESSION, true));
// Set response header JSON
header('Content-Type: application/json');

// Include Midtrans SDK (pastikan path sesuai dengan file kamu)
require_once __DIR__ . '/../midtrans-php/Midtrans.php';

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-p7wysBtK1rnYkDz9OJpAzYIK';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil data dari POST
$id = $_POST['id'] ?? '';
$jumlah = (int) ($_POST['jumlah'] ?? 1);
$tipe = $_POST['tipe'] ?? 'satuan';
$total = (int) ($_POST['total'] ?? 0);


// Koneksi ke database
require_once __DIR__ . '/../db.php';

// Ambil data produk dari database
$stmt = $conn->prepare("SELECT * FROM products WHERE produk_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    echo json_encode(['error' => 'Produk tidak ditemukan']); exit;
}


// Validasi data
if (!$id || $total <= 0) {
    echo json_encode(['error' => 'Data tidak valid']);
    exit;
}

// Ambil data user dari session, fallback ke default kalau belum login
$user_first_name = $_SESSION['user']['first_name'] ?? 'Pembeli';
$user_last_name = $_SESSION['user']['last_name'] ?? '';
$user_email = $_SESSION['user']['email'] ?? 'pembeli@example.com';
$user_phone = $_SESSION['user']['phone'] ?? '';
$alamat = $_POST['alamat'] ?? '';


// Buat array customer_details sesuai Midtrans docs
$customer_details = [
    'first_name' => $user_first_name,
    'email' => $user_email,
];
if ($user_last_name !== '') {
    $customer_details['last_name'] = $user_last_name;
}
if ($user_phone !== '') {
    $customer_details['phone'] = $user_phone;


}

// Tambahkan alamat pengiriman ke customer_details
$customer_details['address'] = [
    'first_name' => $user_first_name,
    'last_name' => $user_last_name,
    'phone' => $user_phone,
    'address' => $alamat,
    'city' => '',     // optional
    'postal_code' => '',  // optional
    'country_code' => 'IDN'  // optional, kode negara Indonesia
];


// Siapkan parameter transaksi untuk Snap token
$params = [
    'transaction_details' => [
        'order_id' => uniqid('ORDER-'),
        'gross_amount' => (int) $total,
    ],
    'item_details' => [
        [
            'id' => strval($id),
            'price' => (int) ($total / $jumlah),
            'quantity' => (int) $jumlah,
            'name' => substr($produk['name'], 0, 50), // maksimal 50 karakter
        ],
    ],
    'customer_details' => $customer_details,
];


// Generate Snap token dan kirim response JSON
try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo json_encode(['token' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
