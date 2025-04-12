<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: pelanggaran.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM pelanggaran WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $jenis_hukuman = $_POST['jenis_hukuman'];  // Ganti dengan jenis_hukuman
    $tanggal = $_POST['tanggal'];

    $update = "UPDATE pelanggaran SET jenis_pelanggaran='$jenis_pelanggaran', jenis_hukuman='$jenis_hukuman', tanggal='$tanggal' WHERE id='$id'";
    mysqli_query($koneksi, $update);
    
    header("Location: pelanggaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggaran</title>
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
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
    }

    .container {
        background: rgba(248, 6, 6, 0.1);
        padding: 30px;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        width: 400px;
        text-align: center;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    h1 {
        margin-bottom: 20px;
    }

    input,
    select,
    button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        font-size: 16px;
    }

    /* Updated styles */
    select {
        background: rgba(255, 255, 255, 0.3);
        /* Increased padding for better visual appeal */
        border-radius: 8px;
        border: 1px solid #ff4b5c;
        /* Red border for focus */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        /* Soft shadow */
        transition: all 0.3s ease;
        /* Smooth transition on hover/focus */
    }

    /* On hover or focus */
    select:hover,
    select:focus {
        background: rgba(255, 255, 255, 0.4);
        /* Slightly darker background on hover/focus */
        border-color: #e63946;
        /* Darker red border on hover/focus */
        box-shadow: 0 4px 10px rgba(255, 99, 71, 0.3);
        /* Red shadow on hover/focus */
        outline: none;
        /* Remove default outline */
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Pelanggaran</h1>
        <form method="POST">
            <input type="text" name="jenis_pelanggaran" value="<?= $data['jenis_pelanggaran']; ?>" required>
            <select name="jenis_hukuman" required>
                <!-- Ganti hukuman menjadi jenis_hukuman -->
                <?php
                // Ambil data jenis hukuman dari database
                $hukuman_query = mysqli_query($koneksi, "SELECT * FROM jenis_hukuman");
                while ($hukuman = mysqli_fetch_assoc($hukuman_query)) {
                    echo "<option value='" . $hukuman['id'] . "' " . ($data['jenis_hukuman'] == $hukuman['id'] ? 'selected' : '') . ">" . $hukuman['nama'] . "</option>";
                }
                ?>
            </select>
            <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required>
            <button type="submit" name="update">Simpan Perubahan</button>
            <a href="pelanggaran.php" class="btn-batal">Batal</a>
        </form>
    </div>
</body>

</html>