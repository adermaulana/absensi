<?php

session_start();

if($_SESSION['status'] != 'login'){

    echo "<script>
        alert('Login Terlebih dahulu');
        window.location.href='index.php';
    </script>";
  
  }

?>