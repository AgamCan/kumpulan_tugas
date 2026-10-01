CREATE DATABASE IF NOT EXISTS banksampah_agam CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE banksampah_agam;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS pengepul;
DROP TABLE IF EXISTS sampah;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','nasabah','pengepul') NOT NULL DEFAULT 'nasabah',
    kategori_nasabah ENUM('siswa','guru','none') NOT NULL DEFAULT 'none',
    saldo DECIMAL(12,2) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE sampah (
    id_sampah INT AUTO_INCREMENT PRIMARY KEY,
    jenis_sampah VARCHAR(100) NOT NULL,
    harga_per_kg DECIMAL(12,2) NOT NULL DEFAULT 0,
    stok_kg DECIMAL(10,2) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE pengepul (
    id_pengepul INT AUTO_INCREMENT PRIMARY KEY,
    nama_pengepul VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    saldo_topup DECIMAL(12,2) NOT NULL DEFAULT 0,
    alamat TEXT,
    no_hp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_sampah INT NOT NULL,
    id_pengepul INT NULL,
    tipe ENUM('setor','jual','tarik') NOT NULL DEFAULT 'setor',
    berat_kg DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_rp DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('menunggu','disetujui','ditolak') NOT NULL DEFAULT 'menunggu',
    tanggal DATE NOT NULL,
    CONSTRAINT fk_transaksi_user FOREIGN KEY (id_user) REFERENCES user(id_user) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_transaksi_sampah FOREIGN KEY (id_sampah) REFERENCES sampah(id_sampah) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_transaksi_pengepul FOREIGN KEY (id_pengepul) REFERENCES pengepul(id_pengepul) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Hash BCRYPT valid ($2y$10$) untuk password default
INSERT INTO user (nama, username, password, role, kategori_nasabah, saldo) VALUES
('Administrator', 'admin',    '$2y$10$koVR4qqxtsrYxIm.fiLuW.GlE6CeaqnF4Cs8wwfUHX322FXNILvEe', 'admin',    'none',  0),
('Siswa Contoh',  'siswa',    '$2y$10$qU3ov7qKLq/7twMxFQrctecL/5YTQhz3ON2.kYQDn6qoF.bTpY5oO', 'nasabah',  'siswa', 0),
('Guru Contoh',   'guru',     '$2y$10$tDkWKu3xvRaNJrSXUCTdBO5han7BHROjc8AxyiwKpevHRuk5uzofy', 'nasabah',  'guru',  0),
('Pengepul Contoh','pengepul','$2y$10$1kHaj4fpCahkv6Z..Jh9ne0jVy1hCpqqYtZTin4UwwuNMtYs5kC9O', 'pengepul', 'none',  0);

INSERT INTO pengepul (nama_pengepul, username, password, saldo_topup, alamat, no_hp) VALUES
('Pengepul Contoh', 'pengepul', '$2y$10$1kHaj4fpCahkv6Z..Jh9ne0jVy1hCpqqYtZTin4UwwuNMtYs5kC9O', 0, 'Takeran, Magetan', '081234567890');

INSERT INTO sampah (jenis_sampah, harga_per_kg, stok_kg) VALUES
('Plastik PET (botol)', 3000, 0), ('Kardus', 1500, 0), ('Kertas HVS', 2000, 0), ('Kaleng/Logam', 5000, 0);
