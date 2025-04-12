<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pelanggaran_siswa"; // Ganti database menjadi pelanggaran_siswa

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$nama  = htmlspecialchars($_POST['nama']);
$email = htmlspecialchars($_POST['email']);
$pesan = htmlspecialchars($_POST['pesan']);
$tanggal = date("Y-m-d H:i:s");

// Simpan ke database
$sql = "INSERT INTO kontak (nama, email, pesan, tanggal) VALUES ('$nama', '$email', '$pesan', '$tanggal')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
        alert('Pesan berhasil dikirim! Kami akan segera menghubungi Anda.');
        window.location.href='kontak.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal mengirim pesan, coba lagi.');
        window.location.href='kontak.php';
    </script>";
}

// Tutup koneksi
$conn->close();
?>