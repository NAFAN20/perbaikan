<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$success = false;
$error = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mencegah SQL Injection

    $query = "DELETE FROM siswa WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $success = true;
    } else {
        $error = "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    $error = "ID tidak valid.";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Siswa</title>
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
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        text-align: center;
    }

    .container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        width: 400px;
        animation: fadeIn 0.5s ease-in-out;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 15px;
    }

    p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .success {
        color: #4CAF50;
    }

    .error {
        color: #FF3B3B;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        background: #ff4757;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn:hover {
        background: #e84118;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <?php if ($success) { ?>
        <h1 class="success">✅ Siswa Berhasil Dihapus</h1>
        <p>Data siswa telah dihapus dari sistem.</p>
        <?php } else { ?>
        <h1 class="error">❌ Gagal Menghapus Siswa</h1>
        <p><?= htmlspecialchars($error); ?></p>
        <?php } ?>
        <a href="siswa.php" class="btn">Kembali ke Manajemen Siswa</a>
    </div>
</body>

</html>