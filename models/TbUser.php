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

    public function master(): array
    {
        // Prepare SQL for pagination
        $sql = "SELECT * FROM {$this->table} WHERE status_aktif = true";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function table(
        int $start,
        int $length,
        ?string $search = null
    ): array {
        $sql = "
            SELECT 
                id_user, 
                nama_lengkap, 
                username, 
                password,
                role,
                status_aktif
            FROM {$this->table}
            WHERE 1=1
        ";

        $params = [];

        if ($search) {
            $sql .= " AND nama_lengkap LIKE :search";
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

    public function count(): array
    {
        // Prepare SQL for pagination
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function find(string $username): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data): bool
    {
        // Build SET clause dynamically
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $set) . " WHERE id_area = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id_area = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
