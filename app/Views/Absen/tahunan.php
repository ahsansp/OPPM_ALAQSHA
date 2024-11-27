<?= $this->extend('Template/template.php') ?>
<?= $this->section('html_header') ?>
<link
    rel="stylesheet"
    href="<?= base_url() ?>plugins/daterangepicker/daterangepicker.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>plugins/select2/css/select2.min.css" />
<link
    rel="stylesheet"
    href="<?= base_url() ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" />
<style>
    #table {
        overflow-x: scroll;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('main_header') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Absen Tahunan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Absen</a></li>
                    <li class="breadcrumb-item active">Absen Tahunan</li>
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
            <form action="" method="get" id="form">
                <div class="card-header d-flex">
                    <h3 class="card-title align-self-center">Kobong</h3>
                    <div class="input-group-prepend my-0 mx-1">
                        <input type="number" class="form-control" name="tahun" id="tahun" value="<?= (isset($tahun)) ? $tahun : (int)date('Y') ?>" onchange="tahun(this)">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-1 d-flex">
                            <button class="btn col-6 btn-primary rounded-right" onclick="if(parseInt(document.getElementById('bulan').value) - 1 < 1){document.getElementById('bulan').value = 12; document.getElementById('tahun').value = parseInt(document.getElementById('tahun').value) - 1}else{document.getElementById('bulan').value = parseInt(document.getElementById('bulan').value) - 1}"><span class="fa fa-chevron-left"></span></button>
                            <button class="btn col-6 btn-primary rounded-left" onclick="if(parseInt(document.getElementById('bulan').value) + 1 > 12){document.getElementById('bulan').value = 1; document.getElementById('tahun').value = parseInt(document.getElementById('tahun').value) + 1}else{document.getElementById('bulan').value = parseInt(document.getElementById('bulan').value) + 1}"><span class="fa fa-chevron-right"></span></button>
                        </div>
                        <div class="col-8">
                            <input type="hidden" name="bulan" id="bulan" value="<?= (isset($bulan)) ? $bulan : date('n') ?>">
                            <?php
                            $bulan_name = [
                                '1' => 'Januari',
                                '2' => 'Februari',
                                '3' => 'Maret',
                                '4' => 'April',
                                '5' => 'Mei',
                                '6' => 'Juni',
                                '7' => 'Juli',
                                '8' => 'Agustus',
                                '9' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            ]
                            ?>
                            <h1 class="text-center"><?= $bulan_name[(isset($bulan)) ? $bulan : date('n')] . " " . date('Y') ?></h1>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-2">
                            <div class="inout-group">
                                <select name="kobong" id="kobong">
                                    <?php
                                    foreach ($list_kobong as $value) {
                                    ?>
                                        <option value="<?= $value ?>" <?= ($value == $kobong) ? "selected" : "" ?>><?= $value ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group col-4">
                            <select name="jenis" id="jenis_absen" class="form-control">
                                <option value="shalat" <?= ($jenis == 'shalat') ? "selected" : "" ?>>absen shalat</option>
                                <option value="kobong" <?= ($jenis == 'kobong') ? "selected" : "" ?>>absen kobong</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-default" onclick="print()" type="button">Print To Excel</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive" style="height: 500px;">
                            <table class="table table-bordered table-head-fixed text-nowrap" id="table">
                                <thead>
                                    <?php
                                    if ($jenis == 'kobong') {
                                        echo '<tr>';
                                        echo '<th class="text-center" style="vertical-align: middle;">No</th>';
                                        echo '<th class="text-center" style="vertical-align: middle;">Nama</th>';
                                        for ($i = 0; $i < $full_month; $i++) {
                                            echo "<th class='text-center' style='vertical-align: middle;'>" . ($i + 1) . "</th>";
                                        }
                                        echo '</tr>';
                                    } elseif ($jenis == 'shalat') {
                                        echo '<tr>';
                                        echo '<th class="text-center" rowspan="2" style="vertical-align: middle;">No</th>';
                                        echo '<th class="text-center" rowspan="2" style="vertical-align: middle;">Nama</th>';
                                        for ($i = 0; $i < $full_month; $i++) {
                                            echo '<th class="text-center" colspan="5" style="vertical-align: middle;">' . ($i + 1) . '</th>';
                                        }
                                        echo '</tr>';
                                        echo '<tr class="position-sticky" style="top: 50px; z-index: 10;background-color: white">';
                                        for ($i = 0; $i < $full_month; $i++) {
                                            echo '<th class="text-center bg-white" style="vertical-align: middle;">S</th>';
                                            echo '<th class="text-center bg-white" style="vertical-align: middle;">D</th>';
                                            echo '<th class="text-center bg-white" style="vertical-align: middle;">A</th>';
                                            echo '<th class="text-center bg-white" style="vertical-align: middle;">M</th>';
                                            echo '<th class="text-center bg-white" style="vertical-align: middle;">I</th>';
                                        }
                                        echo '</tr>';
                                    }
                                    ?>


                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if ($jenis == 'kobong') {
                                        foreach ($absen as $nama => $value) {
                                            echo '<tr>';
                                            echo '<td class="text-center" style="vertical-align: middle;">' . $no++ . '</td>';
                                            echo '<td class="text-left" style="vertical-align: middle;">' . $nama . '</td>';
                                            if ($jenis = 'kobong') {
                                                for ($i = 0; $i < $full_month; $i++) {
                                                    if (isset($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)])) {
                                                        echo '<td class="text-center' . (($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)] == 'H') ? ' bg-success' : ' bg-danger') . '" style="vertical-align: middle;">' . $value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)] . '</td>';
                                                    } else {
                                                        echo '<td class="text-center" style="vertical-align: middle;">-</td>';
                                                    }
                                                }
                                            }
                                            echo '</tr>';
                                        }
                                    } elseif ($jenis == 'shalat') {
                                        foreach ($absen as $nama => $value) {
                                            echo '<tr>';
                                            echo '<td class="text-center" style="vertical-align: middle;">' . $no++ . '</td>';
                                            echo '<td class="text-left" style="vertical-align: middle;">' . $nama . '</td>'; {
                                                for ($i = 0; $i < $full_month; $i++) {
                                                    if (isset($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)])) {
                                                        $waktu = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
                                                        for ($j = 0; $j < 5; $j++) {
                                                            if ($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)][$waktu[$j]] != "-") {
                                                                echo '<td class="text-center bg-' . (($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)][$waktu[$j]] == 'H') ? 'success' : 'danger') . '" style="vertical-align: middle;">' . $value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)][$waktu[$j]] . '</td>';
                                                            } else {
                                                                echo '<td class="text-center" style="vertical-align: middle;">-</td>';
                                                            }
                                                        }
                                                    } else {
                                                        for ($j = 0; $j < 5; $j++) {
                                                            echo '<td class="text-center" style="vertical-align: middle;">-</td>';
                                                        }
                                                    }
                                                }
                                            }
                                            // dd($absen);
                                            echo '</tr>';
                                        }
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
</section>
<?php
$absen = json_encode($absen);
$absen = str_replace("'", '%27', $absen);
?>
<form id="printForm" action="<?= base_url() ?>absen/rekap/print-tahunan" method="post">
    <input type="hidden" name="absen" value='<?= $absen ?>'>
    <input type="hidden" name="jenis" value='<?= $jenis ?>'>
    <input type="hidden" name="full_month" value='<?= $full_month ?>'>
    <input type="hidden" name="bulan" value='<?= $bulan ?>'>
    <input type="hidden" name="tahun" value='<?= $tahun ?>'>

</form>
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
    prnt = false;

    function print() {
        prnt = true;
        document.getElementById('printForm').submit();
    }
    value = document.getElementById('kobong').value;
    document.getElementById('form').addEventListener('input', function(e) {
        console.log(e.target.value);
        document.getElementById('form').submit();

    })
    document.addEventListener('mouseup', function(e) {
        if (value != document.getElementById('kobong').value) {
            document.getElementById('form').submit();
        }
    })
    // document.getElementById('kobong')
    $(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    })
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