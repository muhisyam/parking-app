<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/TbKendaraan.php';

$model = new TbKendaraan($pdo);
$model->delete($_GET['id']);

// Redirect
header('Location: ../../views/kendaraan/index.php');
exit;
