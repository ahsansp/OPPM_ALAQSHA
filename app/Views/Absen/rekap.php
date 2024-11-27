<?= $this->extend('Template/template.php') ?>
<?= $this->section('html_header') ?>
<!-- daterange picker -->
<link
  rel="stylesheet"
  href="<?= base_url() ?>plugins/daterangepicker/daterangepicker.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>plugins/select2/css/select2.min.css" />
<link
  rel="stylesheet"
  href="<?= base_url() ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" />
<style>

</style>
<?= $this->endSection() ?>
<?= $this->section('main_header') ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Rekap Absen</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Rekap Absen</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('main_content') ?>
<section class="content">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title align-self-center">Kobong</h3>
        <div class="input-group-prepend my-0 mx-1">
          <select name="kobong" id="kobong" onchange="kobong(this)">
            <?php
            foreach ($list_kobong as $kobong) :
            ?>
              <option value="<?= $kobong ?>" <?= ($kobong == $nama_kobong) ? "selected" : "" ?>><?= $kobong ?></option>
            <?php
            endforeach;
            ?>
          </select>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form action="<?= base_url() ?>/absen/rekap/api" method="POST" id="form">
          <input type="hidden" name="kobong" id="input_kobong">
          <div class="row mb-2">
            <div class="input-group col-1">
              <button type="submit" id="rekap" class="btn btn-primary mr-2">rekap</button>
            </div>
            <div class="input-group date col-4" id="reservationdate" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="date" required>
              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                <div class="input-group-text">
                  <i class="fa fa-calendar"></i>
                </div>
              </div>
            </div>
            <div class="input-group col-4">
              <select name="jenis_absen" id="jenis_absen" class="form-control">
                <option value="subuh">absen shalat subuh</option>
                <option value="dzuhur">absen shalat dzuhur</option>
                <option value="ashar">absen shalat ashar</option>
                <option value="maghrib">absen shalat maghrib</option>
                <option value="isya">absen shalat isya</option>
                <option value="kobong">absen kobong</option>
              </select>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">No</th>
                <th>Nama</th>
                <th style="width: 40px">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($santri as $obj):
              ?>
                <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td><?= $obj->nama_lengkap ?></td>
                  <td class="p-0">
                    <select name="ket[<?= $obj->santri_id ?>]" id="ket" class="form-control">
                      <option value="H" selected>Hadir</option>
                      <option value="P">Pulang</option>
                      <option value="S">Sakit</option>
                      <option value="I">Izin</option>
                      <option value="A">Tanpa Keterangan</option>
                      <option value="D">Dispen</option>
                    </select>
                  </td>
                </tr>
              <?php
                $no++;
              endforeach;
              ?>
            </tbody>
          </table>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- Select2 -->
<script src="<?= base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url() ?>plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url() ?>plugins/daterangepicker/daterangepicker.js"></script>
<script>
  <?= (session()->get('data')) ? "alert('" . session()->get('data') . "')" : "" ?>

  function kobong(element) {
    kobong = element.value;
    kobong = kobong.toLowerCase();
    kobong = kobong.replace(' ', '-');
    location.href = "<?= base_url() ?>absen/rekap-absen/" + kobong;
  }
  document.getElementById('input_kobong').value = document.getElementById('kobong').value;
  document.addEventListener('keydown', function(e) {
    if (e.key == 'Enter' || e.key == 'ArrowDown') {
      e.preventDefault();
      activeElement = document.activeElement;
      if (activeElement.tagName == "INPUT") {
        document.getElementById('input' + (Number(activeElement.id.slice(5)) + 1)).focus();
      }
    }
    if (e.key == 'ArrowUp') {
      e.preventDefault();
      activeElement = document.activeElement;
      if (activeElement.tagName == "INPUT") {
        document.getElementById('input' + (Number(activeElement.id.slice(5)) - 1)).focus();
      }
    }
    console.log(e.key);
  });
  // document.getElementById('date').addEventListener('keydown', function(e) {
  //   if (Number.isInteger(parseInt(e.key))) {

  //   } else {
  //     e.preventDefault();
  //   }
  // })
  $(function() {
    //Date picker
    $("#reservationdate").datetimepicker({
      format: "DD/MM/YYYY"
    });
    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {
      placeholder: "dd/mm/yyyy"
    });
    //Initialize Select2 Elements
    $("#kobong").select2({
      theme: "bootstrap4",
    });
  })
</script>
<?= $this->endSection() ?>