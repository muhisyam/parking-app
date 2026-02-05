<?php

class TbKendaraan
{
    private PDO $pdo;
    private string $table = 'tb_kendaraan';

    // Inject database connection
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Insert kendaraan for specific user
    public function create(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return (int) $this->pdo->lastInsertId();
    }

    // Find kendaraan by ID
    public function findByPlat(string $plat): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE plat_nomor = :plat";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['plat' => $plat]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update kendaraan
    public function update(int $id, array $data): bool
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Delete kendaraan
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    // Get all vehicles by user
    public function findByUser(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
