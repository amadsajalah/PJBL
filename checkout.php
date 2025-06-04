<?php
session_start();
include 'db.php';

// Ambil parameter dari URL
$id = $_GET['produk_id'] ?? null;
$tipe = $_GET['tipe'] ?? 'satuan';
$jumlah = isset($_GET['jumlah']) && is_numeric($_GET['jumlah']) ? (int) $_GET['jumlah'] : 1;

// Validasi ID produk
if (!$id || !is_numeric($id)) {
  die("ID produk tidak valid.");
}

// Cek koneksi database
if (!$conn) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Siapkan dan jalankan query
$stmt = $conn->prepare("SELECT * FROM products WHERE produk_id = ?");
if (!$stmt) {
  die("Kesalahan saat prepare statement: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

// Cek apakah produk ditemukan
if (!$produk) {
  die("Produk tidak ditemukan.");
}

// Atur jumlah berdasarkan tipe
if ($tipe === 'satuan') {
  $jumlah = 1;
} elseif ($jumlah < 2) {
  $jumlah = 2;
}

$total = $produk['price'] * $jumlah;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Checkout - <?= htmlspecialchars($produk['name']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-kO53Z9Kvt_fV7VxE"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-4xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Konfirmasi Pembelian</h1>

    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row gap-6">
      <img src="images/<?= htmlspecialchars($produk['image']) ?>" alt="<?= htmlspecialchars($produk['name']) ?>" class="w-full md:w-60 h-60 object-cover rounded-lg border" />

      <div class="flex-1">
        <h2 class="text-2xl font-semibold text-gray-800"><?= htmlspecialchars($produk['name']) ?></h2>
        <p class="text-gray-600 mt-2"><?= nl2br(htmlspecialchars($produk['description'])) ?></p>

        <div class="mt-4 space-y-1 text-gray-700">
          <p><strong>Harga Satuan:</strong> Rp<?= number_format($produk['price'], 0, ',', '.') ?></p>
          <p><strong>Tipe:</strong> <?= ucfirst($tipe) ?></p>
          <p><strong>Jumlah:</strong> <?= $jumlah ?></p>
        </div>

        <p class="mt-4 text-xl font-bold text-yellow-600">Total: Rp<?= number_format($total, 0, ',', '.') ?></p>

        <div class="mt-2 flex flex-row gap-3">
          <form id="payment-form" action="/PJBL/snap/checkout-process-simple-version.php" method="POST" class="flex-1">
            <input type="hidden" name="id" value="<?= $produk['produk_id'] ?>" />
            <input type="hidden" name="jumlah" value="<?= $jumlah ?>" />
            <input type="hidden" name="tipe" value="<?= $tipe ?>" />
            <input type="hidden" name="total" value="<?= $total ?>" />

            <button type="submit" id="pay-button"
              class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg font-semibold transition">
              Bayar Sekarang
            </button>
          </form>

          <a href="produk_detail.php?id=<?= $produk['produk_id'] ?>"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg font-semibold transition self-center">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);

      fetch(form.action, {
        method: 'POST',
        body: formData
      })
      .then(res => res.text())
      .then(text => {
        try {
          const data = JSON.parse(text);
          if (data.token) {
            snap.pay(data.token, {
              onSuccess: function(result) {
                // Kirim data transaksi ke server untuk simpan ke DB
                fetch('save-transaction.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify(result)
                })
                .then(res => res.json())
                .then(response => {
                  if (response.status === 'success') {
                    window.location.href = "success.php";
                  } else {
                    alert('Gagal menyimpan transaksi: ' + response.message);
                  }
                })
                .catch(() => {
                  alert('Terjadi kesalahan saat menyimpan transaksi.');
                });
              },
              onPending: function(result) {
                alert("Pembayaran sedang diproses.");
              },
              onError: function(result) {
                alert("Terjadi kesalahan saat pembayaran.");
              },
              onClose: function() {
                alert("Anda menutup popup pembayaran tanpa menyelesaikan pembayaran.");
              }
            });
          } else {
            alert("Gagal membuat transaksi: " + (data.error || 'Token kosong'));
          }
        } catch (e) {
          alert("Respon bukan JSON:\n" + text);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Error koneksi ke server.");
      });
    });
  </script>
</body>
</html>
