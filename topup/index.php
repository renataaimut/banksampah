<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] <> "admin") {
    header('location:../logout.php');
    exit;
}

// Pesan status
$pesan = null;
if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses') {
    $pesan = 'Top up saldo pengepul berhasil.';
} elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
    $pesan = 'Nominal top up tidak valid.';
}

// Daftar pengepul beserta saldo
$pengepul = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'pengepul' ORDER BY nama");

// Riwayat top up
$riwayat = mysqli_query($koneksi, "
    SELECT t.*, u.nama
    FROM topup_saldo t
    JOIN users u ON t.id_user = u.id_user
    ORDER BY t.tanggal DESC, t.id_topup DESC
    LIMIT 20
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Pengepul</title>
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
                <a href="../penjualan"><span class="ic">🧾</span> Penjualan</a>
                <a href="../topup" class="active"><span class="ic">🔋</span> Top Up Pengepul</a>
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
                        <h1>Top Up Pengepul</h1>
                        <div class="sub">Isi saldo pengepul supaya bisa membeli sampah</div>
                    </div>
                </div>
            </div>

            <div class="page">

                <?php if ($pesan) { ?>
                    <div class="card card-pad" style="margin-bottom:18px; background:var(--pink-gradient-soft); color:var(--pink-700); font-weight:600; font-size:13.5px;">
                        <?php echo htmlspecialchars($pesan); ?>
                    </div>
                <?php } ?>

                <div class="card" style="margin-bottom:20px;">
                    <div class="card-head"><h2>Saldo Pengepul</h2></div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Saldo Saat Ini</th>
                                    <th class="aksi">Top Up</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($pengepul) === 0) { ?>
                                    <tr><td colspan="4"><div class="empty-state"><span class="emoji">🔋</span><p>Belum ada akun pengepul</p></div></td></tr>
                                <?php } ?>
                                <?php while ($p = mysqli_fetch_array($pengepul)) { ?>
                                    <tr>
                                        <td>
                                            <div class="cell-user">
                                                <div class="avatar"><?php echo strtoupper(substr($p['nama'], 0, 1)); ?></div>
                                                <span class="cell-name"><?php echo $p['nama']; ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $p['username']; ?></td>
                                        <td style="font-weight:700;">Rp <?php echo number_format($p['saldo'], 0, ',', '.'); ?></td>
                                        <td class="aksi">
                                            <form action="proses.php" method="POST" style="display:flex; gap:6px; justify-content:flex-end; align-items:center;">
                                                <input type="hidden" name="id_user" value="<?php echo $p['id_user']; ?>">
                                                <input type="number" step="1000" min="1000" name="nominal" placeholder="Nominal" required style="width:120px; padding:8px 10px; border:1px solid var(--ink-100); border-radius:8px; font-size:13px;">
                                                <button type="submit" class="btn btn-primary btn-sm">Top Up</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head"><h2>Riwayat Top Up Terakhir</h2></div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pengepul</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($riwayat) === 0) { ?>
                                    <tr><td colspan="3"><div class="empty-state"><span class="emoji">📜</span><p>Belum ada riwayat top up</p></div></td></tr>
                                <?php } ?>
                                <?php while ($r = mysqli_fetch_array($riwayat)) { ?>
                                    <tr>
                                        <td><?php echo date("d-m-Y", strtotime($r['tanggal'])); ?></td>
                                        <td><?php echo $r['nama']; ?></td>
                                        <td style="font-weight:700;color:var(--pink-600);">Rp <?php echo number_format($r['nominal'], 0, ',', '.'); ?></td>
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
