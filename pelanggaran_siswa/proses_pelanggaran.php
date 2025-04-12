<?php
// proses_pelanggaran.php

// Pastikan koneksi sudah benar
include('db_connection.php');

// Ambil data JSON yang dikirimkan
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // Ambil data dari JSON
    $nis = $data['nis'];
    $nama = $data['nama'];
    $kelas = $data['kelas'];
    $jurusan = $data['jurusan'];
    $jenis_pelanggaran = $data['jenis_pelanggaran'];

    // Query untuk memasukkan data ke tabel pelanggaran
    $query = "INSERT INTO pelanggaran (nis, nama, kelas, jurusan, jenis_pelanggaran) 
              VALUES ('$nis', '$nama', '$kelas', '$jurusan', '$jenis_pelanggaran')";

    if (mysqli_query($conn, $query)) {
        echo "success"; // Jika berhasil
    } else {
        echo "error"; // Jika gagal
    }
} else {
    echo "No data received";
}
?>