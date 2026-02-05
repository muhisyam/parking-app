<?php

class TbTarif
{
    private PDO $pdo;
    private string $table = 'tb_tarif';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function table(
        int $start,
        int $length,
    ): array {
        $sql = "
            SELECT id_tarif, jenis_kendaraan, tarif_per_jam
            FROM {$this->table}
            WHERE 1=1
        ";

        $sql .= " LIMIT :length OFFSET :start";

        $stmt = $this->pdo->prepare($sql);
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

    // Create tarif
    public function create(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return (int) $this->pdo->lastInsertId();
    }

    // Find tarif by ID
    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_tarif = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get tarif by jenis kendaraan
    public function findByJenis(string $jenis): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE jenis_kendaraan = :jenis";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['jenis' => $jenis]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update kendaraan
    public function update(int $id, array $data): bool
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id_tarif = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Delete kendaraan
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id_tarif = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
