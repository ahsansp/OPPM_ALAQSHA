<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url() ?>dist/img/LOGO no bg.png">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url() ?>plugins/summernote/summernote-bs4.min.css">
  <?= $this->renderSection('html_header') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= base_url() ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">OPPMA</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url() ?>dist/img/LOGO.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">OPPMA ALI UTSMAN</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <?php if (session()->get('role') == 'admin') : ?>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active" href="./index.html">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-edit"></i>
                  <p>
                    Jadwal Maker
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url() ?>form/PT" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jadwal PT</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>form/PA" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jadwal PA</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>form/imam" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jadwal Imam</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url() ?>directorycontrol" class="nav-link" href="./index.html">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Directory Control
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-columns"></i>
                  <p>
                    Absen
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url() ?>absen/rekap-absen/ubk-1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Input Absen</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>absen/rekap/print" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Print Rekapan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>absen/rekap/tahunan?tahun=<?= date('Y') ?>&bulan=<?= date('n') ?>&kobong=Kelas+1&jenis=shalat" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Absen tahunan</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-edit"></i>
                  <p>
                    Data control
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/kenaikan-kelas" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kenaikan Kelas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/perpindahan-kobong" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Perpindahan Kobong</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/santri-baru" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>santri baru</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/db-control" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>DB Control</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= site_url() ?>/calendar" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Calendar
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/gallery.html" class="nav-link">
                  <i class="nav-icon far fa-image"></i>
                  <p>
                    Gallery
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url() ?>/logout" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>
            </ul>
          </nav>
        <?php endif;
        if (session()->get('role') == 'user') :
        ?>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-columns"></i>
                  <p>
                    Absen
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url() ?>absen/rekap/tahunan?tahun=<?= date('Y') ?>&bulan=<?= date('n') ?>&kobong=Kelas+1&jenis=shalat" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Absen tahunan</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-edit"></i>
                  <p>
                    Data control
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/kenaikan-kelas" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kenaikan Kelas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/perpindahan-kobong" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Perpindahan Kobong</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/santri-baru" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>santri baru</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url() ?>datacontrol/db-control" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>DB Control</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= site_url() ?>/calendar" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>
                    Calendar
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/gallery.html" class="nav-link">
                  <i class="nav-icon far fa-image"></i>
                  <p>
                    Gallery
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url() ?>/logout" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>
            </ul>
          </nav>
        <?php endif; ?>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?= $this->renderSection('main_header') ?>
      <!-- /.content-header -->

      <!-- Main content -->
      <?= $this->renderSection('main_content') ?>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer d-print-none">
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?= base_url() ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url() ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url() ?>plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <!-- <script src="<?= base_url() ?>plugins/sparklines/sparkline.js"></script> -->
  <!-- JQVMap -->
  <script src="<?= base_url() ?>plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?= base_url() ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= base_url() ?>plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url() ?>plugins/moment/moment.min.js"></script>
  <script src="<?= base_url() ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url() ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?= base_url() ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url() ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?= base_url() ?>dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="<?= base_url() ?>dist/js/pages/dashboard.js"></script> -->
  <script src="<?= base_url() ?>js/script.js"></script>
  <!-- spesific page script -->
  <?= $this->renderSection('script') ?>

</body>

</html>