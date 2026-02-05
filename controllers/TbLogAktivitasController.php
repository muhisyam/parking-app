<?php

require_once __DIR__ . '/../models/TbLogAktivitas.php';

class TbLogAktivitasController
{
    private TbLogAktivitas $model;
    private string $moduleUrl;

    public function __construct(PDO $pdo)
    {
        // Inject model with database connection
        $this->model     = new TbLogAktivitas($pdo);
        $this->moduleUrl = 'log';
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
}
