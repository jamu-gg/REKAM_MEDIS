-- database.sql — OPSIONAL.
-- Gunakan hanya jika db_rekam_medis belum punya tabel. Jika sudah ada, tidak perlu diimpor.
CREATE DATABASE IF NOT EXISTS db_rekam_medis CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_rekam_medis;

CREATE TABLE IF NOT EXISTS pasien (
  id_pasien INT(11) NOT NULL AUTO_INCREMENT,
  no_rm VARCHAR(20) NOT NULL,
  nama_pasien VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  tanggal_lahir DATE NOT NULL,
  alamat TEXT NOT NULL,
  PRIMARY KEY (id_pasien),
  UNIQUE KEY uq_no_rm (no_rm)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS dokter (
  id_dokter INT(11) NOT NULL AUTO_INCREMENT,
  nama_dokter VARCHAR(100) NOT NULL,
  spesialisasi VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_dokter)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS obat (
  id_obat INT(11) NOT NULL AUTO_INCREMENT,
  nama_obat VARCHAR(100) NOT NULL,
  satuan VARCHAR(30) NOT NULL,
  stok INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_obat)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS rekam_medis (
  id_rekam INT(11) NOT NULL AUTO_INCREMENT,
  id_pasien INT(11) NOT NULL,
  id_dokter INT(11) NOT NULL,
  id_obat INT(11) NOT NULL,
  tanggal_periksa DATE NOT NULL,
  keluhan TEXT NOT NULL,
  diagnosa TEXT NOT NULL,
  tindakan TEXT NOT NULL,
  resep VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_rekam),
  CONSTRAINT fk_rm_pasien FOREIGN KEY (id_pasien) REFERENCES pasien (id_pasien) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_rm_dokter FOREIGN KEY (id_dokter) REFERENCES dokter (id_dokter) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_rm_obat   FOREIGN KEY (id_obat)   REFERENCES obat   (id_obat)   ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Data uji (FIKTIF)
INSERT INTO pasien (no_rm, nama_pasien, jenis_kelamin, tanggal_lahir, alamat) VALUES
('RM-0001','Budi Santoso','L','2001-03-14','Jl. Melati No. 12, Tuban'),
('RM-0002','Siti Aminah','P','1998-07-02','Jl. Kenanga No. 5, Tuban'),
('RM-0003','Rizky Pratama','L','2005-11-23','Jl. Mawar No. 8, Tuban');

INSERT INTO dokter (nama_dokter, spesialisasi) VALUES
('dr. Andi Wijaya','Umum'),
('dr. Maya Lestari','Anak');

INSERT INTO obat (nama_obat, satuan, stok) VALUES
('Paracetamol 500 mg','Tablet',120),
('Amoxicillin 500 mg','Kapsul',60),
('OBH Sirup','Sirup',25);

INSERT INTO rekam_medis (id_pasien, id_dokter, id_obat, tanggal_periksa, keluhan, diagnosa, tindakan, resep) VALUES
(1,1,1,'2026-11-02','Demam dan sakit kepala sejak 2 hari','Demam viral','Pemeriksaan suhu dan tekanan darah','3 x 1 tablet sesudah makan'),
(2,2,3,'2026-11-05','Batuk berdahak','Bronkitis ringan','Pemeriksaan auskultasi paru','3 x 1 sendok makan');
