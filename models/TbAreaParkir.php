<?php

class TbAreaParkir
{
    private PDO $pdo;
    private string $table = 'tb_area_parkir';

    // Inject PDO connection
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function master(): array
    {
        // Prepare SQL for pagination
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get paginated data
    public function paginate(int $limit, int $offset): array
    {
        // Prepare SQL for pagination
        $sql = "SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters safely
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find record by ID
    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new record
    public function create(array $data): bool
    {
        // Build SQL dynamically
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    // Update existing record
    public function update(int $id, array $data): bool
    {
        // Build SET clause dynamically
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $set) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Delete record
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
