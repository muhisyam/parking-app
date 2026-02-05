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
              <form method="POST" action="./update">
                <input type="hidden" name="id_kendaraan" value=<?= $data['id_kendaraan']; ?> readonly>

                <div class="form-group">
                  <label for="input-plat-nomor" class="form-control-label">Plat Nomor</label>
                  <input class="form-control" type="text" name="plat_nomor" placeholder="A 1234 AB" value="<?= $data['plat_nomor'] ?>" id="input-plat-nomor" required>
                </div>
                <div class="form-group">
                  <label for="input-jenis-kendaraan" class="form-control-label">Jenis Kendaraan</label>
                  <select class="form-control" name="jenis_kendaraan" id="input-jenis-kendaraan" required>
                    <option value="motor"   <?= $data['jenis_kendaraan'] == 'motor' ? 'selected' : '' ?>   >Motor</option>
                    <option value="mobil"   <?= $data['jenis_kendaraan'] == 'mobil' ? 'selected' : '' ?>   >Mobil</option>
                    <option value="lainnya" <?= $data['jenis_kendaraan'] == 'lainnya' ? 'selected' : '' ?> >Lainnya</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="input-warna" class="form-control-label">Warna</label>
                  <input class="form-control" type="text" name="warna" placeholder="Putih" value="<?= $data['warna'] ?>" id="input-warna" required>
                </div>
                <input type="hidden" name="pemilik" readonly>
                <div class="form-group">
                  <label for="input-user" class="form-control-label">Pemilik</label>
                  <select class="form-control" name="id_user" id="input-user" required>
                    <?php 
                      foreach ($listUser as $user) {
                        $selected = ($data['id_user'] == $user['id_user']) ? 'selected' : '';

                        echo '<option value="' . $user['id_user'] . '" ' . $selected . '>'
                            . $user['nama_lengkap']
                            . '</option>';
                      }
                    ?>
                  </select>
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