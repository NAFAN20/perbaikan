<?php
$conn = new mysqli("localhost", "root", "", "pelanggaran_siswa");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST["nis"];
    $nama = $_POST["nama"];
    $kelas = $_POST["kelas"];
    $jurusan = $_POST["jurusan"];

    $sql = "INSERT INTO siswa (nis, nama, kelas, jurusan) VALUES ('$nis', '$nama', '$kelas', '$jurusan')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Siswa berhasil ditambahkan'); window.location.href='manajemen_siswa.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-500 to-indigo-600 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-96">
        <h2 class="text-3xl font-bold text-gray-700 text-center mb-6">Tambah Siswa</h2>
        <form action="" method="post" class="space-y-4">
            <div>
                <label class="block text-gray-600">NIS:</label>
                <input type="text" name="nis"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div>
                <label class="block text-gray-600">Nama:</label>
                <input type="text" name="nama"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div>
                <label class="block text-gray-600">Kelas:</label>
                <select name="kelas"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">Pilih Kelas</option>
                    <option value="1">Kelas 10</option>
                    <option value="2">Kelas 11</option>
                    <option value="3">Kelas 12</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-600">Jurusan:</label>
                <select name="jurusan"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">Pilih Jurusan</option>
                    <optgroup label="Rekayasa Perangkat Lunak (RPL)">
                        <option value="RPL 1">RPL 1</option>
                        <option value="RPL 2">RPL 2</option>
                    </optgroup>
                    <optgroup label="Akuntansi (AK)">
                        <option value="AK 1">AK 1</option>
                        <option value="AK 2">AK 2</option>
                        <option value="AK 3">AK 3</option>
                        <option value="AK 4">AK 4</option>
                    </optgroup>
                    <optgroup label="Administrasi Perkantoran (AP)">
                        <option value="AP 1">AP 1</option>
                        <option value="AP 2">AP 2</option>
                        <option value="AP 3">AP 3</option>
                        <option value="AP 4">AP 4</option>
                    </optgroup>
                    <optgroup label="Pekerja Sosial (PS)">
                        <option value="PS 1">PS 1</option>
                        <option value="PS 2">PS 2</option>
                        <option value="PS 3">PS 3</option>
                        <option value="PS 4">PS 4</option>
                    </optgroup>
                </select>
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="manajemen_siswa.php" class="text-blue-500 hover:underline">Kembali</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>