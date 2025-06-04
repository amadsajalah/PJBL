<?php
session_start();
include 'db.php';

$user = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT first_name FROM users WHERE user_id = $user_id");
    $user = $result->fetch_assoc();
}
$is_logged_in = $user ? 'true' : 'false'; // untuk javascript
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Landing Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">
  
<?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?> 
  <script>
    alert("Berhasil daftar! Silakan login.");
  </script>
<?php endif; ?>

<!-- Header -->
<header class="flex items-center justify-between px-6 py-4 shadow">
  <div class="flex items-center gap-2">
    <img src="images/logo.png" alt="Logo" class="w-10 h-10" />
    <span class="font-bold text-lg">ARYO SAE GAGE</span>
  </div>
  <nav class="hidden md:flex gap-6 text-sm text-gray-700">
    <a href="#" id="navBeranda">Beranda</a>
    <a href="#" id="navToko">Toko</a>
    <a href="#" id="navTentang">Tentang Kami</a>
  </nav>
  <div class="flex gap-2">
    <?php if ($user): ?>
      <a href="logout.php" class="bg-yellow-300 text-black px-4 py-1 rounded hover:bg-yellow-400">Logout</a>
    <?php else: ?>
      <button id="registerBtn" class="bg-yellow-200 text-black px-4 py-1 rounded hover:bg-yellow-300">Daftar</button>
      <button id="loginBtn" class="border border-yellow-300 px-4 py-1 rounded hover:bg-gray-100">Masuk</button>
    <?php endif; ?>
  </div>
</header>

<!-- Background + Hero -->
<div style="background-image: url('images/background.png'); background-size: cover; background-position: center;" class="min-h-screen">
  <section class="flex flex-col md:flex-row justify-between items-center px-6 py-12 max-w-7xl mx-auto">
    <div class="max-w-xl space-y-4">
      <h1 class="text-6xl font-bold leading-tight">
        PILIHAN TERBAIK UNTUK <span class="text-yellow-500">BURUNG</span> <span class="text-sky-500">PELIHARAAN</span> ANDA.
      </h1>
      <div class="flex gap-4 mt-6">
        <button id="ctaGo" class="bg-yellow-400 px-4 py-2 rounded hover:bg-yellow-200">Lets Go →</button>
        <button id="ctaBuyNow" class="border px-4 py-2 rounded">Beli Disini Yak 🛒</button>
      </div>
    </div>
    <div class="mt-8 md:mt-0">
      <img src="images/burung.png" alt="Burung" class="w-[500px]" />
    </div>
  </section>
</div>

<!-- Modal Login -->
<div id="loginModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
  <div class="bg-white p-8 rounded-lg w-[350px] relative">
    <button id="closeModal" class="absolute top-2 right-2 text-gray-500 text-xl hover:text-black">×</button>
    <h2 class="text-center text-xl font-bold mb-1">Silahkan Login</h2>
    <p class="text-center text-sm text-gray-400 mb-4">Pastikan isi username dan password dengan benar</p>
    <form class="space-y-4" method="POST" action="login.php">
      <div>
        <label class="text-sm">Email</label>
        <input name="email" type="email" placeholder="Masukkan Email" class="w-full border rounded px-3 py-2 mt-1" required>
      </div>
      <div>
        <label class="text-sm">Password</label>
        <input name="password" type="password" id="passwordKu" placeholder="Masukkan Password" class="w-full border rounded px-3 py-2 mt-1" required>
        <label class="inline-flex items-center mt-1 cursor-pointer">
          <input type="checkbox" onclick="showHide()" class="mr-2">
          <span class="text-sm select-none">Tampilkan Password</span>
        </label>
      </div>
      <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black py-2 rounded">Masuk</button>
    </form>
    <p class="text-center text-sm mt-4">
      Belum punya akun?
      <button id="registerBtnFromLogin" class="text-yellow-500 underline hover:text-yellow-600">Silahkan Registrasi…</button>
    </p>
  </div>
</div>

<!-- Modal Register -->
<div id="registerModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-xl w-full max-w-md p-6 relative">
    <button id="closeRegisterModal" class="absolute top-4 right-4 text-xl text-gray-600 hover:text-black">×</button>
    <h2 class="text-2xl font-bold text-center mb-1">Buat Akun Baru</h2>
    <p class="text-sm text-center text-gray-400 mb-6">Daftarkan dirimu & lengkap data diri bersama kami</p>
    <form class="space-y-4" method="POST" action="register.php">
      <div class="flex gap-2">
        <input name="first_name" type="text" placeholder="Nama Depan" class="w-1/2 border rounded px-4 py-2" required>
        <input name="last_name" type="text" placeholder="Nama Belakang" class="w-1/2 border rounded px-4 py-2" required>
      </div>
      <input name="birth_date" type="date" class="w-full border rounded px-4 py-2" required>
      <input name="email" type="email" placeholder="Masukkan Email" class="w-full border rounded px-4 py-2" required>
      <input name="password" type="password" placeholder="Masukkan Password" class="w-full border rounded px-4 py-2" required>
      <button type="submit" class="w-full bg-yellow-400 text-black py-2 rounded hover:bg-yellow-500">Daftar</button>
    </form>
  </div>
</div>

<!-- Script Modal Logic dan Cek Login -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const closeModal = document.getElementById('closeModal');

    const registerBtn = document.getElementById('registerBtn');
    const registerModal = document.getElementById('registerModal');
    const closeRegisterModal = document.getElementById('closeRegisterModal');
    const registerBtnFromLogin = document.getElementById('registerBtnFromLogin');

    loginBtn?.addEventListener('click', () => loginModal.classList.remove('hidden'));
    closeModal?.addEventListener('click', () => loginModal.classList.add('hidden'));
    registerBtn?.addEventListener('click', () => registerModal.classList.remove('hidden'));
    closeRegisterModal?.addEventListener('click', () => registerModal.classList.add('hidden'));
    registerBtnFromLogin?.addEventListener('click', () => {
      loginModal.classList.add('hidden');
      registerModal.classList.remove('hidden');
    });

    window.showHide = function () {
      const inputan = document.getElementById("passwordKu");
      if (inputan) {
        inputan.type = inputan.type === "password" ? "text" : "password";
      }
    };

    const isLoggedIn = <?= $is_logged_in ?>;

    // Tombol call-to-action
    const ctaGo = document.getElementById("ctaGo");
    const ctaBuyNow = document.getElementById("ctaBuyNow");

    [ctaGo, ctaBuyNow].forEach(btn => {
      btn?.addEventListener("click", () => {
        if (!isLoggedIn) {
          alert("Silakan login terlebih dahulu untuk melanjutkan.");
        } else {
          // Redirect jika sudah login (opsional)
          // window.location.href = "toko.php";
        }
      });
    });

    // Navbar links
    const navLinks = ["navBeranda", "navToko", "navTentang"];
    navLinks.forEach(id => {
      const el = document.getElementById(id);
      el?.addEventListener("click", (e) => {
        if (!isLoggedIn) {
          e.preventDefault();
          alert("Silakan login terlebih dahulu untuk melanjutkan.");
        } else {
          // Redirect ke halaman masing-masing
          // if (id === "navToko") window.location.href = "toko.php";
        }
      });
    });
  });
</script>

</body>
</html>
