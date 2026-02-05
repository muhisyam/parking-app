CREATE TABLE tb_area_parkir (
    id_area INT AUTO_INCREMENT PRIMARY KEY,
    nama_area VARCHAR(50) NOT NULL,
    kapasitas INT NOT NULL,
    terisi INT NOT NULL
);

CREATE TABLE tb_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas', 'owner') NOT NULL,
    status_aktif BOOLEAN NOT NULL
);

CREATE TABLE tb_kendaraan (
    id_kendaraan INT AUTO_INCREMENT PRIMARY KEY,
    plat_nomor VARCHAR(15) NOT NULL,
    jenis_kendaraan VARCHAR(20) NOT NULL,
    warna VARCHAR(20) NOT NULL,
    pemilik VARCHAR(100) NOT NULL,
    id_user INT NOT NULL,
    CONSTRAINT fk_kendaraan_user
        FOREIGN KEY (id_user)
        REFERENCES tb_user(id_user)
        ON UPDATE CASCADE
);

CREATE TABLE tb_log_aktivitas (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    aktivitas VARCHAR(100) NOT NULL,
    waktu_aktivitas DATETIME NOT NULL,
    CONSTRAINT fk_log_user
        FOREIGN KEY (id_user)
        REFERENCES tb_user(id_user)
        ON UPDATE CASCADE
);

CREATE TABLE tb_tarif (
    id_tarif INT AUTO_INCREMENT PRIMARY KEY,
    jenis_kendaraan ENUM('motor', 'mobil', 'lainnya') NOT NULL,
    tarif_per_jam DECIMAL(10,0) NOT NULL
);

CREATE TABLE tb_transaksi (
    id_parkir INT AUTO_INCREMENT PRIMARY KEY,
    id_kendaraan INT NOT NULL,
    waktu_masuk DATETIME NOT NULL,
    waktu_keluar DATETIME,
    id_tarif INT NOT NULL,
    durasi_jam INT,
    biaya_total DECIMAL(10,0),
    status ENUM('masuk', 'keluar') NOT NULL,
    id_user INT NOT NULL,
    id_area INT NOT NULL,

    CONSTRAINT fk_transaksi_kendaraan
        FOREIGN KEY (id_kendaraan)
        REFERENCES tb_kendaraan(id_kendaraan)
        ON UPDATE CASCADE,

    CONSTRAINT fk_transaksi_tarif
        FOREIGN KEY (id_tarif)
        REFERENCES tb_tarif(id_tarif)
        ON UPDATE CASCADE,

    CONSTRAINT fk_transaksi_user
        FOREIGN KEY (id_user)
        REFERENCES tb_user(id_user)
        ON UPDATE CASCADE,

    CONSTRAINT fk_transaksi_area
        FOREIGN KEY (id_area)
        REFERENCES tb_area_parkir(id_area)
        ON UPDATE CASCADE
);
