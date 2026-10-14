<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] <> "admin") {
    header('location:../logout.php');
    exit;
}

$id_user = isset($_POST['id_user']) ? (int) $_POST['id_user'] : 0;
$nominal = isset($_POST['nominal']) ? (float) $_POST['nominal'] : 0;

// Pastikan target benar-benar pengepul
$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$id_user' AND role='pengepul'");

if ($nominal <= 0 || mysqli_num_rows($cek) === 0) {
    header('Location: index.php?pesan=gagal');
    exit;
}

$tanggal = date('Y-m-d');

$insert = mysqli_query($koneksi, "INSERT INTO topup_saldo (id_user, nominal, tanggal, keterangan) VALUES ('$id_user', '$nominal', '$tanggal', 'Top up oleh admin')");

if ($insert) {
    mysqli_query($koneksi, "UPDATE users SET saldo = saldo + $nominal WHERE id_user='$id_user'");
    header('Location: index.php?pesan=sukses');
    exit;
} else {
    echo "Top up gagal: " . mysqli_error($koneksi);
}
?>
