<?php

class TbTarif
{
    private PDO $pdo;
    private string $table = 'tb_tarif';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
    public function find(int $idTarif): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_tarif = :id_tarif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_tarif' => $idTarif]);

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
}
