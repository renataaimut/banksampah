<?php
include "koneksi.php";

$id_transaksi = $_GET['id_transaksi'];

$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'");
$data = mysqli_fetch_array($query);

$nasabah = mysqli_query($koneksi, "SELECT * FROM users WHERE role IN ('siswa','guru')");
$sampah = mysqli_query($koneksi, "SELECT * FROM sampah");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Setoran</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=3">
</head>

<body class="role-admin">

    <div class="form-wrap">
        <div class="form-card">

            <div class="icon-top">✏️</div>
            <h1>Edit Setoran</h1>
            <p class="sub">Ubah data setoran</p>

            <form action="update.php" method="post">

                <input type="hidden" name="id_transaksi" value="<?php echo $data['id_transaksi'] ?>">
                <input type="hidden" name="id_user_lama" value="<?php echo $data['id_user'] ?>">
                <input type="hidden" name="id_sampah_lama" value="<?php echo $data['id_sampah'] ?>">
                <input type="hidden" name="berat_kg_lama" value="<?php echo $data['berat_kg'] ?>">
                <input type="hidden" name="total_rp_lama" value="<?php echo $data['total_rp'] ?>">

                <div class="form-group">
                    <label>Nasabah</label>
                    <select name="id_user" required>
                        <?php while ($n = mysqli_fetch_array($nasabah)) { ?>
                            <option value="<?php echo $n['id_user']; ?>" <?php echo ($n['id_user'] == $data['id_user']) ? 'selected' : ''; ?>>
                                <?php echo $n['nama']; ?> (<?php echo ucfirst($n['role']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <select name="id_sampah" required>
                        <?php while ($s = mysqli_fetch_array($sampah)) { ?>
                            <option value="<?php echo $s['id_sampah']; ?>" <?php echo ($s['id_sampah'] == $data['id_sampah']) ? 'selected' : ''; ?>>
                                <?php echo $s['jenis_sampah']; ?> (Rp <?php echo number_format($s['harga_per_kg'],0,',','.'); ?>/kg)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Berat (Kg)</label>
                    <input type="number" step="0.01" name="berat_kg" value="<?php echo $data['berat_kg'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="<?php echo $data['tanggal'] ?>" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>

            </form>

            <a href="index.php" class="form-back">← Kembali ke Data Setoran</a>

        </div>
    </div>

</body>
</html>
