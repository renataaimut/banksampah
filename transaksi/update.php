<?php
include "koneksi.php";

$id_transaksi = $_POST['id_transaksi'];
$id_user_lama = $_POST['id_user_lama'];
$id_sampah_lama = $_POST['id_sampah_lama'];
$berat_kg_lama = $_POST['berat_kg_lama'];
$total_rp_lama = $_POST['total_rp_lama'];

$id_user = $_POST['id_user'];
$id_sampah = $_POST['id_sampah'];
$berat_kg = $_POST['berat_kg'];
$tanggal = $_POST['tanggal'];

// Kembalikan efek transaksi lama
mysqli_query($koneksi, "UPDATE users SET saldo = saldo - $total_rp_lama WHERE id_user='$id_user_lama'");
mysqli_query($koneksi, "UPDATE sampah SET stok_kg = stok_kg - $berat_kg_lama WHERE id_sampah='$id_sampah_lama'");

// Hitung ulang total baru
$cek = mysqli_query($koneksi, "SELECT harga_per_kg FROM sampah WHERE id_sampah='$id_sampah'");
$harga = mysqli_fetch_array($cek);
$total_rp = $berat_kg * $harga['harga_per_kg'];

// Update data transaksi
mysqli_query($koneksi, "UPDATE transaksi SET id_user='$id_user', id_sampah='$id_sampah', tanggal='$tanggal', berat_kg='$berat_kg', total_rp='$total_rp' WHERE id_transaksi='$id_transaksi'");

// Terapkan efek baru
mysqli_query($koneksi, "UPDATE users SET saldo = saldo + $total_rp WHERE id_user='$id_user'");
mysqli_query($koneksi, "UPDATE sampah SET stok_kg = stok_kg + $berat_kg WHERE id_sampah='$id_sampah'");

header('Location: index.php');
exit;
?>
