<?= $this->extend('layout/LayoutDashboard') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
              <button type="button" class="btn btn-primary btn-sm waves-effect waves-light mb-3" data-toggle="modal" data-target="#addOrderModal">Tambah Temuan</button>
              <?php if(session()->get('role') === 'superadmin'): ?>
              <?php endif ?>
            </div>
            <table id="datatable" class="table table-bordered dt-responsive nowrap">
              <thead>
                <tr>
                  <th>Unit Audit</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Tanggal Pembuatan</th>
                  <th>Tanggal Update</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($content as $data): ?>
                <tr>
                  <td><?= $data->name ?></td>
                  <td><?= $data->tanggal_db ?></td>
                  <td>
                    <?php if($data->status == 'menunggu_konfirmasi'): ?>
                    <span class="badge-pill badge-warning"> Menunggu Tindaklanjuti</span>
                    <?php elseif($data->status == 'dalam_progres'): ?>
                    <span class="badge-pill badge-primary"> Proses Tindaklanjuti</span>
                    <?php elseif($data->status == 'selesai'): ?>
                    <span class="badge-pill badge-success"> Selesai</span>
                    <?php endif ?>
                  </td>
                  <td><?= $data->created_at ?></td>
                  <td><?= $data->updated_at ?></td>
                  <td>
                    <button class="btn-sm btn-primary" onclick="editOrder(<?= $data->id?>)">
                      <span>Detail</span>
                    </button>
                    <button class="btn-sm btn-danger" onclick="deleteOrder(<?= $data->id?>)">
                      <span>Delete</span>
                    </button>
                  </td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end row -->

<!-- Add Order Modal -->
<div id="addOrderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Tambah Temuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form">
          <input hidden name="id" id="id"/>
          <div class="form-group form-group mb-4">
            <label for="tanggal_db">Tanggal</label>
            <input type="date" class="form-control datepicker-here" data-language="en" name="tanggal_db" id="tanggal_db" required/>
          </div>
          <div class="form-group form-group mb-4">
            <label for="deskripsi_db">Deskripsi Temuan</label>
            <textarea type="text" class="form-control" name="deskripsi_db" id="deskripsi_db" required></textarea>
          </div>
          <div class="form-group form-group mb-4" id="select">
            <label for="id_user">Unit Audit</label>
            <select name="id_user" id="id_user" required></select>
          </div>
          <div class="form-group form-group mb-4">
            <label for="perbaikan">Rekomendasi Perbaikan</label>
            <input type="text" class="form-control" id="perbaikan" name="perbaikan" required> 
          </div>
          <div class="form-group form-group mb-4">
            <label for="kategori">Kategori Temuan</label>
            <select class="custom-select" name="kategori" id="kategori" required>
              <option selected>Pilih Kategori</option>
              <?php foreach($jenis as $data): ?>
              <option value="<?= $data['id'] ?>"><?= $data['nama_kategori'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group form-group mb-4">
            <label for="admin">Admin Eksekusi</label>
            <select class="custom-select" name="admin" id="admin" required>
              <option selected>Pilih Admin</option>
              <?php foreach($admin as $data): ?>
              <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group form-group mb-4" id="status_order" hidden>
            <label for="status">Status Temuan</label>
            <select class="custom-select" name="status" id="status" required>
              <option selected>Pilih Status</option>
            </select>
          </div>
          <div class="mt-4">
            <button class="btn btn-primary waves-effect waves-light" onclick="saveOrder()">Simpan Temuan</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="exportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Export</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formExport">
          <div class="form-group">
            <label for="admin">Admin</label>
            <select class="form-control" id="id_admin" name="id_admin">
              <option selected>Pilih Admin</option>
              <?php foreach($admin as $data): ?>
              <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="date">Mulai Tanggal</label>
            <input type="date" class="form-control" id="startDate" name="startDate"/>
          </div>
          <div class="form-group">
            <label for="date">Sampai Tanggal</label>
            <input type="date" class="form-control" id="endDate" name="endDate"/>
          </div>
          <div class="mt-4">
            <button class="btn btn-primary waves-effect waves-light" type="button" id="exportBtn">Export</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/libs/selectize/js/standalone/selectize.min.js') ?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url('ajax/crudOrder.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('formExport').addEventListener('click', function(event) {
    if (event.target.id === 'exportBtn') {
      var startDate = document.getElementById('startDate').value;
      var endDate = document.getElementById('endDate').value;
      var id = document.getElementById('id_admin').value;
      var url = `${base_url}dashboard/orders/laporan/${startDate}/${endDate}/${id}`;
      window.open(url, '_blank');
    }
  });
});
</script>
<?= $this->endSection() ?>
