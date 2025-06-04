<header class="bg-white sticky top-0 z-50 shadow">
  <div class="max-w-screen-xl mx-auto px-6 py-4 flex justify-between items-center">
    <!-- Logo -->
    <div class="flex items-center gap-2">
      <img src="images/logo.png" alt="Logo" class="w-10 h-10">
      <span class="font-bold text-lg">ARYO SAE GAGE</span>
    </div>

    <!-- Navbar -->
    <nav class="flex gap-6 text-sm text-gray-700 items-center">
      <a href="dashboard.php" class="hover:underline">Beranda</a>
      <div class="relative group inline-block">
        <a href="produk.php" class="hover:underline">Toko ▼</a>
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
