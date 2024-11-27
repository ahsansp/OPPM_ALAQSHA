<?= $this->extend('Template/template.php') ?>
<?= $this->section('html_header') ?>
<title>Jadwal PA Maker</title>
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url() ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
  .dropdown-item {
    cursor: pointer;
  }
</style>
<?= $this->endSection() ?>
<?= $this->section('main_header') ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Jadwal Maker</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<? base_url() ?>">Home</a></li>
          <li class="breadcrumb-item active">Jadwal Piket Asrama Maker</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('main_content') ?>
<div class="col-md-10 mx-auto">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Jadwal PA</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="../form/print/PA">
      <div class="card-body">
        <p>Judul</p>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            </button>
            <ul class="dropdown-menu">
              <li class="dropdown-item" onclick="insert_value(this)">Piket Rayyon UBK</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Rayyon SAA</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Rayyon ALI</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Rayyon ABBAS</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Aula Lantai 1</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Aula Lantai 2</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Mujaffaf Lantai 3</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Mujaffaf Lantai 2</li>
              <li class="dropdown-item" onclick="insert_value(this)">Piket Gerobak</li>
            </ul>
          </div>
          <!-- /btn-group -->
          <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
          <p>Tanggal</p>
          <div class="input-group date" id="reservationdate" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="date" required />
            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="typeNumber">Orang per hari</label>
            <input value='2' type="number" id="typeNumber" class="form-control" name="orang" min='1' max='10' required />
          </div>
        </div>
        <div class="form-group">
          <p>kobong</p>
          <select class="form-control select2bs4" style="width: 100%;" name="kobong[]" multiple required>
            <?php
            foreach ($kobong as $value):
            ?>
              <option value="<?= $value['kobong'] ?>"><?= $value['kobong'] ?></option>
            <?php
            endforeach;
            ?>
          </select>
        </div>
        <div class="form-group" id="NB-parent">
          <p>NB:</p>
          <div class="input-group input-group-md mb-2" id="NB">
            <input type="text" class="form-control" name="NB[]">
            <span class="input-group-append rounded-end">
              <button onclick="addNB()" type="button" class="btn btn-success btn-flat" style="border-radius:0 .2rem .2rem 0">+</button>
            </span>
          </div>
        </div>

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- Select2 -->
<script src="<?= base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url() ?>plugins/daterangepicker/daterangepicker.js"></script>
<script>
  function addNB() {
    element = document.querySelector('#NB').cloneNode(true);
    element.children[0].value = '';
    parent = document.querySelector('#NB-parent');
    element.children[1].children[0].innerHTML = "-";
    element.children[1].children[0].setAttribute('onclick', 'minNB(this)');
    element.children[1].children[0].classList.replace('btn-success', 'btn-danger')
    parent.appendChild(element);
  }

  function minNB(self) {
    parent.removeChild(self.parentElement.parentElement);
  }

  function insert_value(v) {
    v.parentElement.parentElement.nextElementSibling.value = v.innerHTML;
  }
  $(function() {
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
    //Date picker
    $('#reservationdate').datetimepicker({
      format: 'L'
    });
  })
</script>
<?= $this->endSection() ?>