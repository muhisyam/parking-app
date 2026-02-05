<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TbAreaParkir.php';

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/parking-app');

session_start();
date_default_timezone_set('Asia/Jakarta');

$base = '/parking-app';
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri  = str_replace($base, '', $uri);
$uri  = ltrim($uri, '/');

$path     = explode('/', $uri);
$module   = $path[0];
$variable = count($path) > 1 ? $path[1] : 'index';

switch ($module) {
    case 'auth':
        require '../controllers/AuthController.php';
        $controller = new AuthController($pdo);

        switch ($variable) {
            case 'login':
                $controller->loginForm();
                break;
                
            case 'signin':
                $controller->login();
                break;

            case 'register':
                $controller->registerForm();
                break;
                
            case 'signup':
                $controller->register();
                break;
        }
        break;
    case 'area-parkir':
        require '../controllers/TbAreaParkirController.php';
        $controller = new TbAreaParkirController($pdo);

        switch ($variable) {
            case 'create':
                # code...
                break;
            
            default:
                $controller->test();
                break;
        }
        break;
    case 'parkir':
        require '../controllers/TbTransaksiController.php';
        $controller = new TbTransaksiController($pdo);

        switch ($variable) {
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
            default:
                $controller->table();
                break;
        }
        break;

    default:
        http_response_code(404);
        echo '404';
}
