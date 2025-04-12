<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$jenis_kelamin_filter = '';

// Proses filter jenis kelamin
if (isset($_POST['filter'])) {
    $jenis_kelamin_filter = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin_filter']);
}

// Proses tambah siswa
if (isset($_POST['tambah'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);

    $query = "INSERT INTO siswa (nis, nama, kelas, jurusan, jenis_kelamin) 
              VALUES ('$nis', '$nama', '$kelas', '$jurusan', '$jenis_kelamin')";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi));
    } else {
        header("Location: siswa.php");
        exit;
    }
}

// Query siswa + filter jika ada
$siswa_query = "SELECT * FROM siswa";
if ($jenis_kelamin_filter != '') {
    $siswa_query .= " WHERE jenis_kelamin = '$jenis_kelamin_filter'";
}
$siswa = mysqli_query($koneksi, $siswa_query);
if (!$siswa) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
        backdrop-filter: blur(10px);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        padding: 10px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .content {
        flex: 1;
        padding: 30px;
    }

    h1 {
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
        color: black;
        border-radius: 10px;
        overflow: hidden;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background: #2a5298;
        color: white;
    }

    .form-container {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    input,
    select,
    button {
        padding: 10px;
        border-radius: 5px;
        border: none;
    }

    button {
        background: #2a5298;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #1e3c72;
    }

    .aksi a {
        text-decoration: none;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        margin-right: 5px;
    }

    .aksi a.edit {
        background: orange;
    }

    .aksi a.hapus {
        background: red;
    }

    .aksi a:hover {
        opacity: 0.8;
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
        <h1>Manajemen Siswa</h1>

        <!-- Form Tambah Siswa -->
        <form method="POST" class="form-container">
            <input type="text" name="nis" placeholder="NIS" required>
            <input type="text" name="nama" placeholder="Nama" required>

            <select name="kelas" required>
                <option value="">Pilih Kelas</option>
                <option value="10">Kelas 10</option>
                <option value="11">Kelas 11</option>
                <option value="12">Kelas 12</option>
            </select>

            <select name="jurusan" required>
                <option value="">Pilih Jurusan</option>
                <option value="10">Rpl 1</option>
                <option value="11">Rpl 2</option>
                <option value="12">AK 1</option>
                <option value="12">AK 2</option>
                <option value="12">AK 3</option>
                <option value="12">AK 4</option>
                <option value="12">AP 1</option>
                <option value="12">AP 2</option>
                <option value="12">AP 3</option>
                <option value="12">AP 4</option>
                <option value="12">PS 1</option>
                <option value="12">PS 2</option>
                <option value="12">PS 3</option>
                <option value="12">PS 4</option>

            </select>

            <select name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <button type="submit" name="tambah">Tambah</button>
        </form>

        <!-- Filter Jenis Kelamin -->
        <form method="POST" class="form-container">
            <select name="jenis_kelamin_filter">
                <option value="">Semua</option>
                <option value="Laki-laki" <?= $jenis_kelamin_filter == 'Laki-laki' ? 'selected' : ''; ?>>Siswa</option>
                <option value="Perempuan" <?= $jenis_kelamin_filter == 'Perempuan' ? 'selected' : ''; ?>>Siswi</option>
            </select>
            <button type="submit" name="filter">Tampilkan</button>
        </form>

        <!-- Tabel Siswa -->
        <table>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($siswa)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['nis']); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['kelas']); ?></td>
                <td><?= htmlspecialchars($row['jurusan']); ?></td>
                <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                <td class="aksi">
                    <a href="edit_siswa.php?id=<?= $row['id']; ?>" class="edit">✏️ Edit</a>
                    <a href="hapus_siswa.php?id=<?= $row['id']; ?>" class="hapus"
                        onclick="return confirm('Yakin ingin menghapus siswa ini?');">❌ Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>

</body>

</html>