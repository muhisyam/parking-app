<!DOCTYPE html>
<html lang="en">

<?php $title = 'Parkir'; ?>
<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<body class="g-sidenav-show  bg-gray-100">
  <?php include BASE_PATH . '/views/layouts/sidebar.php'; ?>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include BASE_PATH . '/views/layouts/navbar.php'; ?>
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>List Kendaraan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kendaraan / Pemilik</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Kendaraan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Masuk</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Keluar</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Biaya Total (Durasi)</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($parkir as $data) {
                        $dtWaktuMasuk  = new DateTime($data['waktu_masuk']);
                        $tanggalKeluar = $waktuKeluar = '-';
                        
                        // Init
                        $biayaTotal = '-';
                        $durasiJam  = '-';
                        $statusBg   = $data['status'] == 'keluar' 
                            ? 'bg-gradient-success' 
                            : 'bg-gradient-secondary';

                        if ($data['status'] == 'keluar') {
                            $dtWaktuKeluar = new DateTime($data['waktu_keluar']);
                            $tanggalKeluar = $dtWaktuKeluar->format('Y-m-d');
                            $waktuKeluar   = $dtWaktuKeluar->format('H:i:s');

                            $durasiJam  = $data['durasi_jam'];
                            $biayaTotal = $data['biaya_total'];
                        }

                        echo '
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">' . $data['plat_nomor'] . '</h6>
                                        <p class="text-xs text-secondary mb-0">' . $data['pemilik'] . '</p>
                                    </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">' . ucwords($data['jenis_kendaraan']) . '</p>
                                    <p class="text-xs text-secondary mb-0">' . ucwords($data['warna']) . '</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">' . $dtWaktuMasuk->format('Y-m-d') . '</p>
                                    <p class="text-xs text-secondary mb-0">' . $dtWaktuMasuk->format('H:i:s') . '</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">' . $tanggalKeluar . '</p>
                                    <p class="text-xs text-secondary mb-0">' . $waktuKeluar . '</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">Rp ' . $biayaTotal . ' (' . $durasiJam . ' Jam)</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm ' . $statusBg . '">' . $data['status'] . '</span>
                                </td>
                                <td class="align-middle">
                                    <a href="./parkir/show?id_parkir=' . $data['id_parkir'] . '" class="btn btn-sm bg-gradient-warning my-auto" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm bg-gradient-danger my-auto" data-toggle="tooltip" data-original-title="Edit user">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        ';
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php include __DIR__ . '/../layouts/footer.php'; ?>
    </div>
  </main>

  <?php include __DIR__ . '/../layouts/js/core.php'; ?>
</body>

</html>