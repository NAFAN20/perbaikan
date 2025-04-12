<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mencegah SQL Injection
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        die("Data tidak ditemukan.");
    }
}

if (isset($_POST['update'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];

    $update = mysqli_query($koneksi, "UPDATE siswa SET nis='$nis', nama='$nama', kelas='$kelas', jurusan='$jurusan' WHERE id='$id'");

    if ($update) {
        header("Location: siswa.php?msg=updated");
        exit;
    } else {
        echo "Gagal mengupdate data.";
    }
}

if (isset($_POST['cancel'])) {
    header("Location: siswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
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
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        width: 400px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
    }

    input,
    select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 5px;
        outline: none;
        background: rgba(255, 255, 255, 0.8);
        color: #333;
    }

    .button-group {
        display: flex;
        gap: 10px;
    }

    button {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
    }

    .btn-save {
        background: #2a5298;
        color: white;
    }

    .btn-save:hover {
        background: #1e3c72;
    }

    .btn-cancel {
        background: #ff4757;
        color: white;
    }

    .btn-cancel:hover {
        background: #e84118;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Siswa</h2>
        <form method="POST">
            <input type="text" name="nis" value="<?= htmlspecialchars($data['nis']); ?>" required placeholder="NIS">
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required placeholder="Nama">

            <!-- Dropdown Kelas -->
            <select name="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="10" <?= $data['kelas'] == '10' ? 'selected' : ''; ?>>10</option>
                <option value="11" <?= $data['kelas'] == '11' ? 'selected' : ''; ?>>11</option>
                <option value="12" <?= $data['kelas'] == '12' ? 'selected' : ''; ?>>12</option>
            </select>

            <!-- Dropdown Jurusan -->
            <select name="jurusan" required>
                <option value="">-- Pilih Jurusan --</option>
                <option value="RPL 1" <?= $data['jurusan'] == 'RPL 1' ? 'selected' : ''; ?>>RPL 1</option>
                <option value="RPL 2" <?= $data['jurusan'] == 'RPL 2' ? 'selected' : ''; ?>>RPL 2</option>
                <option value="AP 1" <?= $data['jurusan'] == 'AP 1' ? 'selected' : ''; ?>>AP 1</option>
                <option value="AP 2" <?= $data['jurusan'] == 'AP 2' ? 'selected' : ''; ?>>AP 2</option>
                <option value="AP 3" <?= $data['jurusan'] == 'AP 3' ? 'selected' : ''; ?>>AP 3</option>
                <option value="AP 4" <?= $data['jurusan'] == 'AP 4' ? 'selected' : ''; ?>>AP 4</option>
                <option value="AK 1" <?= $data['jurusan'] == 'AK 1' ? 'selected' : ''; ?>>AK 1</option>
                <option value="AK 2" <?= $data['jurusan'] == 'AK 2' ? 'selected' : ''; ?>>AK 2</option>
                <option value="AK 3" <?= $data['jurusan'] == 'AK 3' ? 'selected' : ''; ?>>AK 3</option>
                <option value="AK 4" <?= $data['jurusan'] == 'AK 4' ? 'selected' : ''; ?>>AK 4</option>
                <option value="PS 1" <?= $data['jurusan'] == 'PS 1' ? 'selected' : ''; ?>>PS 1</option>
                <option value="PS 2" <?= $data['jurusan'] == 'PS 2' ? 'selected' : ''; ?>>PS 2</option>
                <option value="PS 3" <?= $data['jurusan'] == 'PS 3' ? 'selected' : ''; ?>>PS 3</option>
                <option value="PS 4" <?= $data['jurusan'] == 'PS 4' ? 'selected' : ''; ?>>PS 4</option>
            </select>

            <div class="button-group">
                <button type="submit" name="update" class="btn-save">Simpan</button>
                <button type="submit" name="cancel" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</body>

</html>