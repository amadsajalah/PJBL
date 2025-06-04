<?php
session_start();
include 'db.php';

// Ambil filter kategori & subkategori
$kategori = $_GET['kategori'] ?? null;
$search = $_GET['search'] ?? null;

$where = [];

if (!empty($kategori) && strtolower($kategori) !== 'semua') {
  $kategori = $conn->real_escape_string($kategori);
  $where[] = "LOWER(c.name) = LOWER('$kategori')";
}

if ($search) {
  $search = $conn->real_escape_string($search);
$where[] = "(p.subcategory LIKE '%$search%' OR p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$query = "
  SELECT p.*, c.name AS category_name
  FROM products p
  LEFT JOIN categories c ON p.category_id = c.id
  $whereSQL 
  ORDER BY p.created_at DESC
";

$result = $conn->query($query);
$kategori_lower = $kategori ? strtolower($kategori) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Toko - Aryo Sae Gage</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">

<!-- navbar -->
<header class="bg-white sticky top-0 z-50 shadow">
  <div class="max-w-screen-xl mx-auto px-6 py-4 flex justify-between items-center">
    <div class="flex items-center gap-2">
      <img src="images/logo.png" alt="Logo" class="w-10 h-10">
      <span class="font-bold text-lg">ARYO SAE GAGE</span>
    </div>
    <nav class="flex gap-6 text-sm text-gray-700 items-center">
      <a href="dashboard.php" class="hover:underline">Beranda</a>
      <div class="relative group inline-block">
        <a href="#" class="hover:underline">Toko ▼</a>
        <ul class="absolute hidden group-hover:block bg-white shadow rounded mt-0.5 w-48 z-50">
          <li><a href="produk.php?kategori=Burung" class="block px-4 py-2 hover:bg-gray-100">Burung Peliharaan</a></li>
          <li><a href="produk.php?kategori=Kandang" class="block px-4 py-2 hover:bg-gray-100">Kandang Burung</a></li>
          <li><a href="produk.php?kategori=Peralatan" class="block px-4 py-2 hover:bg-gray-100">Peralatan Rawat Burung</a></li>
          <li><a href="produk.php?kategori=Pakan" class="block px-4 py-2 hover:bg-gray-100">Pakan Burung</a></li>
        </ul>
      </div>
      <a href="tentang_kami.php" class="hover:underline">Tentang Kami</a>
      <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
    </nav>
  </div>
</header>

<?php
$subcategories_by_kategori = [
  'burung' => ['Lovebird', 'Kenari', 'Kacer', 'Ciblek', 'Murai Batu', 'Sirtu', 'Deruk', 'Perkutut', 'Kutilang'],
  'kandang' => ['Kayu', 'Plastik', 'besi',],
  'pakan' => ['Serangga', 'Buah', 'Sayur', 'Pur',],
  'peralatan' => ['Alat', 'Obat', 'Wadah',]
];

switch ($kategori_lower) {
  case 'burung':
    $judul = "Temukan Burung Menarik Impian Kamu";
    $subjudul = "Cari dan temukan burung eksotis yang cocok untukmu. Nikmati keindahan dan pesona mereka sekarang!";
    break;
  case 'kandang':
    $judul = "Kandang Burung Berkualitas";
    $subjudul = "Lindungi dan rawat burung kesayanganmu dengan kandang yang nyaman dan aman.";
    break;
  case 'pakan':
    $judul = "Pakan Bernutrisi untuk Burung";
    $subjudul = "Berikan nutrisi terbaik agar burungmu selalu sehat dan aktif.";
    break;
  case 'peralatan':
    $judul = "Peralatan Perawatan Burung";
    $subjudul = "Buat perawatan harian jadi mudah dengan peralatan terbaik.";
    break;
  default:
    $judul = "Temukan Produk Terbaik";
    $subjudul = "Jelajahi berbagai produk unggulan untuk burung kesayanganmu.";
    break;
}
?>

<section class="text-center py-6 bg-gray-50">
  <h1 class="text-2xl font-bold mb-2"><?= $judul ?></h1>
  <h2 class="text-gray-700"><?= $subjudul ?></h2>
</section>

<?php if (!empty($kategori_lower) && isset($subcategories_by_kategori[$kategori_lower])): ?>
  <form method="GET" class="mt-2 max-w-md mx-auto">
    <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
    <div class="flex items-center gap-2">
      <input type="text" name="search" placeholder="Cari <?= $kategori_lower ?>..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" />
      <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500">Cari</button>
    </div>
  </form>

  <form method="GET" class="mt-4 flex flex-wrap justify-center gap-2">
    <?php
      $subs = $subcategories_by_kategori[$kategori_lower];
      $activeSearch = $_GET['search'] ?? '';
      $classSemua = $activeSearch === '' ? 'bg-yellow-400 text-white' : 'bg-gray-200 text-black hover:bg-yellow-300';
      echo "<a href='produk.php?kategori=$kategori' class='px-4 py-1 rounded $classSemua text-sm'>Semua</a>";

      foreach ($subs as $s) {
        $isActive = strtolower($activeSearch) === strtolower($s);
        $class = $isActive ? 'bg-yellow-400 text-white' : 'bg-gray-200 text-black hover:bg-yellow-300';
        echo "<a href='produk.php?kategori=$kategori&search=$s' class='px-4 py-1 rounded $class text-sm'>$s</a>";
      }
    ?>
  </form>
<?php elseif (!$kategori): ?>
  <form method="GET" class="mt-4 max-w-md mx-auto">
    <div class="flex items-center gap-2">
      <input type="text" name="search" placeholder="Cari produk..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" />
      <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500">Cari</button>
    </div>
  </form>
<?php endif; ?>

<!--GRID PRODUK -->
<main class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
  <?php while($row = $result->fetch_assoc()): ?>
    <div class="bg-white rounded-lg shadow p-4 border border-gray-40">
      <img src="images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-full h-48 object-cover rounded mb-4">
      <h2 class="text-xl font-semibold"><?= htmlspecialchars($row['name']) ?></h2>
      <p class="text-gray-600 text-sm"><?= htmlspecialchars($row['description']) ?></p>
      <p class="text-yellow-500 font-bold text-lg mt-2">Rp<?= number_format($row['price'], 0, ',', '.') ?></p>
      <a href="produk_detail.php?id=<?= $row['produk_id'] ?>" class="inline-block mt-3 bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500 text-sm">Beli Sekarang</a>
    </div>
  <?php endwhile; ?>
</main>

<?php
$kategori_list = ['burung', 'kandang', 'pakan', 'peralatan'];
$current_index = array_search(strtolower($kategori), $kategori_list);
$prev_kategori = $current_index > 0 ? $kategori_list[$current_index - 1] : null;
$next_kategori = $current_index !== false && $current_index < count($kategori_list) - 1 ? $kategori_list[$current_index + 1] : null;
?>

<!-- Navigasi Antar Kategori -->
<section class="mt-12 max-w-7xl mx-auto px-6">
  <div class="flex justify-between">
    <?php if ($prev_kategori): ?>
      <a href="produk.php?kategori=<?= ucfirst($prev_kategori) ?>" class="px-5 py-2 bg-gray-200 text-black rounded hover:bg-yellow-400">← <?= ucfirst($prev_kategori) ?></a>
    <?php else: ?>
      <div></div>
    <?php endif; ?>

    <?php if ($next_kategori): ?>
      <a href="produk.php?kategori=<?= ucfirst($next_kategori) ?>" class="px-5 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500"><?= ucfirst($next_kategori) ?> →</a>
    <?php endif; ?>
  </div>
</section>

</body>
</html>
