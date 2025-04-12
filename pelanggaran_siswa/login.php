<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Simpan data session
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect ke dashboard sesuai role
        if ($row['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($row['role'] == 'guru') {
            header("Location: dashboard_guru.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "Username, Password, atau Role salah!";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(-45deg, #1e3c72, #2a5298, #4a90e2, #56ccf2);
        background-size: 400% 400%;
        animation: gradientBG 8s ease infinite;
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

    .login-container {
        background: rgba(255, 255, 255, 0.15);
        padding: 35px;
        border-radius: 15px;
        backdrop-filter: blur(12px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 380px;
    }

    h2 {
        color: white;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .error-message {
        color: #ff3333;
        font-size: 14px;
        margin-bottom: 10px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    input,
    select {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        outline: none;
    }

    input[type="text"],
    input[type="password"],
    select {
        background: #ffffff;
        /* Warna solid putih */
        color: #2a5298;
        /* Warna teks lebih gelap */
        font-weight: 500;
        transition: 0.3s ease;
    }


    button {
        width: 100%;
        padding: 12px;
        background: #56ccf2;
        border: none;
        color: white;
        font-size: 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button:hover {
        background: #2a5298;
        transform: scale(1.05);
    }

    .register-btn {
        border: 2px solid white;
        color: white;
        font-size: 16px;
        padding: 10px;
        width: 100%;
        border-radius: 8px;
        margin-top: 10px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .register-btn:hover {
        background: white;
        color: #2a5298;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <!-- Menampilkan pesan error -->
        <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
            </select>
            <button type="submit" name="login">Login</button>
        </form>

        <!-- Tambahkan tombol register -->
    </div>
</body>

</html>