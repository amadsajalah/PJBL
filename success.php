<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="refresh" content="5;url=http://localhost/PJBL/dashboard.php" />
  <title>Pembayaran Berhasil</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fef3c7; /* kuning muda seperti bg-yellow-100 */
      color: #92400e; /* coklat gelap seperti text-yellow-800 */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      text-align: center;
    }
    h1 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
      color: #b45309; /* kuning tua seperti text-yellow-700 */
    }
    p {
      font-size: 1.25rem;
      margin-bottom: 2rem;
      color: #78350f; /* kuning lebih gelap, mirip text-yellow-800 */
    }
    .loader {
      border: 5px solid #fde68a; /* kuning cerah seperti bg-yellow-300 */
      border-top: 5px solid #b45309; /* kuning tua seperti text-yellow-700 */
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <h1>Pembayaran Berhasil</h1>
  <p>Terimakasih atas pembelian Anda.<br>Anda akan diarahkan ke dashboard dalam beberapa detik.</p>
  <div class="loader"></div>

</body>
</html>
