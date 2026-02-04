<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/TbKendaraan.php';

// Authorization-like check (user must exist)
$user = new TbUser($pdo);
$user = $this->userModel->find($_POST['user_id']);
if (!$user) {
    http_response_code(404);
    exit('User not found');
}

$model = new TbKendaraan($pdo);
$model->update($_GET['id'], $_POST);

// Redirect
header('Location: ../../views/kendaraan/index.php');
exit;
