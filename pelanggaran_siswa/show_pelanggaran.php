x<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pelanggaran_siswa";

// Koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Periksa apakah 'id' ada di URL
if (!isset($_GET['id'])) {
    die("ID pelanggaran tidak ditemukan.");
}

$id = $_GET['id'];

$query = "SELECT p.*, s.nama AS nama_siswa, s.nis, s.jurusan, s.kelas, p.jenis_hukuman 
          FROM pelanggaran p
          JOIN siswa s ON p.id_siswa = s.id
          WHERE p.id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Periksa apakah data ditemukan
$row = mysqli_fetch_assoc($result);
if (!$row) {
    die("Data tidak ditemukan.");
}

// Array untuk mengonversi nama hari dan bulan ke bahasa Indonesia
$hari = array(
    "Sunday" => "Minggu",
    "Monday" => "Senin",
    "Tuesday" => "Selasa",
    "Wednesday" => "Rabu",
    "Thursday" => "Kamis",
    "Friday" => "Jumat",
    "Saturday" => "Sabtu"
);

$bulan = array(
    "January" => "Januari",
    "February" => "Februari",
    "March" => "Maret",
    "April" => "April",
    "May" => "Mei",
    "June" => "Juni",
    "July" => "Juli",
    "August" => "Agustus",
    "September" => "September",
    "October" => "Oktober",
    "November" => "November",
    "December" => "Desember"
);

// Mendapatkan nama hari dan bulan dalam bahasa Inggris
$nama_hari = date('l', strtotime('now'));
$nama_bulan = date('F', strtotime('now'));

// Mengonversi nama hari dan bulan ke bahasa Indonesia
$nama_hari_id = $hari[$nama_hari];
$nama_bulan_id = $bulan[$nama_bulan];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggaran</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        margin-bottom: 15px;
    }

    .info {
        background: white;
        color: black;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        text-align: left;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 10px;
        background: #ffcc00;
        color: black;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn:hover {
        background: #e6b800;
    }

    .btn-print {
        background: #00cc66;
    }

    .btn-print:hover {
        background: #00994d;
    }

    /* Tambahkan CSS untuk menyembunyikan tombol saat print */
    @media print {
        .no-print {
            display: none;
        }

        .signature {
            margin-top: 50px;
            text-align: left;
        }
    }

    .signature {
        margin-top: 50px;
        text-align: left;
    }

    .note {
        background: rgba(255, 255, 255, 0.3);
        color: black;
        padding: 10px;
        border-radius: 5px;
        margin-top: 20px;
        text-align: left;
    }

    .date-time {
        margin-top: 10px;
        font-size: 14px;
        color: white;
    }
    </style>
</head>

<body>
    <div class="container" id="printArea">
        <h2>📄 Detail Pelanggaran</h2>
        <div class="date-time">
            <strong>Tanggal:</strong>
            <?php echo $nama_hari_id . ", " . date('d') . " " . $nama_bulan_id . " " . date('Y'); ?>
            <!-- Menampilkan hari dan bulan dalam bahasa Indonesia -->
        </div>
        <div class="info"><strong>ID Siswa:</strong> <?php echo htmlspecialchars($row['id_siswa']); ?></div>
        <div class="info"><strong>Nama Siswa:</strong> <?php echo htmlspecialchars($row['nama_siswa']); ?></div>
        <div class="info"><strong>NIS:</strong> <?php echo htmlspecialchars($row['nis']); ?></div>
        <div class="info"><strong>Kelas:</strong> <?php echo htmlspecialchars($row['kelas']); ?></div>
        <!-- Menampilkan kelas -->
        <div class="info"><strong>Jurusan:</strong> <?php echo htmlspecialchars($row['jurusan']); ?></div>
        <div class="info"><strong>Jenis Pelanggaran:</strong> <?php echo htmlspecialchars($row['jenis_pelanggaran']); ?>
        </div>
        <div class="info"><strong>Jenis Hukuman:</strong> <?php echo htmlspecialchars($row['jenis_hukuman']); ?></div>
        <div class="info"><strong>Tanggal Pelanggaran:</strong> <?php echo htmlspecialchars($row['tanggal']); ?></div>
        <div class="info"><strong>Alasan:</strong>
            <?php echo !empty($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '-'; ?></div>

        <div class="note">
            <p><strong>Keterangan Bahwa Siswa/Siswi Tidak Akan Mengulangi Kesalahan Yang sama:</strong></p><br>
            <p>__________________________________________</p><br>
            <p>__________________________________________</p>
        </div>

        <div class="signature">
            <p><strong>Orang Tua/Wali:</strong></p>
            <p>___________________________</p>
            <p>(Tanda Tangan & Nama Jelas)</p>
        </div>

        <a href="laporan.php" class="btn no-print">⬅ Kembali</a>
        <button class="btn btn-print no-print" onclick="printDetail()">🖨 Cetak</button>
    </div>

    <script>
    function printDetail() {
        window.print();
    }
    </script>
</body>

</html>