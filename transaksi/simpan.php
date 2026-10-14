<?php
include "koneksi.php";

$id_user = $_POST['id_user'];
$id_sampah = $_POST['id_sampah'];
$berat_kg = $_POST['berat_kg'];
$tanggal = $_POST['tanggal'];

// Ambil harga per kg dari tabel sampah
$cek = mysqli_query($koneksi, "SELECT harga_per_kg FROM sampah WHERE id_sampah='$id_sampah'");
$harga = mysqli_fetch_array($cek);
$total_rp = $berat_kg * $harga['harga_per_kg'];

$query = mysqli_query($koneksi, "INSERT INTO transaksi (id_user, id_sampah, tanggal, berat_kg, total_rp) VALUES ('$id_user', '$id_sampah', '$tanggal', '$berat_kg', '$total_rp')");

if ($query) {
    // Tambah saldo nasabah
    mysqli_query($koneksi, "UPDATE users SET saldo = saldo + $total_rp WHERE id_user='$id_user'");

    // Tambah stok sampah
    mysqli_query($koneksi, "UPDATE sampah SET stok_kg = stok_kg + $berat_kg WHERE id_sampah='$id_sampah'");

    header('Location: index.php');
    exit;
} else {
    echo "Data gagal disimpan: " . mysqli_error($koneksi);
}
?>
