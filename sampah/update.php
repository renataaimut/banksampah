<?php
include "koneksi.php";

$id_sampah = $_POST['id_sampah'];
$jenis_sampah = $_POST['jenis_sampah'];
$harga_per_kg = $_POST['harga_per_kg'];
$harga_jual_kg = $_POST['harga_jual_kg'];
$stok_kg = $_POST['stok_kg'];

$query = mysqli_query($koneksi, "UPDATE sampah SET jenis_sampah='$jenis_sampah', harga_per_kg='$harga_per_kg', harga_jual_kg='$harga_jual_kg', stok_kg='$stok_kg' WHERE id_sampah='$id_sampah'");

header('Location: index.php');
exit;
?>
