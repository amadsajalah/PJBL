<?php
session_start();
include 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: landingPage.php");
    exit;
}

// Ambil data user
$user_id = $_SESSION['user_id'];
$query = "SELECT first_name FROM users WHERE user_id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Alert jika login sukses (hanya sekali)
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    echo "<script>('$message');</script>";
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php include 'navbar.php'; ?>

<body class="bg-white font-sans">
<!-- Hero Section -->
<div style="background-image: url('images/background.png'); background-size: cover; background-position: center;" class="min-h-screen">
  <section class="flex flex-col md:flex-row justify-between items-center px-6 py-12 max-w-7xl mx-auto">
    <div class="max-w-xl space-y-4">
      <h1 class="text-6xl font-bold leading-tight">
        PILIHAN TERBAIK UNTUK <span class="text-yellow-500">BURUNG</span> <span class="text-sky-500">PELIHARAAN</span> ANDA.
      </h1>
      <div class="flex gap-4 mt-6">
        <a href="produk.php?kategori=Burung" class="bg-yellow-400 px-4 py-2 rounded hover:bg-yellow-200">Lets Go →</a>
        <a href="produk.php?kategori=Burung" class="border px-4 py-2 rounded">Beli Disini Yak 🛒</a>
      </div>
    </div>
    <div class="mt-8 md:mt-0">
      <img src="images/burung.png" alt="Burung" class="w-[500px]" />
    </div>
  </section>
</div>

</body>
</html>
