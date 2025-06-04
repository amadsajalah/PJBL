<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Alamat</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-top: 40px;
            font-size: 24px;
        }

        form {
            width: 90%;
            max-width: 500px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #f5a623;
            box-shadow: 0 0 5px rgba(245, 166, 35, 0.7);
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .submit-button {
            width: 100%;
            padding: 15px;
            background-color: #f5a623;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #e0911b;
        }
    </style>
</head>

<body>

    <h1>Daftar Alamat</h1>

    <form id="alamatForm">

        <input type="hidden" id="produk_id" value="<?= $_GET['produk_id'] ?? '' ?>">
        <input type="hidden" id="tipe" value="<?= $_GET['tipe'] ?? 'satuan' ?>">
        <input type="hidden" id="jumlah" value="<?= $_GET['jumlah'] ?? 1 ?>">


        <div class="form-group">
            <label for="telepon">No. Telepon</label>
            <input type="tel" id="telepon" name="telepon" required pattern="[0-9]{10,}" />
        </div>

        <div class="form-group">
            <label for="provinsi">Provinsi</label>
            <select id="provinsi" name="provinsi" required>
                <option value="">Pilih Provinsi</option>
                <option value="Jawa Barat">Jawa Barat</option>
                <option value="Jawa Tengah">Jawa Tengah</option>
                <option value="DKI Jakarta">DKI Jakarta</option>
            </select>
        </div>

        <div class="form-group">
            <label for="kota">Kota/Kabupaten</label>
            <select id="kota" name="kota" required>
                <option value="">Pilih Kota/Kabupaten</option>
            </select>
        </div>

        <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <select id="kecamatan" name="kecamatan" required>
                <option value="">Pilih Kecamatan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="kodepos">Kode Pos</label>
            <input type="text" id="kodepos" name="kodepos" required pattern="^[0-9]{5}$" />
        </div>

        <div class="form-group">
            <label for="alamat">Alamat Lengkap</label>
            <textarea id="alamat" name="alamat" placeholder="Nama gedung, jalan dan lainnya..." required></textarea>
        </div>

         <button type="submit" class="submit-button">Kirim</button>
    </form>

    <script>
        const dataWilayah = {
            "Jawa Barat": {
                "Bandung": ["Coblong", "Sukajadi", "Cicendo"],
                "Bekasi": ["Bekasi Selatan", "Bekasi Timur", "Bekasi Utara"]
            },
            "Jawa Tengah": {
                "Semarang": ["Candisari", "Gajahmungkur", "Tembalang"],
                "Surakarta": ["Laweyan", "Pasar Kliwon", "Serengan"]
            },
            "DKI Jakarta": {
                "Jakarta Selatan": ["Kebayoran Baru", "Mampang Prapatan", "Pancoran"],
                "Jakarta Timur": ["Cakung", "Duren Sawit", "Jatinegara"]
            }
        };

        function updateKota() {
            const provinsi = document.getElementById('provinsi').value;
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            if (provinsi && dataWilayah[provinsi]) {
                Object.keys(dataWilayah[provinsi]).forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota;
                    option.textContent = kota;
                    kotaSelect.appendChild(option);
                });
            }
        }

        function updateKecamatan() {
            const provinsi = document.getElementById('provinsi').value;
            const kota = document.getElementById('kota').value;
            const kecamatanSelect = document.getElementById('kecamatan');
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            if (provinsi && kota && dataWilayah[provinsi][kota]) {
                dataWilayah[provinsi][kota].forEach(kecamatan => {
                    const option = document.createElement('option');
                    option.value = kecamatan;
                    option.textContent = kecamatan;
                    kecamatanSelect.appendChild(option);
                });
            }
        }

        document.getElementById('provinsi').addEventListener('change', updateKota);
        document.getElementById('kota').addEventListener('change', updateKecamatan);

        document.getElementById('alamatForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                telepon: document.getElementById('telepon').value.trim(),
                provinsi: document.getElementById('provinsi').value.trim(),
                kota: document.getElementById('kota').value.trim(),
                kecamatan: document.getElementById('kecamatan').value.trim(),
                kodepos: document.getElementById('kodepos').value.trim(),
                alamat: document.getElementById('alamat').value.trim(),
                produk_id: document.getElementById('produk_id').value.trim(),
                tipe: document.getElementById('tipe').value.trim(),
                jumlah: document.getElementById('jumlah').value.trim()
            };


            if (!data.telepon || !data.provinsi || !data.kota || !data.kecamatan || !data.kodepos || !data.alamat) {
                alert("Mohon lengkapi semua field.");
                return;
            }

            fetch('simpenalamat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    alert("Alamat berhasil disimpan!");
                    const url = `checkout.php?produk_id=${data.produk_id}&tipe=${data.tipe}&jumlah=${data.jumlah}`;
                    window.location.href = url;
                })

                .catch(error => {
                    console.error("Gagal menyimpan:", error);
                    alert("Terjadi kesalahan saat menyimpan data.");
                });
        });
    </script>

</body>

</html>