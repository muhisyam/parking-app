<?php

require_once __DIR__ . '/../models/TbUser.php';
require_once __DIR__ . '/../models/TbLogAktivitas.php';

class AuthController
{
    private TbUser $user;
    private TbLogAktivitas $log;

    public function __construct(PDO $pdo)
    {
        // Inject model with database connection
        $this->user = new TbUser($pdo);
        $this->log  = new TbLogAktivitas($pdo);
    }

    public function loginForm()
    {
        // Render view
        include BASE_PATH . '/views/auth/login.php';
    }

    public function login()
    {
        // Basic validation
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $_SESSION['error'] = 'Username dan password wajib diisi';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
        
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $user     = $this->user->find($username);

        // Check user & password
        if (!$user || ($password != $user['password'])) {
            $_SESSION['error'] = 'Username atau password salah';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        // Check active status
        if (!$user['status_aktif']) {
            $_SESSION['error'] = 'Akun tidak aktif';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        // Save session
        $_SESSION['auth'] = [
            'id_user'      => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap'],
            'username'     => $user['username'],
            'role'         => $user['role'],
        ];

        $this->log->create([
            'id_user'          => $user['id_user'],
            'aktivitas'        => "Login",
            'waktu_aktivitas' => date("Y-m-d H:i:s"),
        ]);
        
        header('Location: ' . BASE_URL . '/parkir');
        exit;
    }

    public function registerForm()
    {
        // Render view
        include BASE_PATH . '/views/auth/register.php';
    }

    public function register()
    {
        // Basic validation
        if (
            empty($_POST['nama_lengkap']) ||
            empty($_POST['username']) ||
            empty($_POST['password']) ||
            empty($_POST['role'])
        ) {
            $_SESSION['error'] = 'Semua field wajib diisi';
            header('Location: ' . BASE_URL . '/auth/register');
            exit;
        }

        $nama     = trim($_POST['nama_lengkap']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $role     = $_POST['role'];
        $user     = $this->user->find($username);

        if (!empty($user)) {
            $_SESSION['error'] = 'Username sudah digunakan';
            header('Location: ' . BASE_URL . '/auth/register');
            exit;
        }

        // Register
        $this->user->create([
            'nama_lengkap' => $nama,
            'username'     => $username,
            'password'     => $password,
            'role'         => $role,
        ]);

        $this->log->create([
            'id_user'          => $user['id_user'],
            'aktivitas'        => "Login",
            'waktu_aktivitas' => date("Y-m-d H:i:s"),
        ]);

        header('Location: ' . BASE_URL . '/parkir');
        exit;
    }

    public function logout()
    {
        $user = $_SESSION['auth'];

        $this->log->create([
            'id_user'          => $user['id_user'],
            'aktivitas'        => "Logout",
            'waktu_aktivitas' => date("Y-m-d H:i:s"),
        ]);

        unset($_SESSION['auth']);

        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
}
