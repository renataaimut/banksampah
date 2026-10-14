<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] == "admin") {
    header('location:logout.php');
    exit;
}
if ($_SESSION['role'] == "pengepul") {
    header('location:dashboard_pengepul.php');
    exit;
}

$id_user = (int) $_SESSION['id_user'];
$sampah = mysqli_query($koneksi, "SELECT * FROM sampah ORDER BY jenis_sampah ASC");

$pesan = $_GET['pesan'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setor Sampah - SiDU Bank Sampah</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body class="role-<?php echo htmlspecialchars($_SESSION['role']); ?>">

    <div class="app-shell">

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="mark">♻</div>
                <div class="txt"><strong>SiDU</strong><span>Bank Sampah Sekolah</span></div>
            </div>
            <nav class="sidebar-nav">
                <p class="sidebar-label">Menu</p>
                <a href="dashboard_nasabah.php"><span class="ic">🏠</span> Beranda</a>
                <a href="setor.php" class="active"><span class="ic">♻</span> Setor Sampah</a>
                <a href="dashboard_nasabah.php#saldo"><span class="ic">💰</span> Tarik Saldo</a>
                <a href="riwayat.php"><span class="ic">📜</span> Riwayat</a>
                <p class="sidebar-label">Akun</p>
                <a href="logout.php" class="logout"><span class="ic">🚪</span> Keluar</a>
            </nav>
            <div class="sidebar-foot">SiDU © Bank Sampah Sekolah</div>
        </aside>

        <div class="main">
            <div class="topbar">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button class="menu-toggle" id="menuToggle" aria-label="Menu">☰</button>
                    <div>
                        <h1>Setor Sampah</h1>
                        <div class="sub">Ajukan setoran, admin akan memverifikasi saat sampah diterima</div>
                    </div>
                </div>
                <span class="role-tag"><?php echo ucfirst($_SESSION['role']); ?></span>
            </div>

            <div class="page">
                <div class="card card-pad" style="max-width:520px;">

                    <?php if ($pesan == 'berhasil') { ?>
                        <div class="auth-error" style="background:var(--pink-50);color:var(--pink-700);">Pengajuan setor terkirim. Serahkan sampahnya ke admin untuk ditimbang &amp; disetujui.</div>
                    <?php } elseif ($pesan == 'gagal') { ?>
                        <div class="auth-error">Data tidak valid. Pastikan jenis sampah dipilih dan berat lebih dari 0.</div>
                    <?php } ?>

                    <form action="setor_proses.php" method="post">

                        <div class="form-group">
                            <label>Jenis Sampah</label>
                            <select name="id_sampah" required>
                                <option value="">-- Pilih Jenis Sampah --</option>
                                <?php while ($s = mysqli_fetch_array($sampah)) { ?>
                                    <option value="<?php echo $s['id_sampah']; ?>">
                                        <?php echo htmlspecialchars($s['jenis_sampah']); ?> (Rp <?php echo number_format($s['harga_per_kg'], 0, ',', '.'); ?>/kg)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Perkiraan Berat (Kg)</label>
                            <input type="number" step="0.01" min="0.01" name="berat_kg" placeholder="Contoh: 2" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Ajukan Setoran</button>
                    </form>

                    <p style="font-size:12.5px;color:var(--ink-300);margin-top:14px;">
                        Saldo baru bertambah setelah admin menyetujui pengajuan. Berat final mengikuti hasil timbangan admin.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('menuToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>

</body>
</html>
