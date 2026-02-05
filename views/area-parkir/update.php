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
                  <h6 class="mb-0">Update Area Parkir</h6>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 pb-2">
              <form method="POST" action="./update">
                <input type="hidden" name="id_area" value=<?= $data['id_area']; ?> readonly>
                
                <div class="form-group">
                  <label for="input-nama-area" class="form-control-label">Nama Area</label>
                  <input class="form-control" type="text" name="nama_area" placeholder="Area A" value="<?= $data['nama_area'] ?>" id="input-nama-area" require>
                </div>
                <div class="form-group">
                  <label for="input-kapasitas" class="form-control-label">Kapasitas</label>
                  <input class="form-control" type="number" name="kapasitas" value="<?= $data['kapasitas'] ?>" id="input-kapasitas" require>
                </div>
                <div class="form-group">
                  <label for="input-terisi" class="form-control-label">Terisi</label>
                  <input class="form-control" type="number" name="terisi"  value="<?= $data['terisi'] ?>" id="input-terisi" require>
                </div>
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
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