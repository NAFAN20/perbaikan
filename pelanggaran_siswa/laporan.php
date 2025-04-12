<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pelanggaran_siswa";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggaran</title>
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
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
    }

    .sidebar {
        width: 250px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        padding: 10px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .content {
        flex: 1;
        padding: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h2,
    h3 {
        margin-bottom: 20px;
        text-align: center;
    }

    .statistik {
        width: 50%;
        background: rgba(255, 255, 255, 0.2);
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }

    .statistik table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        color: black;
        border-radius: 10px;
        overflow: hidden;
    }

    .statistik th,
    .statistik td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .statistik th {
        background: #2a5298;
        color: white;
    }

    table {
        width: 90%;
        max-width: 950px;
        border-collapse: collapse;
        background: white;
        color: black;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        max-width: 200px;
        word-wrap: break-word;
        white-space: nowrap;
    }

    th {
        background: #2a5298;
        color: white;
    }

    td:last-child {
        text-align: center;
        white-space: nowrap;
    }

    .button-container {
        margin-top: 20px;
        text-align: left;
        width: 100%;
    }

    .button-container a button {
        padding: 10px 20px;
        font-size: 16px;
        background: #2a5298;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    .button-container a button:hover {
        background: #1e3c72;
    }

    .edit-btn {
        background: #ffcc00;
        color: black;
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        text-align: center;
    }

    .edit-btn:hover {
        background: #e6b800;
    }

    .show-btn {
        background: #007bff;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }

    .show-btn:hover {
        background: #0056b3;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin_dashboard.php">🏠 Home</a>
        <a href="siswa.php">📚 Manajemen Siswa</a>
        <a href="hukuman.php">⚠️ Manajemen Hukuman</a>
        <a href="pelanggaran.php">⚠️ Manajemen Pelanggaran</a>
        <a href="laporan.php">📊 Laporan</a>
    </div>

    <div class="content">
        <!-- Statistik Pelanggaran -->
        <div class="statistik">
            <h3>📊 Statistik Pelanggaran</h3>
            <table>
                <thead>
                    <tr>
                        <th>Total Siswa Melanggar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $countQuery = "SELECT COUNT(DISTINCT id_siswa) AS total_pelanggar FROM pelanggaran";
                    $countResult = mysqli_query($conn, $countQuery);
                    $countData = mysqli_fetch_assoc($countResult);
                    echo "<tr><td>" . htmlspecialchars($countData['total_pelanggar']) . "</td></tr>";
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Laporan Pelanggaran -->
        <h2>Laporan Pelanggaran</h2>
        <table id="reportTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tanggal</th>
                    <th>Alasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $query = "SELECT p.id, s.nama AS nama_siswa, s.jurusan, s.kelas, p.jenis_pelanggaran, p.tanggal, p.keterangan 
                FROM pelanggaran p 
                JOIN siswa s ON p.id_siswa = s.id";
      $result = mysqli_query($conn, $query);
      
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['id']) . "</td>";
          echo "<td>" . htmlspecialchars($row['nama_siswa']) . "</td>";
          echo "<td>" . htmlspecialchars($row['jurusan']) . "</td>";
          echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
          echo "<td>" . htmlspecialchars($row['jenis_pelanggaran']) . "</td>";
          echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
          echo "<td>" . (!empty($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '-') . "</td>";
          echo "<td>
                  <div class='action-buttons'>
                      <a href='show_pelanggaran.php?id=" . urlencode($row['id']) . "' class='show-btn'>👁 Show</a>
                      <a href='edit_keterangan.php?id=" . urlencode($row['id']) . "' class='edit-btn'>✏️ Edit</a>
                  </div>
                </td>";
          echo "</tr>";
      }
      
                ?>
            </tbody>
        </table>

        <!-- Tombol Tambah Keterangan -->
        <div class="button-container">
            <a href="isi_keterangan.php">
                <button>➕ Tambah Keterangan</button>
            </a>
        </div>

    </div>

    <script>
    function confirmAction(action, id) {
        let message = (action === "terima") ? "Apakah Anda yakin ingin MENERIMA email ini?" :
            "Apakah Anda yakin ingin MENOLAK email ini?";
        if (confirm(message)) {
            fetch(`proses_email.php?action=${action}&id=${id}`)
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        let statusCell = document.querySelector(`#status-${id}`);
                        let actionCell = document.querySelector(`#action-${id}`);
                        let color = (action === "terima") ? "green" : "red";
                        statusCell.innerHTML =
                            `<span style='color: ${color};'>${action.charAt(0).toUpperCase() + action.slice(1)}</span>`;
                        actionCell.innerHTML = "<span>-</span>";
                        document.querySelector(`#email-${id}`).dataset.status = action;

                        // Ambil data dari email yang diterima
                        const nis = document.querySelector(`#email-${id}`).dataset.nis;
                        const nama = document.querySelector(`#email-${id}`).dataset.nama;
                        const kelas = document.querySelector(`#email-${id}`).dataset.kelas;
                        const jurusan = document.querySelector(`#email-${id}`).dataset.jurusan;
                        const jenis_pelanggaran = document.querySelector(`#email-${id}`).dataset.jenis_pelanggaran;

                        // Kirim data ke PHP menggunakan AJAX
                        fetch('proses_pelanggaran.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    nis: nis,
                                    nama: nama,
                                    kelas: kelas,
                                    jurusan: jurusan,
                                    jenis_pelanggaran: jenis_pelanggaran
                                })
                            })
                            .then(response => response.text())
                            .then(result => {
                                if (result.trim() === 'success') {
                                    alert("Data berhasil dimasukkan ke tabel pelanggaran.");
                                } else {
                                    alert("Terjadi kesalahan saat memasukkan data.");
                                }
                            })
                            .catch(error => {
                                alert("Gagal mengirim data.");
                                console.error(error);
                            });
                    } else {
                        alert("Terjadi kesalahan: " + data);
                    }
                })
                .catch(error => {
                    alert("Gagal mengubah status email.");
                    console.error(error);
                });
        }
    }
    </script>

</body>

</html>