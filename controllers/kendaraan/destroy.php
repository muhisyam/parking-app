<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/TbUser.php';

$model = new TbUser($pdo);
$model->delete($_GET['id']);

// Redirect
header('Location: ../../views/user/index.php');
exit;
