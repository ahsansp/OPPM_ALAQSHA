<?= $this->extend('Template/template.php') ?>
<?= $this->section('html_header') ?>
<!-- DataTables -->
<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>plugins/select2/css/select2.min.css" />
<link
    rel="stylesheet"
    href="<?= base_url() ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" />
<style>
    #dataSantri {
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main_header') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Base Control</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Base Control</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('main_content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul
                            class="nav nav-tabs"
                            id="custom-tabs-one-tab"
                            role="tablist">
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    id="custom-tabs-one-home-tab"
                                    data-toggle="pill"
                                    href="#custom-tabs-one-home"
                                    role="tab"
                                    aria-controls="custom-tabs-one-home"
                                    aria-selected="true">Santri</a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    id="custom-tabs-one-profile-tab"
                                    data-toggle="pill"
                                    href="#custom-tabs-one-profile"
                                    role="tab"
                                    aria-controls="custom-tabs-one-profile"
                                    aria-selected="false">kelas</a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    id="custom-tabs-one-messages-tab"
                                    data-toggle="pill"
                                    href="#custom-tabs-one-messages"
                                    role="tab"
                                    aria-controls="custom-tabs-one-messages"
                                    aria-selected="false">Kobong</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div
                                class="tab-pane fade show active"
                                id="custom-tabs-one-home"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-home-tab">
                                <table class="table" id="table_santri">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>santri ID</td>
                                            <td>Nama Lengkap</td>
                                            <td>Nama Pendek</td>
                                            <td>Kelas Kmmi</td>
                                            <td>Kelas Umum</td>
                                            <td>Kobong</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($santri as $nama) :
                                        ?>
                                            <tr>
                                                <td onclick="edit(this)" id="dataSantri"><?= $no++ ?></td>
                                                <td onclick="edit(this)" id="dataSantri"><?= $nama['santri_id'] ?></td>
                                                <td onclick="edit(this)" id="dataSantri"><?= $nama['nama_lengkap'] ?></td>
                                                <td onclick="edit(this)" id="dataSantri"><?= $nama['nama_pendek'] ?></td>
                                                <td onclick="edit(this)" id="dataSantri"><?= $nama['kmmi'] ?></td>
                                                <td onclick="edit(this)" id="dataSantri"><?= $nama['umum'] ?></td>
                                                <td onclick="edit(this)" id="dataSantri"><?= $nama['kobong'] ?></td>
                                            </tr>

                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div
                                class="tab-pane fade"
                                id="custom-tabs-one-profile"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-profile-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-1">No</td>
                                            <td>KMMI</td>
                                            <td>UMUM</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($kelas as $kls) :
                                        ?>
                                            <tr id="dataKelas">
                                                <td onclick="edit_kelas(this)"><?= $no++ ?></td>
                                                <td onclick="edit_kelas(this)"><?= $kls['kmmi'] ?></td>
                                                <td onclick="edit_kelas(this)"><?= $kls['umum'] ?></td>
                                                <td style="display: none;" id="dataKelas"><?= $kls['id'] ?></td">
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div
                                class="tab-pane fade"
                                id="custom-tabs-one-messages"
                                role="tabpanel"
                                aria-labelledby="custom-tabs-one-messages-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-1">No</td>
                                            <td>KOBONG</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($kobong as $kob) :
                                        ?>
                                            <tr id="dataKobong">
                                                <td onclick="edit_kobong(this)"><?= $no++ ?></td>
                                                <td onclick="edit_kobong(this)"><?= $kob['kobong'] ?></td>
                                                <td style="display: none;" id="dataKobong"><?= $kob['id'] ?></td">
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalSantri" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= base_url() ?>datacontrol/db-control/update/santri" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <input type="hidden" name="santri_id" id="santri_id">
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama lengkap:</label>
                            <input type="text" class="form-control " id="nama" name="nama_lengkap">
                        </div>
                        <div class="form-group">
                            <label for="nama-pendek" class="col-form-label">Nama Pendek:</label>
                            <input type="text" class="form-control " id="nama-pendek" name="nama_pendek">
                        </div>
                        <div class="form-group">
                            <label for="kelas" class="col-form-label col-2">kelas:</label>
                            <select name="kelas" id="kelas-input">
                                <?php
                                $kelas_json = json_encode($kelas);
                                foreach ($kelas as $kls) :
                                ?>
                                    <option value="<?= $kls['kmmi'] ?>"><?= $kls['kmmi'] ?> | <?= $kls['umum'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kobong" class="col-form-label col-2">Kobong:</label>
                            <select name="kobong" id="kobong-input">
                                <?php
                                // dd($santri);
                                $santri_json = json_encode($santri);
                                $santri_json = str_replace("'", "%27", $santri_json);
                                foreach ($kobong as $kob) :
                                ?>
                                    <option value="<?= $kob['kobong'] ?>"><?= $kob['kobong'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit()">Save</button>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= base_url() ?>datacontrol/db-control/update/kelas" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kelas_id" id="kelas_id">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="kmmi" class="col-form-label">Kmmi:</label>
                            <input type="text" class="form-control " id="kmmi" name="kmmi">
                        </div>
                        <div class="form-group">
                            <label for="umum" class="col-form-label">Umum:</label>
                            <input type="text" class="form-control " id="umum" name="umum">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit()">Save</button>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalKobong" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= base_url() ?>datacontrol/db-control/update/kobong" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kobong_id" id="kobong_id">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="kobong" class="col-form-label">Kobong:</label>
                            <input type="text" class="form-control " id="kobong" name="kobong">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit()">Save</button>

                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- Select2 -->
<script src="<?= base_url() ?>plugins/select2/js/select2.full.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?= base_url() ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    // kelas = JSON.parse('<?= $kelas_json ?>');
    slected = null;
    data = <?= $santri_json ?>;
    $(function() {
        bsCustomFileInput.init();
        $("#kobong-input").select2({
            theme: "bootstrap4",

        });
        $("#kelas-input").select2({
            theme: "bootstrap4",
        });
        $('#table_santri').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });

    function edit(e) {
        element = e;
        if (slected == e.parentElement) {
            $('#modalSantri').modal('show');
            document.getElementById('santri_id').value = e.parentElement.children[1].innerHTML;
            document.getElementById('nama').value = e.parentElement.children[2].innerHTML;
            document.getElementById('nama-pendek').value = e.parentElement.children[3].innerHTML;
            $('#kelas-input').val(e.parentElement.children[4].innerHTML).trigger('change');
            $('#kobong-input').val(e.parentElement.children[6].innerHTML).trigger('change');
            slected = null;

            e.parentElement.style.background = "";
        } else {
            document.querySelectorAll("tr").forEach((element) => {
                element.style.background = "";
            })
            slected = e.parentElement
            e.parentElement.style.background = "#AFEEEE";
        }
        // console.log(e);
    }

    function edit_kelas(e) {
        element = e;
        if (slected == e.parentElement) {
            $('#modalKelas').modal('show');
            document.getElementById('kelas_id').value = parseInt(e.parentElement.children[3].innerHTML);
            document.getElementById('kmmi').value = e.parentElement.children[1].innerHTML;
            document.getElementById('umum').value = e.parentElement.children[2].innerHTML;
            slected = null;
            e.parentElement.style.background = "";
        } else {
            document.querySelectorAll("tr").forEach((element) => {
                element.style.background = "";
            })
            slected = e.parentElement
            e.parentElement.style.background = "#AFEEEE";
        }
        // console.log(e);
    }

    function edit_kobong(e) {
        element = e;
        if (slected == e.parentElement) {
            $('#modalKobong').modal('show');
            document.getElementById('kobong_id').value = parseInt(e.parentElement.children[2].innerHTML);
            document.getElementById('kobong').value = e.parentElement.children[1].innerHTML;
            slected = null;
            e.parentElement.style.background = "";
        } else {
            document.querySelectorAll("tr").forEach((element) => {
                element.style.background = "";
            })
            slected = e.parentElement
            e.parentElement.style.background = "#AFEEEE";
        }
    }
</script>
<?= $this->endSection() ?>