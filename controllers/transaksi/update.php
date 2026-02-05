<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/TbUser.php';
require_once __DIR__ . '/../../models/TbKendaraan.php';

session_start();

// MARK: Validation
if (empty($_POST['waktu_keluar'])) {
    exit('Waktu keluar wajib diisi');
}

// MARK: Model
$model = [
    'transaksi' => new TbTransaksi($pdo),
];

// MARK: Find kendaraan by tarif
$transaksi = $model['transaksi']->findWithTarif($_POST['id_parkir']);
if (!$transaksi) {
    http_response_code(404);
    exit('Transaksi tidak ditemukan');
}

// MARK: Hitung durasi
$masuk  = new DateTime($transaksi['waktu_masuk']);
$keluar = new DateTime($_POST['waktu_keluar']);

if ($keluar <= $masuk) {
    exit('Waktu keluar harus setelah waktu masuk');
}

// Hitung selisih jam
$diff       = $masuk->diff($keluar);
$durasiJam  = max(1, ($diff->days * 24) + $diff->h);

// MARK: HITUNG BIAYA
$tarifPerJam = (int) $transaksi['tarif_per_jam'];
$biayaTotal  = $durasiJam * $tarifPerJam;

// MARK: UPDATE TRANSAKSI
$this->transaksiModel->update($idParkir, [
    'waktu_keluar' => $_POST['waktu_keluar'],
    'durasi_jam'   => $durasiJam,
    'biaya_total'  => $biayaTotal,
    'status'       => 'keluar',
]);

header('Location: /transaksi/index.php?success=keluar');
exit;
