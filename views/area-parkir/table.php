<!DOCTYPE html>
<html lang="en">

<?php $title = 'Area Parkir'; ?>
<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<body class="g-sidenav-show  bg-gray-100">
  <?php include BASE_PATH . '/views/layouts/sidebar.php'; ?>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include BASE_PATH . '/views/layouts/navbar.php'; ?>
    
    <div class="container-fluid py-4">
      <div class="row ">
        <div class="row col-12">
          <div class="col-6 mt-auto">
            <a href="./area-parkir/create" class="btn btn-primary">Tambah</a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>List Area Parkir</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tabel-area-parkir">
                  <thead>
                    <tr>
                      <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Kapasitas</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Terisi</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Sisa</th>
                      <th class="text-secondary opacity-7 w-10"></th>
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
        const moduleUrl = 'area-parkir';
        const table     = $('#tabel-area-parkir').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
              url: `/parking-app/area-parkir/table`,
              type: 'GET',
              error: function (xhr) {
                console.log(xhr.responseText);
              }
            },
            columns: [
              {
                data: null,
                orderable: false,
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
                      <p class="text-xs mb-0">${data.nama_area}</p>
                    `;
                  }
              },
            {
                  data: null,
                  render: function (data) {
                    return `
                      <p class="text-xs mb-0">${data.kapasitas}</p>
                    `;
                  }
              },
              {
                  data: null,
                  render: function (data) {
                    return `
                      <p class="text-xs mb-0">${data.terisi}</p>
                    `;
                  }
              },
              {
                  data: null,
                  render: function (data) {
                    return `
                      <p class="text-xs mb-0">${data.sisa}</p>
                    `;
                  }
              },
              {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                  return `
                    <div class='ps-5'>
                      <a 
                        href="./${moduleUrl}/show?id=${data.id_area}"
                        class="btn btn-sm bg-gradient-warning my-auto"
                      >
                        Edit
                      </a>
                      <a 
                        href="./${moduleUrl}/delete?id=${data.id_area}"
                        class="btn btn-sm bg-gradient-danger my-auto"
                      >
                        Delete
                      </a>
                    </div>
                  `;
                }
              }
            ]
        });
    });
  </script>
</body>

</html>