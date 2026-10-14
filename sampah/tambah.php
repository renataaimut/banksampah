<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Sampah</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=3">
</head>

<body class="role-admin">

    <div class="form-wrap">
        <div class="form-card">

            <div class="icon-top">🗑️</div>
            <h1>Tambah Sampah</h1>
            <p class="sub">Masukkan jenis sampah baru</p>

            <form action="simpan.php" method="post">

                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <input type="text" name="jenis_sampah" placeholder="Contoh: Plastik" required>
                </div>

                <div class="form-group">
                    <label>Harga Beli dari Nasabah / Kg</label>
                    <input type="number" step="0.01" name="harga_per_kg" placeholder="Contoh: 2000" required>
                </div>

                <div class="form-group">
                    <label>Harga Jual ke Pengepul / Kg</label>
                    <input type="number" step="0.01" name="harga_jual_kg" placeholder="Contoh: 2500" required>
                </div>

                <div class="form-group">
                    <label>Stok (Kg)</label>
                    <input type="number" step="0.01" name="stok_kg" placeholder="Contoh: 0" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Simpan Data</button>

            </form>

            <a href="index.php" class="form-back">← Kembali ke Data Sampah</a>

        </div>
    </div>

</body>
</html>
