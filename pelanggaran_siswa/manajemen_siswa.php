<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pelanggaran_siswa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM siswa");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">
    <div class="w-64 bg-blue-900 text-white min-h-screen p-5 shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
        <ul>
            <li class="mb-4"><a href="dashboard_guru.php" class="block p-2 hover:bg-blue-700 rounded">Beranda</a></li>
            <li class="mb-4"><a href="manajemen_siswa.php" class="block p-2 hover:bg-blue-700 rounded">Manajemen
                    Siswa</a></li>
            <li class="mb-4"><a href="laporan_guru.php" class="block p-2 hover:bg-blue-700 rounded">Laporan</a></li>
        </ul>
    </div>

    <div class="flex-1 container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Daftar Siswa</h1>

        <!-- Input Pencarian & Tombol Tambah Siswa -->
        <div class="mb-4 flex items-center justify-between">
            <a href="tambah_siswa.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Siswa
            </a>
            <div class="flex items-center space-x-2">
                <input type="text" id="search" placeholder="Cari siswa..."
                    class="p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
                <select id="genderFilter"
                    class="p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
                    <option value="">Semua</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 rounded-lg" id="studentTable">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                        <tr>
                            <th class="px-6 py-3 border">No</th>
                            <th class="px-6 py-3 border">NIS</th>
                            <th class="px-6 py-3 border">Nama</th>
                            <th class="px-6 py-3 border">Kelas</th>
                            <th class="px-6 py-3 border">Jurusan</th>
                            <th class="px-6 py-3 border">Jenis Kelamin</th>
                            <th class="px-6 py-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        <?php 
                        $no = 1; 
                        $result = $conn->query("SELECT * FROM siswa");
                        while ($row = $result->fetch_assoc()) { ?>
                        <tr class='border-t border-gray-300 hover:bg-gray-100 transition'>
                            <td class='px-6 py-3 border text-center'><?= $no++ ?></td>
                            <td class='px-6 py-3 border'><?= $row["nis"] ?></td>
                            <td class='px-6 py-3 border'><?= $row["nama"] ?></td>
                            <td class='px-6 py-3 border'><?= $row["kelas"] ?></td>
                            <td class='px-6 py-3 border'><?= $row["jurusan"] ?></td>
                            <td class='px-6 py-3 border'><?= $row["jenis_kelamin"] ?></td>
                            <td class='px-6 py-3 border text-center'>
                                <a href="detail_siswa.php?nis=<?= $row['nis'] ?>"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Show</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    document.getElementById("search").addEventListener("keyup", filterTable);
    document.getElementById("genderFilter").addEventListener("change", filterTable);

    function filterTable() {
        let searchValue = document.getElementById("search").value.toLowerCase();
        let genderValue = document.getElementById("genderFilter").value;
        let rows = document.querySelectorAll("#studentTable tbody tr");

        rows.forEach(row => {
            let name = row.cells[2].textContent.toLowerCase();
            let nis = row.cells[1].textContent.toLowerCase();
            let gender = row.cells[5].textContent;

            let nameMatch = name.includes(searchValue) || nis.includes(searchValue);
            let genderMatch = genderValue === "" || gender === genderValue;

            if (nameMatch && genderMatch) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
    </script>
</body>

</html>