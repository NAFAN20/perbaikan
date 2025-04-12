<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pelanggaran_siswa";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'terima') {
        $status = 'diterima';
    } elseif ($action === 'tolak') {
        $status = 'ditolak';
    } else {
        die("Aksi tidak valid.");
    }

    $query = "UPDATE emails SET status='$status' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "success"; // Kembalikan teks 'success' agar AJAX bisa mengenali perubahan berhasil
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Permintaan tidak valid.";
}
?>