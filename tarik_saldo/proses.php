<?php
include "koneksi.php";

if (isset($_GET['id_tarik']) && isset($_GET['aksi'])) {

    $id_tarik = $_GET['id_tarik'];
    $aksi = $_GET['aksi']; // disetujui / ditolak

    $cek = mysqli_query($koneksi, "SELECT * FROM tarik_saldo WHERE id_tarik='$id_tarik'");
    $data = mysqli_fetch_array($cek);

    if ($data && $data['status'] == 'pending') {

        if ($aksi == 'disetujui') {
            // Kurangi saldo nasabah karena penarikan disetujui
            mysqli_query($koneksi, "UPDATE users SET saldo = saldo - {$data['nominal']} WHERE id_user='{$data['id_user']}'");
        }

        mysqli_query($koneksi, "UPDATE tarik_saldo SET status='$aksi' WHERE id_tarik='$id_tarik'");
    }

    header("Location: index.php");
    exit;
} else {
    echo "Data tidak lengkap!";
}
?>
