<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/TbUser.php';
require_once __DIR__ . '/../../models/TbKendaraan.php';

session_start();

print_r($_POST);
exit;

// ===== VALIDATION =====
if (empty($request['plat_nomor'])) {
    exit('Plat nomor wajib diisi');
}

if (empty($request['waktu_masuk'])) {
    exit('Waktu masuk wajib diisi');
}

if (empty($request['id_area'])) {
    exit('Area parkir wajib diisi');
}

$model = [
    'kendaraan' => new TbKendaraan($pdo),
    'tarif'     => new TbTarif($pdo),
    'transaksi' => new TbTransaksi($pdo),
];

// ===== FIND KENDARAAN BY PLAT =====
$kendaraan = $model['kendaraan']->findByPlat($request['plat_nomor']);
if (!$kendaraan) {
    http_response_code(404);
    exit('Kendaraan tidak ditemukan');
}

// ===== FIND TARIF BERDASARKAN JENIS KENDARAAN =====
$tarif = $model['tarif']->findByJenis($vehicle['jenis_kendaraan']);
if (!$tarif) {
    http_response_code(404);
    exit('Tarif tidak ditemukan');
} 

// ===== INSERT TRANSAKSI =====
$$model['transaksi']->create([
    'id_kendaraan' => $kendaraan['id_kendaraan'],
    'waktu_masuk'  => $$_POST['waktu_masuk'],
    'id_tarif'     => $tarif['id_tarif'],
    'status'       => 'masuk',
    'id_user'      => $_SESSION['id_user'],
    'id_area'      => $$_POST['id_area'],
]);

// ===== REDIRECT =====
header('Location: ../../views/user/index.php');
exit;
