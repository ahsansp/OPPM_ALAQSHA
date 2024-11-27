<?= $this->extend('Template/template.php') ?>
<?= $this->section('main_header') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Santri Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Santri Baru</li>
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
            <div class="card card-primary col-12 p-0">
                <div class="card-header">
                    <h3 class="card-title">Input Data Santri</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="<?= base_url() ?>/datacontrol/santri-baru" enctype="multipart/form-data">
                    <?php $validationData = session()->getFlashdata('validation');

                    if ($validationData !== null && is_array($validationData)) {
                        // Convert the array to an object
                        $validationData = (object) $validationData;
                    }

                    if ($validationData !== null) :
                        // Rest of the code remains the same
                    ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($validationData->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="template_download" class="mr-3"> Template file excel :</label>
                            <a href="/templateExcel/santri_baru.xlsx" id="template_download" class="btn btn-primary" download="santri_baru">Download Template File</a>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="file">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <?php
                if (session()->getFlashdata('error')) {
                    echo '<div class="alert alert-danger">' . session()->getFlashdata('error') . '</div>';
                }
                ?>
                <?php if (session()->get('tabel_santri_baru')) : ?>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center col-1">
                                    <td>No</td>
                                    <td>Nama Lengkap</td>
                                    <td>Nama Pendek</td>
                                    <td>Kelas</td>
                                    <td>Kobong</td>
                                    <td>angkatan</td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach (session()->get('tabel_santri_baru') as $key => $value) : ?>
                                    <tr>
                                        <td class="text-center col-1"><?= $no++ ?></td>
                                        <td class="<?= ($value['nama_ada'] == 0) ? "" : "bg-danger" ?>"><?= $value["nama"] ?></td>
                                        <td class="<?= ($value['nama_ada'] == 0) ? "" : "bg-danger" ?>"><?= $value["nama_pendek"] ?></td>
                                        <td class="<?= ($value['kelas_con'] != 0) ? "" : "bg-warning" ?>"><?= $value["kmmi"] ?></td>
                                        <td class="<?= ($value['kobong_con'] != 0) ? "" : "bg-warning" ?>"><?= $value["kobong"] ?></td>
                                        <td class=""><?= isset($value["angkatan"]) ? $value["angkatan"] : ""  ?></td>

                                    </tr>
                                <?php endforeach;
                                ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <p>data yang tidak sesuai akan otomatis tidak ter update</p>
                            <a href="<?= base_url() ?>datacontrol/santri-baru/update" class="btn btn-primary">Update</a>
                            <a href="<?= base_url() ?>datacontrol/santri-baru/cencel" class="btn btn-primary">cencel</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- bs-custom-file-input -->
<script src="<?= base_url() ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<?= $this->endSection() ?>