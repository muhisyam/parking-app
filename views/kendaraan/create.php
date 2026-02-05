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
                  <h6 class="mb-0">Input Area Parkir</h6>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 pb-2">
              <form method="POST" action="./store">
                <div class="form-group">
                  <label for="input-plat-nomor" class="form-control-label">Plat Nomor</label>
                  <input class="form-control" type="text" name="plat_nomor" placeholder="A 1234 AB" id="input-plat-nomor" require>
                </div>
                <div class="form-group">
                  <label for="input-jenis-kendaraan" class="form-control-label">Jenis Kendaraan</label>
                  <select class="form-control" name="jenis_kendaraan" id="input-jenis-kendaraan" require>
                    <option value="motor">Motor</option>
                    <option value="mobil">Mobil</option>
                    <option value="lainnya">Lainnya</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="input-warna" class="form-control-label">Warna</label>
                  <input class="form-control" type="text" name="warna" placeholder="Putih" id="input-warna" require>
                </div>
                <input type="hidden" name="pemilik">
                <div class="form-group">
                  <label for="input-user" class="form-control-label">Pemilik</label>
                  <select class="form-control" name="id_user" id="input-user" require>
                    <?php 
                      foreach ($listUser as $user) {
                        echo '<option value="' . $user['id_user'] . '">'
                            . $user['nama_lengkap']
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const userSelect = document.getElementById('input-user');
      const pemilikInput = document.querySelector('input[name="pemilik"]');

      // Set initial value when page loads
      const selectedOption = userSelect.options[userSelect.selectedIndex];
      pemilikInput.value = selectedOption.text;

      // Update value when user changes selection
      userSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        pemilikInput.value = selectedOption.text;
      });
    });
  </script>
</body>

</html>