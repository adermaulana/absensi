<?php
include '../koneksi.php';

// Ambil parameter filter dari URL
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Query data laporan
$query = "SELECT a.*, s.nama_lengkap AS nama_siswa, g.nama_lengkap AS nama_guru
          FROM absensi a
          JOIN siswa s ON a.siswa_id = s.id
          JOIN guru g ON a.guru_id = g.id";

if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    $query .= " WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$query .= " ORDER BY a.tanggal DESC, a.created_at DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        /* Tambahkan CSS untuk menyesuaikan tampilan cetak */
        @media print {
            .no-print { display: none; }
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Laporan Absensi</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Nama Guru</th>
                <th>Waktu Input</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
                <td><?= $data['nama_siswa'] ?></td>
                <td>
                    <?php if ($data['status'] == 'Hadir'): ?>
                        <span class="badge badge-success"><?= $data['status'] ?></span>
                    <?php elseif ($data['status'] == 'Sakit'): ?>
                        <span class="badge badge-warning"><?= $data['status'] ?></span>
                    <?php elseif ($data['status'] == 'Izin'): ?>
                        <span class="badge badge-info"><?= $data['status'] ?></span>
                    <?php else: ?>
                        <span class="badge badge-danger"><?= $data['status'] ?></span>
                    <?php endif; ?>
                </td>
                <td><?= $data['keterangan'] ?></td>
                <td><?= $data['nama_guru'] ?></td>
                <td><?= date('d-m-Y H:i', strtotime($data['created_at'])) ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <!-- Tambahkan script untuk langsung masuk ke mode cetak -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>