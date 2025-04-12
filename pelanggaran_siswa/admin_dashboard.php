<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(-45deg, #1e3c72, #2a5298, #4a90e2, #56ccf2);
        background-size: 400% 400%;
        animation: gradientBG 8s ease infinite;
        padding: 20px;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .dashboard-container {
        background: rgba(255, 255, 255, 0.15);
        padding: 40px;
        border-radius: 20px;
        backdrop-filter: blur(15px);
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 450px;
        text-align: center;
        transition: all 0.3s ease;
    }

    h1 {
        color: white;
        font-weight: 600;
        font-size: 26px;
        margin-bottom: 20px;
    }

    nav {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    a {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
        background: rgba(255, 255, 255, 0.25);
        color: white;
        text-decoration: none;
        font-size: 18px;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    a:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: translateY(-3px);
        box-shadow: 0px 5px 15px rgba(255, 255, 255, 0.2);
    }

    a i {
        margin-right: 10px;
        font-size: 20px;
    }

    /* Tambahan Media Queries untuk Responsiveness */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 30px;
        }

        h1 {
            font-size: 22px;
        }

        a {
            font-size: 16px;
            padding: 12px;
        }

        a i {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .dashboard-container {
            padding: 25px;
            border-radius: 15px;
        }

        h1 {
            font-size: 20px;
        }

        a {
            font-size: 14px;
            padding: 10px;
        }

        a i {
            font-size: 16px;
            margin-right: 8px;
        }
    }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h1>Selamat Datang di Dashboard</h1>
        <nav>
            <a href="siswa.php"><i class="fas fa-user-graduate"></i> Manajemen Siswa</a>
            <a href="pelanggaran.php"><i class="fas fa-exclamation-triangle"></i> Manajemen Pelanggaran</a>
            <a href="laporan.php"><i class="fas fa-file-alt"></i> Laporan</a>
            <a href="hukuman.php"><i class="fas fa-file-alt"></i> Hukuman</a>
            <a href="lihat_pesan.php"><i class="fas fa-envelope"></i> Pengaduan</a>
            <a href="logout.php" style="background: #ff4d4d;"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
</body>

</html>