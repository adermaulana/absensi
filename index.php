<?php

include 'koneksi.php';

session_start();

// Cek apakah pengguna sudah login
if(isset($_SESSION['username_admin'])) {
    $isLoggedIn = true;
    $userName = $_SESSION['username_admin']; // Ambil nama user dari session

} elseif(isset($_SESSION['nis'])) {
  $isLoggedIn = true;
  $userName = $_SESSION['nis']; // Ambil nama user dari session

} elseif(isset($_SESSION['nip'])) {
  $isLoggedIn = true;
  $userName = $_SESSION['nip']; // Ambil nama user dari session
} 
else {
    $isLoggedIn = false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Absensi</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/home/img/apple-touch-icon.png" rel="icon">
  <link href="assets/home/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/home/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/home/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/home/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/home/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/home/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/home/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
      .jumbotron {
          background: url(assets/images/sma.jpg);
          z-index: 0;
      }

      .jumbotron::after {
          content: '';
          display: block;
          position: absolute;
          width: 100%;
          height: 100%;
          background-image: linear-gradient(to bottom, rgba(0,0,0,9), rgba(0,0,0,0));
          bottom: 0;
          pointer-events: none;
      }

      .tulisan {
          position: relative; /* Relative to .jumbotron */
          z-index: 2; /* Place the text above the overlay */
          color: white; /* Make the text white to stand out against the dark overlay */
        }

      .highlight-text {
        font-size: 2em; /* Adjust font size as needed */
        text-align: center; /* Center the text */
      }


  </style>


</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
         <img src="assets/images/tutwuri.png" alt="Tutwuri">
        <h1 style="font-size:22px;" class="sitename">Absensi</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="absensi.php" class="active">Absensi</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
       <?php if($isLoggedIn): ?>
          <?php if(isset($_SESSION['username_admin'])): ?>
            <a class="btn-getstarted" href="admin">Dashboard</a>
          <?php elseif(isset($_SESSION['nis'])): ?>
            <a class="btn-getstarted" href="siswa">Dashboard</a>
          <?php else: ?>
            <a class="btn-getstarted" href="guru">Dashboard</a>
          <?php endif; ?>
       <?php else: ?>
       <a class="btn-getstarted" href="login.php">Login</a>
       <?php endif; ?>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero jumbotron section dark-background">

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12 order-2 order-lg-1 d-flex flex-column justify-content-center tulisan" data-aos="zoom-out">
                <h1 class="highlight-text">Sistem Absensi Digital yang Efisien dan Akurat</h1>
                <p class="highlight-text">"Tingkatkan kedisiplinan dan efektivitas pencatatan kehadiran dengan sistem absensi digital kami. Mudah digunakan, real-time, dan dapat diandalkan untuk memantau kehadiran dengan lebih baik."</p>
                <div class="d-flex">
                    <a href="login.php" class="btn-get-started">Mulai Absen</a>
                    <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Panduan Penggunaan</span></a>
                </div>
            </div>
        </div>
    </div>

    </section><!-- /Hero Section -->



    <!-- About Section -->
    <section id="visimisi" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Visi & Misi</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p>
            Mewujudkan generasi yang unggul dalam bidang Ilmu Pengetahuan dan Teknologi (IPTEK), iman dan Taqwa (1MTAQ), terampil dan mandiri serta berkarakter
            </p>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <p>Membentuk karakter siswa berbudi pekerti luhur yang dilandasi iman dan taqwa</p>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->
  </main>

  <footer id="contact" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-6 col-md-6 footer-about">
          <a href="index.php" class="d-flex align-items-center">
            <span class="sitename">Absensi</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Perintis Kemerdekaan</p>
            <p>Sulawesi Selatan, Indonesia</p>
            <p class="mt-3"><strong>Phone:</strong> <span>0853xxx</span></p>
            <p><strong>Email:</strong> <span>absen@gmail.com</span></p>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <h4>Follow Us</h4>
          <p>Sosial Media</p>
          <div class="social-links d-flex">
            <a href="#contact"><i class="bi bi-twitter-x"></i></a>
            <a href="#contact"><i class="bi bi-facebook"></i></a>
            <a href="#contact"><i class="bi bi-instagram"></i></a>
            <a href="#contact"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Arsha</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/home/vendor/php-email-form/validate.js"></script>
  <script src="assets/home/vendor/aos/aos.js"></script>
  <script src="assets/home/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/home/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/home/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/home/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/home/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/home/js/main.js"></script>

</body>

</html>