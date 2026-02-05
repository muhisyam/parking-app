<!DOCTYPE html>
<html lang="en">

<?php $title = 'Area Parkir'; ?>
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
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Input Kendaraan Masuk</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                  <i class="far fa-calendar-alt me-2"></i>
                  <small>23 - 30 March 2020</small>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 pb-2">
              <form method="POST" action="./store">
                <div class="form-group">
                  <label for="input-tanggal-masuk" class="form-control-label">Tanggal Masuk</label>
                  <input class="form-control" type="date" name="tanggal_masuk" value="<?= date('Y-m-d'); ?>" id="input-tanggal-masuk">
                </div>
                <div class="form-group">
                  <label for="input-waktu-masuk" class="form-control-label">Waktu Masuk</label>
                  <input class="form-control" type="time" name="waktu_masuk" value="<?= date('H:i:s'); ?>" id="input-waktu-masuk">
                </div>
                <div class="form-group">
                  <label for="input-plat-nomor" class="form-control-label">Plat Nomor</label>
                  <input class="form-control" type="text" name="plat_nomor" placeholder="AB 1234 CC" id="input-plat-nomor">
                </div>
                <div class="form-group">
                  <label for="input-area-parkir" class="form-control-label">Area Parkir</label>
                  <select class="form-control" name="id_area" id="input-area-parkir">
                    <?php 
                      foreach ($areaParkir as $parkir) {
                        echo '<option value="' . $parkir['id_area'] . '">'
                            . $parkir['nama_area']
                            . '</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                  <a href="./" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
              </form>
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