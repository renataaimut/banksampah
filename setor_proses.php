<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] == "admin") {
    header('location:logout.php');
    exit;
}
if ($_SESSION['role'] == "pengepul") {
    header('location:dashboard_pengepul.php');
    exit;
}

$id_user   = (int) $_SESSION['id_user'];
$id_sampah = (int) ($_POST['id_sampah'] ?? 0);
$berat_kg  = (float) ($_POST['berat_kg'] ?? 0);
$tanggal   = date('Y-m-d');

$cek = mysqli_query($koneksi, "SELECT id_sampah FROM sampah WHERE id_sampah='$id_sampah'");

if ($id_sampah <= 0 || $berat_kg <= 0 || mysqli_num_rows($cek) === 0) {
    header('Location: setor.php?pesan=gagal');
    exit;
}

mysqli_query($koneksi, "INSERT INTO setor_sampah (id_user, id_sampah, berat_kg, tanggal, status) VALUES ('$id_user', '$id_sampah', '$berat_kg', '$tanggal', 'pending')");

header('Location: setor.php?pesan=berhasil');
exit;
?>
