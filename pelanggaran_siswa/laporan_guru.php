<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran</title>
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
        height: 100vh;
        background: linear-gradient(135deg, #1c1c1c, #3a3a3a);
        color: white;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.2);
        width: 90%;
        max-width: 1000px;
        text-align: center;
    }

    h2 {
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .search-box {
        margin-bottom: 15px;
        text-align: left;
    }

    .search-box input {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.95);
        color: black;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background: #2a5298;
        color: white;
        font-size: 16px;
    }

    tbody tr:nth-child(odd) {
        background: #f5f5f5;
    }

    tbody tr:nth-child(even) {
        background: #e0e0e0;
    }

    tbody tr:hover {
        background: #d1e7fd;
        transition: 0.3s;
    }

    .sidebar {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 250px;
        background: #1e3a8a;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sidebar h2 {
        color: white;
        margin-bottom: 20px;
    }

    .sidebar a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        text-align: center;
        background: #1e40af;
        border-radius: 5px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: #2563eb;
    }

    .email-button {
        margin-top: 20px;
        padding: 12px 20px;
        font-size: 16px;
        background: #ff5733;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .email-button:hover {
        background: #e64a19;
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Menu</h2>
        <a href="dashboard_guru.php"> Beranda</a>
        <a href="manajemen_siswa.php"> Siswa</a>
        <a href="laporan_guru.php">Laporan</a>
    </div>

    <div class="container">
        <h2>📊 Laporan Pelanggaran</h2>

        <!-- Input Pencarian -->
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari Nama Siswa..." onkeyup="filterTable()">
        </div>

        <table id="pelanggaranTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Jenis Hukuman</th> <!-- Added this column -->
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Create connection
                $conn = mysqli_connect("localhost", "root", "", "pelanggaran_siswa");

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Updated query to include 'jenis_hukuman'
                $query = "SELECT p.id, s.nama AS nama_siswa, p.jenis_pelanggaran, h.nama AS jenis_hukuman, p.tanggal, p.keterangan 
                          FROM pelanggaran p 
                          JOIN siswa s ON p.id_siswa = s.id
                          JOIN jenis_hukuman h ON p.id_hukuman = h.id"; // Added JOIN with jenis_hukuman table
                $result = mysqli_query($conn, $query);

                // Check if query returns results
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_siswa']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jenis_pelanggaran']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jenis_hukuman']) . "</td>"; // Display jenis_hukuman
                        echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                        echo "<td>" . (!empty($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '-') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>"; // Display message if no data found
                }

                // Close connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>

    </div>

    <script>
    function sendEmail() {
        window.location.href = "kirim_email.php";
    }

    // Filter table function
    function filterTable() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toLowerCase();
        var table = document.getElementById('pelanggaranTable');
        var trs = table.getElementsByTagName('tr');

        for (var i = 1; i < trs.length; i++) {
            var td = trs[i].getElementsByTagName('td')[1]; // The second column (Nama Siswa)
            if (td) {
                var txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    trs[i].style.display = "";
                } else {
                    trs[i].style.display = "none";
                }
            }
        }
    }
    </script>

</body>

</html>