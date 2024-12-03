<?php
// Sambungkan ke database
include '../koneksi.php';

// Periksa apakah parameter id dan status tersedia
if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $status_baru = mysqli_real_escape_string($koneksi, $_GET['status']);
    
    // Daftar status yang valid
    $status_valid = ['Hadir', 'Sakit', 'Izin', 'Alpa'];
    
    // Validasi status
    if(in_array($status_baru, $status_valid)) {
        // Query untuk mengubah status
        $query = "UPDATE absensi SET status = '$status_baru' WHERE id = '$id'";
        
        // Eksekusi query
        if(mysqli_query($koneksi, $query)) {
            // Redirect dengan pesan sukses
            header("Location: absensi.php?pesan=status_berhasil_diubah");
            exit();
        } else {
            // Redirect dengan pesan error
            header("Location: absensi.php?pesan=gagal_ubah_status");
            exit();
        }
    } else {
        // Status tidak valid
        header("Location: absensi.php?pesan=status_tidak_valid");
        exit();
    }
} else {
    // Parameter tidak lengkap
    header("Location: absensi.php?pesan=parameter_tidak_valid");
    exit();
}
?>