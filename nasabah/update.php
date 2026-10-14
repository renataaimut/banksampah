<?php
include "koneksi.php";

$id_user = $_POST['id_user'];
$username = $_POST['username'];
$password = $_POST['password'];
$nama = $_POST['nama'];
$saldo = $_POST['saldo'];
$role = $_POST['role'];

$query = mysqli_query($koneksi, "UPDATE users SET username='$username', password='$password', nama='$nama', saldo='$saldo', role='$role' WHERE id_user='$id_user'");

header('Location: index.php');
exit;
?>
