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
                <h1>Rekapan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Print Rekapan</li>
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
                        <?php foreach ($list_kobong as $kobong) : ?>
                            <option value="<?= $kobong ?>"><?= $kobong ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?= base_url() ?>absen/rekap/print" method="POST" id="form">
                    <input type="hidden" name="kobong" value="" id="form_kobong">
                    <div class="row mb-4 d-flex col-5 align-items-center col-12">
                        <div class="form-group d-flex col-5 align-items-center mb-0">
                            <label>Date range:</label>
                            <div class="input-group col-9">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control float-right"
                                    id="reservation"
                                    name="date" />
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="input-group col-4">
                            <select name="jenis_absen" id="jenis_absen" class="form-control">
                                <option value="shalat">absen shalat</option>
                                <option value="kobong">absen kobong</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary">rekap</button>
                        </div>
                    </div>
                    <div class="col-12 table-responsive " <?= (!isset($none)) ? 'style="height: 500px;"' : '' ?>>
                        <table class="table table-bordered table-head-fixed text-nowrap">
                            <thead>
                                <?php
                                if (!isset($none)) {


                                    echo '<tr>';
                                    echo '<th class="text-center" rowspan="2" style="vertical-align: middle;">No</th>';
                                    echo '<th class="text-center" rowspan="2" style="vertical-align: middle;">Nama</th>';
                                    foreach ($tanggal as $tgl) {
                                        echo '<th class="text-center" colspan="6" style="vertical-align: middle;">' . $tgl . '</th>';
                                    }
                                    echo '</tr>';
                                    echo '<tr class="position-sticky" style="top: 50px; z-index: 10;background-color: white">';
                                    foreach ($tanggal as $tgl) {
                                        echo '<th class="text-center bg-white" style="vertical-align: middle;">H</th>';
                                        echo '<th class="text-center bg-white" style="vertical-align: middle;">S</th>';
                                        echo '<th class="text-center bg-white" style="vertical-align: middle;">A</th>';
                                        echo '<th class="text-center bg-white" style="vertical-align: middle;">P</th>';
                                        echo '<th class="text-center bg-white" style="vertical-align: middle;">I</th>';
                                        echo '<th class="text-center bg-white" style="vertical-align: middle;">D</th>';
                                    }
                                    echo '</tr>';
                                ?>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach ($absen as $nama => $data): ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td><?= $nama ?></td>
                                        <?php
                                        foreach ($data as $tgl => $ket) {
                                            foreach ($ket as $value) {
                                                echo '<td class="text-center">' . $value . '</td>';
                                            }
                                        }
                                        ?>
                                    </tr>
                            <?php
                                        $no++;
                                    endforeach;
                                } ?>
                            </tbody>
                        </table>
                    </div>

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
<!-- date-range-picker -->
<script src="<?= base_url() ?>plugins/daterangepicker/daterangepicker.js"></script>
<script>
    // document.getElementById("toglebtn").click();
    document.getElementById("form_kobong").value = document.getElementById("kobong").value;

    function kobong() {
        document.getElementById("form_kobong").value = document.getElementById("kobong").value;
    }

    $(function() {
        //Date range picker
        $("#reservation").daterangepicker({
            locale: {
                format: "DD/MM/YYYY"
            }
        });
        $("#reservation2").daterangepicker({
            locale: {
                format: "DD/MM/YYYY"
            }
        });
        $("#kobong").select2({
            theme: "bootstrap4",
        });
    })
</script>
<?= $this->endSection() ?>