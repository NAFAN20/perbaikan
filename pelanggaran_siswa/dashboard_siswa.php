<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi ke database

// Pastikan user sudah login dan memiliki peran siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data siswa dari database
$query_siswa = "SELECT * FROM siswa WHERE id = '$user_id'";
$result_siswa = mysqli_query($conn, $query_siswa);
$siswa = mysqli_fetch_assoc($result_siswa);

// Ambil data pelanggaran siswa
$query_pelanggaran = "SELECT * FROM pelanggaran WHERE siswa_id = '$user_id'";
$result_pelanggaran = mysqli_query($conn, $query_pelanggaran);
$jumlah_pelanggaran = mysqli_num_rows($result_pelanggaran);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .dashboard-container {
        background: #fff;
        width: 80%;
        max-width: 800px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        color: #2c3e50;
    }

    .siswa-info {
        background: #ecf0f1;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .pelanggaran-section {
        text-align: left;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #bdc3c7;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
    }

    th {
        background: #3498db;
        color: white;
    }

    .no-pelanggaran {
        color: #27ae60;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h2><i class="fa-solid fa-user-graduate"></i> Dashboard Siswa</h2>
        <div class="siswa-info">
            <p><strong>Nama:</strong> <?php echo $siswa['nama']; ?></p>
            <p><strong>Kelas:</strong> <?php echo $siswa['kelas']; ?></p>
            <p><strong>Jurusan:</strong> <?php echo $siswa['jurusan']; ?></p>
        </div>
        <div class="pelanggaran-section">
            <h3><i class="fa-solid fa-exclamation-triangle"></i> Riwayat Pelanggaran</h3>
            <?php if ($jumlah_pelanggaran > 0) { ?>
            <table>
                <tr>
                    <th>No</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result_pelanggaran)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['jenis_pelanggaran']; ?></td>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['keterangan']; ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <p class="no-pelanggaran">✔ Anda tidak memiliki pelanggaran.</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>