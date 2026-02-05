<?php

require_once __DIR__ . '/../models/TbKendaraan.php';
require_once __DIR__ . '/../models/TbUser.php';

class TbKendaraanController
{
    private TbKendaraan $kendaraan;
    private TbUser $user;
    private string $moduleUrl;

    public function __construct(PDO $pdo)
    {
        // Inject model with database connection
        $this->kendaraan = new TbKendaraan($pdo);
        $this->user      = new TbUser($pdo);
        $this->moduleUrl = 'kendaraan';
    }

    public function index(): void
    {
        // Render
        include sprintf("%s/views/%s/table.php", BASE_PATH, $this->moduleUrl);
    }

    public function table(): void
    {
        $draw   = $_GET['draw'] ?? 1;
        $start  = $_GET['start'] ?? 0;
        $length = $_GET['length'] ?? 10;

        $data  = $this->kendaraan->table($start, $length);
        $total = $this->kendaraan->count();

        echo json_encode([
            'draw'            => (int) $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data
        ]);
    }

    // MARK: Create

    public function create(): void
    {
        $listUser = $this->user->master();

        // Render
        include sprintf("%s/views/%s/create.php", BASE_PATH, $this->moduleUrl);
    }

    private function validation(): void
    {
        // Validation
    }

    // MARK: Store

    public function store(): void
    {
        $this->validation();
        $this->kendaraan->create($_POST);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }

    // MARK: Show

    public function show(): void
    {
        $listUser = $this->user->master();
        $data     = $this->kendaraan->find($_GET['id']);

        // Render
        include sprintf("%s/views/%s/update.php", BASE_PATH, $this->moduleUrl);
    }

    // MARK: Update

    public function update(): void
    {
        $this->validation();
        $this->kendaraan->update($_POST['id_kendaraan'], $_POST);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }

    // MARK: Destroy

    public function destroy(): void
    {
        $this->kendaraan->delete($_GET['id']);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }
}
