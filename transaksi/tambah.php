<?php
include "koneksi.php";

$nasabah = mysqli_query($koneksi, "SELECT * FROM users WHERE role IN ('siswa','guru')");
$sampah = mysqli_query($koneksi, "SELECT * FROM sampah");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Setoran</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=3">
</head>

<body class="role-admin">

    <div class="form-wrap">
        <div class="form-card">

            <div class="icon-top">📥</div>
            <h1>Tambah Setoran</h1>
            <p class="sub">Catat setoran sampah nasabah</p>

            <form action="simpan.php" method="post">

                <div class="form-group">
                    <label>Nasabah</label>
                    <select name="id_user" required>
                        <option value="">-- Pilih Nasabah --</option>
                        <?php while ($n = mysqli_fetch_array($nasabah)) { ?>
                            <option value="<?php echo $n['id_user']; ?>"><?php echo $n['nama']; ?> (<?php echo ucfirst($n['role']); ?>)</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <select name="id_sampah" required>
                        <option value="">-- Pilih Jenis Sampah --</option>
                        <?php while ($s = mysqli_fetch_array($sampah)) { ?>
                            <option value="<?php echo $s['id_sampah']; ?>" data-harga="<?php echo $s['harga_per_kg']; ?>">
                                <?php echo $s['jenis_sampah']; ?> (Rp <?php echo number_format($s['harga_per_kg'],0,',','.'); ?>/kg)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Berat (Kg)</label>
                    <input type="number" step="0.01" name="berat_kg" placeholder="Contoh: 2" required>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Simpan Setoran</button>

            </form>

            <a href="index.php" class="form-back">← Kembali ke Data Setoran</a>

        </div>
    </div>

</body>
</html>
