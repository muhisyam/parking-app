<!DOCTYPE html>
<html lang="en">

<?php $title = 'User'; ?>
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
                  <h6 class="mb-0">Update User</h6>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 pb-2">
              <form method="POST" action="./update">
                <input type="hidden" name="id_user" value=<?= $data['id_user']; ?> readonly>
                
                <div class="form-group">
                  <label for="input-nama-lengkap" class="form-control-label">Nama Lengkap</label>
                  <input class="form-control" type="text" name="nama_lengkap" placeholder="John Doe" value=<?= $data['nama_lengkap'] ?> id="input-nama-area" require>
                </div>
                <div class="form-group">
                  <label for="input-username" class="form-control-label">Username</label>
                  <input class="form-control" type="number" name="username" value=<?= $data['nama_area'] ?> id="input-username" require>
                </div>
                <div class="form-group">
                  <select class="form-control" name="role" id="input-role">
                    <option value="" disabled selected hidden>Role</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="owner">Owner</option>
                  </select>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="status_aktif" id="input-status-aktif" checked="">
                  <label class="form-check-label" for="input-status-aktif">Status Akitf</label>
                </div>
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
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