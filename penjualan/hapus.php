<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] <> "admin") {
    header('location:../logout.php');
    exit;
}

$id_penjualan = isset($_GET['id_penjualan']) ? (int) $_GET['id_penjualan'] : 0;

$cek = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_penjualan='$id_penjualan'");
$data = mysqli_fetch_array($cek);

if ($data) {
    // Kembalikan stok sampah & saldo pengepul seperti sebelum transaksi terjadi
    mysqli_query($koneksi, "UPDATE sampah SET stok_kg = stok_kg + {$data['berat_kg']} WHERE id_sampah='{$data['id_sampah']}'");
    mysqli_query($koneksi, "UPDATE users SET saldo = saldo + {$data['total_rp']} WHERE id_user='{$data['id_pengepul']}'");
    mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'");
}

header('Location: index.php');
exit;
?>
