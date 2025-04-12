<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: pelanggaran.php");
    exit;
}

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM pelanggaran WHERE id = '$id'");

header("Location: pelanggaran.php");
exit;
?>