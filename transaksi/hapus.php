<?php
include "koneksi.php";

if (isset($_GET['id_transaksi'])) {

    $id_transaksi = $_GET['id_transaksi'];

    // Ambil data transaksi sebelum dihapus, untuk membatalkan efek saldo & stok
    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'");
    $data = mysqli_fetch_array($cek);

    if ($data) {
        mysqli_query($koneksi, "UPDATE users SET saldo = saldo - {$data['total_rp']} WHERE id_user='{$data['id_user']}'");
        mysqli_query($koneksi, "UPDATE sampah SET stok_kg = stok_kg - {$data['berat_kg']} WHERE id_sampah='{$data['id_sampah']}'");
    }

    $query = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID transaksi tidak ditemukan!";
}
?>
