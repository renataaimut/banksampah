<?php
include "koneksi.php";
session_start();

if ($_SESSION['status'] <> "sukses" || $_SESSION['role'] <> "admin") {
    header('location:../logout.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Setor</title>
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
                <a href="../pengajuan_setor" class="active"><span class="ic">📬</span> Pengajuan Setor</a>
                <a href="../tarik_saldo"><span class="ic">💰</span> Tarik Saldo</a>
                <a href="../penjualan"><span class="ic">🧾</span> Penjualan</a>
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
                        <h1>Pengajuan Setor Sampah</h1>
                        <div class="sub">Verifikasi setoran sampah dari siswa &amp; guru</div>
                    </div>
                </div>
            </div>

            <div class="page">
                <div class="card">
                    <div class="card-head"><h2>Daftar Pengajuan Setor</h2></div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nasabah</th>
                                    <th>Role</th>
                                    <th>Jenis Sampah</th>
                                    <th>Berat</th>
                                    <th>Estimasi</th>
                                    <th>Status</th>
                                    <th class="aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($koneksi, "
                                    SELECT t.*, u.nama AS nama_nasabah, u.role AS role_nasabah, s.jenis_sampah, s.harga_per_kg
                                    FROM setor_sampah t
                                    JOIN users u ON t.id_user = u.id_user
                                    JOIN sampah s ON t.id_sampah = s.id_sampah
                                    ORDER BY FIELD(t.status,'pending','disetujui','ditolak'), t.id_setor DESC
                                ");
                                if (mysqli_num_rows($query) === 0) {
                                ?>
                                    <tr><td colspan="8">
                                        <div class="empty-state"><span class="emoji">💰</span><p>Belum ada pengajuan setor sampah</p></div>
                                    </td></tr>
                                <?php
                                }
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo date("d-m-Y", strtotime($data['tanggal'])); ?></td>
                                        <td>
                                            <div class="cell-user">
                                                <div class="avatar"><?php echo strtoupper(substr($data['nama_nasabah'], 0, 1)); ?></div>
                                                <span class="cell-name"><?php echo $data['nama_nasabah']; ?></span>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-neutral"><?php echo ucfirst($data['role_nasabah']); ?></span></td>
                                        <td><?php echo htmlspecialchars($data['jenis_sampah']); ?></td>
                                        <td><?php echo $data['berat_kg']; ?> kg</td>
                                        <td>Rp <?php echo number_format($data['berat_kg'] * $data['harga_per_kg'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                            $badgeClass = $data['status'] == 'pending' ? 'badge-warn' : ($data['status'] == 'disetujui' ? 'badge-pink' : 'badge-danger');
                                            ?>
                                            <span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst($data['status']); ?></span>
                                        </td>
                                        <td class="aksi">
                                            <?php if ($data['status'] == 'pending') { ?>
                                                <a href="proses.php?id_setor=<?php echo $data['id_setor']; ?>&aksi=disetujui" onclick="return confirm('Setujui? Saldo nasabah dan stok akan bertambah.')" class="btn btn-outline btn-sm">Setujui</a>
                                                <a href="proses.php?id_setor=<?php echo $data['id_setor']; ?>&aksi=ditolak" onclick="return confirm('Tolak pengajuan ini?')" class="btn btn-danger-ghost btn-sm">Tolak</a>
                                            <?php } else { ?>
                                                <span class="cell-sub">—</span>
                                            <?php } ?>
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
