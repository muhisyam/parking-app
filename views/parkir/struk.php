<!DOCTYPE html>
<html lang="en">

<?php $title = 'Area Parkir'; ?>
<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<body class="g-sidenav-show bg-gray-100">
  <?php include BASE_PATH . '/views/layouts/sidebar.php'; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include BASE_PATH . '/views/layouts/navbar.php'; ?>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Struk</h6>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 pb-2">
              <form method="POST" action="./update">
                <input type="hidden" name="id_parkir" value=<?= $data['id_parkir']; ?> readonly>

                <div class="form-group">
                  <label for="input-tanggal-masuk" class="form-control-label">Tanggal Masuk</label>
                  <input class="form-control" type="date" name="tanggal_masuk" value=<?= $data['tanggal_masuk']; ?> id="input-tanggal-masuk" readonly>
                </div>
                <div class="form-group">
                    <label for="input-waktu-masuk" class="form-control-label">Waktu Masuk</label>
                    <input class="form-control" type="time" name="waktu_masuk" value=<?= $data['waktu_masuk'] ?> id="input-waktu-masuk" readonly>
                </div>
                <div class="form-group">
                  <label for="input-plat-nomor" class="form-control-label">Plat Nomor</label>
                  <input class="form-control" type="text" name="plat_nomor" value=<?= $data['plat_nomor']; ?> id="input-plat-nomor" readonly>
                </div>
                <div class="form-group">
                  <label for="input-area-parkir" class="form-control-label">Area Parkir</label>
                  <select class="form-control" name="id_area" id="input-area-parkir" readonly>
                    <?php 
                      foreach ($areaParkir as $parkir) {
                        $selected = ($data['id_area'] == $parkir['id_area']) ? 'selected' : '';

                        echo '<option value="' . $parkir['id_area'] . '" ' . $selected . '>'
                            . $parkir['nama_area']
                            . '</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="row my-4">
                  <div class="col-md-6">
                    <h6 class="mb-0">Detail Kendaraan</h6>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input-pemilik" class="form-control-label">Pemilik</label>
                  <input class="form-control" type="text" name="pemilik" value=<?= $data['pemilik']; ?> id="input-pemilik" readonly>
                </div>
                <div class="form-group">
                  <label for="input-tanggal-keluar" class="form-control-label">Tanggal Keluar</label>
                  <input class="form-control" type="date" name="tanggal_keluar" value=<?= $data['tanggal_keluar']; ?> id="input-tanggal-keluar" readonly>
                </div>
                <div class="form-group">
                    <label for="input-waktu-keluar" class="form-control-label">Waktu Keluar</label>
                    <input class="form-control" type="time" name="waktu_keluar" value=<?= $data['waktu_keluar'] ?> id="input-waktu-keluar" readonly>
                </div>
                <div class="form-group">
                  <label for="input-durasi" class="form-control-label">Durasi</label>
                  <div class="input-group">
                    <input class="form-control" type="text" name="durasi" value=<?= $data['raw_total_durasi']; ?> id="input-durasi" readonly>
                    <span class="input-group-text group-text-right end-0">Jam</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input-biaya-total" class="form-control-label">Biaya Total</label>
                  <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input class="form-control ps-2" type="text" name="biaya_total" value=<?= $data['raw_total_biaya']; ?> id="input-biaya-total" readonly>
                  </div>
                </div>
                <div class="mt-4">
                  <a href="./" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </form>
          </div>
        </div>
      </div>
      
      <?php include __DIR__ . '/../layouts/footer.php'; ?>
    </div>
  </main>
  
  <?php include __DIR__ . '/../layouts/js/core.php'; ?>

</body>

</html>