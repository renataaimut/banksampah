-- Jalankan file ini di phpMyAdmin kalau database kamu SUDAH ada (tanpa import ulang).
CREATE TABLE IF NOT EXISTS `setor_sampah` (
  `id_setor` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_sampah` int(11) NOT NULL,
  `berat_kg` decimal(10,2) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id_setor`),
  KEY `id_user` (`id_user`),
  KEY `id_sampah` (`id_sampah`),
  CONSTRAINT `setor_sampah_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `setor_sampah_ibfk_2` FOREIGN KEY (`id_sampah`) REFERENCES `sampah` (`id_sampah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
