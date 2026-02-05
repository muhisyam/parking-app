<?php

require_once __DIR__ . '/../models/TbTarif.php';

class TbTarifController
{
    private TbTarif $model;
    private string $moduleUrl;

    public function __construct(PDO $pdo)
    {
        // Inject model with database connection
        $this->model     = new TbTarif($pdo);
        $this->moduleUrl = 'tarif';
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

        $data  = $this->model->table($start, $length);
        $total = $this->model->count();

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
        $this->model->create($_POST);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }

    // MARK: Show

    public function show(): void
    {
        $data = $this->model->find($_GET['id']);

        // Render
        include sprintf("%s/views/%s/update.php", BASE_PATH, $this->moduleUrl);
    }

    // MARK: Update

    public function update(): void
    {
        $this->validation();
        $this->model->update($_POST['id_tarif'], $_POST);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }

    // MARK: Destroy

    public function destroy(): void
    {
        $this->model->delete($_GET['id']);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }
}
