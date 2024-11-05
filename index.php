<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])) {
      // Sanitasi input
      $username = mysqli_real_escape_string($koneksi, $_POST['username']);
      $nis = isset($_POST['nis']) ? mysqli_real_escape_string($koneksi, $_POST['nis']) : '';
      $nip = isset($_POST['nip']) ? mysqli_real_escape_string($koneksi, $_POST['nip']) : '';
      $password = md5($_POST['password']); // Tetap menggunakan MD5 sesuai sistem yang ada
  
      // Query dengan prepared statement untuk admin
      $stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username=? AND password=?");
      mysqli_stmt_bind_param($stmt, "ss", $username, $password);
      mysqli_stmt_execute($stmt);
      $login = mysqli_stmt_get_result($stmt);
      $cek = mysqli_num_rows($login);
  
      // Query dengan prepared statement untuk mahasiswa
      $stmtSiswa = mysqli_prepare($koneksi, "SELECT * FROM siswa WHERE nis=? AND password=?");
      mysqli_stmt_bind_param($stmtSiswa, "ss", $nis, $password);
      mysqli_stmt_execute($stmtSiswa);
      $loginSiswa = mysqli_stmt_get_result($stmtSiswa);
      $cekSiswa = mysqli_num_rows($loginSiswa);
  
      // Query dengan prepared statement untuk dosen
      $stmtGuru = mysqli_prepare($koneksi, "SELECT * FROM guru WHERE nip=? AND password=?");
      mysqli_stmt_bind_param($stmtGuru, "ss", $nip, $password);
      mysqli_stmt_execute($stmtGuru);
      $loginGuru = mysqli_stmt_get_result($stmtGuru);
      $cekGuru = mysqli_num_rows($loginGuru);
  
      if($cek > 0) {
          $admin_data = mysqli_fetch_assoc($login);
          $_SESSION['id_admin'] = $admin_data['id'];
          $_SESSION['nama_admin'] = $admin_data['nama'];
          $_SESSION['username_admin'] = $username;
          $_SESSION['status'] = "login";
          $_SESSION['role'] = "admin";
          header('location:admin');
          exit();
  
      } else if($cekSiswa > 0) {
          $siswa_data = mysqli_fetch_assoc($loginSiswa);
          $_SESSION['id_siswa'] = $siswa_data['id'];
          $_SESSION['nama_siswa'] = $siswa_data['nama_lengkap'];
          $_SESSION['nis'] = $siswa_data['nis'];
          $_SESSION['status'] = "login";
          $_SESSION['role'] = "siswa";
          header('location:siswa');
          exit();
  
      } else if($cekGuru > 0) {
          $guru_data = mysqli_fetch_assoc($loginGuru);
          $_SESSION['id_guru'] = $guru_data['id'];
          $_SESSION['nama_guru'] = $guru_data['nama_lengkap'];
          $_SESSION['nip'] = $guru_data['nip'];
          $_SESSION['status'] = "login";
          $_SESSION['role'] = "guru";
          header('location:guru');
          exit();
  
      } else {
          echo "<script>
              alert('Login Gagal');
              window.location.href='index.php';
          </script>";
          exit();
      }
  }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/vertical-light-layout/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <h4 class="text-center">Login</h4>
                <form class="pt-3" method="POST">

                  <div class="form-group">
                        <label class="form-label">Login Sebagai</label>
                        <select class="form-control form-control-lg" id="roleSelect" onchange="showFields()">
                            <option value="admin">Admin</option>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                        </select>
                  </div>

                  <div id="usernameField" class="form-group">
                    <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Username">
                  </div>
                  <div id="nimField" class="form-group" style="display:none;">
                    <input type="text" class="form-control form-control-lg" name="nis" id="nis" placeholder="NIS">
                  </div>
                  <div id="nipField" class="form-group" style="display:none;">
                    <input type="text" class="form-control form-control-lg" name="nip" id="nip" placeholder="NIP">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Password">
                  </div>


                  <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="login" type="submit">SIGN IN</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->

    <script>
        function showFields() {
            const role = document.getElementById('roleSelect').value;
            const usernameField = document.getElementById('usernameField');
            const nimField = document.getElementById('nimField');
            const nipField = document.getElementById('nipField');

            // Sembunyikan semua field
            usernameField.style.display = 'none';
            nimField.style.display = 'none';
            nipField.style.display = 'none';

            // Tampilkan field sesuai role
            switch(role) {
                case 'admin':
                    usernameField.style.display = 'block';
                    break;
                case 'siswa':
                    nimField.style.display = 'block';
                    break;
                case 'guru':
                    nipField.style.display = 'block';
                    break;
            }
        }

        // Jalankan saat halaman dimuat
        window.onload = showFields;
    </script>
  </body>
</html>
