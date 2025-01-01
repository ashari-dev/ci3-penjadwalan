-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 09:53 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jadwal2`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `kode` int(2) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `status_dosen` int(3) NOT NULL,
  `id_guru` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`kode`, `nip`, `nama`, `alamat`, `telp`, `password`, `status_dosen`, `id_guru`) VALUES
(324, '', 'Widyatmini,Dr', '', '', '', 1, NULL),
(325, '', 'Dyah Anggraini, Dr.', '', '', '', 1, NULL),
(326, '', 'Lulu Chaerani Munggaran, Dr', '', '', '', 1, NULL),
(327, '', 'Nuryuliani, Dr', '', '', '', 1, NULL),
(328, '', 'Fitrianingsih, Dr.', '', '', '', 1, NULL),
(329, '', 'Teguh Budiarto,Drs', '', '', '', 1, NULL),
(330, '', 'Rodiah, Dr.', '', '', '', 1, NULL),
(331, '', 'Widya Silfianti,Dr', '', '', '', 1, NULL),
(332, '', 'Mohammad Iqbal,Dr', '', '', '', 1, NULL),
(333, '', 'Tb. Maulana Kusuma, Dr', '', '', '', 1, NULL),
(334, '', 'Rina Sugiarti, Dr', '', '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hari`
--

