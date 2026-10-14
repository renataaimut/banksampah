<?php
include "koneksi.php";

$id_sampah = $_GET['id_sampah'];

$query = mysqli_query($koneksi, "SELECT * FROM sampah WHERE id_sampah='$id_sampah'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Sampah</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=3">
</head>

<body class="role-admin">

    <div class="form-wrap">
        <div class="form-card">

            <div class="icon-top">✏️</div>
            <h1>Edit Sampah</h1>
            <p class="sub">Ubah data jenis sampah</p>

            <form action="update.php" method="post">

                <input type="hidden" name="id_sampah" value="<?php echo $data['id_sampah'] ?>">

                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <input type="text" name="jenis_sampah" value="<?php echo $data['jenis_sampah'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Harga Beli dari Nasabah / Kg</label>
                    <input type="number" step="0.01" name="harga_per_kg" value="<?php echo $data['harga_per_kg'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Harga Jual ke Pengepul / Kg</label>
                    <input type="number" step="0.01" name="harga_jual_kg" value="<?php echo $data['harga_jual_kg'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Stok (Kg)</label>
                    <input type="number" step="0.01" name="stok_kg" value="<?php echo $data['stok_kg'] ?>" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>

            </form>

            <a href="index.php" class="form-back">← Kembali ke Data Sampah</a>

        </div>
    </div>

</body>
</html>
