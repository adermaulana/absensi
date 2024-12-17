<?php

include '../koneksi.php';

session_start();

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();

    header('location:../');
}

if (isset($_POST['simpan'])) {
    // Ambil data dari form, jika kosong gunakan data sebelumnya
    $latitude = !empty($_POST['latitude']) ? mysqli_real_escape_string($koneksi, $_POST['latitude']) : '';
    $longitude = !empty($_POST['longitude']) ? mysqli_real_escape_string($koneksi, $_POST['longitude']) : '';
    $radius = !empty($_POST['radius']) ? mysqli_real_escape_string($koneksi, $_POST['radius']) : '';

    // Jika data kosong, ambil data sebelumnya dari database
    if (empty($latitude) || empty($longitude) || empty($radius)) {
        $query = mysqli_query($koneksi, 'SELECT latitude, longitude, radius_meter FROM lokasi_sekolah LIMIT 1');
        $data_lokasi = mysqli_fetch_assoc($query);
        
        // Gunakan data sebelumnya jika ada
        if ($data_lokasi) {
            $latitude = empty($latitude) ? $data_lokasi['latitude'] : $latitude;
            $longitude = empty($longitude) ? $data_lokasi['longitude'] : $longitude;
            $radius = empty($radius) ? $data_lokasi['radius_meter'] : $radius;
        }
    }

    // Periksa apakah sudah ada data lokasi sekolah
    $cek_lokasi = mysqli_query($koneksi, 'SELECT COUNT(*) as jumlah FROM lokasi_sekolah');
    $result_cek = mysqli_fetch_assoc($cek_lokasi);

    if ($result_cek['jumlah'] > 0) {
        // Jika sudah ada, lakukan UPDATE
        $query = "UPDATE lokasi_sekolah SET 
                  latitude = '$latitude', 
                  longitude = '$longitude', 
                  radius_meter = '$radius'";

        $simpan = mysqli_query($koneksi, $query);
    } else {
        // Jika belum ada, lakukan INSERT
        $query = "INSERT INTO lokasi_sekolah (latitude, longitude, radius_meter) 
                  VALUES ('$latitude', '$longitude', '$radius')";

        $simpan = mysqli_query($koneksi, $query);
    }

    if ($simpan) {
        echo "<script>
              alert('Data lokasi sekolah berhasil disimpan!');
              document.location='sekolah.php';
           </script>";
    } else {
        echo "<script>
              alert('Simpan data gagal: " . mysqli_error($koneksi) . "');
              document.location='sekolah.php';
           </script>";
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <style>
        #map {
            height: 500px;
            /* Tinggi sama dengan lebar */
            width: 500px;
            /* Lebar tetap */
            margin: 20px auto;
            /* Center map */
            border: 2px solid #ddd;
            border-radius: 8px;
        }

        #status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
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
                        <h3 class="page-title">Atur Lokasi Sekolah</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form class="forms-sample" method="POST">
                                        <input type="hidden" id="latitude" name="latitude">
                                        <input type="hidden" id="longitude" name="longitude">
                                        <h1>Lokasi</h1>
                                        <div id="status"></div>

                                        <div class="search-box mb-3">
                                            <input class="form-control mb-3" type="text" id="searchInput"
                                                placeholder="Masukkan nama lokasi...">
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="searchLocation()">Cari Lokasi</button>
                                        </div>

                                        <div class="coordinates-box">
                                            <div id="coordinates">Koordinat yang dipilih akan muncul di sini</div>
                                        </div>

                                        <div id="map"></div>

                                        <?php
                                        // Ambil data radius dari database
                                        $lokasi_query = mysqli_query($koneksi, 'SELECT radius_meter FROM lokasi_sekolah LIMIT 1');
                                        $radius_data = mysqli_fetch_assoc($lokasi_query);
                                        $radius_sekolah = isset($radius_data['radius_meter']) ? $radius_data['radius_meter'] : 0;
                                        ?>

                                        <div class="form-group">
                                            <label for="radius">Radius Batas Absensi</label>
                                            <input type="number" class="form-control mb-3" id="radius"
                                                placeholder="Radius" name="radius">
                                            <small id="radiusHelp" class="form-text text-muted">Radius saat ini: <?= $radius_sekolah ?> meter</small>
                                        </div>

                                        <button type="submit" name="simpan"
                                            class="btn btn-primary me-2">Simpan</button>
                                        <a href="kelas.php" class="btn btn-light">Cancel</a>
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
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
                e.preventDefault();
                alert('Silahkan pilih lokasi pada peta terlebih dahulu!');
                return false;
            }
        });


        let map;
        let marker;
        const userId = 1;
        let selectedLat = null;
        let selectedLng = null;

        function updateStatus(message, isError = false) {
            const statusDiv = document.getElementById('status');
            statusDiv.textContent = message;
            statusDiv.className = isError ? 'error' : 'success';
        }

        function updateCoordinates(latitude, longitude) {
            selectedLat = latitude;
            selectedLng = longitude;
            // Update input hidden
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            document.getElementById('coordinates').textContent =
                `Latitude: ${latitude.toFixed(6)}, Longitude: ${longitude.toFixed(6)}`;
        }

        // Inisialisasi peta dengan lokasi default (Indonesia)
        function initMap() {
            map = L.map('map').setView([-0.7893, 113.9213], 5); // Centered on Indonesia
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Event ketika klik di peta
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }

                updateCoordinates(lat, lng);
                updateStatus('Lokasi dipilih');
            });
        }

        // Fungsi pencarian lokasi menggunakan Nominatim API
        // Modifikasi fungsi searchLocation
        async function searchLocation(e) {
            // Prevent any form submission
            e && e.preventDefault();

            const searchText = document.getElementById('searchInput').value;
            if (!searchText) {
                updateStatus('Masukkan nama lokasi terlebih dahulu', true);
                return;
            }

            try {
                updateStatus('Mencari lokasi...');
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchText)}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'User-Agent': 'YourAppName/1.0'
                        },
                        timeout: 5000
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data && data.length > 0) {
                    const location = data[0];
                    const lat = parseFloat(location.lat);
                    const lng = parseFloat(location.lon);

                    map.setView([lat, lng], 13);

                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng]).addTo(map);
                    }

                    updateCoordinates(lat, lng);
                    updateStatus('Lokasi ditemukan');
                } else {
                    updateStatus('Lokasi tidak ditemukan, coba kata kunci lain', true);
                }
            } catch (error) {
                console.error('Error searching location:', error);
                updateStatus(`Error: ${error.message}`, true);
            }
        }

        // Modifikasi event listener untuk Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                searchLocation();
            }
        });

        // Modifikasi fungsi saveSelectedLocation
        async function saveSelectedLocation(e) {
            e && e.preventDefault(); // Prevent any form submission

            if (!selectedLat || !selectedLng) {
                updateStatus('Pilih lokasi terlebih dahulu', true);
                return;
            }

            // Update hidden inputs
            document.getElementById('latitude').value = selectedLat;
            document.getElementById('longitude').value = selectedLng;

            updateStatus('Lokasi berhasil disimpan');
        }

        // Event listener untuk form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!document.getElementById('latitude').value || !document.getElementById('longitude')
                    .value) {
                    e.preventDefault();
                    alert('Silahkan pilih lokasi pada peta terlebih dahulu!');
                    return false;
                }
            });
        });

        // Enter key untuk pencarian
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchLocation();
            }
        });

        // Inisialisasi peta saat halaman dimuat
        window.onload = initMap;
    </script>

</body>

</html>
