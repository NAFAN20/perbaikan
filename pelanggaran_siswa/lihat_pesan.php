<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pelanggaran_siswa";

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil keyword pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query dengan pencarian
$sql = "SELECT nama, email, pesan, DATE(tanggal) AS tgl, TIME(tanggal) AS jam FROM kontak 
        WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR pesan LIKE '%$search%'
        ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white min-h-screen flex items-center justify-center">
    <div
        class="container mx-auto p-8 bg-gradient-to-br from-black to-blue-900 shadow-2xl rounded-lg max-w-3xl border border-blue-500">
        <h2 class="text-4xl font-extrabold text-blue-400 text-center mb-6 uppercase tracking-wider">Pesan Masuk</h2>

        <!-- Form pencarian -->
        <form method="GET" class="mb-6 text-center">
            <input type="text" name="search" placeholder="Cari pesan..."
                class="border border-blue-500 p-3 rounded-lg w-2/3 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="px-5 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-500 transition duration-300">Cari</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-blue-600 shadow-lg">
                <thead>
                    <tr class="bg-blue-700 text-white">
                        <th class="border border-blue-500 p-3">No</th>
                        <th class="border border-blue-500 p-3">Nama</th>
                        <th class="border border-blue-500 p-3">Email</th>
                        <th class="border border-blue-500 p-3">Pesan</th>
                        <th class="border border-blue-500 p-3">Tanggal</th>
                        <th class="border border-blue-500 p-3">Jam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='bg-gray-900 hover:bg-blue-800 transition duration-300'>";
                            echo "<td class='border border-blue-500 p-3 text-center'>{$no}</td>";
                            echo "<td class='border border-blue-500 p-3'>{$row['nama']}</td>";
                            echo "<td class='border border-blue-500 p-3'>{$row['email']}</td>";
                            echo "<td class='border border-blue-500 p-3'>{$row['pesan']}</td>";
                            echo "<td class='border border-blue-500 p-3 text-center'>{$row['tgl']}</td>";
                            echo "<td class='border border-blue-500 p-3 text-center'>{$row['jam']}</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='border border-blue-500 p-3 text-center text-gray-400'>Belum ada pesan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-6">
            <a href="admin_dashboard.php"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-500 transition duration-300">Kembali
                ke Beranda</a>
        </div>
    </div>
</body>

</html>