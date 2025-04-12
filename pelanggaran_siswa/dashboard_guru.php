<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Pelanggaran Siswa</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="bg-blue-900 text-white w-64 h-screen p-5 flex flex-col space-y-6">
        <h1 class="text-3xl font-semibold mb-8">Dashboard Guru</h1>

        <div class="flex flex-col space-y-4">
            <a href="dashboard_guru.php"
                class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                <span class="text-lg">Beranda</span>
            </a>
            <a href="manajemen_siswa.php"
                class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                <span class="text-lg">Siswa</span>
            </a>
            <a href="laporan_guru.php"
                class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                <span class="text-lg">Laporan</span>
            </a>
        </div>

        <div class="mt-auto">
            <a href="logout.php" class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition duration-200">
                <span class="text-lg">Logout</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto p-6 w-full flex-1">
        <h1 class="text-3xl font-bold mb-4">Dashboard Guru - Pelanggaran Siswa</h1>

        <!-- Statistik Pelanggaran -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <canvas id="pelanggaranChart"></canvas>
        </div>

        <!-- Tabel Pelanggaran -->
        <div class="bg-white p-6 mt-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Daftar Pelanggaran</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 rounded-lg">
                    <thead class="bg-blue-600 text-white text-md uppercase">
                        <tr>
                            <th class="px-6 py-3 border border-gray-300 text-center w-16">No</th>
                            <th class="px-6 py-3 border border-gray-300 text-center">Nama Siswa</th>
                            <th class="px-6 py-3 border border-gray-300 text-center w-32">Kelas</th>
                            <th class="px-6 py-3 border border-gray-300 text-center w-32">Jurusan</th>
                            <th class="px-6 py-3 border border-gray-300 text-center w-32">Jenis Kelamin</th>
                            <th class="px-6 py-3 border border-gray-300 text-center w-48">Jenis Pelanggaran</th>
                            <th class="px-6 py-3 border border-gray-300 text-center w-32">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 bg-gray-50">
                        <?php
                        // Koneksi ke database
                        $conn = new mysqli("localhost", "root", "", "pelanggaran_siswa");

                        // Cek koneksi
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        // Ambil data pelanggaran
                        $query = "SELECT p.id, s.nama, s.kelas, s.jurusan, s.jenis_kelamin, p.jenis_pelanggaran, p.tanggal 
                                  FROM pelanggaran p 
                                  JOIN siswa s ON p.id_siswa = s.id
                                  ORDER BY p.tanggal DESC";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='border-t border-gray-300 hover:bg-gray-200 transition'>
                                        <td class='px-6 py-3 border border-gray-300 text-center font-semibold'>{$no}</td>
                                        <td class='px-6 py-3 border border-gray-300'>{$row['nama']}</td>
                                        <td class='px-6 py-3 border border-gray-300 text-center'>{$row['kelas']}</td>
                                        <td class='px-6 py-3 border border-gray-300 text-center'>{$row['jurusan']}</td>
                                        <td class='px-6 py-3 border border-gray-300 text-center'>{$row['jenis_kelamin']}</td>
                                        <td class='px-6 py-3 border border-gray-300 text-center'>{$row['jenis_pelanggaran']}</td>
                                        <td class='px-6 py-3 border border-gray-300 text-center'>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                                      </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='7' class='px-6 py-4 text-center text-gray-500 border border-gray-300'>
                                        Tidak ada data pelanggaran
                                    </td>
                                  </tr>";
                        }

                        // Ambil data statistik
                        $query_stat = "SELECT jenis_pelanggaran, COUNT(*) as jumlah FROM pelanggaran GROUP BY jenis_pelanggaran";
                        $result_stat = $conn->query($query_stat);

                        $data_stat = ["Ringan" => 0, "Sedang" => 0, "Berat" => 0];

                        while ($row_stat = $result_stat->fetch_assoc()) {
                            if ($row_stat['jenis_pelanggaran'] == 'Bolos') {
                                $data_stat['Ringan'] = $row_stat['jumlah'];
                            } elseif ($row_stat['jenis_pelanggaran'] == 'Merokok') {
                                $data_stat['Sedang'] = $row_stat['jumlah'];
                            } elseif ($row_stat['jenis_pelanggaran'] == 'Tawuran, Bully') {
                                $data_stat['Berat'] = $row_stat['jumlah'];
                            }
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    // Data Statistik dari PHP
    var pelanggaranData = <?php echo json_encode(array_values($data_stat)); ?>;

    var ctx = document.getElementById('pelanggaranChart').getContext('2d');
    var pelanggaranChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ringan', 'Sedang', 'Berat'],
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: pelanggaranData,
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>

</html>