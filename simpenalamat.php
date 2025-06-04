<?php
session_start();

// Ambil data dari JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data alamat
if (!$data || !isset($data['telepon'], $data['provinsi'], $data['kota'], $data['kecamatan'], $data['kodepos'], $data['alamat'])) {
    http_response_code(400);
    echo "Data alamat tidak lengkap.";
    exit;
}

// Simpan data alamat ke SESSION
$_SESSION['alamat'] = [
    'telepon'   => $data['telepon'],
    'provinsi'  => $data['provinsi'],
    'kota'      => $data['kota'],
    'kecamatan' => $data['kecamatan'],
    'kodepos'   => $data['kodepos'],
    'alamat'    => $data['alamat']
];

echo "Data berhasil disimpan.";
