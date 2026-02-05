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
    public function findFull(int $idParkir): array|false
    {
        $sql = "
            SELECT t.*, tr.*, tk.*, tu.*
            FROM tb_transaksi t
            JOIN tb_kendaraan tk ON tk.id_kendaraan = t.id_kendaraan
            JOIN tb_tarif tr ON tr.id_tarif = t.id_tarif
            JOIN tb_user tu ON tu.id_user = t.id_user
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

    // Table
    // public function findRekapByDate(string $from, string $to, string|null $userId = null): array
    // {
    //     $sql = "
    //         SELECT t.*, tk.*, tr.*, tu.*, ta.*
    //         FROM tb_transaksi t
    //         JOIN tb_kendaraan tk ON tk.id_kendaraan = t.id_kendaraan
    //         JOIN tb_tarif tr ON tr.id_tarif = t.id_tarif
    //         JOIN tb_user tu ON tu.id_user = t.id_user
    //         JOIN tb_area_parkir ta ON ta.id_area = t.id_area
    //         WHERE t.waktu_masuk BETWEEN :from AND :to
    //         ORDER BY t.waktu_masuk DESC
    //     ";

    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute([
    //         'from' => $from,
    //         'to'   => $to
    //     ]);

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function findRekapByDate(
        string $from,
        string $to,
        ?string $userId = null,
        int $start = 0,
        int $limit = 10
    ): array {
        // Base SQL
        $sql = "
            SELECT 
                t.*,
                tk.*,
                tr.*,
                tu.*,
                ta.*
            FROM tb_transaksi t
            JOIN tb_kendaraan tk ON tk.id_kendaraan = t.id_kendaraan
            JOIN tb_tarif tr ON tr.id_tarif = t.id_tarif
            JOIN tb_user tu ON tu.id_user = t.id_user
            JOIN tb_area_parkir ta ON ta.id_area = t.id_area
            WHERE t.waktu_masuk BETWEEN :from AND :to
        ";

        // Parameter wajib
        $params = [
            'from' => $from,
            'to'   => $to
        ];

        // Optional filter user
        if ($userId !== null) {
            $sql .= " AND t.id_user = :user_id";
            $params['user_id'] = $userId;
        }

        // Sorting + pagination (DataTables)
        $sql .= "
            ORDER BY t.waktu_masuk DESC
            LIMIT :start, :limit
        ";

        $stmt = $this->pdo->prepare($sql);

        // Bind parameter tanggal & user
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        // Bind limit & offset (HARUS integer)
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countRekapByDate(
        string $from,
        string $to,
        ?string $userId = null
    ): int {
        $sql = "
            SELECT COUNT(*) AS total
            FROM tb_transaksi t
            WHERE t.waktu_masuk BETWEEN :from AND :to
        ";

        $params = [
            'from' => $from,
            'to'   => $to
        ];

        if ($userId !== null) {
            $sql .= " AND t.id_user = :user_id";
            $params['user_id'] = $userId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }


}
