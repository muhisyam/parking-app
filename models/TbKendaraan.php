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

    public function table(
        int $start,
        int $length,
        ?string $search = null
    ): array {
        $sql = "
            SELECT 
                id_kendaraan, 
                plat_nomor, 
                jenis_kendaraan, 
                warna, 
                pemilik, 
                tu.*
            FROM {$this->table} t
            JOIN tb_user tu ON tu.id_user = t.id_user
            WHERE 1=1
        ";

        $params = [];

        if ($search) {
            $sql .= " AND plat_nomor LIKE :search";
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

    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_kendaraan = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Find kendaraan by ID
    public function findByPlat(string $plat): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE plat_nomor = :plat";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['plat' => $plat]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all vehicles by user
    public function findByUser(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update kendaraan
    public function update(int $id, array $data): bool
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id_kendaraan = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Delete kendaraan
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id_kendaraan = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