CREATE TABLE `hari` (
  `kode` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `id_hari` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hari`
--

INSERT INTO `hari` (`kode`, `nama`, `id_hari`) VALUES
(1, 'Senin', 'H01'),
(2, 'Selasa', 'H02'),
(3, 'Rabu', 'H03'),
(4, 'Kamis', 'H04'),
(5, 'Jumat', 'H05');

-- --------------------------------------------------------

--
-- Table structure for table `jadwalpelajaran`
--

CREATE TABLE `jadwalpelajaran` (
  `kode` int(10) NOT NULL,
  `kode_pengampu` int(10) DEFAULT NULL,
  `kode_jam` int(10) DEFAULT NULL,
  `kode_hari` int(10) DEFAULT NULL,
  `kode_ruang` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='hasil proses';

--
-- Dumping data for table `jadwalpelajaran`
--

INSERT INTO `jadwalpelajaran` (`kode`, `kode_pengampu`, `kode_jam`, `kode_hari`, `kode_ruang`) VALUES
(3, 1361, 3, 4, 48),
(4, 1362, 4, 1, 49);

-- --------------------------------------------------------

--
-- Table structure for table `jam`
--

CREATE TABLE `jam` (
  `kode` int(10) NOT NULL,
  `range_jam` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam`
--

INSERT INTO `jam` (`kode`, `range_jam`) VALUES
(1, '07.30-08.20'),
(2, '08.20-09.10'),
(3, '09.10-10.00'),
(4, '10.10-11.00'),
(5, '11.00-11.50'),
(6, '11.50-12.40'),
(7, '12.40-13.30'),
(8, '13.30-14.20'),
(9, '14.20-15.10'),
(10, '15:10-16:00'),
(11, '16.00-16.50'),
(12, '16.50-17.40');

-- --------------------------------------------------------

--
-- Table structure for table `jam2`
--

CREATE TABLE `jam2` (
  `kode` int(10) NOT NULL,
  `range_jam` varchar(50) DEFAULT NULL,
  `sks` int(2) DEFAULT NULL,
  `sesi` int(2) DEFAULT NULL,
  `id_jam` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam2`
--

INSERT INTO `jam2` (`kode`, `range_jam`, `sks`, `sesi`, `id_jam`) VALUES
(1, '07.30-10.00', 3, 1, 'T11'),
(2, '10.10-12.40', 3, 2, 'T12'),
(3, '13.00-15.30', 3, 3, 'T13'),
(4, '15.30-18.00', 3, 4, 'T14'),
(5, '07.30-09.10', 2, 1, 'T05'),
(6, '10.10-11.50', 2, 2, 'T06'),
(7, '13.00-14.40', 2, 3, 'T07'),
(8, '15.30-17.10', 2, 4, 'T08'),
(9, '07.30-08.20', 1, 1, 'T01'),
(10, '10.10-11:00', 1, 2, 'T02'),
(11, '13.00-13.50', 1, 3, 'T03'),
(12, '15.30-16.20', 1, 4, 'T04'),
(13, '13.30-16.00', 3, 5, 'T15'),
(14, '13.30-15.10', 2, 5, 'T09'),
(15, '16.00-17.40', 2, 6, 'T10'),
(16, '07.30-09.10', 4, 1, 'T16'),
(17, '10.10-11.50', 4, 2, 'T17'),
(18, '13.00-14.40', 4, 3, 'T18'),
(19, '15.30-17.10', 4, 4, 'T19'),
(20, '13.30-15.10', 4, 5, 'T20'),
(21, '16.00-17.40', 4, 6, 'T21'),
(23, '08.20-10.00', 3, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `kode` int(11) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`kode`, `nama_jurusan`) VALUES
(9, 'SISTEM INFORMASI');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `kode` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `kode_jurusan` int(3) NOT NULL,
  `id_kelas` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`kode`, `nama_kelas`, `kode_jurusan`, `id_kelas`) VALUES
(9, 'REGULAR', 0, NULL),
(10, 'NON REGULA', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `matapelajaran`
--

CREATE TABLE `matapelajaran` (
  `kode` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jumlah_jam` int(6) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `aktif` enum('True','False') DEFAULT 'True',
  `jenis` enum('TEORI','PRAKTIKUM') DEFAULT 'TEORI',
  `nama_kode` varchar(10) DEFAULT NULL,
  `kode_prodi` int(5) DEFAULT NULL,
  `id_mapel` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='example kode_mk = 0765109 ';

--
-- Dumping data for table `matapelajaran`
--

INSERT INTO `matapelajaran` (`kode`, `nama`, `jumlah_jam`, `semester`, `aktif`, `jenis`, `nama_kode`, `kode_prodi`, `id_mapel`) VALUES
(399, 'Manajemen Strategik dan Sistem Pakar', 3, 1, 'True', 'TEORI', 'MSSP', 9, NULL),
(400, 'Pengembangan Sistem', 3, 1, 'True', 'TEORI', 'PS', 9, NULL),
(401, 'Perencanaan dan Pengendalian Manajemen', 3, 1, 'True', 'TEORI', 'PPM', 9, NULL),
(402, 'Sistem Informasi Akuntansi', 3, 1, 'True', 'TEORI', 'SIA', 9, NULL),
(403, 'Sistem Jaringan Bisnis Internasional', 3, 1, 'True', 'TEORI', 'SJBI', 9, NULL),
(404, 'Testing dan Implementasi Sistem', 3, 1, 'True', 'TEORI', 'TIS', 11, NULL),
(405, 'Sistem Manajemen Biaya / Aktivitas', 3, 1, 'True', 'PRAKTIKUM', 'SMB', 9, NULL),
(406, 'Testing dan Implementasi Sistem', 3, 1, 'True', 'TEORI', 'TIS', 10, NULL),
(407, 'Sistem Perangkat Keras', 3, 1, 'True', 'TEORI', 'SPK', 10, NULL),
(408, 'Pengelolaan Proyek Sistem Informasi', 3, 1, 'True', 'TEORI', 'PPSI', 10, NULL),
(409, 'Pengembangan Sistem', 3, 1, 'True', 'TEORI', 'PS', 10, NULL),
(410, 'Sistem Jaringan Bisnis Internasional', 3, 1, 'True', 'TEORI', 'SJBI', 10, NULL),
(411, 'Manajemen Strategik dan Sistem Pakar', 3, 1, 'True', 'TEORI', 'MSSP', 10, NULL),
(412, 'Teknologi Informasi Lanjut', 3, 1, 'True', 'TEORI', 'TIL', 9, NULL),
(413, 'Sistem Jaringan Bisnis Internasional', 3, 1, 'True', 'TEORI', 'SJBI', 11, NULL),
(414, 'Pengembangan Sistem', 3, 1, 'True', 'TEORI', 'PS', 11, NULL),
(415, 'Keamanan Sistem dan Kriptografi', 3, 1, 'True', 'TEORI', 'KSK', 11, NULL),
(416, 'Perangkat Lunak Aplikasi Web', 3, 1, 'True', 'TEORI', 'PLAW', 11, NULL),
(417, 'Manajemen Strategik dan Sistem Pakar', 3, 1, 'True', 'TEORI', 'MSSP', 11, NULL),
(418, 'Perancangan Perangkat Lunak Lanjut', 3, 1, 'True', 'TEORI', 'PPLL', 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengampu`
--

CREATE TABLE `pengampu` (
  `kode` int(10) NOT NULL,
  `kode_mk` int(10) DEFAULT NULL,
  `kode_guru` int(10) DEFAULT NULL,
  `kelas` int(10) DEFAULT NULL,
  `tahun_akademik` int(10) DEFAULT NULL,
  `kode_prodi` int(11) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `kuota` int(5) DEFAULT NULL,
  `kode_ruang` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengampu`
--

INSERT INTO `pengampu` (`kode`, `kode_mk`, `kode_guru`, `kelas`, `tahun_akademik`, `kode_prodi`, `semester`, `kuota`, `kode_ruang`) VALUES
(1361, 399, 325, 9, 10, 9, 1, 0, 48),
(1362, 408, 324, 9, 10, 10, 1, 100, 49);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `kode` int(11) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `kode_jurusan` int(5) NOT NULL,
  `id_prodi` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`kode`, `nama_prodi`, `kode_jurusan`, `id_prodi`) VALUES
(9, 'SISTEM INFORMASI AKUNTANSI', 9, ''),
(10, 'SISTEM INFORMASI BISNIS', 9, ''),
(11, 'PERANGKAT LUNAK SISTEM INFORMASI', 9, '');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_penjadwalan`
--

CREATE TABLE `riwayat_penjadwalan` (
  `kode` int(11) NOT NULL,
  `kode_pengampu` int(10) NOT NULL,
  `kode_hari` int(5) NOT NULL,
  `kode_jam` int(5) NOT NULL,
  `kode_ruang` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `kode` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kapasitas` int(10) DEFAULT NULL,
  `jenis` enum('TEORI','LABORATORIUM') DEFAULT NULL,
  `kode_jurusan` int(5) NOT NULL,
  `lantai` int(3) NOT NULL,
  `id_ruang` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`kode`, `nama`, `kapasitas`, `jenis`, `kode_jurusan`, `lantai`, `id_ruang`) VALUES
(48, 'A1', 50, 'TEORI', 9, 1, 'R0'),
(49, 'A2', 50, 'TEORI', 9, 1, 'R1'),
(50, 'A3', 50, 'LABORATORIUM', 9, 1, 'R2'),
(51, 'A4', 50, 'TEORI', 9, 1, 'R3'),
(52, 'A5', 50, 'TEORI', 9, 1, 'R4');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `kode` int(2) NOT NULL,
  `nama_semester` varchar(10) NOT NULL,
  `semester_tipe` int(10) NOT NULL,
  `id_semester` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`kode`, `nama_semester`, `semester_tipe`, `id_semester`) VALUES
