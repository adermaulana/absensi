<?php
// get_school_location.php
include '../koneksi.php';

// Ambil lokasi sekolah dari tabel lokasi_sekolah
$query = mysqli_query($koneksi, "SELECT latitude, longitude FROM lokasi_sekolah LIMIT 1");

if ($query) {
    $location = mysqli_fetch_assoc($query);
    
    if ($location) {
        // Kembalikan lokasi sebagai JSON
        header('Content-Type: application/json');
        echo json_encode([
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude']
        ]);
    } else {
        // Jika tidak ada data lokasi
        http_response_code(404);
        echo json_encode(['error' => 'Lokasi sekolah tidak ditemukan']);
    }
} else {
    // Jika query gagal
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil lokasi sekolah']);
}

mysqli_close($koneksi);
?>