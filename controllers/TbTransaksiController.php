<?php

require_once __DIR__ . '/../models/TbTransaksi.php';
require_once __DIR__ . '/../models/TbKendaraan.php';
require_once __DIR__ . '/../models/TbAreaParkir.php';
require_once __DIR__ . '/../models/TbTarif.php';

class TbTransaksiController
{
    private TbKendaraan $kendaraan;
    private TbTransaksi $transaksi;
    private TbAreaParkir $parkir;
    private TbTarif $tarif;

    public function __construct(PDO $pdo)
    {
        $this->kendaraan = new TbKendaraan($pdo);
        $this->transaksi = new TbTransaksi($pdo);
        $this->parkir    = new TbAreaParkir($pdo);
        $this->tarif     = new TbTarif($pdo);
    }

    public function table()
    {
        $post   = $_POST;
        $from   = date('Y-m-d');
        $to     = (new DateTime('now'))->modify('+1 day')->format('Y-m-d');
        $parkir = $this->transaksi->findRekapByDate($from, $to);

        // print_r($data);
        // exit;

        // Render view
        include BASE_PATH . '/views/parkir/table-parkir.php';
    }

    public function create()
    {
        // Data area parkir
        $areaParkir = $this->parkir->master();

        // Render view
        include BASE_PATH . '/views/parkir/form-masuk.php';
    }

    public function store()
    {
        // MARK: Validation
        // if (empty($_POST['plat_nomor'])) {
        //     exit('Plat nomor wajib diisi');
        // }

        // if (empty($_POST['waktu_masuk'])) {
        //     exit('Waktu masuk wajib diisi');
        // }

        // if (empty($_POST['id_area'])) {
        //     exit('Area parkir wajib diisi');
        // }

        // MARK: Find kendaraan by plat
        $kendaraan = $this->kendaraan->findByPlat($_POST['plat_nomor']);
        if (!$kendaraan) {
            http_response_code(404);
            exit('Kendaraan tidak ditemukan');
        }

        // MARK: Find tarif berdasarkan jenis kendaraan
        $tarif = $this->tarif->findByJenis($kendaraan['jenis_kendaraan']);
        if (!$tarif) {
            http_response_code(404);
            exit('Tarif tidak ditemukan');
        }

        // MARK: Insert transaksi
        $this->transaksi->create([
            'id_kendaraan' => $kendaraan['id_kendaraan'],
            'waktu_masuk'  => $_POST['tanggal_masuk'] . ' ' . $_POST['waktu_masuk'],
            'id_tarif'     => $tarif['id_tarif'],
            'status'       => 'masuk',
            'id_user'      => $kendaraan['id_user'],
            'id_area'      => $_POST['id_area'],
        ]);

        // MARK: Redirect
        header('Location: ' . BASE_URL . '/parkir/create');
        exit;
    }

    public function show()
    {
        // Data parkir
        $idParkir      = $_GET['id_parkir'];
        $data          = $this->transaksi->findFull($idParkir);
        $dtWaktuMasuk  = new DateTime($data['waktu_masuk']);
        $dtWaktuKeluar = new DateTime($data['waktu_keluar'] ?? 'now');

        // Data area parkir
        $areaParkir = $this->parkir->master();

        // Data durasi
        $now       = new DateTime('now');
        $diff      = $dtWaktuMasuk->diff($now);
        $durasiJam = ($diff->days * 24) + $diff->h;
        $durasiJam = max(1, $durasiJam);

        // Data biaya total
        $biayaTotal = $data['tarif_per_jam'] * $durasiJam;

        // Gabung data
        $data = array_merge($data, [
            'tanggal_masuk'    => $dtWaktuMasuk->format('Y-m-d'),
            'waktu_masuk'      => $dtWaktuMasuk->format('H:i:s'),
            'tanggal_keluar'   => $dtWaktuKeluar->format('Y-m-d'),
            'waktu_keluar'     => $dtWaktuKeluar->format('H:i:s'),
            'raw_total_durasi' => $durasiJam,
            'raw_total_biaya'  => $biayaTotal,
            'selesai'          => $data['status'] == 'keluar',
        ]);

        // Render view
        include BASE_PATH . '/views/parkir/form-keluar.php';
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

        // MARK: Redirect
        header('Location: ' . BASE_URL . '/parkir/show?id_parkir=' . $_POST['id_parkir']);
        exit;
    }

}
