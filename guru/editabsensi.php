<?php
include '../koneksi.php';

session_start();

$id_guru = $_SESSION['id_guru'];

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();
    header('location:../');
}

// Check if an ID is passed for editing
$edit_id = isset($_GET['id']) ? $_GET['id'] : null;
$edit_data = null;

if ($edit_id) {
    // Fetch existing attendance record
    $query = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id = '$edit_id'");
    $edit_data = mysqli_fetch_assoc($query);
}

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $siswa_id = $_POST['siswa_id'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];
    $guru_id = $_POST['guru_id'];

    if ($edit_id) {
        // Update existing attendance record
        $query = "UPDATE absensi 
                  SET tanggal = '$tanggal', 
                      status = '$status', 
                      keterangan = '$keterangan'
                  WHERE id = '$edit_id'";

        $simpan = mysqli_query($koneksi, $query);

        if ($simpan) {
            echo "<script>
                    alert('Update data absensi berhasil!');
                    document.location='absensi.php';
                 </script>";
        } else {
            echo "<script>
                    alert('Update data absensi gagal!');
                    document.location='absensi.php';
                 </script>";
        }
    } else {
        // Original insert logic (if not in edit mode)
        // Check if attendance already exists for this student on this date
        $check = mysqli_query(
            $koneksi,
            "SELECT id FROM absensi 
             WHERE tanggal = '$tanggal' 
             AND siswa_id = '$siswa_id'",
        );

        if (mysqli_num_rows($check) > 0) {
            echo "<script>
                    alert('Absensi untuk siswa ini pada tanggal tersebut sudah ada!');
                    document.location='absensi.php';
                 </script>";
        } else {
            // Insert new attendance
            $query = "INSERT INTO absensi (tanggal, siswa_id, status, keterangan, guru_id) 
                     VALUES ('$tanggal', '$siswa_id', '$status', '$keterangan', '$guru_id')";

            $simpan = mysqli_query($koneksi, $query);

            if ($simpan) {
                echo "<script>
                        alert('Simpan data absensi berhasil!');
                        document.location='absensi.php';
                     </script>";
            } else {
                echo "<script>
                        alert('Simpan data absensi gagal!');
                        document.location='absensi.php';
                     </script>";
            }
        }
    }
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
                <a class="sidebar-brand brand-logo" href="index.php"><img src="../assets/images/logo.svg"
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
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
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
                    <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false"
                        aria-controls="forms">
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
                                <span class="profile-name"><?= $_SESSION['nama_guru'] ?></span>
                            </a>
                            <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="logout.php">
                                    Signout</a>
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
                        <h3 class="page-title">Tambah Absensi</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form class="forms-sample" method="POST">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal"
                                                value="<?= $edit_data ? $edit_data['tanggal'] : date('Y-m-d') ?>"
                                                required <?= $edit_id ? '' : 'readonly' ?>>
                                        </div>

                                        <div class="form-group">
                                            <label>Siswa</label>
                                            <?php
                                            if ($edit_id) {
                                                // Get student name for edit mode
                                                $siswa_query = mysqli_query($koneksi, "SELECT nama_lengkap FROM siswa WHERE id = '{$edit_data['siswa_id']}'");
                                                $siswa = mysqli_fetch_assoc($siswa_query);
                                            }
                                            ?>
                                            <input type="hidden" name="siswa_id"
                                                value="<?= $edit_data ? $edit_data['siswa_id'] : '' ?>">
                                            <input type="text" class="form-control"
                                                value="<?= $edit_id ? $siswa['nama_lengkap'] : '' ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option disabled <?= $edit_id ? '' : 'selected' ?>>Pilih Status</option>
                                                <option value="Hadir"
                                                    <?= $edit_data && $edit_data['status'] == 'Hadir' ? 'selected' : '' ?>>
                                                    Hadir</option>
                                                <option value="Izin"
                                                    <?= $edit_data && $edit_data['status'] == 'Izin' ? 'selected' : '' ?>>
                                                    Izin</option>
                                                <option value="Sakit"
                                                    <?= $edit_data && $edit_data['status'] == 'Sakit' ? 'selected' : '' ?>>
                                                    Sakit</option>
                                                <option value="Alpa"
                                                    <?= $edit_data && $edit_data['status'] == 'Alpa' ? 'selected' : '' ?>>
                                                    Alpa</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="4"><?= $edit_data ? $edit_data['keterangan'] : '' ?></textarea>
                                        </div>

                                        <input type="hidden" name="guru_id" value="<?= $id_guru ?>">

                                        <button type="submit" name="simpan"
                                            class="btn btn-primary me-2"><?= $edit_id ? 'Update' : 'Submit' ?></button>
                                        <a href="absensi.php" class="btn btn-light">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
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
