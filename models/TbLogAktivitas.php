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

    public function table(
        int $start,
        int $length,
        ?string $search = null
    ): array {
        $sql = "
            SELECT t.*, tu.*
            FROM {$this->table} t
            JOIN tb_user tu ON tu.id_user = t.id_user
            WHERE 1=1
        ";

        $params = [];

        if ($search) {
            $sql .= " AND username LIKE :search";
            $params['search'] = "%{$search}%";
        }

        $sql .= " LIMIT :length OFFSET :start";

        $stmt = $this->pdo->prepare($sql);

        // Bind manual karena LIMIT & OFFSET harus INT
        foreach ($params as $key => $val) {
            $stmt->bindValue(":{$key}", $val);
        }

        $stmt->bindValue(':length', $length, PDO::PARAM_INT);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(): int
    {
        // Prepare SQL for pagination
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
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
}
