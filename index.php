<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $login = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' and password='$password'");
        $cek = mysqli_num_rows($login);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['id_admin'] = $admin_data['id'];
            $_SESSION['nama_admin'] = $admin_data['nama'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:admin');

        }  else {
            echo "<script>
            alert('Login Gagal, Periksa Username dan Password Anda!');
            header('location:index.php');
                 </script>";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/login/css/bootstrap.min.css">
    <title>Login</title>

    <style>

        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
        }
        .h-custom {
        height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
        .h-custom {
        height: 100%;
        }
        }

    </style>

</head>
<body>
    <section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="POST">
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                <p class="lead fw-normal mb-0 me-3">Sign in</p>
            </div>
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4 mt-2">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control form-control-lg"
                placeholder="Enter username" />
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg"
                placeholder="Enter password" />
            </div>


            <div class="text-center text-lg-start mt-4 pt-2">
                <button  type="submit" name="login" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            </div>

            </form>
        </div>
        </div>
    </div>
    <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
        Copyright © 2020. All rights reserved.
        </div>
        <!-- Copyright -->

        <!-- Right -->
        <div>
        <a href="#!" class="text-white me-4">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#!" class="text-white me-4">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="#!" class="text-white me-4">
            <i class="fab fa-google"></i>
        </a>
        <a href="#!" class="text-white">
            <i class="fab fa-linkedin-in"></i>
        </a>
        </div>
        <!-- Right -->
    </div>
    </section>

    <script src="assets/login/js/bootstrap.bundle.min.js"></script>

</body>
</html>
