<!DOCTYPE html>
<html lang="en">

<?php $title = 'Log Aktivitas'; ?>
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
              <h6>List Log Aktivitas</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tabel-log">
                  <thead>
                    <tr>
                      <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Lengkap / Username</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aktivitas</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                    </tr>
                  </thead>
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
  <?php include __DIR__ . '/../layouts/js/datatable.php'; ?>

  <script>
    $(document).ready(function () {
        const moduleUrl = 'log';
        const table     = $('#tabel-log').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
              url: `/parking-app/${moduleUrl}/table`,
              type: 'GET',
              error: function (xhr) {
                  console.log(xhr.responseText);
              }
            },
            columns: [
              {
                  data: null,
                  render: function (data, type, row, meta) {
                    return `
                      <p class="text-xs text-start font-weight-bold mb-0">${meta.row + meta.settings._iDisplayStart + 1}</p>
                    `;
                  }
              },
              {
                  data: null,
                  render: function (data) {
                    return `
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">${data.nama_lengkap}</h6>
                          <p class="text-xs text-secondary mb-0">${data.username}</p>
                        </div>
                      </div>
                    `;
                  }
              },
              {
                  data: null,
                  render: function (data) {
                    return `
                      <p class="text-xs mb-0">${data.aktivitas}</p>
                    `;
                  }
              },
              {
                  data: null,
                  render: function (data) {
                  return `
                      <p class="text-xs mb-0">${data.waktu_aktivitas}</p>
                    `;
                  }
              }
            ]
        });
    });
  </script>
</body>

</html>