<?php

require_once __DIR__ . '/../models/TbTransaksi.php';
require_once __DIR__ . '/../models/TbKendaraan.php';
require_once __DIR__ . '/../models/TbAreaParkir.php';
require_once __DIR__ . '/../models/TbTarif.php';
require_once __DIR__ . '/../models/TbUser.php';

class TbTransaksiController
{
    private TbKendaraan $kendaraan;
    private TbTransaksi $transaksi;
    private TbAreaParkir $parkir;
    private TbTarif $tarif;
    private TbUser $user;
    private string $moduleUrl;

    public function __construct(PDO $pdo)
    {
        $this->kendaraan = new TbKendaraan($pdo);
        $this->transaksi = new TbTransaksi($pdo);
        $this->parkir    = new TbAreaParkir($pdo);
        $this->tarif     = new TbTarif($pdo);
        $this->user      = new TbUser($pdo);
        $this->moduleUrl = 'parkir';
    }

    public function index()
    {
        $from   = (new DateTime('first day of this month 00:00:00'));
        $to     = (new DateTime('last day of this month 23:59:59'));
        $parkir = $this->transaksi->findRekapByDate(
            $from->format('Y-m-d H:i:s'), 
            $to->format('Y-m-d H:i:s'),
        );

        // Render view
        include sprintf("%s/views/%s/table.php", BASE_PATH, $this->moduleUrl);
    }

    public function table()
    {
        $draw   = $_GET['draw'] ?? 1;
        $start  = $_GET['start'] ?? 0;
        $length = $_GET['length'] ?? 10;

        $from = $_GET['tanggal_masuk'] ?? '2025-01-20';
        $to   = $_GET['tanggal_selesai'] ?? date('Y-m-d');

        // Contoh: owner lihat semua, petugas hanya miliknya
        $userId = $_SESSION['auth']['role'] === 'owner'
            ? $_SESSION['auth']['id_user']
            : null;

        $data  = $this->transaksi->findRekapByDate($from, $to, $userId, $start, $length);
        $total = $this->transaksi->countRekapByDate($from, $to, $userId);

        echo json_encode([
            'draw'            => (int) $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data
        ]);
    }



    public function create()
    {
        // Data area parkir
        $areaParkir = $this->parkir->master();

        // Render view
        include BASE_PATH . '/views/parkir/form-masuk.php';
    }

    private function validation(): void
    {
        // Validation
    }

    public function store()
    {
        $this->validation();

        // Find kendaraan by plat
        $kendaraan = $this->kendaraan->findByPlat($_POST['plat_nomor']);
        if (!$kendaraan) {
            http_response_code(404);
            exit('Kendaraan tidak ditemukan');
        }

        // Find tarif berdasarkan jenis kendaraan
        $tarif = $this->tarif->findByJenis($kendaraan['jenis_kendaraan']);
        if (!$tarif) {
            http_response_code(404);
            exit('Tarif tidak ditemukan');
        }

        // Insert transaksi
        $this->transaksi->create([
            'id_kendaraan' => $kendaraan['id_kendaraan'],
            'waktu_masuk'  => $_POST['tanggal_masuk'] . ' ' . $_POST['waktu_masuk'],
            'id_tarif'     => $tarif['id_tarif'],
            'status'       => 'masuk',
            'id_user'      => $kendaraan['id_user'],
            'id_area'      => $_POST['id_area'],
        ]);

        $this->parkir->isiParkir($_POST['id_area']);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }

    public function show()
    {
        // Data parkir
        $idParkir      = $_GET['id_parkir'];
        $data          = $this->transaksi->findFull($idParkir);
        $dtWaktuMasuk  = new DateTime($data['waktu_masuk']);
        
        // Data keluar
        $dtWaktuKeluar = new DateTime($data['waktu_keluar'] ?? 'now');
        $tanggalKeluar = $dtWaktuKeluar->format('Y-m-d');
        $waktuKeluar   = $dtWaktuKeluar->format('H:i:s');

        // Data durasi
        $diff      = $dtWaktuMasuk->diff($dtWaktuKeluar);
        $durasiJam = ($diff->days * 24) + $diff->h;
        $durasiJam = max(1, $durasiJam);

        // Data biaya total
        $biayaTotal = $data['tarif_per_jam'] * $durasiJam;

        // Data area parkir
        $areaParkir = $this->parkir->master();

        // Gabung data
        $data = array_merge($data, [
            'tanggal_masuk'    => $dtWaktuMasuk->format('Y-m-d'),
            'waktu_masuk'      => $dtWaktuMasuk->format('H:i:s'),
            'tanggal_keluar'   => $tanggalKeluar,
            'waktu_keluar'     => $waktuKeluar,
            'raw_total_durasi' => $durasiJam,
            'raw_total_biaya'  => $biayaTotal,
            'selesai'          => $data['status'] == 'keluar',
        ]);

        // Render view
        include sprintf("%s/views/%s/form-keluar.php", BASE_PATH, $this->moduleUrl);
    }

    public function update()
    {
        // Update transaksi
        $this->transaksi->update($_POST['id_parkir'], [
            'waktu_keluar' => (new DateTime('now'))->format('Y-m-d H:i:s'),
            'durasi_jam'   => $_POST['durasi'],
            'biaya_total'  => $_POST['biaya_total'],
            'status'       => 'keluar',
        ]);

        $this->parkir->kurangiParkir($_POST['id_area']);

        // Redirect
        header('Location: ' . sprintf('%s/%s', BASE_URL, $this->moduleUrl));
        exit;
    }

}
