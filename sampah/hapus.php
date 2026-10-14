<?php
include "koneksi.php";

if (isset($_GET['id_sampah'])) {

    $id_sampah = $_GET['id_sampah'];

    $query = mysqli_query($koneksi, "DELETE FROM sampah WHERE id_sampah='$id_sampah'");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID sampah tidak ditemukan!";
}
?>
