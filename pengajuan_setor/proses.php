<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] <> "admin") {
    header('location:../logout.php');
    exit;
}

if (isset($_GET['id_setor']) && isset($_GET['aksi']) && in_array($_GET['aksi'], ['disetujui', 'ditolak'])) {

    $id_setor = (int) $_GET['id_setor'];
    $aksi = $_GET['aksi'];

    $cek = mysqli_query($koneksi, "SELECT * FROM setor_sampah WHERE id_setor='$id_setor'");
    $data = mysqli_fetch_array($cek);

    if ($data && $data['status'] == 'pending') {

        if ($aksi == 'disetujui') {
            $id_user   = (int) $data['id_user'];
            $id_sampah = (int) $data['id_sampah'];
            $berat_kg  = $data['berat_kg'];
            $tanggal   = date('Y-m-d');

            // Harga dihitung saat disetujui, sama seperti setoran manual admin
            $h = mysqli_fetch_array(mysqli_query($koneksi, "SELECT harga_per_kg FROM sampah WHERE id_sampah='$id_sampah'"));
            $total_rp = $berat_kg * $h['harga_per_kg'];

            mysqli_query($koneksi, "INSERT INTO transaksi (id_user, id_sampah, tanggal, berat_kg, total_rp) VALUES ('$id_user', '$id_sampah', '$tanggal', '$berat_kg', '$total_rp')");
            mysqli_query($koneksi, "UPDATE users SET saldo = saldo + $total_rp WHERE id_user='$id_user'");
            mysqli_query($koneksi, "UPDATE sampah SET stok_kg = stok_kg + $berat_kg WHERE id_sampah='$id_sampah'");
        }

        mysqli_query($koneksi, "UPDATE setor_sampah SET status='$aksi' WHERE id_setor='$id_setor'");
    }

    header("Location: index.php");
    exit;
} else {
    echo "Data tidak lengkap!";
}
?>
