<?php
include "koneksi.php";

$jenis_sampah = $_POST['jenis_sampah'];
$harga_per_kg = $_POST['harga_per_kg'];
$harga_jual_kg = $_POST['harga_jual_kg'];
$stok_kg = $_POST['stok_kg'];

$query = mysqli_query($koneksi, "INSERT INTO sampah (jenis_sampah, harga_per_kg, harga_jual_kg, stok_kg) VALUES ('$jenis_sampah', '$harga_per_kg', '$harga_jual_kg', '$stok_kg')");

if ($query) {
    header('Location: index.php');
    exit;
} else {
    echo "Data gagal disimpan: " . mysqli_error($koneksi);
}
?>
