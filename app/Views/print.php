<?= $this->extend('Template/template.php') ?>
<?= $this->section('html_header') ?>
<style>
  .d-table-c{
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
            <div class="col-12 bg-success pt-1">
                <h3 class="text-center mb-0"><?=$title?></h3>
            </div>
            <div class="col-12 d-flex flex-wrap">
            <?php 
            foreach ($json as $tanggal => $santri) :  
                $tanggal = date('Y-m-d',$tanggal)
            ?>
            <div class="col-2 border border-dark p-0 my-4 overflow-hidden">
                <div class="col-12 border-bottom border-dark text-center"><b><?= $tanggal?></b></div>
                <?php
                    for ($i=0; $i < count($santri); $i++) { 
                        echo '<div class="border-bottom border-dark text-nowarp pl-1">' . $santri[$i] . '</div>';
                    }
                ?>
            </div>
            <?php
            endforeach
            ?>
            </div>
            <?php
            if (count($NB) > 1) :
            ?>
              <div class="col-12">
                <ul>
                <?php
                  foreach ($NB as $value) :
                    
                ?>
                  <li><?= $value?></li>
                <?php
                    endforeach
                ?>
                </ul>
                
              </div>
            <?php
            endif
            ?>
            
        </div>
    </div>
</section>
<?= $this->endSection() ?>
