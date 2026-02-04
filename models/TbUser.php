<?php

class TbUser
{
    private PDO $pdo;
    private string $table = 'tb_user';

    // Inject database connection
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Insert new user
    public function create(array $data): int
    {
        // Build SQL dynamically
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        // Return inserted user ID
        return (int) $this->pdo->lastInsertId();
    }

    // Find user by ID
    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user
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

    // Delete user
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
