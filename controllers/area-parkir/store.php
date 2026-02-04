<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/TbAreaParkir.php';

$model = new TbAreaParkir($pdo);
$model->create($_POST);

// Redirect
header('Location: ../../views/area-parkir/form.php');
exit;
