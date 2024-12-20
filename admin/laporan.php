<?php

include '../koneksi.php';

session_start();

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();

    header('location:../');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Breeze Admin</title>
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
                <a class="sidebar-brand brand-logo" href="index.html"><img src="../assets/images/logo.svg"
                        alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini ps-4 pt-3" href="index.html"><img
                        src="../assets/images/logo-mini.svg" alt="logo" /></a>
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
                            <span class="font-weight-medium mb-2"><?= $_SESSION['nama_admin'] ?></span>
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
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                        <span class="menu-title">Siswa</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="siswa.php">Data Siswa</a></li>
                            <li class="nav-item"> <a class="nav-link" href="tambahsiswa.php">Tambah Siswa</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-guru" aria-expanded="false"
                        aria-controls="ui-basic">
                        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                        <span class="menu-title">Guru</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-guru">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="guru.php">Data Guru</a></li>
                            <li class="nav-item"> <a class="nav-link" href="tambahguru.php">Tambah Guru</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false"
                        aria-controls="icons">
                        <i class="mdi mdi-contacts menu-icon"></i>
                        <span class="menu-title">Kelas</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="icons">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="kelas.php">Data Kelas</a></li>
                            <li class="nav-item"> <a class="nav-link" href="tambahkelas.php">Tambah Kelas</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false"
                        aria-controls="forms">
                        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                        <span class="menu-title">Absensi</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="absensi.php">Data Absensi</a></li>
                            <li class="nav-item"> <a class="nav-link" href="tambahabsensi.php">Tambah Absensi</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="laporan.php">
                        <i class="mdi mdi-file-document-box menu-icon"></i>
                        <span class="menu-title">Laporan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sekolah.php">
                        <i class="mdi mdi-file-document-box menu-icon"></i>
                        <span class="menu-title">Atur Lokasi Sekolah</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                    <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="index.html"><img
                            src="../../../assets/images/logo-mini.svg" alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center me-2" type="button"
                        data-toggle="minimize">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <ul class="navbar-nav navbar-nav-right ml-lg-auto">
                        <li class="nav-item  nav-profile dropdown border-0">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                                data-bs-toggle="dropdown">
                                <img class="nav-profile-img me-2" alt=""
                                    src="../assets/images/faces/face1.jpg">
                                <span class="profile-name"><?= $_SESSION['nama_admin'] ?></span>
                            </a>
                            <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="logout.php">
                                    Signout </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Laporan</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Data Laporan Absensi</h4>

                                    <!-- Form Filter -->
                                    <form method="GET" action="" class="mb-4">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tanggal Awal</label>
                                                    <input type="date" name="tanggal_awal" class="form-control"
                                                        value="<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tanggal Akhir</label>
                                                    <input type="date" name="tanggal_akhir" class="form-control"
                                                        value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <select name="kelas_id" class="form-control">
                                                        <option value="">Semua Kelas</option>
                                                        <?php
                                      // Query to fetch all classes
                                      $kelas_query = mysqli_query($koneksi, "SELECT id, nama_kelas FROM kelas");
                                      while($kelas = mysqli_fetch_array($kelas_query)):
                                      ?>
                                                        <option value="<?= $kelas['id'] ?>"
                                                            <?= isset($_GET['kelas_id']) && $_GET['kelas_id'] == $kelas['id'] ? 'selected' : '' ?>>
                                                            <?= $kelas['nama_kelas'] ?>
                                                        </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="">Semua Status</option>
                                                        <option value="Hadir"
                                                            <?= isset($_GET['status']) && $_GET['status'] == 'Hadir' ? 'selected' : '' ?>>
                                                            Hadir</option>
                                                        <option value="Sakit"
                                                            <?= isset($_GET['status']) && $_GET['status'] == 'Sakit' ? 'selected' : '' ?>>
                                                            Sakit</option>
                                                        <option value="Izin"
                                                            <?= isset($_GET['status']) && $_GET['status'] == 'Izin' ? 'selected' : '' ?>>
                                                            Izin</option>
                                                        <option value="Alpa"
                                                            <?= isset($_GET['status']) && $_GET['status'] == 'Alpa' ? 'selected' : '' ?>>
                                                            Alpa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nama Siswa</label>
                                                    <select name="nama_siswa" class="form-control">
                                                        <option value="">Semua Siswa</option>
                                                        <?php
                                      // Query to fetch all student names
                                      $siswa_query = mysqli_query($koneksi, "SELECT DISTINCT nama_lengkap FROM siswa ORDER BY nama_lengkap");
                                      while($siswa = mysqli_fetch_array($siswa_query)):
                                      ?>
                                                        <option value="<?= htmlspecialchars($siswa['nama_lengkap']) ?>"
                                                            <?= isset($_GET['nama_siswa']) && $_GET['nama_siswa'] == $siswa['nama_lengkap'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($siswa['nama_lengkap']) ?>
                                                        </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="mdi mdi-filter"></i> Filter
                                                </button>
                                                <a href="cetak_laporan.php?tanggal_awal=<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '' ?>&tanggal_akhir=<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '' ?>"
                                                    class="btn btn-success" target="_blank">
                                                    <i class="mdi mdi-printer"></i> Cetak
                                                </a>
                                                <a href="?" class="btn btn-outline-secondary">
                                                    <i class="mdi mdi-refresh"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Kelas</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                    <th>Nama Guru</th>
                                                    <th>Waktu Input</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                      $no = 1;
                      $query = "SELECT a.*, 
                                  s.nama_lengkap as nama_siswa,
                                  g.nama_lengkap as nama_guru,
                                  k.nama_kelas
                                FROM absensi a
                                JOIN siswa s ON a.siswa_id = s.id 
                                JOIN guru g ON a.guru_id = g.id
                                JOIN kelas k ON s.kelas_id = k.id";

                      $conditions = [];

                      // Tambahkan filter tanggal jika ada
                      if(isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
                        $tanggal_awal = $_GET['tanggal_awal'];
                        $tanggal_akhir = $_GET['tanggal_akhir'];
                        
                        if(!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                          $conditions[] = "a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
                        }
                      }

                      // Kelas filter
                      if(isset($_GET['kelas_id']) && !empty($_GET['kelas_id'])) {
                        $kelas_id = $_GET['kelas_id'];
                        $conditions[] = "s.kelas_id = '$kelas_id'";
                      }

                      // Status filter
                      if(isset($_GET['status']) && !empty($_GET['status'])) {
                        $status = $_GET['status'];
                        $conditions[] = "a.status = '$status'";
                      }

                      if(isset($_GET['nama_siswa']) && !empty($_GET['nama_siswa'])) {
                          $nama_siswa = mysqli_real_escape_string($koneksi, $_GET['nama_siswa']);
                          $conditions[] = "s.nama_lengkap = '$nama_siswa'";
                      }

                      // Tambahkan WHERE clause jika ada kondisi
                      if(!empty($conditions)) {
                        $query .= " WHERE " . implode(" AND ", $conditions);
                      }

                      $query .= " ORDER BY a.tanggal DESC, a.created_at DESC";
                      $tampil = mysqli_query($koneksi, $query);

                      if(mysqli_num_rows($tampil) > 0) {
                        while($data = mysqli_fetch_array($tampil)):
                      ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
                                                    <td><?= $data['nama_siswa'] ?></td>
                                                    <td><?= $data['nama_kelas'] ?></td>
                                                    <td>
                                                        <?php if($data['status'] == 'Hadir'): ?>
                                                        <span class="badge badge-success"><?= $data['status'] ?></span>
                                                        <?php elseif($data['status'] == 'Sakit'): ?>
                                                        <span class="badge badge-warning"><?= $data['status'] ?></span>
                                                        <?php elseif($data['status'] == 'Izin'): ?>
                                                        <span class="badge badge-info"><?= $data['status'] ?></span>
                                                        <?php else: ?>
                                                        <span class="badge badge-danger"><?= $data['status'] ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $data['keterangan'] ?></td>
                                                    <td><?= $data['nama_guru'] ?></td>
                                                    <td><?= date('d-m-Y H:i', strtotime($data['created_at'])) ?></td>
                                                </tr>
                                                <?php 
                          endwhile; 
                        } else {
                      ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada data yang
                                                        ditemukan</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a
                                href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights
                            reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="mdi mdi-heart text-danger"></i></span>
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
