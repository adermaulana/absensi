<?php

include '../koneksi.php';
session_start();

// Cek apakah sudah login
if ($_SESSION['status'] != 'login') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Silakan login terlebih dahulu'
    ]);
    exit();
}

$lokasi_query = mysqli_query($koneksi, "SELECT latitude, longitude, radius_meter FROM lokasi_sekolah LIMIT 1");
if (mysqli_num_rows($lokasi_query) == 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Lokasi sekolah belum diatur'
    ]);
    exit();
}

$lokasi = mysqli_fetch_assoc($lokasi_query);
$SCHOOL_LATITUDE = floatval($lokasi['latitude']);
$SCHOOL_LONGITUDE = floatval($lokasi['longitude']);
$RADIUS_METER = intval($lokasi['radius_meter']);

// Fungsi untuk menghitung jarak antara dua titik koordinat (Haversine formula)
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371000; // Radius bumi dalam meter
    
    $φ1 = deg2rad($lat1);
    $φ2 = deg2rad($lat2);
    $Δφ = deg2rad($lat2 - $lat1);
    $Δλ = deg2rad($lon2 - $lon1);

    $a = sin($Δφ/2) * sin($Δφ/2) +
         cos($φ1) * cos($φ2) *
         sin($Δλ/2) * sin($Δλ/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return $R * $c; // Jarak dalam meter
}

// Tangkap data dari request
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($data['latitude']) || !isset($data['longitude'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Koordinat tidak valid'
    ]);
    exit();
}

// Hitung jarak dari sekolah
$distance = calculateDistance(
    $SCHOOL_LATITUDE, 
    $SCHOOL_LONGITUDE, 
    $data['latitude'], 
    $data['longitude']
);

// Validasi jarak
if ($distance > $RADIUS_METER) {
    if ($data['status'] != 'Izin' && $data['status'] != 'Sakit' && $data['status'] != 'Alpa') {
        echo json_encode([
            'status' => 'error',
            'message' => "Di luar radius sekolah! Anda hanya diperbolehkan memilih status 'Izin', 'Sakit', atau 'Alpa'."
        ]);
        exit();
    }
}

// Ambil data siswa dari session
$id_siswa = $_SESSION['id_siswa'];
$tanggal = date('Y-m-d');

// Cek apakah sudah absen hari ini
$cek_absen = mysqli_query($koneksi, "SELECT * FROM absensi WHERE siswa_id = '$id_siswa' AND tanggal = '$tanggal'");
if (mysqli_num_rows($cek_absen) > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Anda sudah melakukan absensi hari ini'
    ]);
    exit();
}

// Proses absensi
$status = mysqli_real_escape_string($koneksi, $data['status']);
$keterangan = mysqli_real_escape_string($koneksi, $data['keterangan'] ?? '');
$guru_id = mysqli_real_escape_string($koneksi, $data['guru_id'] ?? '');

$query = "INSERT INTO absensi (
    tanggal, 
    siswa_id, 
    status, 
    keterangan, 
    guru_id, 
    latitude, 
    longitude
) VALUES (
    '$tanggal', 
    '$id_siswa', 
    '$status', 
    '$keterangan', 
    '$guru_id', 
    '{$data['latitude']}', 
    '{$data['longitude']}'
)";

if (mysqli_query($koneksi, $query)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Absensi berhasil',
        'jarak' => round($distance, 2)
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menyimpan absensi: ' . mysqli_error($koneksi)
    ]);
}
?>