<!DOCTYPE html>
<html lang="en">

<?php $title = 'Parkir'; ?>
<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<body class="g-sidenav-show  bg-gray-100">
  <?php include BASE_PATH . '/views/layouts/sidebar.php'; ?>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include BASE_PATH . '/views/layouts/navbar.php'; ?>
    
    <div class="container-fluid py-4">
      <div class="row ">
        <div class="row col-12">
          <div class="col-6 mt-auto">
            <a href="./parkir/create" class="btn btn-primary">Tambah</a>
          </div>
          <div class="col-6">
            <form id="filter-parkir" class="row">
              <div class="col-7 form-group">
                <label for="input-search" class="form-control-label">Search</label>
                <input class="form-control" type="text" name="search" placeholder="Keyword kendaraan" id="input-search">
              </div>
              <div class="col-2 form-group">
                <label for="input-tanggal-mulai" class="form-control-label">Tanggal Mulai</label>
                <input class="form-control" type="date" name="tanggal_mulai" value="<?= $from->format('Y-m-d'); ?>" id="input-tanggal-mulai">
              </div>
              <div class="col-2 form-group">
                <label for="input-tanggal-selesai" class="form-control-label">Tanggal Selesai</label>
                <input class="form-control" type="date" name="tanggal_selesai" value="<?= $to->format('Y-m-d'); ?>" id="input-tanggal-selesai">
              </div>
              <div class="col-1 mt-auto">
                <button type="submit" class="btn btn-secondary">Filter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>List Kendaraan Parkir</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tabel-parkir">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kendaraan / Pemilik</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Kendaraan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Mulai</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Selesai</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Biaya Total (Durasi)</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
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

  <!-- Datatable script -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.js"></script>

  <script>
    $(document).ready(function () {
      const AUTH_ROLE = "<?= $_SESSION['auth']['role'] ?? '' ?>";
      const table     = $('#tabel-parkir').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
          url: '/parking-app/parkir/table',
          type: 'GET',
          data: function (d) {
            d.tanggal_mulai   = $('input[name="tanggal_mulai"]').val();
            d.tanggal_selesai = $('input[name="tanggal_selesai"]').val();
          },
          error: function (xhr) {
            console.log(xhr.responseText);
          }
        },
        columns: [
          // No
          {
            data: null,
            render: function (data, type, row, meta) {
              return `
                <p class="text-xs text-start font-weight-bold mb-0">${meta.row + meta.settings._iDisplayStart + 1}</p>
              `;
            }
          },

          // Pemilik
          {
            data: null,
            render: function (data) {
              return `
                <div class="d-flex px-2 py-1">
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">${data.plat_nomor}</h6>
                    <p class="text-xs text-secondary mb-0">${data.pemilik}</p>
                  </div>
                </div>
              `;
            }
          },

          // Kendaraan
          {
            data: null,
            render: function (data) {
              return `
                <p class="text-xs font-weight-bold mb-0">${toTitleCase(data.jenis_kendaraan)}</p>
                <p class="text-xs text-secondary mb-0">${toTitleCase(data.warna)}</p>
              `;
            }
          },

          // Mulai
          {
            data: null,
            render: function (data) {
              const dt = new Date(data.waktu_masuk.replace(' ', 'T'));
              return `
                <p class="text-xs font-weight-bold mb-0">${dt.toISOString().slice(0,10)}</p>
                <p class="text-xs text-secondary mb-0">${dt.toTimeString().slice(0,8)}</p>
              `;
            }
          },

          // keluar
          {
            data: null,
            render: function (data) {
              if (data.status !== 'keluar') {
                return `
                  <p class="text-xs font-weight-bold mb-0">-</p>
                  <p class="text-xs text-secondary mb-0">-</p>
                `;
              }

              const dt = new Date(data.waktu_keluar.replace(' ', 'T'));
              return `
                <p class="text-xs font-weight-bold mb-0">${dt.toISOString().slice(0,10)}</p>
                <p class="text-xs text-secondary mb-0">${dt.toTimeString().slice(0,8)}</p>
              `;
            }
          },

          // Biaya
          {
            data: null,
            className: 'text-center',
            render: function (data) {
              if (data.status !== 'keluar') {
                return `<span class="text-secondary text-xs font-weight-bold">-</span>`;
              }

              return `
                <span class="text-secondary text-xs font-weight-bold">
                  Rp ${data.biaya_total} (${data.durasi_jam} Jam)
                </span>
              `;
            }
          },

          // Status
          {
            data: 'status',
            className: 'text-center',
            render: function (data) {
              const badge = data === 'keluar'
                ? 'bg-gradient-success'
                : 'bg-gradient-secondary';

              return `<span class="badge badge-sm ${badge}">${data}</span>`;
            }
          },

          // Aksi
          {
            data: 'id_parkir',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {

              // 👉 KHUSUS OWNER
              if (AUTH_ROLE === 'owner') {
                return `
                  <div class="ps-5">
                    <a href="./parkir"
                      class="btn btn-sm bg-gradient-secondary my-auto">
                      Kembali
                    </a>
                  </div>
                `;
              }

              // 👉 ROLE SELAIN OWNER
              let btnStruk = '';

              if (row.status === 'keluar') {
                btnStruk = `
                  <a href="./parkir/struk?id_parkir=${row.id_parkir}"
                    class="btn btn-sm bg-gradient-success my-auto">
                    Struk
                  </a>
                `;
              }

              return `
                <div class="ps-5">
                  <a href="./parkir/show?id_parkir=${row.id_parkir}"
                    class="btn btn-sm bg-gradient-warning my-auto">
                    Edit
                  </a>

                  <a href="javascript:;"
                    class="btn btn-sm bg-gradient-danger my-auto">
                    Delete
                  </a>

                  ${btnStruk}
                </div>
              `;
            }
          }
        ]
      });

      $('#filter-parkir').on('submit', function (e) {
        e.preventDefault();
        table.ajax.reload();
      });
    });

    // helper
    function toTitleCase(str) {
      return str.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
      });
    }
  </script>
</body>

</html>