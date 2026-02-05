<!DOCTYPE html>
<html lang="en">

<?php $title = 'Tarif'; ?>
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
                  <h6 class="mb-0">Input Tarif</h6>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 pb-2">
              <form method="POST" action="./store">
                <div class="form-group">
                  <label for="input-jenis-kendaraan" class="form-control-label">Jenis Kendaraan</label>
                  <select class="form-control" name="jenis_kendaraan" id="input-jenis-kendaraan" require>
                    <option value="motor">Motor</option>
                    <option value="mobil">Mobil</option>
                    <option value="lainnya">Lainnya</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="input-tarif-per-jam" class="form-control-label">Tarif per jam</label>
                  <div class="input-group">
                    <input class="form-control" type="number" name="tarif_per_jam" id="input-tarif-per-jam" require>
                    <span class="input-group-text group-text-right end-0">/ Jam</span>
                  </div>
                </div>
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                  <button type="button" class="btn btn-secondary btn-sm">Kembali</button>
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