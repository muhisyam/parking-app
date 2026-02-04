<?php

require_once __DIR__ . '/../models/TbAreaParkir.php';

class TbAreaParkirController
{
    private TbAreaParkir $model;

    public function __construct(PDO $pdo)
    {
        // Inject model with database connection
        $this->model = new TbAreaParkir($pdo);
    }

    public function test()
    {
        print_r("asd");
        exit;
    }

    // GET /area-parkir
    public function index(): void
    {
        // Simple pagination logic
        $page  = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $data = $this->model->paginate($limit, $offset);

        // Render view
        include __DIR__ . '/../views/area_parkir/index.php';
    }

    // POST /area-parkir
    public function store(): void
    {
        // Get POST data
        $formData = $_POST;

        $this->model->create($formData);

        // Redirect after insert
        header('Location: /area-parkir?success=created');
        exit;
    }

    // GET /area-parkir/show?id=1
    public function show(): void
    {
        $id = (int) $_GET['id'];

        $areaParkir = $this->model->find($id);

        include __DIR__ . '/../views/area_parkir/show.php';
    }

    // POST /area-parkir/update?id=1
    public function update(): void
    {
        $id = (int) $_GET['id'];
        $formData = $_POST;

        $this->model->update($id, $formData);

        header('Location: /area-parkir?success=updated');
        exit;
    }

    // POST /area-parkir/delete?id=1
    public function destroy(): void
    {
        $id = (int) $_GET['id'];

        $this->model->delete($id);

        header('Location: /area-parkir?success=deleted');
        exit;
    }
}