(1, 'I', 1, 'S01'),
(2, 'II', 2, 'S02'),
(3, 'III', 1, 'S03'),
(4, 'IV', 2, 'S04'),
(5, 'V', 1, 'S05'),
(6, 'VI', 2, 'S06'),
(7, 'VII', 1, 'S07'),
(11, 'VIII', 2, 'S08');

-- --------------------------------------------------------

--
-- Table structure for table `semester_tipe`
--

CREATE TABLE `semester_tipe` (
  `kode` int(2) NOT NULL,
  `tipe_semester` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester_tipe`
--

INSERT INTO `semester_tipe` (`kode`, `tipe_semester`) VALUES
(1, 'GANJIL'),
(2, 'GENAP');

-- --------------------------------------------------------

--
-- Table structure for table `status_dosen`
--

CREATE TABLE `status_dosen` (
  `kode` int(5) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_dosen`
--

INSERT INTO `status_dosen` (`kode`, `status`) VALUES
(1, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `kode` int(10) NOT NULL,
  `tahun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`kode`, `tahun`) VALUES
(10, '2023/2024');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `kode` int(2) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kode`, `email`, `password`, `nama`) VALUES
(1, 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
(4, 'ashari@gmail.com', 'ef32f46642c4beedf76c514d4f668c88', 'Ashari');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_tidak_bersedia`
--

CREATE TABLE `waktu_tidak_bersedia` (
  `kode` int(10) NOT NULL,
  `kode_guru` int(10) DEFAULT NULL,
  `kode_hari` int(10) DEFAULT NULL,
  `kode_jam` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `guru_ibfk_1` (`status_dosen`);

--
-- Indexes for table `hari`
--
ALTER TABLE `hari`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `jadwalpelajaran`
--
ALTER TABLE `jadwalpelajaran`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `jadwalpelajaran_ibfk_1` (`kode_pengampu`),
  ADD KEY `kode_jam` (`kode_jam`),
  ADD KEY `kode_hari` (`kode_hari`),
  ADD KEY `kode_ruang` (`kode_ruang`);

--
-- Indexes for table `jam`
--
ALTER TABLE `jam`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `jam2`
--
ALTER TABLE `jam2`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `matapelajaran`
--
ALTER TABLE `matapelajaran`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `matapelajaran_ibfk_1` (`semester`),
  ADD KEY `matapelajaran_ibfk_2` (`kode_prodi`);

--
-- Indexes for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `kode_mk` (`kode_mk`),
  ADD KEY `kode_guru` (`kode_guru`),
  ADD KEY `kelas` (`kelas`),
  ADD KEY `tahun_akademik` (`tahun_akademik`),
  ADD KEY `kode_prodi` (`kode_prodi`),
  ADD KEY `semester` (`semester`),
  ADD KEY `kode_ruang` (`kode_ruang`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `prodi_ibfk_1` (`kode_jurusan`);

--
-- Indexes for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `riwayat_penjadwalan_ibfk_4` (`kode_pengampu`),
  ADD KEY `riwayat_penjadwalan_ibfk_3` (`kode_hari`),
  ADD KEY `riwayat_penjadwalan_ibfk_2` (`kode_jam`),
  ADD KEY `riwayat_penjadwalan_ibfk_1` (`kode_ruang`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `ruang_ibfk_1` (`kode_jurusan`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `semester_ibfk_1` (`semester_tipe`);

--
-- Indexes for table `semester_tipe`
--
ALTER TABLE `semester_tipe`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `status_dosen`
--
ALTER TABLE `status_dosen`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `waktu_tidak_bersedia_ibfk_2` (`kode_guru`),
  ADD KEY `waktu_tidak_bersedia_ibfk_1` (`kode_hari`),
  ADD KEY `waktu_tidak_bersedia_ibfk_3` (`kode_jam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `kode` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `hari`
--
ALTER TABLE `hari`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwalpelajaran`
--
ALTER TABLE `jadwalpelajaran`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jam`
--
ALTER TABLE `jam`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jam2`
--
ALTER TABLE `jam2`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `matapelajaran`
--
ALTER TABLE `matapelajaran`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1363;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=529;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `kode` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `semester_tipe`
--
ALTER TABLE `semester_tipe`
  MODIFY `kode` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_dosen`
--
ALTER TABLE `status_dosen`
  MODIFY `kode` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `kode` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  MODIFY `kode` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`status_dosen`) REFERENCES `status_dosen` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwalpelajaran`
--
ALTER TABLE `jadwalpelajaran`
  ADD CONSTRAINT `jadwalpelajaran_ibfk_1` FOREIGN KEY (`kode_pengampu`) REFERENCES `pengampu` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwalpelajaran_ibfk_2` FOREIGN KEY (`kode_jam`) REFERENCES `jam2` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwalpelajaran_ibfk_3` FOREIGN KEY (`kode_hari`) REFERENCES `hari` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwalpelajaran_ibfk_4` FOREIGN KEY (`kode_ruang`) REFERENCES `ruang` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matapelajaran`
--
ALTER TABLE `matapelajaran`
  ADD CONSTRAINT `matapelajaran_ibfk_1` FOREIGN KEY (`semester`) REFERENCES `semester_tipe` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matapelajaran_ibfk_2` FOREIGN KEY (`kode_prodi`) REFERENCES `prodi` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD CONSTRAINT `pengampu_ibfk_1` FOREIGN KEY (`kode_mk`) REFERENCES `matapelajaran` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_2` FOREIGN KEY (`kode_guru`) REFERENCES `guru` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_3` FOREIGN KEY (`kelas`) REFERENCES `kelas` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_4` FOREIGN KEY (`tahun_akademik`) REFERENCES `tahun_akademik` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_5` FOREIGN KEY (`kode_prodi`) REFERENCES `prodi` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_6` FOREIGN KEY (`semester`) REFERENCES `semester` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_7` FOREIGN KEY (`kode_ruang`) REFERENCES `ruang` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_ibfk_1` FOREIGN KEY (`kode_jurusan`) REFERENCES `jurusan` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_penjadwalan`
--
ALTER TABLE `riwayat_penjadwalan`
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_1` FOREIGN KEY (`kode_ruang`) REFERENCES `ruang` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_2` FOREIGN KEY (`kode_jam`) REFERENCES `jam2` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_3` FOREIGN KEY (`kode_hari`) REFERENCES `hari` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riwayat_penjadwalan_ibfk_4` FOREIGN KEY (`kode_pengampu`) REFERENCES `pengampu` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ruang`
--
ALTER TABLE `ruang`
  ADD CONSTRAINT `ruang_ibfk_1` FOREIGN KEY (`kode_jurusan`) REFERENCES `jurusan` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`semester_tipe`) REFERENCES `semester_tipe` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waktu_tidak_bersedia`
--
ALTER TABLE `waktu_tidak_bersedia`
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_1` FOREIGN KEY (`kode_hari`) REFERENCES `hari` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_2` FOREIGN KEY (`kode_guru`) REFERENCES `guru` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waktu_tidak_bersedia_ibfk_3` FOREIGN KEY (`kode_jam`) REFERENCES `jam2` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
