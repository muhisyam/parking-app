<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TbAreaParkir.php';

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/parking-app');

session_start();
date_default_timezone_set('Asia/Jakarta');

$uri = $_SERVER['REQUEST_URI'];

// Remove trailing slash except root
if ($uri !== '/' && str_ends_with($uri, '/')) {
    header("Location: " . rtrim($uri, '/'), true, 301);
    exit;
}


$base = '/parking-app';
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri  = str_replace($base, '', $uri);
$uri  = ltrim($uri, '/');

$path     = explode('/', $uri);
$module   = $path[0];
$variable = count($path) > 1 ? $path[1] : 'index';

switch ($module) {
    case 'area-parkir':
        require '../controllers/TbAreaParkirController.php';
        $controller = new TbAreaParkirController($pdo);

        switch ($variable) {
            case 'table':
                $controller->table();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'show':
                $controller->show();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->destroy();
                break;
            default:
                $controller->index();
                break;
        }
        break;
    
    case 'tarif':
        require '../controllers/TbTarifController.php';
        $controller = new TbTarifController($pdo);

        switch ($variable) {
            case 'table':
                $controller->table();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'show':
                $controller->show();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->destroy();
                break;
            default:
                $controller->index();
                break;
        }
        break;
    
    case 'kendaraan':
        require '../controllers/TbKendaraanController.php';
        $controller = new TbKendaraanController($pdo);

        switch ($variable) {
            case 'table':
                $controller->table();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'show':
                $controller->show();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->destroy();
                break;
            default:
                $controller->index();
                break;
        }
        break;
    
    case 'log':
        require '../controllers/TbLogAktivitasController.php';
        $controller = new TbLogAktivitasController($pdo);

        switch ($variable) {
            case 'table':
                $controller->table();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'auth':
        require '../controllers/AuthController.php';
        $controller = new AuthController($pdo);

        switch ($variable) {
            case 'signin':
                $controller->login();
                break;

            case 'register':
                $controller->registerForm();
                break;
                
            case 'signup':
                $controller->register();
                break;

            case 'logout':
                $controller->logout();
                break;

            default:
                $controller->loginForm();
                break;
        }
        break;

    case 'parkir':
        require '../controllers/TbTransaksiController.php';
        $controller = new TbTransaksiController($pdo);

        switch ($variable) {
            case 'table':
                $controller->table();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'show':
            case 'struk':
                $controller->show();
                break;
            case 'update':
                $controller->update();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    default:
        http_response_code(404);
        echo '404';
}
