<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pelanggaran_siswa";
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data keterangan berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT keterangan FROM pelanggaran WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
}

// Proses update keterangan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $updateQuery = "UPDATE pelanggaran SET keterangan = '$keterangan' WHERE id = $id";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Keterangan berhasil diperbarui!'); window.location='laporan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Keterangan</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
    }

    .container {
        background: rgba(255, 255, 255, 0.2);
        padding: 20px;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        width: 400px;
        text-align: center;
    }

    h2 {
        color: white;
        margin-bottom: 15px;
    }

    label {
        font-size: 14px;
        font-weight: 600;
        color: white;
        display: block;
        text-align: left;
        margin-bottom: 5px;
    }

    textarea {
        width: 100%;
        height: 100px;
        padding: 10px;
        border: none;
        border-radius: 8px;
        resize: none;
        outline: none;
        font-size: 14px;
    }

    button {
        margin-top: 10px;
        width: 100%;
        font-size: 16px;
        padding: 10px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    button[type="submit"] {
        background: #27ae60;
        color: white;
    }

    button[type="submit"]:hover {
        background: #219150;
    }

    button[type="button"] {
        background: #e74c3c;
        color: white;
        margin-top: 5px;
    }

    button[type="button"]:hover {
        background: #c0392b;
    }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Keterangan</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <label for="keterangan">Keterangan:</label>
            <textarea name="keterangan" required><?= htmlspecialchars($data['keterangan'] ?? '') ?></textarea>
            <button type="submit">Simpan</button>
            <button type="button" onclick="window.history.back();">Kembali</button>
        </form>
    </div>

</body>

</html>