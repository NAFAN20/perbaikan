<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pelanggaran_siswa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['nis'])) {
    echo "Data siswa tidak ditemukan!";
    exit;
}

$nis = $_GET['nis'];
$siswa_query = $conn->query("SELECT nama, kelas, jurusan FROM siswa WHERE nis = '$nis'");
$siswa = $siswa_query->fetch_assoc();

if (!$siswa) {
    echo "Data siswa tidak ditemukan!";
    exit;
}

$pelanggaran_query = $conn->query("
    SELECT * FROM pelanggaran 
    WHERE id_siswa = (SELECT id FROM siswa WHERE nis = '$nis')
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-900 to-purple-900 min-h-screen flex flex-col items-center text-white">

    <div class="w-full max-w-4xl bg-white text-gray-800 shadow-lg rounded-lg mt-10 p-8">
        <h1 class="text-3xl font-bold text-center text-blue-700">Detail Siswa</h1>

        <div class="bg-gray-100 p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-semibold text-blue-800"><?= $siswa["nama"] ?></h2>
            <p class="text-gray-700">Kelas: <span class="font-semibold"><?= $siswa["kelas"] ?></span></p>
            <p class="text-gray-700">Jurusan: <span class="font-semibold"><?= $siswa["jurusan"] ?></span></p>
        </div>

        <h2 class="text-2xl font-bold mt-6 text-blue-700">Riwayat Pelanggaran</h2>
        <div class="bg-gray-100 p-6 rounded-lg shadow-md mt-3">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 rounded-lg">
                    <thead class="bg-blue-700 text-white uppercase text-sm">
                        <tr>
                            <th class="px-6 py-3 border">No</th>
                            <th class="px-6 py-3 border">Pelanggaran</th>
                            <th class="px-6 py-3 border">Tanggal</th>
                            <th class="px-6 py-3 border">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        <?php $no = 1; while ($row = $pelanggaran_query->fetch_assoc()) { ?>
                        <tr class='border-t border-gray-300 hover:bg-gray-200 transition'>
                            <td class='px-6 py-3 border text-center font-bold'><?= $no++ ?></td>
                            <td class='px-6 py-3 border'><?= $row["jenis_pelanggaran"] ?></td>
                            <td class='px-6 py-3 border text-center'><?= date('d M Y', strtotime($row["tanggal"])) ?>
                            </td>
                            <td class='px-6 py-3 border italic'><?= $row["keterangan"] ?: '-' ?></td>
                        </tr>
                        <?php } ?>
                        <?php if ($pelanggaran_query->num_rows == 0) { ?>
                        <tr>
                            <td colspan="4" class="text-center py-3 text-gray-600 font-semibold">Tidak ada pelanggaran
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="manajemen_siswa.php"
            class="mt-6 inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">Kembali</a>
    </div>

</body>

</html>

<?php $conn->close(); ?>