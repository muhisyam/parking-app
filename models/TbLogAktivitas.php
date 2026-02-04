<?php

class TbLogAktivitas
{
    private PDO $pdo;
    private string $table = 'tb_log_aktivitas';

    // Inject database connection
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Insert log aktivitas
    public function create(array $data): int
    {
        // Build column and value placeholders dynamically
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        // Return inserted ID
        return (int) $this->pdo->lastInsertId();
    }

    // Find log by ID
    public function find(int $idLog): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_log = :id_log";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_log' => $idLog]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get logs by user
    public function findByUser(int $idUser): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_user = :id_user ORDER BY waktu_aktivitas DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $idUser]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
