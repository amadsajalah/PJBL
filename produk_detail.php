<?php
session_start();
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: alamat.php");
  exit;
}

$stmt = $conn->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.produk_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "Produk tidak ditemukan.";
  exit;
}

$produk = $result->fetch_assoc();

// Dummy data ulasan
$ulasan = [
  [
    'user' => 'Matonde',
    'date' => 'Yesterday',
    'rating' => 5,
    'review' => 'Banyak sekali macam burung yang unik dan pastinya sangat cantik, dan juga toko disini sangat lengkap berbagai pakan dan perlengkapan lainnya. Pokoknya Gacor deh 😁',
    'likes' => 20,
    'replies' => 3
  ],
  [
    'user' => 'Edward Newgate',
    'date' => 'Yesterday',
    'rating' => 4,
    'review' => 'Burungnya aktif, sesuai deskripsi. Terima kasih!',
    'likes' => 20,
    'replies' => 3
  ],
  [
    'user' => 'Matonde',
    'date' => '3 days ago',
    'rating' => 3,
    'review' => 'Kenari yang saya terima suaranya tidak sesuai harapan.',
    'likes' => 20,
    'replies' => 3
  ],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($produk['name']) ?> - Detail Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">

<header class="bg-white shadow">
  <div class="max-w-screen-xl mx-auto px-6 py-4 flex justify-between items-center">
    <div class="flex items-center gap-2">
      <img src="images/logo.png" alt="Logo" class="w-10 h-10">
      <span class="font-bold text-lg">ARYO SAE GAGE</span>
    </div>
    <nav class="flex gap-6 text-sm text-gray-700 items-center">
      <a href="dashboard.php" class="hover:underline">Beranda</a>
      <a href="produk.php" class="hover:underline">Toko</a>
      <a href="tentang_kami.php" class="hover:underline">Tentang Kami</a>
      <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
    </nav>
  </div>
</header>

<section class="max-w-6xl mx-auto px-6 py-8">
  <div class="grid md:grid-cols-2 gap-10">
    <img src="images/<?= htmlspecialchars($produk['image']) ?>" alt="<?= htmlspecialchars($produk['name']) ?>" class="w-full h-auto rounded shadow">

    <div>
      <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($produk['name']) ?></h1>
      <div class="flex items-center gap-2 text-yellow-400 text-sm mb-2">
        <?php for ($i = 0; $i < 5; $i++): ?>
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431 8.2 1.191-5.934 5.782 1.4 8.169L12 18.896l-7.334 3.864 1.4-8.169L.132 9.209l8.2-1.191z"/></svg>
        <?php endfor; ?>
        <span class="text-gray-600 ml-1 text-sm">12 Review</span>
      </div>

      <p class="text-yellow-500 text-2xl font-bold mb-4">Rp<?= number_format($produk['price'], 0, ',', '.') ?></p>

      <p class="mb-4 text-gray-700"><strong>Deskripsi :</strong><br><?= nl2br(htmlspecialchars($produk['description'])) ?></p>
<form action="alamat.php" method="GET" id="form-beli" class="space-y-4">
  <input type="hidden" name="produk_id" value="<?= $produk['produk_id'] ?>">

  <div class="flex gap-2">
    <label>
      <input type="radio" name="tipe" value="satuan" class="peer hidden" checked>
      <div class="peer-checked:bg-yellow-100 border border-gray-300 px-3 py-1 rounded text-sm cursor-pointer">Satuan</div>
    </label>
    <label>
      <input type="radio" name="tipe" value="borongan" class="peer hidden">
      <div class="peer-checked:bg-yellow-100 border border-gray-300 px-3 py-1 rounded text-sm cursor-pointer">Borongan</div>
    </label>
  </div>

  <div id="jumlah-wrapper" class="hidden">
    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
    <input type="number" name="jumlah" min="2" value="2" class="mt-1 w-24 border border-gray-300 rounded px-2 py-1 text-sm">
  </div>

  <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded text-sm font-semibold">
    Beli Sekarang
  </button>
</form>

<script>
  const tipeRadios = document.querySelectorAll('input[name="tipe"]');
  const jumlahWrapper = document.getElementById('jumlah-wrapper');

  tipeRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.value === 'borongan' && radio.checked) {
        jumlahWrapper.classList.remove('hidden');
      } else {
        jumlahWrapper.classList.add('hidden');
      }
    });
  });
</script>
 
    </div>
  </div>

  <!-- ULASAN -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-4">Ulasan</h2>
    <div class="space-y-6">
      <?php foreach ($ulasan as $u): ?>
        <div class="border-b pb-4">
          <div class="flex items-center gap-4 mb-2">
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
            <div>
              <p class="font-semibold"><?= htmlspecialchars($u['user']) ?></p>
              <p class="text-xs text-gray-500"><?= $u['date'] ?></p>
            </div>
          </div>
          <div class="flex items-center text-yellow-400 mb-1">
            <?php for ($i = 0; $i < $u['rating']; $i++): ?>
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z"/></svg>
            <?php endfor; ?>
          </div>
          <p class="text-gray-700 italic mb-2">"<?= htmlspecialchars($u['review']) ?>"</p>
          <div class="text-xs text-gray-500 flex gap-4">
            <span>👍 <?= $u['likes'] ?></span>
            <span>💬 <?= $u['replies'] ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

</body>
</html>
