<?= $this->extend('Template/template.php') ?>
<?= $this->section('main_header') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Form Open</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">form Open</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?= $this->endSection() ?>
<?= $this->section('main_content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Directory Control</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center">No</td>
                            <td>name</td>
                            <td>type</td>
                            <td>date</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($dir as $file):
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><a href="<?= base_url() ?>directorycontrol/open?name=<?= $file["title"] ?>"><?= $file["title"] ?></a></td>
                                <td><?= $file["type"] ?></td>
                                <td><?= $file["date"] ?></td>
                                <td style="display:flex;justify-content:center"><a class="btn btn-danger" href="./directorycontrol/delete/<?= $file["title"] ?>" role="button">Delete</a></td>
                            </tr>

                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>