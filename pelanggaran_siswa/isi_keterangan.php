<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pelanggaran_siswa";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $keterangan = $_POST['keterangan'];

    $updateQuery = "UPDATE pelanggaran SET keterangan = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "si", $keterangan, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Keterangan berhasil diperbarui!'); window.location.href='laporan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui keterangan!');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Keterangan Pelanggaran</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
    }

    form {
        background: rgba(255, 255, 255, 0.2);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 300px;
    }

    input,
    textarea,
    button {
        width: 100%;
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
        border: none;
        font-size: 14px;
    }

    button {
        background: #2a5298;
        color: white;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #1e3c72;
    }

    .btn-kembali {
        background: #ff4757;
        margin-top: 10px;
    }

    .btn-kembali:hover {
        background: #e84118;
    }
    </style>
</head>

<body>

    <h2>Isi Keterangan Pelanggaran</h2>
    <form method="POST">
        <label for="id">ID Pelanggaran:</label>
        <input type="number" name="id" required>

        <label for="keterangan">Keterangan:</label>
        <textarea name="keterangan" rows="3" required></textarea>

        <button type="submit" name="submit">Simpan</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='laporan.php'">Kembali</button>
    </form>

</body>

</html>