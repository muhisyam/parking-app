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

    public function table(
        int $start,
        int $length,
        ?string $search = null
    ): array {
        $sql = "
            SELECT 
                id_area, 
                nama_area, 
                kapasitas, 
                terisi,
                (kapasitas - terisi) AS sisa
            FROM {$this->table}
            WHERE 1=1
        ";

        $params = [];

        if ($search) {
            $sql .= " AND nama_area LIKE :search";
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

    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_area = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        // Build SQL dynamically
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
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

    public function isiParkir(int $idArea): bool
    {
        $sql = "
            UPDATE tb_area_parkir
            SET terisi = terisi + 1
            WHERE id_area = :id_area
            AND terisi < kapasitas
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id_area' => $idArea
        ]);
    }

    public function kurangiParkir(int $idArea): bool
    {
        $sql = "
            UPDATE tb_area_parkir
            SET terisi = terisi - 1
            WHERE id_area = :id_area
            AND terisi > 0
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id_area' => $idArea
        ]);
    }
}
