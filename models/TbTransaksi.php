<?php

class TbTransaksi
{
    private PDO $pdo;
    private string $table = 'tb_transaksi';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Create transaksi parkir
    public function create(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $values  = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return (int) $this->pdo->lastInsertId();
    }

    // Find transaksi by ID
    public function find(int $idParkir): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_parkir = :id_parkir";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_parkir' => $idParkir]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get transaksi + tarif (replacement for belongsTo)
    public function findWithTarif(int $idParkir): array|false
    {
        $sql = "
            SELECT t.*, tr.jenis_kendaraan, tr.tarif_per_jam
            FROM tb_transaksi t
            JOIN tb_tarif tr ON tr.id_tarif = t.id_tarif
            WHERE t.id_parkir = :id_parkir
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_parkir' => $idParkir]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update transaksi
    public function update(int $idParkir, array $data): bool
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id_parkir = :id_parkir";
        $stmt = $this->pdo->prepare($sql);

        $data['id_parkir'] = $idParkir;
        return $stmt->execute($data);
    }
}
