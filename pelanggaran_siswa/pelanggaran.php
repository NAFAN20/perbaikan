<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    // Periksa apakah nis sudah ada dalam POST
    if (isset($_POST['nis']) && !empty($_POST['nis'])) {
        $nisn = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $jenis_pelanggaran = mysqli_real_escape_string($koneksi, $_POST['jenis_pelanggaran']);
        $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
        $jenis_hukuman = mysqli_real_escape_string($koneksi, $_POST['jenis_hukuman']);

        // Cek apakah NISN siswa ada dalam database
        $cek_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis = '$nisn'");
        
        if (mysqli_num_rows($cek_siswa) > 0) {
            $siswa = mysqli_fetch_assoc($cek_siswa);
            $id_siswa = $siswa['id'];

            // Cek apakah data pelanggaran sudah ada sebelumnya
            $cek_duplikat = mysqli_query($koneksi, "SELECT * FROM pelanggaran WHERE id_siswa = '$id_siswa' AND jenis_pelanggaran = '$jenis_pelanggaran' AND tanggal = '$tanggal'");
            
            if (mysqli_num_rows($cek_duplikat) == 0) {
                // Data belum ada, lakukan insert
                $stmt = mysqli_prepare($koneksi, "INSERT INTO pelanggaran (id_siswa, jenis_pelanggaran, tanggal, jenis_hukuman) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "isss", $id_siswa, $jenis_pelanggaran, $tanggal, $jenis_hukuman);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $_SESSION['success'] = "Data pelanggaran berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Data pelanggaran ini sudah ada!";
            }
        } else {
            $_SESSION['error'] = "NISN Siswa tidak ditemukan! Harap masukkan NISN yang benar.";
        }
    } else {
        $_SESSION['error'] = "NISN tidak boleh kosong!";
    }
}

$pelanggaran = mysqli_query($koneksi, 
    "SELECT p.id, s.nis, s.nama AS nama_siswa, s.jurusan, s.kelas, p.jenis_pelanggaran, p.tanggal 
     FROM pelanggaran p
     JOIN siswa s ON p.id_siswa = s.id"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        height: 100vh;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
    }

    .sidebar {
        width: 250px;
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        backdrop-filter: blur(10px);
        height: 100vh;
    }

    .sidebar a {
        display: block;
        padding: 12px;
        color: white;
        text-decoration: none;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .content {
        flex: 1;
        padding: 30px;
    }

    .container {
        background: rgba(255, 255, 255, 0.2);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    h1,
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        text-align: center;
        font-weight: bold;
    }

    .alert-success {
        background: #4CAF50;
        color: white;
    }

    .alert-error {
        background: #f44336;
        color: white;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: center;
    }

    input,
    select,
    button {
        width: 90%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
    }

    select {
        background: white;
        color: #333;
    }

    button {
        background: #ff9800;
        color: white;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    button:hover {
        background: #e68900;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
        color: black;
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
    }

    th {
        background: #2a5298;
        color: white;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-edit {
        background: orange;
        color: white;
    }

    .btn-edit:hover {
        background: darkorange;
    }

    .btn-delete {
        background: red;
        color: white;
    }

    .btn-delete:hover {
        background: darkred;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="admin_dashboard.php">🏠 Home</a>
        <a href="siswa.php">📚 Manajemen Siswa</a>
        <a href="hukuman.php">⚠️ Manajemen Hukuman</a>
        <a href="pelanggaran.php">⚠️ Manajemen Pelanggaran</a>
        <a href="laporan.php">📊 Laporan</a>
    </div>

    <div class="content">
        <div class="container">
            <h1>Manajemen Pelanggaran</h1>

            <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-error"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
            <?php } ?>

            <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
            <?php unset($_SESSION['success']); ?>
            <?php } ?>

            <form method="POST">
                <select name="nis" required>
                    <option value="">Pilih NIS Siswa</option>
                    <?php
        // Ambil data siswa dari database
        $siswa_query = mysqli_query($koneksi, "SELECT nis, nama FROM siswa");
        while ($siswa = mysqli_fetch_assoc($siswa_query)) {
            echo "<option value='" . $siswa['nis'] . "'>" . $siswa['nis'] . " - " . $siswa['nama'] . "</option>";
        }
        ?>
                </select>
                <input type="text" name="jenis_pelanggaran" placeholder="Jenis Pelanggaran" required>
                <input type="date" name="tanggal" required>
                <select name="jenis_hukuman" required>
                    <option value="">Pilih Jenis Hukuman</option>
                    <?php
        // Ambil data jenis hukuman dari database
        $hukuman = mysqli_query($koneksi, "SELECT * FROM jenis_hukuman");
        while ($row = mysqli_fetch_assoc($hukuman)) {
            echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
        }
        ?>
                </select>
                <button type="submit" name="tambah">Tambah Pelanggaran</button>
            </form>



            <h2>Daftar Pelanggaran</h2>
            <table>
                <tr>
                    <th>NISN Siswa</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($pelanggaran)) { ?>
                <tr>
                    <td><?= $row['nis']; ?></td>
                    <td><?= $row['nama_siswa']; ?></td>
                    <td><?= $row['kelas']; ?></td>
                    <td><?= $row['jurusan']; ?></td>
                    <td><?= $row['jenis_pelanggaran']; ?></td>
                    <td><?= $row['tanggal']; ?></td>
                    <td>
                        <a href="edit_pelanggaran.php?id=<?= $row['id']; ?>" class="btn btn-edit">✏️ Edit</a>
                        <a href="hapus_pelanggaran.php?id=<?= $row['id']; ?>" class="btn btn-delete"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">❌ Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>