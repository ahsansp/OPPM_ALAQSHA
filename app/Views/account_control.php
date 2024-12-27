<?= $this->extend('Template/template.php') ?>
<?= $this->section('main_header') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Account Control</h1>
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
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Hello <?= session()->get("username")?>
                </div>
                <div class="card-body">
                    <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username: <?= session()->get("username")?></label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Role: <?= session()->get("role")?></label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</section>
<?= $this->endSection() ?>