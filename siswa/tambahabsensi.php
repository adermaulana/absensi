<?php

include '../koneksi.php';

session_start();

$id_siswa = $_SESSION['id_siswa'];

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();

    header('location:../');
}

$query = mysqli_query($koneksi, "SELECT nama_lengkap, id FROM siswa WHERE id = '$id_siswa'");
$data = mysqli_fetch_assoc($query);

$guru = mysqli_query(
    $koneksi,
    "SELECT g.id AS id_guru
                                FROM siswa s
                                JOIN kelas k ON s.kelas_id = k.id
                                JOIN guru g ON k.wali_kelas_id = g.id
                                WHERE s.id = '$id_siswa'
",
);
$data_guru = mysqli_fetch_assoc($guru);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Siswa - <?= $_SESSION['nama_siswa'] ?></title>
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
        #location-error {
            color: red;
            display: none;
        }

        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>

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
                            <span class="font-weight-medium mb-2"><?= $_SESSION['nama_siswa'] ?></span>
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
                    <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false"
                        aria-controls="forms">
                        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                        <span class="menu-title">Absensi</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="absensi.php">Data Absensi</a></li>
                        </ul>
                    </div>
                </li>
                <!-- <li class="nav-item">
      <a class="nav-link" href="laporan.php">
        <i class="mdi mdi-file-document-box menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li> -->
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
                                <img class="nav-profile-img me-2" alt="" src="../assets/images/faces/face1.jpg">
                                <span class="profile-name"><?= $_SESSION['nama_siswa'] ?></span>
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
                                    <div id="location-error" class="alert alert-danger"></div>
                                    <div id="map"></div>
                                    <form id="absensi-form" class="forms-sample">
                                        <input type="hidden" id="guru_id" name="guru_id"
                                            value="<?= $data_guru['id_guru'] ?>">
                                        <div class="form-group mt-3">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal"
                                                value="<?= date('Y-m-d') ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Siswa</label>
                                            <input type="text" class="form-control"
                                                value="<?= $data['nama_lengkap'] ?>" readonly>
                                            <input type="hidden" id="siswa-id" value="<?= $data['id'] ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="Hadir">Hadir</option>
                                                <option value="Izin">Izin</option>
                                                <option value="Sakit">Sakit</option>
                                                <option value="Alpa">Alpa</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea required class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
                                        </div>

                                        <input type="hidden" id="latitude" name="latitude">
                                        <input type="hidden" id="longitude" name="longitude">
                                        <button type="submit" class="btn btn-primary me-2 mt-5">Submit Absensi</button>
                                        <a href="absensi.php" class="btn btn-light mt-5">Cancel</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('absensi-form');
            const locationError = document.getElementById('location-error');
            let map, schoolMarker, userMarker, distanceLine;

            // Fungsi untuk mengambil lokasi sekolah dari server
            function fetchSchoolLocation() {
                return fetch('ambil_data_sekolah.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Tidak dapat mengambil lokasi sekolah');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data.latitude || !data.longitude) {
                            throw new Error('Lokasi sekolah tidak valid');
                        }
                        return [parseFloat(data.latitude), parseFloat(data.longitude)];
                    })
                    .catch(error => {
                        locationError.textContent = error.message;
                        locationError.style.display = 'block';
                        // Fallback koordinat jika gagal
                        return [-4.9414144, 119.5442176];
                    });
            }

            // Inisialisasi peta
            async function initMap() {
                try {
                    // Ambil lokasi sekolah
                    const schoolLocation = await fetchSchoolLocation();

                    // Inisialisasi peta Leaflet
                    map = L.map('map').setView(schoolLocation, 15);

                    // Tambahkan layer peta OpenStreetMap
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Marker sekolah
                    schoolMarker = L.marker(schoolLocation, {
                        icon: L.divIcon({
                            className: 'school-marker',
                            html: '<div style="background-color:blue;width:20px;height:20px;border-radius:50%;"></div>',
                            iconSize: [20, 20]
                        })
                    }).addTo(map).bindPopup('Lokasi Sekolah');

                    // Dapatkan lokasi pengguna
                    getLocation(schoolLocation);
                } catch (error) {
                    locationError.textContent = 'Gagal menginisialisasi peta: ' + error.message;
                    locationError.style.display = 'block';
                }
            }

            // Fungsi untuk menghitung jarak antara dua titik (dalam meter)
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371e3; // Radius bumi dalam meter
                const φ1 = lat1 * Math.PI / 180;
                const φ2 = lat2 * Math.PI / 180;
                const Δφ = (lat2 - lat1) * Math.PI / 180;
                const Δλ = (lon2 - lon1) * Math.PI / 180;

                const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                    Math.cos(φ1) * Math.cos(φ2) *
                    Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                return R * c;
            }

            // Fungsi untuk mendapatkan lokasi
            function getLocation(schoolLocation) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLocation = [
                                position.coords.latitude,
                                position.coords.longitude
                            ];

                            // Update hidden input fields
                            document.getElementById('latitude').value = userLocation[0];
                            document.getElementById('longitude').value = userLocation[1];

                            // Hapus marker pengguna sebelumnya jika ada
                            if (userMarker) map.removeLayer(userMarker);
                            if (distanceLine) map.removeLayer(distanceLine);

                            // Tambahkan marker pengguna
                            userMarker = L.marker(userLocation).addTo(map).bindPopup('Lokasi Anda');

                            // Gambar garis jarak
                            distanceLine = L.polyline([schoolLocation, userLocation], {
                                color: 'red',
                                weight: 3,
                                opacity: 0.7
                            }).addTo(map);

                            // Hitung dan tampilkan jarak
                            const distance = calculateDistance(
                                schoolLocation[0], schoolLocation[1],
                                userLocation[0], userLocation[1]
                            );

                            // Sesuaikan tampilan peta
                            map.fitBounds([schoolLocation, userLocation], {
                                padding: [50, 50]
                            });

                            // Tampilkan jarak
                            locationError.textContent = `Jarak ke sekolah: ${(distance / 1000).toFixed(2)} km`;
                            locationError.style.display = 'block';
                            locationError.style.color = 'green';
                        },
                        function(error) {
                            locationError.textContent = 'Error mendapatkan lokasi: ' + error.message;
                            locationError.style.display = 'block';
                        }
                    );
                } else {
                    locationError.textContent = 'Geolocation tidak didukung browser Anda';
                    locationError.style.display = 'block';
                }
            }

            // Inisialisasi peta
            initMap();

            // Submit form absensi
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    status: document.getElementById('status').value,
                    guru_id: document.getElementById('guru_id').value,
                    keterangan: document.getElementById('keterangan').value,
                    latitude: document.getElementById('latitude').value,
                    longitude: document.getElementById('longitude').value
                };

                fetch('absensi_proses.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Absensi berhasil! Jarak dari sekolah: ' + data.jarak + ' meter');
                            window.location.href = 'absensi.php';
                            window.scrollTo(0, 0);
                        } else {
                            locationError.textContent = data.message;
                            locationError.style.display = 'block';
                            window.scrollTo(0, 0);
                        }
                    })
                    .catch(error => {
                        locationError.textContent = 'Terjadi kesalahan: ' + error;
                        locationError.style.display = 'block';
                        window.scrollTo(0, 0);
                    });
            });
        });
    </script>

</body>

</html>
