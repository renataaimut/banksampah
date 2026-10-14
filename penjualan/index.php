<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] <> "admin") {
    header('location:../logout.php');
    exit;
}

$totalHariIni = mysqli_fetch_array(mysqli_query($koneksi, "
    SELECT COALESCE(SUM(total_rp),0) AS rp, COALESCE(SUM(berat_kg),0) AS kg
    FROM penjualan WHERE tanggal = CURDATE()
"));

$totalBulanIni = mysqli_fetch_array(mysqli_query($koneksi, "
    SELECT COALESCE(SUM(total_rp),0) AS rp, COALESCE(SUM(berat_kg),0) AS kg
    FROM penjualan WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
"));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan ke Pengepul</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=3">
</head>

<body class="role-admin">

    <div class="app-shell">

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="mark">♻</div>
                <div class="txt"><strong>SiDU</strong><span>Bank Sampah Sekolah</span></div>
            </div>
            <nav class="sidebar-nav">
                <p class="sidebar-label">Menu</p>
                <a href="../index.php"><span class="ic">🏠</span> Beranda</a>
                <a href="../nasabah"><span class="ic">👤</span> Nasabah</a>
                <a href="../sampah"><span class="ic">🗑️</span> Sampah</a>
                <a href="../transaksi"><span class="ic">📥</span> Setoran</a>
                <a href="../pengajuan_setor"><span class="ic">📬</span> Pengajuan Setor</a>
                <a href="../tarik_saldo"><span class="ic">💰</span> Tarik Saldo</a>
                <a href="../penjualan" class="active"><span class="ic">🧾</span> Penjualan</a>
                <a href="../topup"><span class="ic">🔋</span> Top Up Pengepul</a>
                <p class="sidebar-label">Akun</p>
                <a href="../logout.php" class="logout"><span class="ic">🚪</span> Keluar</a>
            </nav>
            <div class="sidebar-foot">SiDU © Bank Sampah Sekolah</div>
        </aside>

        <div class="main">
            <div class="topbar">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button class="menu-toggle" id="menuToggle" aria-label="Menu">☰</button>
                    <div>
                        <h1>Data Penjualan</h1>
                        <div class="sub">Riwayat penjualan sampah ke pengepul</div>
                    </div>
                </div>
            </div>

            <div class="page">

                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="ic">🧾</div>
                        <div><div class="lbl">Penjualan Hari Ini</div><div class="val">Rp <?php echo number_format($totalHariIni['rp'], 0, ',', '.'); ?></div></div>
                    </div>
                    <div class="stat-card">
                        <div class="ic">⚖️</div>
                        <div><div class="lbl">Kg Terjual Hari Ini</div><div class="val"><?php echo number_format($totalHariIni['kg'], 1, ',', '.'); ?> kg</div></div>
                    </div>
                    <div class="stat-card">
                        <div class="ic">🧾</div>
                        <div><div class="lbl">Penjualan Bulan Ini</div><div class="val">Rp <?php echo number_format($totalBulanIni['rp'], 0, ',', '.'); ?></div></div>
                    </div>
                    <div class="stat-card">
                        <div class="ic">⚖️</div>
                        <div><div class="lbl">Kg Terjual Bulan Ini</div><div class="val"><?php echo number_format($totalBulanIni['kg'], 1, ',', '.'); ?> kg</div></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head"><h2>Daftar Penjualan ke Pengepul</h2></div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pengepul</th>
                                    <th>Jenis Sampah</th>
                                    <th>Berat</th>
                                    <th>Harga/Kg</th>
                                    <th>Total Rp</th>
                                    <th class="aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($koneksi, "
                                    SELECT p.*, u.nama AS nama_pengepul, s.jenis_sampah
                                    FROM penjualan p
                                    JOIN users u ON p.id_pengepul = u.id_user
                                    JOIN sampah s ON p.id_sampah = s.id_sampah
                                    ORDER BY p.tanggal DESC, p.id_penjualan DESC
                                ");
                                if (mysqli_num_rows($query) === 0) {
                                ?>
                                    <tr><td colspan="7">
                                        <div class="empty-state"><span class="emoji">🧾</span><p>Belum ada data penjualan</p></div>
                                    </td></tr>
                                <?php
                                }
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo date("d-m-Y", strtotime($data['tanggal'])); ?></td>
                                        <td>
                                            <div class="cell-user">
                                                <div class="avatar"><?php echo strtoupper(substr($data['nama_pengepul'], 0, 1)); ?></div>
                                                <span class="cell-name"><?php echo $data['nama_pengepul']; ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $data['jenis_sampah']; ?></td>
                                        <td><?php echo $data['berat_kg']; ?> kg</td>
                                        <td>Rp <?php echo number_format($data['harga_jual_kg'], 0, ',', '.'); ?></td>
                                        <td style="font-weight:700;">Rp <?php echo number_format($data['total_rp'], 0, ',', '.'); ?></td>
                                        <td class="aksi">
                                            <a href="hapus.php?id_penjualan=<?php echo $data['id_penjualan']; ?>" onclick="return confirm('Batalkan penjualan ini? Stok & saldo pengepul akan dikembalikan.')" class="btn btn-danger-ghost btn-sm">Batalkan</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
