<?= $this->extend('Template/template.php') ?>
<?= $this->section('html_header') ?>
<style>
  .d-table-c {
    display: table-cell;
  }
</style>
<?= $this->endSection() ?>
<?= $this->section('main_header') ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Invoice</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Invoice</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<?= $this->endSection() ?>
<?= $this->section('main_content') ?>
<section class="content">
  <div class="invoice p-3 mb-3">
    <div class="row">
      <div class="col-12 bg-success pt-1 mb-3">
        <h3 class="text-center mb-0"><?= $title ?></h3>
      </div>
      <div class="col-12 d-flex flex-wrap">
        <table class="table table-bordered border-dark" border="1">
          <tr>
            <th class="text-center border-dark">Tanggal</th>
            <?php
            foreach ($waktu as $value) {
              echo '<th class="text-center border-dark">' . $value . '</th>';
              echo '<th id="ttd" class="text-center border-dark">TTD</th>';
            }
            ?>
          </tr>
          <?php
          $file = str_replace("'", "%27", $file);
          foreach ($data as $key => $value) :
          ?>
            <tr>
              <?php
              $tanggal = date('d-m-Y', $key);
              echo '<td class="text-center border-dark">' . $tanggal . '</td>';
              foreach ($value as $nama) :
              ?>
                <td class="border-dark"><?= $nama ?></td>
                <td id="ttd" class="border-dark"></td>
              <?php
              endforeach;
              ?>
            </tr>
          <?php
          endforeach;
          ?>
        </table>
      </div>
    </div>
    <div class="col-12">
      <ul>
        <?php
        foreach ($NB as $value) :
          echo ($value == '') ? '' : '<li>' . $value . '</li>';
        endforeach
        ?>
      </ul>

    </div>
    <div class="row no-print">
      <div class="col-12">
        <button onclick="window.print()" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
        <?php
        if (!isset($saved)) :
        ?>
          <button rel="noopener" target="_blank" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter" onclick="save()"><i class="fas fa-download"></i>Save</button>

        <?php
        endif;
        ?>
        <button onclick="hide()" class="btn btn-default"> TTD Cells</button>
        <button rel="noopener" target="_blank" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter" onclick="exportToExcel()">save to excel
        </button>
      </div>
    </div>

  </div>
  </div>
</section>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">File Name:</label>
          <input type="text" class="form-control " id="file_name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submit()">Save</button>

      </div>
    </div>
  </div>
</div>

<form action="<?= base_url() ?>directorycontrol" method="post" id="form">
  <?php
  $file = str_replace("'", "%27", $file);
  // dd($file);
  ?>
  <input type="hidden" name="file" id="field" value='<?= (isset($file)) ? $file : '' ?>'>
  <input type="hidden" name="nama" id="nama">
  <input type="hidden" name="ttd" id="ttd_form">
</form>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
  document.getElementById('file_name').addEventListener('input', function(e) {
    if (document.getElementById('form').getAttribute('action') == '<?= base_url() ?>directorycontrol') {
      postData(e.target.value)
    }
  });

  function exportToExcel() {
    document.getElementById('form').setAttribute('action', '<?= base_url() ?>exportToExcelimam');
  }

  function save() {
    document.getElementById('form').setAttribute('action', '<?= base_url() ?>directorycontrol');
  }

  function submit() {
    if (document.getElementById('file_name').classList.contains('is-valid') && document.getElementById('form').getAttribute('action') == '<?= base_url() ?>directorycontrol') {
      document.getElementById('nama').value = document.getElementById('file_name').value;
      document.getElementById('form').submit();
    } else if (document.getElementById('form').getAttribute('action') == '<?= base_url() ?>exportToExcelimam') {
      document.getElementById('nama').value = document.getElementById('file_name').value;
      document.getElementById('ttd_form').value = (document.getElementById('ttd').style.display == "" || document.getElementById('ttd').style.display != 'none');
      // console.log(document.getElementById('form'));
      document.getElementById('form').submit();
    }
  }

  function hide() {

    ttd_display = document.getElementById('ttd').style.display;
    if (ttd_display == "" || ttd_display != 'none') {
      ttd_display = 'none';
    } else {
      ttd_display = 'table-cell';
    }
    ttd_cells = document.querySelectorAll("#ttd");
    ttd_cells.forEach(cell => {
      cell.style.display = ttd_display;
    });
  }

  function postData(file_name) {

    const xhr = new XMLHttpRequest();

    // Membuka koneksi ke server dengan metode POST dan secara asynchronous (true)
    xhr.open('POST', '<?= base_url()?>directorycontrol/file_name', true);

    // Mengatur header agar server tahu bahwa data yang dikirim adalah JSON
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Fungsi callback untuk menangani response saat request berhasil
    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        if (JSON.parse(xhr.responseText).success) {
          document.getElementById('file_name').classList.remove('is-invalid');
          document.getElementById('file_name').classList.add('is-valid');
        } else {
          document.getElementById('file_name').classList.remove('is-valid');
          document.getElementById('file_name').classList.add('is-invalid');
        } // Menampilkan response jika berhasil
      } else {
        console.error('Error:', xhr.status, xhr.statusText); // Menangani status error
      }
    };

    // Fungsi callback untuk menangani error jika request gagal
    xhr.onerror = function() {
      console.error('Request failed');
    };

    // Data yang akan dikirim dengan format JSON
    const data = JSON.stringify({
      name: file_name
    });

    // Mengirim data
    xhr.send(data);

    // Mengembalikan ress

  }
</script>
<?= $this->endSection() ?>