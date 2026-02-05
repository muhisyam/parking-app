INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES
('Area A', 50, 10),
('Area B', 30, 5),
('Area C', 100, 25);

INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES
('motor', 2000),
('mobil', 5000),
('lainnya', 8000);

INSERT INTO tb_user (nama_lengkap, username, password, role, status_aktif) VALUES
('Admin Parkir', 'admin', 'admin123', 'admin', 1),
('Petugas Satu', 'petugas1', 'petugas123', 'petugas', 1),
('Owner Parkir', 'owner', 'owner123', 'owner', 1);

INSERT INTO tb_kendaraan (plat_nomor, jenis_kendaraan, warna, pemilik, id_user) VALUES
('B 1234 ABC', 'mobil', 'Hitam', 'Andi', 2),
('D 5678 DEF', 'motor', 'Merah', 'Budi', 2),
('L 9012 GHI', 'mobil', 'Putih', 'Citra', 3);
