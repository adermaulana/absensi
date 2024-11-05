<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Guru</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/vertical-light-layout/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
    <a class="sidebar-brand brand-logo" href="index.php"><img src="../assets/images/logo.svg" alt="logo" /></a>
    <a class="sidebar-brand brand-logo-mini ps-4 pt-3" href="index.html"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
  </div>
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="../assets/images/faces/face1.jpg" alt="profile">
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column pe-3">
          <span class="font-weight-medium mb-2"><?= $_SESSION['nama_guru'] ?></span>
        </div>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>        
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        <span class="menu-title">Siswa</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">          
          <li class="nav-item"> <a class="nav-link" href="siswa.php">Data Siswa</a></li>
        </ul>
      </div>
    </li>        
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        <span class="menu-title">Absensi</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="forms">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="absensi.php">Data Absensi</a></li>          
          <li class="nav-item"> <a class="nav-link" href="tambahabsensi.php">Tambah Absensi</a></li>          
        </ul>
      </div>
    </li>    
    <li class="nav-item">
      <a class="nav-link" href="laporan.php">
        <i class="mdi mdi-file-document-box menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li>
  </ul>
</nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">        
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
  <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
    <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="index.html"><img src="../../../assets/images/logo-mini.svg" alt="logo" /></a>
    <button class="navbar-toggler navbar-toggler align-self-center me-2" type="button" data-toggle="minimize">
      <i class="mdi mdi-menu"></i>
    </button>
    <ul class="navbar-nav navbar-nav-right ml-lg-auto">
      <li class="nav-item  nav-profile dropdown border-0">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown">
          <img class="nav-profile-img me-2" alt="" src="../assets/images/faces/face1.jpg">
          <span class="profile-name"><?= $_SESSION['nama_guru'] ?></span>
        </a>
        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="logout.php">
             Signout</a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper pb-0">
            <div class="page-header flex-wrap">
              <h3 class="mb-0">Hi, Selamat Datang! <span class="ps-0 h6 ps-sm-2 text-muted d-inline-block"><?= $_SESSION['nama_guru'] ?></span>
              </h3>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
  </div>
</footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.resize.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.categories.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.stack.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.pie.js"></script>
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/proBanner.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>