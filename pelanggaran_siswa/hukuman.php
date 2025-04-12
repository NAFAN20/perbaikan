<?php
$koneksi = new mysqli("localhost", "root", "", "pelanggaran_siswa"); // Ganti nama_database sesuai database kamu

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Tambah jenis hukuman
if (isset($_POST['tambah_hukuman'])) {
    $nama_hukuman = $_POST['nama_hukuman'];
    $stmt = $koneksi->prepare("INSERT INTO jenis_hukuman (nama) VALUES (?)");
    $stmt->bind_param("s", $nama_hukuman);
    if ($stmt->execute()) {
        header("Location: hukuman.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Hapus jenis hukuman
if (isset($_GET['hapus_hukuman'])) {
    $id = $_GET['hapus_hukuman'];
    $stmt = $koneksi->prepare("DELETE FROM jenis_hukuman WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: hukuman.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Update jenis hukuman
if (isset($_POST['update_hukuman'])) {
    $id = $_POST['id'];
    $nama_hukuman = $_POST['nama_hukuman'];

    $stmt = $koneksi->prepare("UPDATE jenis_hukuman SET nama=? WHERE id=?");
    $stmt->bind_param("si", $nama_hukuman, $id);
    if ($stmt->execute()) {
        header("Location: hukuman.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Tambah data pelanggaran (hukuman)
if (isset($_POST['tambah'])) {
    $id_siswa = $_POST['id_siswa'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $hukuman = $_POST['hukuman'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    $stmt = $koneksi->prepare("INSERT INTO hukuman (id_siswa, jenis_pelanggaran, hukuman, tanggal, keterangan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_siswa, $jenis_pelanggaran, $hukuman, $tanggal, $keterangan);
    if ($stmt->execute()) {
        header("Location: hukuman.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Hapus data pelanggaran (hukuman)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $koneksi->prepare("DELETE FROM hukuman WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: hukuman.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Update data pelanggaran (hukuman)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_siswa = $_POST['id_siswa'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $hukuman = $_POST['hukuman'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    $stmt = $koneksi->prepare("UPDATE hukuman SET id_siswa=?, jenis_pelanggaran=?, hukuman=?, tanggal=?, keterangan=? WHERE id=?");
    $stmt->bind_param("issssi", $id_siswa, $jenis_pelanggaran, $hukuman, $tanggal, $keterangan, $id);
    if ($stmt->execute()) {
        header("Location: hukuman.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Hukuman</title>
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
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h2,
    h3 {
        margin-bottom: 20px;
        text-align: center;
    }

    .form-container {
        width: 80%;
        margin-bottom: 30px;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    form input,
    form select,
    form textarea,
    form button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    form button {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        border: none;
        font-size: 16px;
    }

    form button:hover {
        background-color: #45a049;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
    }

    table td a {
        color: #d9534f;
        text-decoration: none;
    }

    table td a:hover {
        color: #c9302c;
    }

    table td form {
        display: inline-block;
    }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin_dashboard.php">🏠 Home</a>
        <a href="siswa.php">📚 Manajemen Siswa</a>
        <a href="hukuman.php">⚠️ Manajemen Hukuman</a>
        <a href="pelanggaran.php">⚠️ Manajemen Pelanggaran</a>
        <a href="laporan.php">📊 Laporan</a>
    </div>

    <div class="content">
        <h2>Kelola Data Hukuman</h2>

        <!-- Form untuk Tambah Jenis Hukuman -->
        <form method="POST">
            <h3>Tambah Jenis Hukuman</h3>
            <input type="text" name="nama_hukuman" placeholder="Nama Jenis Hukuman" required>
            <button type="submit" name="tambah_hukuman">Tambah Jenis Hukuman</button>
        </form>

        <h3>Daftar Jenis Hukuman</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Jenis Hukuman</th>
                <th>Aksi</th>
            </tr>
            <?php
            $data_hukuman = $koneksi->query("SELECT * FROM jenis_hukuman");
            while ($row_hukuman = $data_hukuman->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $row_hukuman['id']; ?></td>
                <td><?= $row_hukuman['nama']; ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?= $row_hukuman['id']; ?>">
                        <input type="text" name="nama_hukuman" value="<?= $row_hukuman['nama']; ?>" required>
                        <button type="submit" name="update_hukuman">Update</button>
                        <a href="?hapus_hukuman=<?= $row_hukuman['id']; ?>"
                            onclick="return confirm('Yakin ingin menghapus jenis hukuman ini?')">Hapus</a>
                    </form>

                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>