/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 100119
Source Host           : localhost:3306
Source Database       : prosedur_online

Target Server Type    : MYSQL
Target Server Version : 100119
File Encoding         : 65001

Date: 2017-09-19 15:34:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for anggota
-- ----------------------------
DROP TABLE IF EXISTS `anggota`;
CREATE TABLE `anggota` (
  `no_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('admin','user','approval1','qa','msds') NOT NULL DEFAULT 'user',
  `no_department` int(11) NOT NULL,
  `nama_lengkap` varchar(200) NOT NULL,
  `tgl_lahir` date NOT NULL,
  PRIMARY KEY (`no_anggota`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of anggota
-- ----------------------------
INSERT INTO `anggota` VALUES ('10', 'admin', 'admin@admin.admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '68', 'Bima Putra S', '1998-10-22');
INSERT INTO `anggota` VALUES ('13', 'qa', 'qa@qa.qa', '21232f297a57a5a743894a0e4a801fc3', 'user', '1', 'Q A', '2017-01-01');
INSERT INTO `anggota` VALUES ('14', 'ap1', 'ap1@ap1.ap1', '21232f297a57a5a743894a0e4a801fc3', 'approval1', '1', 'A P 1', '2017-01-01');
INSERT INTO `anggota` VALUES ('15', 'user', 'user@user.user', '21232f297a57a5a743894a0e4a801fc3', 'user', '1', 'U S E R', '2017-01-01');
INSERT INTO `anggota` VALUES ('16', 'testap1', 'bmasajalha@yahoo.co.id', '21232f297a57a5a743894a0e4a801fc3', 'approval1', '57', 'BIMA PUTRA S', '2006-06-09');
INSERT INTO `anggota` VALUES ('17', 'testap1b', 'bimaputras@yahoo.co.id', '21232f297a57a5a743894a0e4a801fc3', 'approval1', '46', 'qwewqeqwe', '2010-06-09');
INSERT INTO `anggota` VALUES ('18', 'qaqaa', 'qa1@zz.zz', '21232f297a57a5a743894a0e4a801fc3', 'qa', '25', '11qwqw', '2005-07-14');
INSERT INTO `anggota` VALUES ('19', 'qaqab', 'bima@bim.bim', '21232f297a57a5a743894a0e4a801fc3', 'qa', '48', 'qa2@zz.zz', '2003-08-15');

-- ----------------------------
-- Table structure for ddd
-- ----------------------------
DROP TABLE IF EXISTS `ddd`;
CREATE TABLE `ddd` (
  `no_ddd` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_ddd` date NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` int(11) NOT NULL,
  `pengaju` varchar(200) NOT NULL,
  `email_pengaju` varchar(200) NOT NULL,
  `no_prosedur` int(11) NOT NULL,
  `jumlah_copy` int(11) NOT NULL,
  `lokasi_penyimpanan` varchar(200) NOT NULL,
  `jenis_penyimpanan` varchar(255) NOT NULL,
  `pic_penyimpanan` int(11) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `no_spd` varchar(200) NOT NULL,
  `no_copy_awal` int(11) NOT NULL,
  `no_copy_akhir` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `status` enum('process','closed','batal','waiting') NOT NULL DEFAULT 'process',
  `tgl_batal` date NOT NULL,
  `alasan_batal` text NOT NULL,
  `ddd_no_revisi` int(11) NOT NULL,
  PRIMARY KEY (`no_ddd`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ddd
-- ----------------------------
INSERT INTO `ddd` VALUES ('27', '2017-09-08', '2017', '9', 'Bima Putra S', 'admin@admin.admin', '38', '3', 'Contoh1', 'internal', '10', '0000-00-00', '0000-00-00', '0000-00-00', '', '0', '0', '', 'waiting', '0000-00-00', '', '1');
INSERT INTO `ddd` VALUES ('28', '2017-09-08', '2017', '9', 'Bima Putra S', 'admin@admin.admin', '38', '3', 'Contoh1', 'internal', '10', '0000-00-00', '0000-00-00', '0000-00-00', '', '0', '0', '', 'waiting', '0000-00-00', '', '2');
INSERT INTO `ddd` VALUES ('29', '2017-09-08', '2017', '9', 'Bima Putra S', 'admin@admin.admin', '39', '3', 'Fada', 'internal', '10', '0000-00-00', '0000-00-00', '0000-00-00', '', '0', '0', '', 'waiting', '0000-00-00', '', '1');

-- ----------------------------
-- Table structure for ddd_s2
-- ----------------------------
DROP TABLE IF EXISTS `ddd_s2`;
CREATE TABLE `ddd_s2` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `no_ddd` int(11) NOT NULL,
  `no_prosedur` int(11) NOT NULL,
  `nomor_copy` int(255) NOT NULL,
  `lokasi_penyimpanan` varchar(200) NOT NULL,
  `jenis_penyimpanan` varchar(255) NOT NULL,
  `pic_penyimpanan` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `ddds2status` enum('ok','done','validasi') NOT NULL DEFAULT 'validasi',
  `ddd2_no_revisi` int(11) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ddd_s2
-- ----------------------------
INSERT INTO `ddd_s2` VALUES ('132', '27', '38', '1', 'Contoh1', 'internal', '10', '', 'done', '1');
INSERT INTO `ddd_s2` VALUES ('133', '27', '38', '2', 'Contoh1', 'internal', '10', '', 'validasi', '1');
INSERT INTO `ddd_s2` VALUES ('134', '27', '38', '3', 'Contoh1', 'internal', '10', '', 'validasi', '1');
INSERT INTO `ddd_s2` VALUES ('135', '28', '38', '1', 'Contoh1', 'internal', '10', '', 'done', '2');
INSERT INTO `ddd_s2` VALUES ('136', '28', '38', '2', 'Contoh1', 'internal', '10', '', 'validasi', '2');
INSERT INTO `ddd_s2` VALUES ('137', '28', '38', '3', 'Contoh1', 'internal', '10', '', 'validasi', '2');
INSERT INTO `ddd_s2` VALUES ('138', '29', '39', '1', 'Fada', 'internal', '10', '', 'done', '1');
INSERT INTO `ddd_s2` VALUES ('139', '29', '39', '12', 'Fada', 'internal', '10', '', 'done', '1');
INSERT INTO `ddd_s2` VALUES ('140', '29', '39', '3', 'Fada', 'internal', '10', '', 'validasi', '1');

-- ----------------------------
-- Table structure for ddd_s3
-- ----------------------------
DROP TABLE IF EXISTS `ddd_s3`;
CREATE TABLE `ddd_s3` (
  `no_running` varchar(255) NOT NULL,
  `jenis_penyimpanan` varchar(255) NOT NULL,
  `lokasi_penyimpanan` varchar(255) NOT NULL,
  `nomor_copy` int(11) NOT NULL,
  `no_prosedur` int(11) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `s3_keterangan` text NOT NULL,
  `pic_penyimpanan` varchar(255) NOT NULL,
  `ds3_status` enum('closed','waiting') NOT NULL DEFAULT 'waiting',
  `file_ds3` text,
  `ddd3_no_revisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ddd_s3
-- ----------------------------
INSERT INTO `ddd_s3` VALUES ('001/DDD/2017', 'internal', 'Contoh1', '1', '38', '2017-09-08', '0000-00-00', '', '10', 'waiting', null, '1');
INSERT INTO `ddd_s3` VALUES ('001/DDD/2017', 'internal', 'Contoh1', '1', '38', '2017-09-08', '0000-00-00', '', '10', 'waiting', null, '2');
INSERT INTO `ddd_s3` VALUES ('002/DDD/2017', 'internal', 'Fada', '12', '39', '2017-09-08', '2017-09-08', 'asdds', '10', 'closed', 'file_upload/ddd/002/isinya6.txt', '1');

-- ----------------------------
-- Table structure for ddd_tmp
-- ----------------------------
DROP TABLE IF EXISTS `ddd_tmp`;
CREATE TABLE `ddd_tmp` (
  `no_running` varchar(255) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nomor_copy` int(11) NOT NULL,
  `lokasi_penyimpanan` varchar(200) NOT NULL,
  `jenis_penyimpanan` varchar(255) NOT NULL,
  `pic_penyimpanan` int(11) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`no_running`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ddd_tmp
-- ----------------------------
INSERT INTO `ddd_tmp` VALUES ('001/DDD/2017', '2017', '1', 'Contoh1', 'internal', '10', '2017-09-08', '0000-00-00', '');
INSERT INTO `ddd_tmp` VALUES ('002/DDD/2017', '2017', '12', 'Fada', 'internal', '10', '2017-09-08', '2017-09-08', '');

-- ----------------------------
-- Table structure for dde
-- ----------------------------
DROP TABLE IF EXISTS `dde`;
CREATE TABLE `dde` (
  `no_dde` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_dde` date NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` int(11) NOT NULL,
  `no_department` int(11) NOT NULL,
  `nama_dokumen` text NOT NULL,
  `sumber_edisi_tahun` varchar(200) NOT NULL,
  `pengaju` varchar(200) NOT NULL,
  `email_pengaju` varchar(200) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `no_copy` int(11) NOT NULL,
  `bentuk_penyimpanan` enum('','softcopy','hardcopy') NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kode` varchar(200) NOT NULL,
  `nama_file` text NOT NULL,
  `status` enum('process','closed','batal') DEFAULT 'process',
  `tgl_batal` date NOT NULL,
  `alasan_batal` text NOT NULL,
  PRIMARY KEY (`no_dde`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dde
-- ----------------------------

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(200) NOT NULL,
  `kode_department` char(3) NOT NULL,
  `department` varchar(200) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('1', 'Ciawi', 'ADM', 'Admin');
INSERT INTO `department` VALUES ('2', 'Cibitung', 'AGB', 'Government Relation dan Community Development');
INSERT INTO `department` VALUES ('3', 'Ciawi', 'AGC', 'Government Relation dan Community Development');
INSERT INTO `department` VALUES ('4', 'Ciawi', 'DTA', 'Transporter and Provider Department');
INSERT INTO `department` VALUES ('5', 'Sentul', 'FCC', 'Quality Control Department');
INSERT INTO `department` VALUES ('6', 'Sentul', 'FEC', 'Engineering Department');
INSERT INTO `department` VALUES ('7', 'Sentul', 'FLC', 'Warehouse RTD');
INSERT INTO `department` VALUES ('8', 'Sentul', 'FRC', 'RTD Production Department');
INSERT INTO `department` VALUES ('9', 'Sentul', 'FSC', 'Pest Control dan Sanitation');
INSERT INTO `department` VALUES ('10', 'Sentul', 'FZZ', 'Plant Division');
INSERT INTO `department` VALUES ('11', 'Ciawi', 'ISA', 'Business Application Management Department');
INSERT INTO `department` VALUES ('12', 'Ciawi', 'ITA', 'IT Assistance Department');
INSERT INTO `department` VALUES ('13', 'Ciawi', 'OAP', 'Payroll and Clinic Department');
INSERT INTO `department` VALUES ('14', 'Ciawi', 'PCA', 'Quality Control Department');
INSERT INTO `department` VALUES ('15', 'Cibitung', 'PCB', 'Quality Control Department');
INSERT INTO `department` VALUES ('16', 'Ciawi', 'PEA', 'Engineering Department');
INSERT INTO `department` VALUES ('17', 'Ciawi', 'PEB', 'Engineering Department');
INSERT INTO `department` VALUES ('18', 'Ciawi', 'PEC', 'Engineering Department');
INSERT INTO `department` VALUES ('19', 'Cibitung', 'PED', 'Engineering Department');
INSERT INTO `department` VALUES ('20', 'Cibitung', 'PEE', 'Engineering Department');
INSERT INTO `department` VALUES ('21', 'Ciawi', 'PIA', 'Infrastructure Department');
INSERT INTO `department` VALUES ('22', 'Cibitung', 'PIB', 'Infrastructure Department');
INSERT INTO `department` VALUES ('23', 'Ciawi', 'PLA', 'Logistic Department');
INSERT INTO `department` VALUES ('24', 'Cibitung', 'PLB', 'Logistic Department');
INSERT INTO `department` VALUES ('25', 'Ciawi', 'PLF', 'Finished Good Logistic');
INSERT INTO `department` VALUES ('26', 'Cibitung', 'PLG', 'Finished Good Logistic');
INSERT INTO `department` VALUES ('27', 'Ciawi', 'PPA', 'PPIC Department');
INSERT INTO `department` VALUES ('28', 'Ciawi', 'PRB', 'Plant B Production Department');
INSERT INTO `department` VALUES ('29', 'Ciawi', 'PRC', 'RTD Production Department');
INSERT INTO `department` VALUES ('30', 'Cibitung', 'PRD', 'Plant Cibitung');
INSERT INTO `department` VALUES ('31', 'Cibitung', 'PRE', 'Plant Cibitung');
INSERT INTO `department` VALUES ('32', 'Ciawi', 'PRO', 'Outsourcing Production Departement');
INSERT INTO `department` VALUES ('33', 'Ciawi', 'PSA', 'Health Safety and Environment Department');
INSERT INTO `department` VALUES ('34', 'Ciawi', 'PZZ', 'Plant Division');
INSERT INTO `department` VALUES ('35', 'Cibitung', 'RDL', 'RD Service and Laboratory Department');
INSERT INTO `department` VALUES ('36', 'Ciawi', 'REA', 'RD Process Engineering Department');
INSERT INTO `department` VALUES ('37', 'Ciawi', 'RKA', 'RD Packaging Department');
INSERT INTO `department` VALUES ('39', 'Ciawi', 'RPE', 'RD Export');
INSERT INTO `department` VALUES ('40', 'Ciawi', 'RPN', 'RD Product Non-Powder Department');
INSERT INTO `department` VALUES ('41', 'Ciawi', 'RPP', 'RD Product Powder Department');
INSERT INTO `department` VALUES ('42', 'Ciawi', 'RSL', 'RD Service and Laboratory Department');
INSERT INTO `department` VALUES ('43', 'Cibitung', 'SQA', 'Quality Assurance Department');
INSERT INTO `department` VALUES ('45', 'Ciawi', 'SSA', 'Safety, Health, and Environment Department');
INSERT INTO `department` VALUES ('46', 'Ciawi', 'VFF', 'Finance  Departement');
INSERT INTO `department` VALUES ('47', 'Ciawi', 'YAA', 'General Affairs Department');
INSERT INTO `department` VALUES ('48', 'Cibitung', 'YAB', 'General Affairs Department');
INSERT INTO `department` VALUES ('49', 'Cibitung', 'YAC', 'General Affairs Department');
INSERT INTO `department` VALUES ('50', 'Ciawi', 'YDT', 'Training and Development Department');
INSERT INTO `department` VALUES ('51', 'Cibitung', 'YPB', 'Personnel Administration and Office Management');
INSERT INTO `department` VALUES ('52', 'Ciawi', 'YPC', 'Personnel Administration and Office Management');
INSERT INTO `department` VALUES ('53', 'Sentul', 'AGC', 'Government Relation dan Community Development');
INSERT INTO `department` VALUES ('54', 'Sentul', 'OAP', 'Payroll and Clinic Department');
INSERT INTO `department` VALUES ('55', 'Sentul', 'RSL', 'RD Service and Laboratory Department');
INSERT INTO `department` VALUES ('56', 'Sentul', 'SSA', 'Safety, Health, and Environment Department');
INSERT INTO `department` VALUES ('57', 'Sentul', 'YAA', 'General Affairs Department');
INSERT INTO `department` VALUES ('58', 'Sentul', 'YPC', 'Personnel Administration and Office Management');
INSERT INTO `department` VALUES ('59', 'Cibitung', 'DTA', 'Transporter and Provider Department');
INSERT INTO `department` VALUES ('60', 'Cibitung', 'ITA', 'IT Assistance Department');
INSERT INTO `department` VALUES ('61', 'Cibitung', 'OAP', 'Payroll and Clinic Department');
INSERT INTO `department` VALUES ('62', 'Cibitung', 'REA', 'RD Process Engineering Department');
INSERT INTO `department` VALUES ('63', 'Cibitung', 'RPP', 'RD Product Powder Department');
INSERT INTO `department` VALUES ('64', 'Cibitung', 'SSA', 'Safety, Health, and Environment Department');
INSERT INTO `department` VALUES ('65', 'Cibitung', 'VFF', 'Finance  Departement');
INSERT INTO `department` VALUES ('66', 'Cibitung', 'YDT', 'Training and Development Department');
INSERT INTO `department` VALUES ('67', 'Ciawi', 'SQA', 'Quality Assurance Department');
INSERT INTO `department` VALUES ('68', 'Sentul', 'SQB', 'Quality Assurance Department');
INSERT INTO `department` VALUES ('69', 'Ciawi', 'KMT', 'Kontraktor Maintenance');
INSERT INTO `department` VALUES ('70', 'Cibitung', 'KMT', 'Kontraktor Maintenance');
INSERT INTO `department` VALUES ('71', 'Sentul', 'KMT', 'Kontraktor Maintenance');

-- ----------------------------
-- Table structure for divisi_prosedur
-- ----------------------------
DROP TABLE IF EXISTS `divisi_prosedur`;
CREATE TABLE `divisi_prosedur` (
  `no_divisi_prosedur` int(11) NOT NULL AUTO_INCREMENT,
  `divisi_prosedur` varchar(200) NOT NULL,
  `nf_prosedur` varchar(255) NOT NULL,
  PRIMARY KEY (`no_divisi_prosedur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of divisi_prosedur
-- ----------------------------
INSERT INTO `divisi_prosedur` VALUES ('1', 'Plant Division (P)', 'P');
INSERT INTO `divisi_prosedur` VALUES ('2', 'Research dan Development Division (R)', 'R');

-- ----------------------------
-- Table structure for filemaster_ddd
-- ----------------------------
DROP TABLE IF EXISTS `filemaster_ddd`;
CREATE TABLE `filemaster_ddd` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `no_prosedur` int(11) NOT NULL,
  `nomor_copy` int(255) NOT NULL,
  `lokasi_penyimpanan` varchar(200) NOT NULL,
  `jenis_penyimpanan` varchar(255) NOT NULL,
  `pic_penyimpanan` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `fmd_norev` int(11) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of filemaster_ddd
-- ----------------------------
INSERT INTO `filemaster_ddd` VALUES ('2', '38', '1', '3', 'internal', '28', '', '2');
INSERT INTO `filemaster_ddd` VALUES ('3', '38', '2', '3', 'internal', '28', '', '2');
INSERT INTO `filemaster_ddd` VALUES ('4', '38', '3', '3', 'internal', '28', '', '2');

-- ----------------------------
-- Table structure for file_prosedur_master
-- ----------------------------
DROP TABLE IF EXISTS `file_prosedur_master`;
CREATE TABLE `file_prosedur_master` (
  `no_file_prosedur` int(11) NOT NULL AUTO_INCREMENT,
  `no_divisi_prosedur` int(11) NOT NULL,
  `no_master_prosedur` int(11) NOT NULL,
  `no_jenis_prosedur` int(11) NOT NULL,
  `detail_prosedur` varchar(200) NOT NULL,
  `nama_folder` text NOT NULL,
  `no_revisi` int(11) NOT NULL,
  `tgl_revisi` date NOT NULL,
  `nama_file` text NOT NULL,
  PRIMARY KEY (`no_file_prosedur`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of file_prosedur_master
-- ----------------------------
INSERT INTO `file_prosedur_master` VALUES ('43', '1', '1', '2', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '1', '2017-09-08', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/1_isinya6.txt');
INSERT INTO `file_prosedur_master` VALUES ('44', '1', '1', '2', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '2', '2017-09-08', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/2_isinya5.txt');
INSERT INTO `file_prosedur_master` VALUES ('45', '1', '13', '4', 'Percobaan_Nomor_1', 'Percobaan_Nomor_1', '1', '2017-09-08', 'file_upload/master_prosedur/P/P.06C/form_dan_catatan_mutu/Percobaan_Nomor_1/1_isinya1.txt');
INSERT INTO `file_prosedur_master` VALUES ('46', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '1', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/1_isinya6.txt');
INSERT INTO `file_prosedur_master` VALUES ('47', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '2', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/2_isinya5.txt');
INSERT INTO `file_prosedur_master` VALUES ('48', '1', '1', '2', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', '1', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01B2-Perencanaan-TESTING IK BARU/1_isinya5.txt');
INSERT INTO `file_prosedur_master` VALUES ('49', '1', '14', '2', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '1', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/1_isinya5.txt');
INSERT INTO `file_prosedur_master` VALUES ('50', '1', '14', '2', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/2_isinya5.txt');
INSERT INTO `file_prosedur_master` VALUES ('51', '1', '14', '2', 'Asw', 'IK P.06D03G4-Persiapan-Potansta', '3', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/3_isinya7.txt');
INSERT INTO `file_prosedur_master` VALUES ('52', '2', '84', '2', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', '1', '2017-09-13', 'file_upload/master_prosedur/R/P.01D/intruksi_kerja/IK R.0101A2-Searching-Paku yang Hilang/1_isinya6.txt');
INSERT INTO `file_prosedur_master` VALUES ('53', '1', '81', '2', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', '1', '2017-09-18', 'file_upload/master_prosedur/P/P.01B/intruksi_kerja/IK P.01B01M019-Validasi-Potansta/1_xat.jpg');
INSERT INTO `file_prosedur_master` VALUES ('54', '1', '1', '2', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', '1', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.06D02C001-Maintenance-IK Coba Baru/1_isinya1.txt');
INSERT INTO `file_prosedur_master` VALUES ('55', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '3', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/3_isinya2.txt');
INSERT INTO `file_prosedur_master` VALUES ('56', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', '1', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1/1_isinya5.txt');
INSERT INTO `file_prosedur_master` VALUES ('57', '1', '10', '1', 'ASw', 'ASwASw', '1', '2017-09-19', 'file_upload/master_prosedur/P/P.05E/prosedur/ASwASw/1_isinya3.txt');

-- ----------------------------
-- Table structure for golongan_kasus
-- ----------------------------
DROP TABLE IF EXISTS `golongan_kasus`;
CREATE TABLE `golongan_kasus` (
  `no_golongan_kasus` int(11) NOT NULL AUTO_INCREMENT,
  `golongan_kasus` varchar(200) NOT NULL,
  PRIMARY KEY (`no_golongan_kasus`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of golongan_kasus
-- ----------------------------
INSERT INTO `golongan_kasus` VALUES ('1', 'Ketidaktelitian');
INSERT INTO `golongan_kasus` VALUES ('2', 'Delay Approval');
INSERT INTO `golongan_kasus` VALUES ('3', 'Belum UPP Spek');
INSERT INTO `golongan_kasus` VALUES ('4', 'Terlewat Proses');
INSERT INTO `golongan_kasus` VALUES ('5', 'Drop System');
INSERT INTO `golongan_kasus` VALUES ('6', 'Lain-lain');

-- ----------------------------
-- Table structure for informasi_produk
-- ----------------------------
DROP TABLE IF EXISTS `informasi_produk`;
CREATE TABLE `informasi_produk` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `kode_oracle` varchar(200) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `kode_form` varchar(200) NOT NULL,
  `no_sk` varchar(200) NOT NULL,
  `jenis` enum('pruning','launching') NOT NULL,
  `follow_up` text NOT NULL,
  `status_follow_up` text NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of informasi_produk
-- ----------------------------
INSERT INTO `informasi_produk` VALUES ('1', '2305000120', 'L-MEN SIX PACK 25S (12D)', '43.01', 'SK Pruning No. SK14065/QBL/III tgl 12 Maret 14', 'pruning', 'Pruning formula (untuk item L-MEN SIX PACK 12DX25SX2.5G MALDIVES\r\nL-MEN SIX PACK 25SX12DX2.5G BRUNEI sudah confirm global untuk ditarik)', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('2', '2106016', 'TS LOW FAT NOODLES HAINAN CHICKEN 40OX59G', '67.02', 'SK Pruning No. SK14071/QBT/III tgl 20 Mar 14', 'pruning', 'Pruning formula (untuk item TS LOW FAT NOODLE HAINAN CHICKEN 40OX59GRAM AUSTRALIA sudah confirm global untuk ditarik)', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('3', '1103082', 'NS RTD DRAGON FRUIT 330ML', '56.09', 'SK Pruning No. SK14158/QBN/VI tgl 27 Jun 14', 'pruning', 'Hanya 1 item, bisa ditarik dari prosedur', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('4', '2101471', 'HILO RTD KACANG HIJAU 24PX200ML', '34.21', 'SK Pruning No. SK14249/QBH/X tgl 06 Okt 14', 'pruning', 'Hanya 1 item, bisa ditarik di prosedur', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('5', '1103111', 'NS RTD FRUT LATTE KIWI 24X200ML', '56.12', 'SK Pruning No. SK14271/QBN/XI tgl 20 Nov 2014', 'pruning', 'Hanya 1 item, bisa ditarik dari prosedur', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('6', '2101470', 'HILO RTD KACANG HIJAU 1 L', '34.16', 'SK Pruning No. SK15026/QBH/I tgl 28 Jan 15', 'pruning', 'Hanya 1 item, bisa ditarik dari prosedur', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('7', '1103030', 'NS RTD FV KIWI 1LITERX12TETRAPACK', '56.10', 'SK Pruning No. SK15024/QBN/I tgl 28 Jan 15', 'pruning', 'Hanya 1 item, bisa ditarik dari prosedur', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('8', '1101909022', 'NS AMERICAN SWEET ORANGE 72PX10SX14G FREE 1S NS WDANK BAJIGUR', '53.02', 'SK Pruning No. SK15039/QBN/II tgl 11 Feb 15', 'pruning', 'Item tersebut bisa ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('9', '2306536306', 'L-MEN BAR BANANA POLOS 4PAKX25SX30G', '62.04', 'SK Pruning No. SK15042/QBL/II tgl 23 Feb 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('10', '1101547321', 'NS WDANK SARI JAHE 24GUSSETX5SX15G', '53.22', 'SK Pruning No. SK15046/QBN/II tgl 26 Feb 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('11', '110155332', 'NS WDANK SARABBA 24GUSSETX4SX12G', '53.24', 'SK Pruning No. SK15047/QBN/II tgl 26 Feb 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('12', '2301055148', 'L-MEN BSC MACCHIATO 200G (12D)', '28.03', 'SK Pruning No. SK15057/QBL/III tgl 9 Mar15', 'pruning', 'Untuk item global sudah confirm untuk ditarik juga (pruning formula)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('13', '2104000174', 'TS GULA TEBU 400G (24D)', '49.01', 'SK Pruning No. SK15082/QBT/III tgl 25 Mar15', 'pruning', 'Pruning formula(untuk item TS GULA TEBU 24BAGX400G AUSTRALIA confirm pruning)', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('14', '2304056291', 'L-MEN GAIN MAXX TIRAMISU 6KLRX4SX240G', '35.03', 'SK Pruning No. SK15091/QBL/IV tgl 06 Apr 15', 'pruning', 'Untuk item L-MEN GAIN MAXX TIRAMISU 6KLRX4SX240G MALDIVES \r\nL-MEN GAIN MAXX TIRAMISU 6KLRX4SX240G BRUNEI confirm global bisa ditarik (Pruning formula)', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('15', '1101557016', 'NS PLETOK ALA BETAWI 11GX10SX72P', '53.14', 'SK Pruning No. SK15179/QBN/VI tgl 24 Jun 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('16', '3103100KR', 'NUTRISARI READY TO DRINK FRUT N VEG LESS SUGAR, KOREA, 12 PACKS X 1000 ML', '56.05', 'SK Pruning No. SK15194/QBN/VII tgl 07 Jul 15', 'pruning', 'Bisa ditarik dari prosedur (pruning formula)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('17', '1103100', 'NS FV LESS SUGAR 1000ML', '56.05', 'SK Pruning No. SK15194/QBN/VII tgl 07 Jul 15', 'pruning', 'Bisa ditarik dari prosedur (pruning formula)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('18', '1103000', 'NS RTD JERUK TETRAPACK 1000ML', '56.03', 'SK Pruning No.', 'pruning', 'Bisa ditarik dari prosedur', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('19', '1101568333', 'NS JERUK MANADO PLS 6PX40SX11G', '53.25', 'SK15395/QBN/XI tgl 17 Nov 15', 'launching', 'Bisa langsung ditarik', 'Tinggal UPP', 'tidak aktif');
INSERT INTO `informasi_produk` VALUES ('20', '1101504333', 'NS JERUK EXTRA MANIS PLS 6PX40SX11G', '53.18', 'SK15394/QBN/XI tgl 17 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('21', '1101529333', 'NS ANGGUR PLS 6PX40SX11G', '53.20', 'SK15366/QBN/XI tgl 4 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('22', '1101531333', 'NS ORIENTAL LYCHEE ALOEVERA PLS 6PX40SX11G', '53.05', 'SK15365/QBN/XI tgl 4 Nov 15', 'pruning', 'Bisa langsung tarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('23', '1102011333', 'NS LEMON TEA PLS 6PX40SX11G', '57.01', 'SK15364/QBN/XI tanggal 4 Nov 15', 'launching', 'Bisa langsung ditarik', 'Tinggal UPP', 'tidak aktif');
INSERT INTO `informasi_produk` VALUES ('24', '1101568333', 'NS JERUK MANADO PLS 6PX40SX11G', '53.25', 'SK15395/QBN/XI tgl 17 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('25', '1103050', 'NS RTD SWEET ORANGE 1000ML', '56.08', 'SK15195/QBN/VII tgl 7 Jul 15', 'pruning', 'Bisa langsung ditarik dari prosedur (pruning formula)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('26', '1103102', 'NS RTD FRUT EN VEG 24BTLX330 ML', '56.18', 'SK Pruning No. SK15263/QBN/VIII tgl 14 Agst 15', 'pruning', 'Bisa langsunh ditarik (formula pruning)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('27', '2101751105', 'HILO PLATINUM SWISS CHOCOLATE 12DX5SX35G', '34.28', 'SK Pruning No. SK15275/QBH/IX tgl 3 Sept 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('28', '2101151151', 'TS NFDM CHOCOLATE 225G (12D)', '02.02', 'SK Pruning No. SK15319/QBT/X tgl 12 Okt 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('29', '2104229214', 'TS JAM STRAWBERRY 10DX100PCSX14G', '10.02', 'SK Pruning No. SK15362/QBT/XI tgl 4 Nov 15', 'pruning', 'Bisa langsung ditarik (pruning formula)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('30', '1101569333', 'NS JERUK PERAS PLS 6PX40SX14G', '53.26', 'SK Pruning No. SK15363/QBN/XI tgl 4 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('31', '1102011333', 'NS LEMON TEA PLS 6PX40SX11G', '57.01', 'SK Pruning No. SK15364/QBN/XI tgl 4 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('32', '1101528333', 'NS STRAWBERRY PLS 6PX40SX11G', '53.21', 'SK Pruning No. SK15396/QBN/XI tgl 17 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('33', '1101536333', 'NS SIRSAK PLS 6PX40SX11G', '53.19', 'SK Pruning No. SK15406/QBN/XI tgl 27 Nov 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('34', '2101000152', 'TS NFDM PLAIN 12DX225G', '02.01', 'SK Pruning No. SK15414/QBT/XII tgl 2 Des 15', 'pruning', 'Bisa langsung ditarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('35', '2101369108', 'TS MILK TEA 12DX8SX20G', '29.01', 'SK Pruning No. SK15436/QBT/XII tgl 14 Des 15', 'pruning', 'Bisa langsung ditarik (pruning formula)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('36', '2106017', 'TS LOW FAT NOODLES ROASTED DUCK 40OX61G', '67.03', 'SK Pruning No. SK15437/QBT/XII tgl 14 Des 15', 'pruning', 'Pruning Formula (untuk item TS LOW FAT NOODLE ROASTED DUCK 40OX61GRAM AUSTRALIA sudah confirm global untuk ditarik)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('37', '2102100225', 'TS SWT CAIR 12BTLX350ML', '05.18', 'SK Pruning No. SK16005/QBT/XII tgl 21 Des 15', 'pruning', 'Pruning Formula(untuk item TS SWT CAIR 12BTLX350ML AUSTRALIA, sudah confirm global untuk ditarik)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('38', '1102102030', 'NS MANIS H 30GX36OX10S', '52.08', 'SK Pruning No. SK16031/QBN/I tgl 14 Jan 16', 'pruning', 'Bisa langsung tarik', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('39', '2103000120', 'TS SWT ANTIOXIDANT 25S (12D)', '05.11 (Lokal)', 'SK Pruning No. SK | SK16040/QBT/I tgl 26 Jan 16', 'pruning', 'Info Global by mail, produk ekspor ikut pruning', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('40', '1101569105', 'NS JERUK PERAS 24GUSSETX5SX14G', '53.26', 'SK Pruning no. SK16148/QBN/IV - tgl 28 April 2016', 'pruning', 'Bisa langsung tarik kode oracle / langsung UPP', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('41', '2101000180', 'TS NFDM PLAIN 500G (12D)', '02.01', 'SK Pruning no. SK16112/QBT/III - tgl 29 Maret 2016', 'pruning', 'Bisa langsung tarik kode oracle / langsung UPP', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('42', '1103031', 'NS RTD FV KIWI 200MLX24TETRAPAK', '56.06', 'SK Pruning no. SK16145/QBN/IV - tgl 26 April 2016', 'pruning', 'Pruning formula, cek sekalian prosedur maklon', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('43', '1103021', 'NS FV POMEGRANATE 200ML', '56.04', 'SK Pruning no. SK16144/QBN/IV - tgl 26 April 2016', 'pruning', 'Pruning formula, cek sekalian prosedur maklon', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('44', '2103600128', 'TS SWT CLASSIC GOLD 12DX80SX2.5G', '05.23', 'SK Pruning no. SK16132/QBT/IV - tgl 18 April 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('45', '1101005180', 'NS MANDARIN REF 500GX12D', '52.03', 'SK Pruning no. SK16123/QBN/IV - tgl 07 April 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('46', '1103151', 'NS RTD MANGOSTEEN 24PX200ML', '56.16', 'SK Pruning no. SK16158/QBN/V - tgl 03 Mei 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('47', '2102800133', 'TS SWT SUCRASTICK (GARUDA) 12DX80SX1.5G', '05.13', 'SK Pruning no. SK16160/CD/V - tgl 04 Mei 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('48', '1101006155', 'NS MANDARIN REF 250GX12D', '54.02', 'SK Pruning no. SK16161/QBN/V - tgl 04 Mei 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('49', '1101025155', 'NS JAMBU BIJI REF 250GX12D', '52.05', 'SK Pruning no. SK16166/QBN/V - tgl 09 Mei 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('50', '2106377', 'TS BERAS MERAH ORGANIK (WONOGIRI) 12PCHX1KG', 'Maklon TS Beras Merah', 'SK Pruning no. SK16172/QBT/V - tgl 13 Mei 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('51', '2101852302', 'HILO CHOCOLATE 24PX10SX14G', '34.31', 'SK Pruning No. SK14181/QBH/VII tgl 23 Jul 2016', 'pruning', 'Pruning Kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('52', '2203006601', 'WRP 6 DAY PROMO DIET TEA 6D', '64.01', 'SK Pruning No. SK12231/QBW/V tgl 14 Mei 2012', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('53', '102599530', 'NS ANEKA RASA POLOS 6PAK+TUMBLER+HANGER', '55.04', 'SK Pruning No. SK12228/QBN/V tgl 11 Mei 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('54', '1101909333', 'NS ASO PLS 6PX40SX14G', '53.02', 'SK Pruning No. SK16210/QBN/VI tgl 6 Juni 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('55', '1102102225', 'NS MANIS PTC 350GX12BTL', '52.08', 'SK Pruning No. SK16211/QBN/VI tgl 6 Juni 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('56', '2101200151', 'TS NFDM FIBER PLAIN 225G (12D)', '27.06', 'SK Pruning No. SK16217/QBT/VI tgl 13 Juni 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('57', '2103100125', 'TS SWEETENER STELEAF 50S', '05.17', 'SK Pruning No. SK16243/QBT/VI tgl 27 Juni 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('58', '5102501120TH', 'TS SWT CLASSIC 24DX25SX2.5G THAILAND', '05.19', 'SK Pruning 001/GLT/VIII/2016 tgl 26 Juli 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('59', '5102501125TH', 'TS SWT CLASSIC 24DX50SX2.5G THAILAND', '05.19', 'SK Pruning No. 001/GLT/VIII/2016 tgl 26 Juli 2016', 'pruning', 'Pruning kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('60', 'C180550001', 'All Frozen Food Lokal dan Import', 'Frozen Food Lokal dan Import', 'SK Pruning WRP Tgl 8 Juli 2015', 'pruning', 'Pruning formula (termasuk prosedur P.06C)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('61', '5103000120HK', 'TS SWT LOW CALORIE ANTIOXIDANT 12DX25SX2.5G HONGKONG', '05.11', 'SK Pruning 001/QOX/X/2016, tgl 25 Oktober 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('62', '5103000120KH', 'TS SWT ANTIOXIDAN 25X12KAMBOJA', '05.11', 'SK Pruning 001/QOX/X/2016, tgl 25 Oktober 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('63', '5103000120MV', 'TS SWT ANTIOXIDAN25X12MALDIVES', '05.11', 'SK Pruning 001/QOX/X/2016, tgl 25 Oktober 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('64', '5103000120TT', 'TS SWT ANTIOXIDAN 25X12 TRINID', '05.11', 'SK Pruning 001/QOX/X/2016, tgl 25 Oktober 2016', 'pruning', 'Pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('65', '2306536', 'L-MEN BAR BANANA 4S (12D)', '62.04', 'SK Pruning SK16410/QBL/X, tgl 26 oktober 2016', 'pruning', 'pruning formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('66', '2306055148', 'L-MEN ASIATIX 200G (12D)', '28.08', 'SK16421/QBL/XI-SK PRUNING L-MEN ASIATIX 200G (12D), tgl 01 Nov 2016', 'pruning', 'pruning item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('67', 'xxx', 'FU Mango 2g', '59.42', 'Pruning info email Mbak Lince tgl 04 Nov 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('68', 'xxx', 'FU Orange 2g', '59.41', 'Pruning info email Mbak Lince tgl 04 Nov 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('69', 'xxx', 'FU Lemon 2g', '59.43', 'Pruning info email Mbak Lince tgl 04 Nov 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('70', 'xxx', 'FU Peach 2g', '59.44', 'Pruning info email Mbak Lince tgl 04 Nov 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('71', '5102501850TH', 'TS SWT CLASSIC LOOSEPACK 24PX100SX2.5G THAILAND', '05.19', 'Pruning info email Mbak Lince tgl 04 Nov 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('72', '2104392210', 'TS SOY SAUCE ASIN 200ML (24B)', '68.01', 'SK16422/QBT/XI-SK PRUNING TS SOY SAUCE ASIN 200ML (24B) tgl 1 Nov 2016', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('73', '2106019', 'TS LESS FAT NOODLES KEPITING SAUS PADANG 40OX64G', '67.09', 'SK Pruning SK16289/QBT/VII tgl 28 Juli 2016', 'pruning', 'Formula pruning', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('74', '2306536', 'L-MEN BAR BANANA 4S (12D)', 'xx', 'SK Pruning SK16410/QBL/X tgl 26 Okt 2016', 'pruning', 'Formula pruning', 'sudah ditarik', 'tidak aktif');
INSERT INTO `informasi_produk` VALUES ('75', '2101461148', 'HILO ACTIVE TIRAMISU 12DX200G', '34.27', 'SK Pruning SK17005/QBH/I tgl 3 Jan 2017', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('76', '22050321', 'WRP JELLY DRINK APPLE 12DX2PX200ML', '81.02', 'SK Pruning No. SK17006/EBW/I tgl 3 Jan 2017', 'pruning', 'Pruning formula termasuk item 52050321MV (WRP JELLY DRINK APPLE 12DX2PX200ML MALDIVES) dan 52050321KH (WRP JELLY DRINK APPLE 12DX2PX200ML CAMBODIA)', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('77', '2101456105', 'HILO JAVACINNO 12DX200G(5SX40G)', '34.13', 'SK17034/QBH/II-SK PRUNING HILO JAVACINNO 12DX200G(5SX40G)', 'pruning', 'Pruning Formula', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('78', '2103400316', 'TS SWT I-SWEET INDUSTRIAL 12PX100SX2.5G', '05.34', 'SK17088/QBT/IV-SK PRUNING tgl 5 April 2017', 'pruning', 'UPP pruning kode item click data', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('79', '1101557105', 'NS WDANK PLETOK ALA BETAWI 24DX5SX11G', '53.14', 'SK | SK17085/QBN/IV-SK PRUNING tgl 5 April 2017', 'pruning', 'Pruning formula dan tarik dokumen terkaitnya', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('80', '1101569123', 'NS JERUK PERAS 12GUSSETX30SX14G', '53.26', 'SK | SK17107/QBN/IV-SK PRUNING tgl 04 Mei 2017', 'pruning', 'Tarik kode item', 'sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('81', '1101553104', 'NS WDANK SARABBA 24DX4SX12G', '53.24', 'SK | SK17117/QBN/V-SK PRUNING tgl 18 Mei 2017', 'pruning', 'pruning kode item', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('82', '1103001', 'NS RTD JERUK TETRAPACK 200ML', 'xx', 'K | SK17116/QBN/V-SK PRUNING tgl 18 Mei 2017', 'pruning', 'Pruning formula', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('83', '3102059020KH', 'NC Milk Tea 12Ox10Sx20g Cambodia', '59.24 (Ekspor)', 'SK pruning no. 001/QOX/IV/2015 tgl 22 Mei 2017', 'pruning', 'Pruning formula', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('84', '3102059351NG', 'NC Milk Tea Sugar Free Industrial Pack 40Bx250G Nigeria', '59.24 (Ekspor)', 'SK pruning no. 001/QOX/IV/2015 tgl 22 Mei 2017', 'pruning', 'Pruning formula', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('85', '3102059020TZ', 'NC Milk Tea 12Ox10Sx20G Tanzania', '59.24 (Ekspor)', 'SK pruning no. 001/QOX/IV/2015 tgl 22 Mei 2017', 'pruning', 'Pruning formula', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('86', '2106018', 'TS LESS FAT NOODLES AYAM BAKAR 40OX64G', '67.06', 'SK Pruning no. SK17122/QBT/VI tgl 8 Juni 2017', 'pruning', 'Pruning formula', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('87', 'All Formula 05.29', 'TS SWT Tablet Impor', '05.29', 'SK Pruning No. 002/QOX/VI/2017 tgl 12 Juni 2017', 'pruning', 'Pruning formula', 'Sudah ditarik', 'aktif');
INSERT INTO `informasi_produk` VALUES ('88', '1111', 'Aaaaa', '1212', '1313', 'launching', 'FU', 'SFU', 'tidak aktif');

-- ----------------------------
-- Table structure for jenis_ik
-- ----------------------------
DROP TABLE IF EXISTS `jenis_ik`;
CREATE TABLE `jenis_ik` (
  `kode_ik` int(11) NOT NULL,
  `jenis_ik` varchar(255) NOT NULL,
  PRIMARY KEY (`kode_ik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jenis_ik
-- ----------------------------
INSERT INTO `jenis_ik` VALUES ('1', '');
INSERT INTO `jenis_ik` VALUES ('2', 'Instruksi Kerja Baru');
INSERT INTO `jenis_ik` VALUES ('3', 'Instruksi Kerja Perbaikan');

-- ----------------------------
-- Table structure for jenis_prosedur
-- ----------------------------
DROP TABLE IF EXISTS `jenis_prosedur`;
CREATE TABLE `jenis_prosedur` (
  `no_jenis_prosedur` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_prosedur` varchar(200) NOT NULL,
  `nf_jprosedur` varchar(255) NOT NULL,
  PRIMARY KEY (`no_jenis_prosedur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jenis_prosedur
-- ----------------------------
INSERT INTO `jenis_prosedur` VALUES ('1', 'Prosedur', 'prosedur');
INSERT INTO `jenis_prosedur` VALUES ('2', 'Instruksi Kerja', 'intruksi_kerja');
INSERT INTO `jenis_prosedur` VALUES ('3', 'Lampiran', 'lampiran');
INSERT INTO `jenis_prosedur` VALUES ('4', 'Form dan Catatan Mutu', 'form_dan_catatan_mutu');

-- ----------------------------
-- Table structure for kat_mesin
-- ----------------------------
DROP TABLE IF EXISTS `kat_mesin`;
CREATE TABLE `kat_mesin` (
  `no_kat_mesin` int(11) NOT NULL AUTO_INCREMENT,
  `kat_mesin` varchar(200) NOT NULL,
  PRIMARY KEY (`no_kat_mesin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kat_mesin
-- ----------------------------
INSERT INTO `kat_mesin` VALUES ('1', 'Utility');
INSERT INTO `kat_mesin` VALUES ('2', 'Process');
INSERT INTO `kat_mesin` VALUES ('3', 'Filling');
INSERT INTO `kat_mesin` VALUES ('4', 'Packing');

-- ----------------------------
-- Table structure for kat_msds
-- ----------------------------
DROP TABLE IF EXISTS `kat_msds`;
CREATE TABLE `kat_msds` (
  `kat_msds` int(11) NOT NULL,
  `nama_msds` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kat_msds`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kat_msds
-- ----------------------------
INSERT INTO `kat_msds` VALUES ('1', 'Bahan Baku');
INSERT INTO `kat_msds` VALUES ('2', 'Bahan Kemas');
INSERT INTO `kat_msds` VALUES ('3', 'Supporting Material');

-- ----------------------------
-- Table structure for kat_perubahan
-- ----------------------------
DROP TABLE IF EXISTS `kat_perubahan`;
CREATE TABLE `kat_perubahan` (
  `no_kat_perubahan` int(11) NOT NULL AUTO_INCREMENT,
  `kat_perubahan` varchar(200) NOT NULL,
  PRIMARY KEY (`no_kat_perubahan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kat_perubahan
-- ----------------------------
INSERT INTO `kat_perubahan` VALUES ('1', 'Modifikasi alat / mesin eksis');
INSERT INTO `kat_perubahan` VALUES ('2', 'Perubahan spesifikasi / parameter inspeksi QC');
INSERT INTO `kat_perubahan` VALUES ('3', 'Pengadaan mesin baru / pemindahan mesin');
INSERT INTO `kat_perubahan` VALUES ('4', 'Perubahan cleaning (metode / frequensi / chemical)');
INSERT INTO `kat_perubahan` VALUES ('5', 'Perubahan umur simpan');
INSERT INTO `kat_perubahan` VALUES ('6', 'Perubahan parameter proses');
INSERT INTO `kat_perubahan` VALUES ('7', 'Perubahan kapasitas per batch');

-- ----------------------------
-- Table structure for keluhan
-- ----------------------------
DROP TABLE IF EXISTS `keluhan`;
CREATE TABLE `keluhan` (
  `no_keluhan` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_keluhan` date NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` int(11) NOT NULL,
  `pengaju` varchar(200) NOT NULL,
  `email_pengaju` varchar(200) NOT NULL,
  `no_prosedur` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `golongan_kasus` varchar(200) NOT NULL,
  `penyebab` text NOT NULL,
  `tindakan_koreksi` text NOT NULL,
  `tindakan_preventive` text NOT NULL,
  `pic` varchar(200) NOT NULL,
  `tgl_closed` date NOT NULL,
  `status` enum('process','closed','batal') DEFAULT 'process',
  `keterangan` text NOT NULL,
  `tgl_batal` date NOT NULL,
  `alasan_batal` text NOT NULL,
  PRIMARY KEY (`no_keluhan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of keluhan
-- ----------------------------

-- ----------------------------
-- Table structure for master_ddd
-- ----------------------------
DROP TABLE IF EXISTS `master_ddd`;
CREATE TABLE `master_ddd` (
  `no_master_ddd` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_ddd` enum('internal','eksternal') NOT NULL,
  `no_copy_master` varchar(50) NOT NULL,
  `penerima` varchar(200) NOT NULL,
  `pj` varchar(200) NOT NULL,
  PRIMARY KEY (`no_master_ddd`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_ddd
-- ----------------------------
INSERT INTO `master_ddd` VALUES ('1', 'eksternal', '01', 'Quindofood', 'Deni / Uke');
INSERT INTO `master_ddd` VALUES ('2', 'eksternal', '02', 'Monysaga', 'Fathoro / Suwarna');
INSERT INTO `master_ddd` VALUES ('3', 'eksternal', '03', 'Makindo', 'Handari');
INSERT INTO `master_ddd` VALUES ('4', 'eksternal', '04', 'BTU', 'Ana Alfiati / Maesarah');
INSERT INTO `master_ddd` VALUES ('5', 'eksternal', '09', 'Swanish', 'Kristin / Farid');
INSERT INTO `master_ddd` VALUES ('6', 'eksternal', '11', 'Jakaranatama', 'Julia');
INSERT INTO `master_ddd` VALUES ('7', 'eksternal', '12', 'SAM', 'Tuti / Epa');
INSERT INTO `master_ddd` VALUES ('8', 'eksternal', '14', 'Fairpack', 'Guruh / Suyatno');
INSERT INTO `master_ddd` VALUES ('9', 'eksternal', '15', 'Hokkan', 'Yudi');
INSERT INTO `master_ddd` VALUES ('10', 'internal', '01', 'Mixing filling', 'penyelia');
INSERT INTO `master_ddd` VALUES ('11', 'internal', '02', 'Packing', 'penyelia');
INSERT INTO `master_ddd` VALUES ('12', 'internal', '03\r\n', 'Gedung D', 'penyelia\r\n');
INSERT INTO `master_ddd` VALUES ('13', 'internal', '04', 'Processing', 'penyelia');
INSERT INTO `master_ddd` VALUES ('14', 'internal', '05', 'G-2', 'penyelia');
INSERT INTO `master_ddd` VALUES ('15', 'internal', '06', 'H-2', 'penyelia');
INSERT INTO `master_ddd` VALUES ('16', 'internal', '07', 'PRC', 'penyelia');
INSERT INTO `master_ddd` VALUES ('17', 'internal', '08', 'Gudang Baku - A', 'penyelia');
INSERT INTO `master_ddd` VALUES ('18', 'internal', '09', 'Gudang Baku - B', 'penyelia');
INSERT INTO `master_ddd` VALUES ('19', 'internal', '10', 'Quality Control (QC)', 'inspektor');
INSERT INTO `master_ddd` VALUES ('20', 'internal', '11', 'PLF', 'penyelia');
INSERT INTO `master_ddd` VALUES ('21', 'internal', '12', 'AGC', 'pj area');
INSERT INTO `master_ddd` VALUES ('22', 'internal', '13', 'Gudang Kemas', 'penyelia');
INSERT INTO `master_ddd` VALUES ('23', 'internal', '14', 'Sortir', 'penyelia');
INSERT INTO `master_ddd` VALUES ('24', 'internal', '15', 'RD', 'pj area');
INSERT INTO `master_ddd` VALUES ('25', 'internal', '16', 'Laboratory', 'pj area');
INSERT INTO `master_ddd` VALUES ('26', 'internal', '17', 'PEA', 'pj area');
INSERT INTO `master_ddd` VALUES ('27', 'internal', '18', 'PEB', 'pj area');
INSERT INTO `master_ddd` VALUES ('28', 'internal', '19', 'PPIC', 'pj area');
INSERT INTO `master_ddd` VALUES ('29', 'internal', '20', 'Receptionist', 'pj area');
INSERT INTO `master_ddd` VALUES ('30', 'internal', '21', 'SSA', 'Nindyta');
INSERT INTO `master_ddd` VALUES ('31', 'internal', '21a', 'SSA (Sentul)', 'Ayu');
INSERT INTO `master_ddd` VALUES ('32', 'internal', '26a', 'Sack tipping Cibi', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('33', 'internal', '26b', 'Mixing Cibi', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('34', 'internal', '26c', 'Discharge Cibi', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('35', 'internal', '26d', 'Filling (10 Line)', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('36', 'internal', '26e', 'Filling (5 Line)', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('37', 'internal', '26f', 'Filling (Wolf 2)', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('38', 'internal', '26g', 'Filling (Wolf 3)', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('39', 'internal', '26h', 'Filling (Wolf 4)', 'Firendra / Rizal DS');
INSERT INTO `master_ddd` VALUES ('40', 'internal', '27', 'Engineering Cibi', 'Dery Firdaus');
INSERT INTO `master_ddd` VALUES ('41', 'internal', '28', 'PLG Cibitung', 'Riky PH');
INSERT INTO `master_ddd` VALUES ('42', 'internal', '29', 'PLB Cibitung', 'Moch. Suhaimi');
INSERT INTO `master_ddd` VALUES ('43', 'internal', '30', 'PSB', 'pj area');
INSERT INTO `master_ddd` VALUES ('44', 'internal', '31', 'WTP', 'pj area');
INSERT INTO `master_ddd` VALUES ('45', 'internal', '32', 'YAB Cibitung', 'Mamik');
INSERT INTO `master_ddd` VALUES ('46', 'internal', '33', 'Gudang Tanah Baru', 'Fajrina Atikah');
INSERT INTO `master_ddd` VALUES ('47', 'internal', '34', 'Penyelia Produksi Nutrisari', 'pj area');
INSERT INTO `master_ddd` VALUES ('48', 'internal', '35', 'Penyelia I-2', 'pj area');

-- ----------------------------
-- Table structure for master_prosedur
-- ----------------------------
DROP TABLE IF EXISTS `master_prosedur`;
CREATE TABLE `master_prosedur` (
  `no_master_prosedur` int(11) NOT NULL AUTO_INCREMENT,
  `master_prosedur` varchar(200) NOT NULL,
  `nm_prosedur` varchar(255) NOT NULL,
  PRIMARY KEY (`no_master_prosedur`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_prosedur
-- ----------------------------
INSERT INTO `master_prosedur` VALUES ('1', 'P.01A Sistem Manajemen Keamanan Pangan', 'P.01A');
INSERT INTO `master_prosedur` VALUES ('4', 'P.02 Proses Kualifikasi, dan Validasi', 'P.02');
INSERT INTO `master_prosedur` VALUES ('5', 'P.04 Perencanaan Produksi, Inventory Control, dan Realisasi Produksi Sistem Oracle', 'P.04');
INSERT INTO `master_prosedur` VALUES ('6', 'P.05A Inspeksi, dan Pengetesan', 'P.05A');
INSERT INTO `master_prosedur` VALUES ('7', 'P.05B Pengendalian Barang Tidak Sesuai, Tindakan Koreksi, dan Pencegahan', 'P.05B');
INSERT INTO `master_prosedur` VALUES ('8', 'P.05C Peralatan Inspeksi, Pengukuran, dan Pengetesan', 'P.05C');
INSERT INTO `master_prosedur` VALUES ('9', 'P.05D Spesifikasi', 'P.05D');
INSERT INTO `master_prosedur` VALUES ('10', 'P.05E System Management Laboratory', 'P.05E');
INSERT INTO `master_prosedur` VALUES ('11', 'P.06A Pengendalian Proses Produksi', 'P.06A');
INSERT INTO `master_prosedur` VALUES ('12', 'P.06B Pengendalian Proses Produksi Maklon', 'P.06B');
INSERT INTO `master_prosedur` VALUES ('13', 'P.06C Pengendalian Proses Produksi WRP Ready To Eat Meal', 'P.06C');
INSERT INTO `master_prosedur` VALUES ('14', 'P.06D Pengendalian Proses Produksi Sweetener Tablet', 'P.06D');
INSERT INTO `master_prosedur` VALUES ('15', 'P.06E Pengendalian Proses Produksi HB WRP', 'P.06E');
INSERT INTO `master_prosedur` VALUES ('16', 'P.07 Identifikasi dan Mampu Telusur Produk', 'P.07');
INSERT INTO `master_prosedur` VALUES ('17', 'P.08A Penanganan, Penyimpanan, Pengemasan, Preservasi, dan Penyerahan', 'P.08A');
INSERT INTO `master_prosedur` VALUES ('18', 'P.08B Penanganan, Penyimpanan, Pengemasan, Preservasi, dan Penyerahan Produk Jadi', 'P.08B');
INSERT INTO `master_prosedur` VALUES ('19', 'P.09 Pengendalian, dan Pemeliharaan Mesin', 'P.09');
INSERT INTO `master_prosedur` VALUES ('20', 'P.10 Building, dan Contruction', 'P.10');
INSERT INTO `master_prosedur` VALUES ('21', 'P.11 Sanitasi, dan Safety', 'P.11');
INSERT INTO `master_prosedur` VALUES ('22', 'P.11A Water Treatment Plant', 'P.11A');
INSERT INTO `master_prosedur` VALUES ('23', 'P.12 Ringkas, Rapi, Resik, Rawat, dan Rajin', 'P.12');
INSERT INTO `master_prosedur` VALUES ('24', 'P.13 Pengelolaan Kebun Sentul', 'P.13');
INSERT INTO `master_prosedur` VALUES ('25', 'R.01 Penelitian, Pengembangan, dan Perbaikan Produk', 'R.01');
INSERT INTO `master_prosedur` VALUES ('80', 'P.14. Pest Control', 'P.14');
INSERT INTO `master_prosedur` VALUES ('81', 'P.01B (AHI) Sistem Jaminan Halal', 'P.01B');
INSERT INTO `master_prosedur` VALUES ('82', 'P.01C Sistem Manajemen K3 dan Lingkungan', 'P.01C');
INSERT INTO `master_prosedur` VALUES ('83', 'P.11B Waste Water Treatment Plant (WWTP)', 'P.11B');
INSERT INTO `master_prosedur` VALUES ('84', 'P.01D Food Safety System Certification (FSSC)', 'P.01D');
INSERT INTO `master_prosedur` VALUES ('85', 'Tangina Mo BOBO', 'Tangina');

-- ----------------------------
-- Table structure for msds
-- ----------------------------
DROP TABLE IF EXISTS `msds`;
CREATE TABLE `msds` (
  `nomor` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(255) NOT NULL,
  `kategori_msds` varchar(255) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `nama_bahan` varchar(255) DEFAULT NULL,
  `nama_sederhana_bahan` varchar(255) DEFAULT NULL,
  `tanggal_berlaku` date DEFAULT NULL,
  `tanggal_expired` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `attachement_msds` text,
  `pic` varchar(255) DEFAULT NULL,
  `email_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nomor`,`no`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of msds
-- ----------------------------
INSERT INTO `msds` VALUES ('11', '0001/MSDS/2017', '1', '2017', 'BB_Testing_1', 'BBT1', '2017-08-11', '2022-08-11', 'OK', 'file_upload/msds/2017/1/Pisang.xlsx', 'Bima', 'bima@bima.bima');
INSERT INTO `msds` VALUES ('12', '0002/MSDS/2017', '2', '2017', 'BK_Testing_1', 'BKT1', '2017-08-11', '2022-08-11', 'OK', 'file_upload/msds/2017/2/Jeruk.xlsx', 'Putra', 'putra@putra.putra');
INSERT INTO `msds` VALUES ('13', '0003/MSDS/2017', '3', '2017', 'SM_Testing_1', 'SMT1', '2017-08-11', '2022-08-11', 'OK', 'file_upload/msds/2017/3/Anggur.xlsx', 'Sudimulya', 'sudimulya@yahoo.com');

-- ----------------------------
-- Table structure for plant
-- ----------------------------
DROP TABLE IF EXISTS `plant`;
CREATE TABLE `plant` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `plant` varchar(200) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of plant
-- ----------------------------
INSERT INTO `plant` VALUES ('1', 'Ciawi');
INSERT INTO `plant` VALUES ('2', 'Cibitung');
INSERT INTO `plant` VALUES ('3', 'Sentul');
INSERT INTO `plant` VALUES ('4', 'Jakarta');
INSERT INTO `plant` VALUES ('5', 'Ciawi, Cibitung');
INSERT INTO `plant` VALUES ('6', 'Ciawi, Sentul');
INSERT INTO `plant` VALUES ('7', 'Ciawi, Sentul, Cibitung');
INSERT INTO `plant` VALUES ('8', 'Maklon');

-- ----------------------------
-- Table structure for prosedur
-- ----------------------------
DROP TABLE IF EXISTS `prosedur`;
CREATE TABLE `prosedur` (
  `no_prosedur` int(11) NOT NULL AUTO_INCREMENT,
  `no_divisi_prosedur` int(11) NOT NULL,
  `no_master_prosedur` int(11) NOT NULL,
  `no_jenis_prosedur` int(11) NOT NULL,
  `detail_prosedur` varchar(200) NOT NULL,
  `nama_folder` text NOT NULL,
  `no_revisi` int(11) NOT NULL DEFAULT '1',
  `tgl_revisi` date DEFAULT NULL,
  `judul_file` text NOT NULL,
  `nama_file` text NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL DEFAULT 'aktif',
  `file_fmea` text,
  PRIMARY KEY (`no_prosedur`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prosedur
-- ----------------------------
INSERT INTO `prosedur` VALUES ('38', '1', '1', '2', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '2', '2017-09-08', 'isinya5.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/isinya5.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/1/isinya6.txt');
INSERT INTO `prosedur` VALUES ('39', '1', '13', '4', 'Percobaan_Nomor_1', 'Percobaan_Nomor_1', '1', '2017-09-08', 'isinya1.txt', 'file_upload/prosedur/P/P.06C/form_dan_catatan_mutu/Percobaan_Nomor_1/isinya1.txt', 'aktif', null);
INSERT INTO `prosedur` VALUES ('40', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '2', '2017-09-11', 'isinya5.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/isinya5.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/4/isinya6.txt');
INSERT INTO `prosedur` VALUES ('41', '1', '1', '2', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', '1', '2017-09-11', 'isinya3.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01B2-Perencanaan-TESTING IK BARU/isinya3.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/6/isinya6.txt');
INSERT INTO `prosedur` VALUES ('42', '1', '14', '2', 'IK P.06D03G4-Persiapan-Potansta1231', 'IK P.06D03G4-Persiapan-Potansta', '3', '2017-09-13', 'isinya7.txt', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/isinya3.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/10/isinya1.txt');
INSERT INTO `prosedur` VALUES ('43', '2', '84', '2', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', '1', '2017-09-13', 'isinya1.txt', 'file_upload/prosedur/R/P.01D/intruksi_kerja/IK R.0101A2-Searching-Paku yang Hilang/isinya1.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/11/isinya6.txt');
INSERT INTO `prosedur` VALUES ('44', '1', '1', '2', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', '1', '2017-09-19', 'isinya6.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.06D02C001-Maintenance-IK Coba Baru/isinya6.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/13/isinya1.txt');
INSERT INTO `prosedur` VALUES ('45', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKCoba1', '1', '2017-09-19', 'isinya3.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIKCoba1/isinya3.txt', 'aktif', null);
INSERT INTO `prosedur` VALUES ('46', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', '1', '2017-09-19', 'isinya5.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1/isinya5.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/15/isinya5.txt');
INSERT INTO `prosedur` VALUES ('47', '1', '10', '1', 'ASw', 'ASwASw', '1', '2017-09-19', 'isinya3.txt', 'file_upload/prosedur/P/P.05E/prosedur/ASwASw/isinya3.txt', 'aktif', '');

-- ----------------------------
-- Table structure for pro_d_revisi
-- ----------------------------
DROP TABLE IF EXISTS `pro_d_revisi`;
CREATE TABLE `pro_d_revisi` (
  `no_prosedur` int(11) NOT NULL AUTO_INCREMENT,
  `no_divisi_prosedur` int(11) NOT NULL,
  `no_master_prosedur` int(11) NOT NULL,
  `no_jenis_prosedur` int(11) NOT NULL,
  `detail_prosedur` varchar(200) NOT NULL,
  `nama_folder` text NOT NULL,
  `no_revisi` int(11) NOT NULL DEFAULT '1',
  `tgl_revisi` date DEFAULT NULL,
  `nama_file` text NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`no_prosedur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pro_d_revisi
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_listkdplant
-- ----------------------------
DROP TABLE IF EXISTS `tbl_listkdplant`;
CREATE TABLE `tbl_listkdplant` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `kd_plant` varchar(255) NOT NULL,
  `nm_plant` varchar(255) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_listkdplant
-- ----------------------------
INSERT INTO `tbl_listkdplant` VALUES ('1', 'A', 'NS/Non Dairy Ciawi');
INSERT INTO `tbl_listkdplant` VALUES ('2', 'B', 'Dairy Ciawi');
INSERT INTO `tbl_listkdplant` VALUES ('3', 'C', 'NS/Non Dairy Cibitung');
INSERT INTO `tbl_listkdplant` VALUES ('4', 'D', 'Diary Cibitung');
INSERT INTO `tbl_listkdplant` VALUES ('5', 'E', 'All Ciawi');
INSERT INTO `tbl_listkdplant` VALUES ('6', 'F', 'All Cibitung');
INSERT INTO `tbl_listkdplant` VALUES ('7', 'G', 'All Sentul');
INSERT INTO `tbl_listkdplant` VALUES ('8', 'H', 'Maklon Quindofood');
INSERT INTO `tbl_listkdplant` VALUES ('9', 'I', 'Maklon Makindo');
INSERT INTO `tbl_listkdplant` VALUES ('10', 'J', 'Maklon Hokkan');
INSERT INTO `tbl_listkdplant` VALUES ('11', 'K', 'Maklon Futami');
INSERT INTO `tbl_listkdplant` VALUES ('12', 'L', 'Maklon SAM');
INSERT INTO `tbl_listkdplant` VALUES ('13', 'M', 'Maklon Fairpack');
INSERT INTO `tbl_listkdplant` VALUES ('14', 'N', 'Maklon Tigaraksa');
INSERT INTO `tbl_listkdplant` VALUES ('15', 'O', 'Maklon Tata Nutrisana');
INSERT INTO `tbl_listkdplant` VALUES ('16', 'Z', 'All Plant (Umum)');

-- ----------------------------
-- Table structure for tbl_listnamapros
-- ----------------------------
DROP TABLE IF EXISTS `tbl_listnamapros`;
CREATE TABLE `tbl_listnamapros` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `no_pros` varchar(255) NOT NULL,
  `nm_pros` varchar(255) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_listnamapros
-- ----------------------------
INSERT INTO `tbl_listnamapros` VALUES ('1', 'P.01A', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('2', 'P.01A', 'Realisasi');
INSERT INTO `tbl_listnamapros` VALUES ('3', 'P.01A', 'Validasi');
INSERT INTO `tbl_listnamapros` VALUES ('4', 'P.01A', 'Verifikasi');
INSERT INTO `tbl_listnamapros` VALUES ('5', 'P.01A', 'Perbaikan');
INSERT INTO `tbl_listnamapros` VALUES ('6', 'P.01B', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('7', 'P.01B', 'Realisasi');
INSERT INTO `tbl_listnamapros` VALUES ('8', 'P.01B', 'Validasi');
INSERT INTO `tbl_listnamapros` VALUES ('9', 'P.01B', 'Verifikasi');
INSERT INTO `tbl_listnamapros` VALUES ('10', 'P.01B', 'Perbaikan');
INSERT INTO `tbl_listnamapros` VALUES ('11', 'P.01C', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('12', 'P.01C', 'Realisasi');
INSERT INTO `tbl_listnamapros` VALUES ('13', 'P.01C', 'Validasi');
INSERT INTO `tbl_listnamapros` VALUES ('14', 'P.01C', 'Verifikasi');
INSERT INTO `tbl_listnamapros` VALUES ('15', 'P.01C', 'Perbaikan');
INSERT INTO `tbl_listnamapros` VALUES ('16', 'P.01D', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('17', 'P.01D', 'Realisasi');
INSERT INTO `tbl_listnamapros` VALUES ('18', 'P.01D', 'Validasi');
INSERT INTO `tbl_listnamapros` VALUES ('19', 'P.01D', 'Verifikasi');
INSERT INTO `tbl_listnamapros` VALUES ('20', 'P.01D', 'Perbaikan');
INSERT INTO `tbl_listnamapros` VALUES ('21', 'P.02', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('22', 'P.02', 'Realisasi');
INSERT INTO `tbl_listnamapros` VALUES ('23', 'P.02', 'Validasi');
INSERT INTO `tbl_listnamapros` VALUES ('24', 'P.02', 'Verifikasi');
INSERT INTO `tbl_listnamapros` VALUES ('25', 'P.02', 'Perbaikan');
INSERT INTO `tbl_listnamapros` VALUES ('26', 'P.04', 'PPIC');
INSERT INTO `tbl_listnamapros` VALUES ('27', 'P.05A', 'Inspeksi');
INSERT INTO `tbl_listnamapros` VALUES ('28', 'P.05A', 'Pengetesan');
INSERT INTO `tbl_listnamapros` VALUES ('29', 'P.05B', 'Ketidaksesuaian Baku');
INSERT INTO `tbl_listnamapros` VALUES ('30', 'P.05B', 'Ketidaksesuaian Kemas');
INSERT INTO `tbl_listnamapros` VALUES ('31', 'P.05B', 'Ketidaksesuaian WIP');
INSERT INTO `tbl_listnamapros` VALUES ('32', 'P.05B', 'Ketidaksesuaian FG');
INSERT INTO `tbl_listnamapros` VALUES ('33', 'P.05B', 'Ketidaksesuaian Proses');
INSERT INTO `tbl_listnamapros` VALUES ('34', 'P.05C', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('35', 'P.05C', 'Pelaksanaan');
INSERT INTO `tbl_listnamapros` VALUES ('36', 'P.05C', 'Review');
INSERT INTO `tbl_listnamapros` VALUES ('37', 'P.05E', 'Analisa');
INSERT INTO `tbl_listnamapros` VALUES ('38', 'P.05E', 'Penggunaan');
INSERT INTO `tbl_listnamapros` VALUES ('39', 'P.05E', 'Kalibrasi');
INSERT INTO `tbl_listnamapros` VALUES ('40', 'P.05E', 'Pemeliharaan');
INSERT INTO `tbl_listnamapros` VALUES ('41', 'P.06A', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('42', 'P.06A', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('43', 'P.06A', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('44', 'P.06A', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('45', 'P.06C', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('46', 'P.06C', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('47', 'P.06C', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('48', 'P.06C', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('49', 'P.06D', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('50', 'P.06D', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('51', 'P.06D', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('52', 'P.06D', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('53', 'P.06E', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('54', 'P.06E', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('55', 'P.06E', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('56', 'P.06E', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('57', 'P.06B', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('58', 'P.06B', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('59', 'P.06B', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('60', 'P.06B', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('61', 'P.07', 'Mampu Telusur');
INSERT INTO `tbl_listnamapros` VALUES ('62', 'P.08A', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('63', 'P.08A', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('64', 'P.08A', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('65', 'P.08A', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('66', 'P.08B', 'Persiapan');
INSERT INTO `tbl_listnamapros` VALUES ('67', 'P.08B', 'Operasional');
INSERT INTO `tbl_listnamapros` VALUES ('68', 'P.08B', 'Cleaning');
INSERT INTO `tbl_listnamapros` VALUES ('69', 'P.08B', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('70', 'P.09', 'Maintenance');
INSERT INTO `tbl_listnamapros` VALUES ('71', 'P.09', 'Pengoperasian');
INSERT INTO `tbl_listnamapros` VALUES ('72', 'P.10', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('73', 'P.10', 'Pelaksanaan');
INSERT INTO `tbl_listnamapros` VALUES ('74', 'P.10', 'Inspeksi');
INSERT INTO `tbl_listnamapros` VALUES ('75', 'P.10', 'Pemeliharaan');
INSERT INTO `tbl_listnamapros` VALUES ('76', 'P.11', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('77', 'P.11', 'Pelaksanaan');
INSERT INTO `tbl_listnamapros` VALUES ('78', 'P.11', 'Pemeliharaan');
INSERT INTO `tbl_listnamapros` VALUES ('79', 'P.11', 'Inspeksi');
INSERT INTO `tbl_listnamapros` VALUES ('80', 'P.14', 'Perencanaan');
INSERT INTO `tbl_listnamapros` VALUES ('81', 'P.14', 'Pelaksanaan');
INSERT INTO `tbl_listnamapros` VALUES ('82', 'P.14', 'Monitoring');
INSERT INTO `tbl_listnamapros` VALUES ('83', 'P.14', 'Review');
INSERT INTO `tbl_listnamapros` VALUES ('84', 'R.01', 'Research');
INSERT INTO `tbl_listnamapros` VALUES ('85', 'R.01', 'Searching');
INSERT INTO `tbl_listnamapros` VALUES ('86', 'R.01', 'Design');
INSERT INTO `tbl_listnamapros` VALUES ('87', 'R.01', 'Trial');
INSERT INTO `tbl_listnamapros` VALUES ('88', 'R.01', 'Uji');
INSERT INTO `tbl_listnamapros` VALUES ('89', 'R.01', 'Review');
INSERT INTO `tbl_listnamapros` VALUES ('90', 'R.01', 'Administrasi');

-- ----------------------------
-- Table structure for tbl_listworkcenter
-- ----------------------------
DROP TABLE IF EXISTS `tbl_listworkcenter`;
CREATE TABLE `tbl_listworkcenter` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `no_pros` varchar(255) NOT NULL,
  `kode_workcenter` varchar(255) NOT NULL,
  `ket_workcenter` varchar(255) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_listworkcenter
-- ----------------------------
INSERT INTO `tbl_listworkcenter` VALUES ('1', 'P.01A', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('2', 'P.01B', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('3', 'P.01C', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('4', 'P.01D', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('5', 'P.02', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('6', 'P.04', '01', 'Perencanaan dan realisasi produksi');
INSERT INTO `tbl_listworkcenter` VALUES ('7', 'P.05A', '01', 'QC baku');
INSERT INTO `tbl_listworkcenter` VALUES ('8', 'P.05A', '02', 'QC kemas');
INSERT INTO `tbl_listworkcenter` VALUES ('9', 'P.05A', '03', 'QC WIP - Proses');
INSERT INTO `tbl_listworkcenter` VALUES ('10', 'P.05A', '04', 'QC reference');
INSERT INTO `tbl_listworkcenter` VALUES ('11', 'P.05A', '05', 'QC FillPack');
INSERT INTO `tbl_listworkcenter` VALUES ('12', 'P.05A', '06', 'QC Maklon');
INSERT INTO `tbl_listworkcenter` VALUES ('13', 'P.05B', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('14', 'P.05C', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('15', 'P.05E', '01', 'Lab Mikro');
INSERT INTO `tbl_listworkcenter` VALUES ('16', 'P.05E', '02', 'Lab Kimia');
INSERT INTO `tbl_listworkcenter` VALUES ('17', 'P.06A', '01', 'Giling Gula');
INSERT INTO `tbl_listworkcenter` VALUES ('18', 'P.06A', '02', 'Granulasi');
INSERT INTO `tbl_listworkcenter` VALUES ('19', 'P.06A', '03', 'Mixing');
INSERT INTO `tbl_listworkcenter` VALUES ('20', 'P.06A', '04', 'Fillpack');
INSERT INTO `tbl_listworkcenter` VALUES ('21', 'P.06A', '05', 'Forming');
INSERT INTO `tbl_listworkcenter` VALUES ('22', 'P.06C', '01', 'Giling Gula');
INSERT INTO `tbl_listworkcenter` VALUES ('23', 'P.06C', '02', 'Granulasi');
INSERT INTO `tbl_listworkcenter` VALUES ('24', 'P.06C', '03', 'Mixing');
INSERT INTO `tbl_listworkcenter` VALUES ('25', 'P.06C', '04', 'Fillpack');
INSERT INTO `tbl_listworkcenter` VALUES ('26', 'P.06C', '05', 'Forming');
INSERT INTO `tbl_listworkcenter` VALUES ('27', 'P.06D', '01', 'Giling Gula');
INSERT INTO `tbl_listworkcenter` VALUES ('28', 'P.06D', '02', 'Granulasi');
INSERT INTO `tbl_listworkcenter` VALUES ('29', 'P.06D', '03', 'Mixing');
INSERT INTO `tbl_listworkcenter` VALUES ('30', 'P.06D', '04', 'Fillpack');
INSERT INTO `tbl_listworkcenter` VALUES ('31', 'P.06D', '05', 'Forming');
INSERT INTO `tbl_listworkcenter` VALUES ('32', 'P.06E', '01', 'Giling Gula');
INSERT INTO `tbl_listworkcenter` VALUES ('33', 'P.06E', '02', 'Granulasi');
INSERT INTO `tbl_listworkcenter` VALUES ('34', 'P.06E', '03', 'Mixing');
INSERT INTO `tbl_listworkcenter` VALUES ('35', 'P.06E', '04', 'Fillpack');
INSERT INTO `tbl_listworkcenter` VALUES ('36', 'P.06E', '05', 'Forming');
INSERT INTO `tbl_listworkcenter` VALUES ('37', 'P.06B', '01', 'Giling Gula');
INSERT INTO `tbl_listworkcenter` VALUES ('38', 'P.06B', '02', 'Granulasi');
INSERT INTO `tbl_listworkcenter` VALUES ('39', 'P.06B', '03', 'Mixing');
INSERT INTO `tbl_listworkcenter` VALUES ('40', 'P.06B', '04', 'Fillpack');
INSERT INTO `tbl_listworkcenter` VALUES ('41', 'P.06B', '05', 'Forming');
INSERT INTO `tbl_listworkcenter` VALUES ('42', 'P.06B', '06', 'Sosoh');
INSERT INTO `tbl_listworkcenter` VALUES ('43', 'P.07', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('44', 'P.08A', '01', 'Penerimaan');
INSERT INTO `tbl_listworkcenter` VALUES ('45', 'P.08A', '02', 'Penyimpanan');
INSERT INTO `tbl_listworkcenter` VALUES ('46', 'P.08A', '03', 'Persiapan');
INSERT INTO `tbl_listworkcenter` VALUES ('47', 'P.08B', '01', 'Penerimaan');
INSERT INTO `tbl_listworkcenter` VALUES ('48', 'P.08B', '02', 'Penyimpanan');
INSERT INTO `tbl_listworkcenter` VALUES ('49', 'P.08B', '03', 'Picking');
INSERT INTO `tbl_listworkcenter` VALUES ('50', 'P.08B', '04', 'Pengiriman');
INSERT INTO `tbl_listworkcenter` VALUES ('51', 'P.09', '01', 'Prosessing');
INSERT INTO `tbl_listworkcenter` VALUES ('52', 'P.09', '02', 'Fillpack');
INSERT INTO `tbl_listworkcenter` VALUES ('53', 'P.09', '03', 'Utility');
INSERT INTO `tbl_listworkcenter` VALUES ('54', 'P.10', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('55', 'P.11', '01', 'Limbah padat-cair');
INSERT INTO `tbl_listworkcenter` VALUES ('56', 'P.11', '02', 'Sanitasi-cleaning');
INSERT INTO `tbl_listworkcenter` VALUES ('57', 'P.11', '03', 'Perlengkapan Kerja');
INSERT INTO `tbl_listworkcenter` VALUES ('58', 'P.14', '01', '');
INSERT INTO `tbl_listworkcenter` VALUES ('59', 'R.01', '01', 'Pengembangan dan Perbaikan Produk');
INSERT INTO `tbl_listworkcenter` VALUES ('60', 'R.01', '02', 'R&D Support');
INSERT INTO `tbl_listworkcenter` VALUES ('61', 'P.04', '02', 'Perencanaan pembelian RM');

-- ----------------------------
-- Table structure for tbl_pand
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pand`;
CREATE TABLE `tbl_pand` (
  `no_pand` int(11) NOT NULL AUTO_INCREMENT,
  `nm_pand` varchar(255) NOT NULL,
  `kt_pand` text,
  `fl_pand` varchar(255) NOT NULL,
  `up_pand` varchar(255) NOT NULL,
  PRIMARY KEY (`no_pand`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_pand
-- ----------------------------
INSERT INTO `tbl_pand` VALUES ('5', 'Cara1', 'Keterangan1', 'file_upload/user_guide/Cara1/isinya1.txt', 'admin');

-- ----------------------------
-- Table structure for tbl_status
-- ----------------------------
DROP TABLE IF EXISTS `tbl_status`;
CREATE TABLE `tbl_status` (
  `id_status` int(11) NOT NULL,
  `nm_status` varchar(255) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_status
-- ----------------------------
INSERT INTO `tbl_status` VALUES ('1', 'Progress');
INSERT INTO `tbl_status` VALUES ('2', 'Pending FDH');
INSERT INTO `tbl_status` VALUES ('3', 'Pending SPD');

-- ----------------------------
-- Table structure for un_prosedur
-- ----------------------------
DROP TABLE IF EXISTS `un_prosedur`;
CREATE TABLE `un_prosedur` (
  `no_prosedur` int(11) NOT NULL,
  `no_divisi_prosedur` int(11) NOT NULL,
  `no_master_prosedur` int(11) NOT NULL,
  `no_jenis_prosedur` int(11) NOT NULL,
  `detail_prosedur` varchar(200) NOT NULL,
  `nama_folder` text NOT NULL,
  `no_revisi` int(11) NOT NULL DEFAULT '1',
  `tgl_revisi` date DEFAULT NULL,
  `judul_file` text NOT NULL,
  `nama_file` text NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL DEFAULT 'aktif',
  `file_fmea` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of un_prosedur
-- ----------------------------
INSERT INTO `un_prosedur` VALUES ('38', '1', '1', '2', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '1', '2017-09-08', '1_isinya6.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/revisi/1_isinya6.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/1/isinya6.txt');
INSERT INTO `un_prosedur` VALUES ('40', '1', '1', '2', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '1', '2017-09-11', '1_isinya6.txt', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/revisi/1_isinya6.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/4/isinya6.txt');
INSERT INTO `un_prosedur` VALUES ('42', '1', '14', '2', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '1', '2017-09-13', '1_isinya1.txt', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/revisi/1_isinya1.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/8/isinya5.txt');
INSERT INTO `un_prosedur` VALUES ('42', '1', '14', '2', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2', '2017-09-13', '2_isinya7.txt', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/revisi/2_isinya7.txt', 'aktif', 'file_upload/upp_ik_fmea/2017/9/isinya1.txt');

-- ----------------------------
-- Table structure for upp
-- ----------------------------
DROP TABLE IF EXISTS `upp`;
CREATE TABLE `upp` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `no_upp` varchar(200) NOT NULL,
  `tgl_upp` date NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `pengaju` varchar(200) NOT NULL,
  `email_pengaju` varchar(200) NOT NULL,
  `pic1` varchar(200) NOT NULL,
  `pic2` varchar(200) NOT NULL,
  `no_divisi_prosedur` int(11) NOT NULL,
  `no_master_prosedur` int(11) NOT NULL,
  `nama_bb` varchar(200) NOT NULL,
  `no_jenis_prosedur` int(11) NOT NULL,
  `jenis_ik` int(11) DEFAULT NULL,
  `file_fmea` varchar(255) DEFAULT NULL,
  `detail_prosedur` varchar(200) NOT NULL,
  `nama_folder` text NOT NULL,
  `sebelumperubahan` text NOT NULL,
  `setelahperubahan` text NOT NULL,
  `alasan` text NOT NULL,
  `permohonan_tgl_berlaku` date NOT NULL,
  `file_user` text NOT NULL,
  `kat_perubahan` varchar(200) NOT NULL,
  `kat_mesin` varchar(200) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `cek_ddd` enum('ya','tidak') NOT NULL,
  `status` enum('validasi ik','batal','progress','approval','closed','approved','not approved','need to check') NOT NULL,
  `kat_delay` enum('','UPP mendadak','Delay Approval','UPP belum fix') NOT NULL,
  `tgl_batal` date NOT NULL,
  `alasan_batal` text NOT NULL,
  `tgl_kirim` datetime NOT NULL,
  `tgl_kirim1` date NOT NULL,
  `tgl_kirim2` date NOT NULL,
  `file_master` varchar(200) NOT NULL,
  `tgl_pic1` date NOT NULL,
  `tgl_pic2` date NOT NULL,
  `tgl_approved` datetime NOT NULL,
  `tgl_reject` date NOT NULL,
  `alasan_reject` text NOT NULL,
  `file_prosedur` text NOT NULL,
  `link_prosedur` varchar(200) NOT NULL,
  `tgl_berlaku` date NOT NULL,
  `tgl_sosialisasi` date NOT NULL,
  `tgl_filling` date NOT NULL,
  `tgl_distribusi` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `no_spd` varchar(200) NOT NULL,
  `tgl_pengecekan` date NOT NULL,
  `kesesuaian_dokumen` enum('','ok','tidak ok') NOT NULL,
  `keterangan` text NOT NULL,
  `no_revisi` varchar(200) NOT NULL,
  `no_revisi_cover` varchar(200) NOT NULL,
  `tgl_kepuasan` date NOT NULL,
  `kepuasan` enum('puas','tidak puas') NOT NULL,
  `alasan_kepuasan` text NOT NULL,
  `email_sosialisasi` text NOT NULL,
  `report1` enum('','ok','tidak ok') NOT NULL,
  `report2` enum('','ok','tidak ok') NOT NULL,
  `report3` enum('','ok','tidak ok') NOT NULL,
  `report4` enum('','ok','tidak ok') NOT NULL,
  `file_daftar_hadir` text,
  `ket_proses` text NOT NULL,
  `status_sementara` int(11) NOT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `no_upp` (`no_upp`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of upp
-- ----------------------------
INSERT INTO `upp` VALUES ('49', '2017', '9', '1/UPP/2017', '2017-09-08', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/1/isinya6.txt', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '2018-01-01', 'file_upload/upp_user/2017/1/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-08 14:20:14', '2017-09-08', '2017-09-08', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/1_isinya6.txt', '2017-09-08', '2017-09-08', '2017-09-08 09:20:40', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/revisi/1_isinya6.txt', '', '2017-09-08', '2017-09-08', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'aa', '', '', '', '', null, 'a', '1');
INSERT INTO `upp` VALUES ('50', '2017', '9', '2/UPP/2017', '2017-09-08', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '3', 'file_upload/upp_ik_fmea/2017/2/isinya5.txt', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '2018-01-01', 'file_upload/upp_user/2017/2/isinya5.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-08 14:29:10', '2017-09-08', '2017-09-08', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/2_isinya5.txt', '2017-09-08', '2017-09-08', '2017-09-08 09:29:18', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/isinya5.txt', '', '2017-09-08', '2017-09-08', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '2', '-', '0000-00-00', 'puas', '', 'aa', '', '', '', '', null, 'aawaw', '1');
INSERT INTO `upp` VALUES ('51', '2017', '9', '3/UPP/2017', '2017-09-08', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '13', '-', '4', '1', '', 'Percobaan_Nomor_1', 'Percobaan_Nomor_1', 'Percobaan_Nomor_1', 'Percobaan_Nomor_1', 'Percobaan_Nomor_1', '2018-01-01', 'file_upload/upp_user/2017/3/isinya1.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-08 14:36:43', '2017-09-08', '2017-09-08', 'file_upload/master_prosedur/P/P.06C/form_dan_catatan_mutu/Percobaan_Nomor_1/1_isinya1.txt', '2017-09-08', '2017-09-08', '2017-09-08 14:37:14', '0000-00-00', '', 'file_upload/prosedur/P/P.06C/form_dan_catatan_mutu/Percobaan_Nomor_1/isinya1.txt', '', '2017-09-08', '2017-09-08', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'aa', '', '', '', '', null, 'aws', '1');
INSERT INTO `upp` VALUES ('52', '2017', '9', '4/UPP/2017', '2017-09-11', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/4/isinya6.txt', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '2018-01-02', 'file_upload/upp_user/2017/4/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', 'Test', 'ya', 'need to check', '', '0000-00-00', '', '2017-09-11 08:07:27', '2017-09-11', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/1_isinya6.txt', '2017-09-11', '2017-09-11', '2017-09-11 03:07:35', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/revisi/1_isinya6.txt', '', '2017-09-11', '2017-09-11', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'test1@gmail.com', '', '', '', '', null, 'test1', '1');
INSERT INTO `upp` VALUES ('53', '2017', '9', '5/UPP/2017', '2017-09-11', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '3', 'file_upload/upp_ik_fmea/2017/5/isinya5.txt', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '2018-01-01', 'file_upload/upp_user/2017/5/isinya5.txt', 'Perubahan spesifikasi / parameter inspeksi QC', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-11 08:14:36', '2017-09-11', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/2_isinya5.txt', '2017-09-11', '2017-09-11', '2017-09-11 03:14:44', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/isinya5.txt', '', '2017-09-11', '2017-09-11', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '2', '-', '0000-00-00', 'puas', '', 'testing@test.vom', '', '', '', '', null, 'qqqq', '1');
INSERT INTO `upp` VALUES ('54', '2017', '9', '6/UPP/2017', '2017-09-11', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/6/isinya6.txt', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', '2018-01-01', 'file_upload/upp_user/2017/6/isinya5.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-11 08:19:48', '2017-09-11', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01B2-Perencanaan-TESTING IK BARU/1_isinya5.txt', '2017-09-11', '2017-09-11', '2017-09-11 03:19:57', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01B2-Perencanaan-TESTING IK BARU/isinya3.txt', '', '2017-09-11', '2017-09-11', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'eadfsafda', '', '', '', '', null, 'qq', '1');
INSERT INTO `upp` VALUES ('55', '2017', '9', '7/UPP/2017', '2017-09-13', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '14', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/7/isinya6.txt', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2018-03-03', 'file_upload/upp_user/2017/7/isinya5.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'validasi ik', '', '0000-00-00', '', '2017-09-13 08:13:15', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/1_isinya5.txt', '2017-09-13', '2017-09-13', '2017-09-13 03:13:26', '0000-00-00', '', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/revisi/1_isinya1.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'asw', '', '', '', '', null, 'IK P.06D03G4-Persiapan-Potansta', '1');
INSERT INTO `upp` VALUES ('56', '2017', '9', '8/UPP/2017', '2017-09-13', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '14', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/8/isinya5.txt', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2018-01-01', 'file_upload/upp_user/2017/8/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-13 08:24:23', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/2_isinya5.txt', '2017-09-13', '2017-09-13', '2017-09-13 03:27:32', '0000-00-00', '', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/isinya7.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'aqwwqa', '', '', '', '', null, 'aws', '1');
INSERT INTO `upp` VALUES ('57', '2017', '9', '9/UPP/2017', '2017-09-13', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '14', '-', '2', '3', 'file_upload/upp_ik_fmea/2017/9/isinya1.txt', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2018-01-01', 'file_upload/upp_user/2017/9/isinya1.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-13 10:39:44', '2017-09-13', '2017-09-13', '', '2017-09-13', '2017-09-13', '2017-09-13 05:40:10', '0000-00-00', '', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/revisi/2_isinya7.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '2', '-', '0000-00-00', 'puas', '', 'asw', '', '', '', '', null, 'aws', '1');
INSERT INTO `upp` VALUES ('58', '2017', '9', '10/UPP/2017', '2017-09-13', 'Ciawi', 'adsad', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '14', '-', '2', '3', 'file_upload/upp_ik_fmea/2017/10/isinya7.txt', 'Asw', 'IK P.06D03G4-Persiapan-Potansta', 'Asw', 'Asw', 'Asw', '2018-01-02', 'file_upload/upp_user/2017/10/isinya7.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-13 10:47:00', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/3_isinya7.txt', '2017-09-13', '2017-09-13', '2017-09-13 05:47:10', '0000-00-00', '', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/isinya7.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '3', '-', '0000-00-00', 'puas', '', 'asw', '', '', '', '', null, 'AWDSA', '1');
INSERT INTO `upp` VALUES ('60', '2017', '9', '11/UPP/2017', '2017-09-13', 'Maklon', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '2', '84', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/11/isinya1.txt', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', '2018-01-01', 'file_upload/upp_user/2017/11/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-13 15:06:52', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/R/P.01D/intruksi_kerja/IK R.0101A2-Searching-Paku yang Hilang/1_isinya6.txt', '2017-09-13', '2017-09-13', '2017-09-13 10:07:01', '0000-00-00', '', 'file_upload/prosedur/R/P.01D/intruksi_kerja/IK R.0101A2-Searching-Paku yang Hilang/isinya1.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'IK R.0101A2-Searching-Paku yang Hilang', '', '', '', '', null, 'IK R.0101A2-Searching-Paku yang Hilang', '1');
INSERT INTO `upp` VALUES ('61', '2017', '9', '12/UPP/2017', '2017-09-18', 'Ciawi, Sentul, Cibitung', 'Sudimulya', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '81', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/12/xat.jpg', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', '2018-01-01', 'file_upload/upp_user/2017/12/xat.jpg', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'batal', '', '2017-09-18', 'Tarik Validasi Online', '2017-09-18 14:45:24', '2017-09-18', '2017-09-18', 'file_upload/master_prosedur/P/P.01B/intruksi_kerja/IK P.01B01M019-Validasi-Potansta/1_xat.jpg', '2017-09-18', '2017-09-18', '2017-09-18 09:45:34', '0000-00-00', '', 'file_upload/prosedur/P/P.01B/intruksi_kerja/IK P.01B01M019-Validasi-Potansta/xat.jpg', '', '2017-09-18', '2017-09-18', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'IK P.01B01M019-Validasi-Potansta', '', '', '', '', null, 'IK P.01B01M019-Validasi-Potansta', '1');
INSERT INTO `upp` VALUES ('62', '2017', '9', '13/UPP/2017', '2017-09-19', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/13/isinya1.txt', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', '2018-01-01', 'file_upload/upp_user/2017/13/isinya1.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-19 13:53:09', '2017-09-19', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.06D02C001-Maintenance-IK Coba Baru/1_isinya1.txt', '2017-09-19', '2017-09-19', '2017-09-19 08:53:23', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.06D02C001-Maintenance-IK Coba Baru/isinya6.txt', '', '2017-09-19', '2017-09-19', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'bmasajalha@yahoo.co.id', '', '', '', '', null, 'Ket1', '1');
INSERT INTO `upp` VALUES ('63', '2017', '9', '14/UPP/2017', '2017-09-19', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '3', 'file_upload/upp_ik_fmea/2017/14/isinya6.txt', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKCoba1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '2018-01-01', 'file_upload/upp_user/2017/14/isinya2.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-19 14:10:21', '2017-09-19', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/3_isinya2.txt', '2017-09-19', '2017-09-19', '2017-09-19 09:13:52', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIKCoba1/isinya3.txt', '', '2017-09-19', '2017-09-19', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'bima@bima.cm', '', '', '', '', null, 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '1');
INSERT INTO `upp` VALUES ('64', '2017', '9', '15/UPP/2017', '2017-09-19', 'Cibitung', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '3', 'file_upload/upp_ik_fmea/2017/15/isinya5.txt', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', '2018-01-01', 'file_upload/upp_user/2017/15/isinya5.txt', 'Perubahan cleaning (metode / frequensi / chemical)', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-19 15:26:22', '2017-09-19', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1/1_isinya5.txt', '2017-09-19', '2017-09-19', '2017-09-19 10:26:30', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1/isinya5.txt', '', '2017-09-19', '2017-09-19', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'asw', '', '', '', '', null, 'IK P.01A01A3-Perencanaan-IKIKIKIKIKDicobalagi1', '1');
INSERT INTO `upp` VALUES ('65', '2017', '9', '16/UPP/2017', '2017-09-19', 'Cibitung', 'Sudimulya', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '10', '-', '1', '1', '', 'ASw', 'ASwASw', 'ASw', 'ASw', 'ASw', '2018-01-01', 'file_upload/upp_user/2017/16/isinya3.txt', 'Modifikasi alat / mesin eksis', 'Process', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', 'need to check', '', '0000-00-00', '', '2017-09-19 15:27:52', '2017-09-19', '2017-09-19', 'file_upload/master_prosedur/P/P.05E/prosedur/ASwASw/1_isinya3.txt', '2017-09-19', '2017-09-19', '2017-09-19 10:27:58', '0000-00-00', '', 'file_upload/prosedur/P/P.05E/prosedur/ASwASw/isinya3.txt', '', '2017-09-19', '2017-09-19', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'ASwASw', '', '', '', '', null, 'ASwASw', '1');

-- ----------------------------
-- Table structure for validasi_ik
-- ----------------------------
DROP TABLE IF EXISTS `validasi_ik`;
CREATE TABLE `validasi_ik` (
  `no` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `no_upp` varchar(200) NOT NULL,
  `tgl_upp` date NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `pengaju` varchar(200) NOT NULL,
  `email_pengaju` varchar(200) NOT NULL,
  `pic1` varchar(200) NOT NULL,
  `pic2` varchar(200) NOT NULL,
  `no_divisi_prosedur` int(11) NOT NULL,
  `no_master_prosedur` int(11) NOT NULL,
  `nama_bb` varchar(200) NOT NULL,
  `no_jenis_prosedur` int(11) NOT NULL,
  `jenis_ik` int(11) DEFAULT NULL,
  `file_fmea` varchar(255) DEFAULT NULL,
  `detail_prosedur` varchar(200) NOT NULL,
  `nama_folder` text NOT NULL,
  `sebelumperubahan` text NOT NULL,
  `setelahperubahan` text NOT NULL,
  `alasan` text NOT NULL,
  `permohonan_tgl_berlaku` date NOT NULL,
  `file_user` text NOT NULL,
  `kat_perubahan` varchar(200) NOT NULL,
  `kat_mesin` varchar(200) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `cek_ddd` enum('ya','tidak') NOT NULL,
  `status` enum('','batal','progress','approval','closed','approved','not approved','need to check') NOT NULL,
  `kat_delay` enum('','UPP mendadak','Delay Approval','UPP belum fix') NOT NULL,
  `tgl_batal` date NOT NULL,
  `alasan_batal` text NOT NULL,
  `tgl_kirim` datetime NOT NULL,
  `tgl_kirim1` date NOT NULL,
  `tgl_kirim2` date NOT NULL,
  `file_master` varchar(200) NOT NULL,
  `tgl_pic1` date NOT NULL,
  `tgl_pic2` date NOT NULL,
  `tgl_approved` datetime NOT NULL,
  `tgl_reject` date NOT NULL,
  `alasan_reject` text NOT NULL,
  `file_prosedur` text NOT NULL,
  `link_prosedur` varchar(200) NOT NULL,
  `tgl_berlaku` date NOT NULL,
  `tgl_sosialisasi` date NOT NULL,
  `tgl_filling` date NOT NULL,
  `tgl_distribusi` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `no_spd` varchar(200) NOT NULL,
  `tgl_pengecekan` date NOT NULL,
  `kesesuaian_dokumen` enum('','ok','tidak ok') NOT NULL,
  `keterangan` text NOT NULL,
  `no_revisi` varchar(200) NOT NULL,
  `no_revisi_cover` varchar(200) NOT NULL,
  `tgl_kepuasan` date NOT NULL,
  `kepuasan` enum('puas','tidak puas') NOT NULL,
  `alasan_kepuasan` text NOT NULL,
  `email_sosialisasi` text NOT NULL,
  `report1` enum('','ok','tidak ok') NOT NULL,
  `report2` enum('','ok','tidak ok') NOT NULL,
  `report3` enum('','ok','tidak ok') NOT NULL,
  `report4` enum('','ok','tidak ok') NOT NULL,
  `file_daftar_hadir` text,
  `ket_proses` text NOT NULL,
  `status_sementara` int(11) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of validasi_ik
-- ----------------------------
INSERT INTO `validasi_ik` VALUES ('49', '2017', '9', '1/UPP/2017', '2017-09-08', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/1/isinya6.txt', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', 'IK P.01A01C4-Verifikasi-Granulasi Air Keran', '2018-01-01', 'file_upload/upp_user/2017/1/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-08 14:20:14', '2017-09-08', '2017-09-08', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/1_isinya6.txt', '2017-09-08', '2017-09-08', '2017-09-08 09:20:40', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01C4-Verifikasi-Granulasi Air Keran/isinya6.txt', '', '2017-09-08', '2017-09-08', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'aa', '', '', '', '', null, 'a', '1');
INSERT INTO `validasi_ik` VALUES ('52', '2017', '9', '4/UPP/2017', '2017-09-11', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/4/isinya6.txt', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', 'IK P.01A01A3-Perencanaan-IKIKIKIKIK', '2018-01-02', 'file_upload/upp_user/2017/4/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', 'Test', 'ya', '', '', '0000-00-00', '', '2017-09-11 08:07:27', '2017-09-11', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/1_isinya6.txt', '2017-09-11', '2017-09-11', '2017-09-11 03:07:35', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01A3-Perencanaan-IKIKIKIKIK/isinya6.txt', '', '2017-09-11', '2017-09-11', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'test1@gmail.com', '', '', '', '', null, 'test1', '1');
INSERT INTO `validasi_ik` VALUES ('54', '2017', '9', '6/UPP/2017', '2017-09-11', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/6/isinya6.txt', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', 'IK P.01A01B2-Perencanaan-TESTING IK BARU', '2018-01-01', 'file_upload/upp_user/2017/6/isinya5.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-11 08:19:48', '2017-09-11', '2017-09-11', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.01A01B2-Perencanaan-TESTING IK BARU/1_isinya5.txt', '2017-09-11', '2017-09-11', '2017-09-11 03:19:57', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.01A01B2-Perencanaan-TESTING IK BARU/isinya3.txt', '', '2017-09-11', '2017-09-11', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'eadfsafda', '', '', '', '', null, 'qq', '1');
INSERT INTO `validasi_ik` VALUES ('55', '2017', '9', '7/UPP/2017', '2017-09-13', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '14', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/7/isinya6.txt', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2018-03-03', 'file_upload/upp_user/2017/7/isinya5.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-13 08:13:15', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/1_isinya5.txt', '2017-09-13', '2017-09-13', '2017-09-13 03:13:26', '0000-00-00', '', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/isinya5.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'asw', '', '', '', '', null, 'IK P.06D03G4-Persiapan-Potansta', '1');
INSERT INTO `validasi_ik` VALUES ('56', '2017', '9', '8/UPP/2017', '2017-09-13', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '14', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/8/isinya5.txt', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', 'IK P.06D03G4-Persiapan-Potansta', '2018-01-01', 'file_upload/upp_user/2017/8/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-13 08:24:23', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/2_isinya5.txt', '2017-09-13', '2017-09-13', '2017-09-13 03:27:32', '0000-00-00', '', 'file_upload/prosedur/P/P.06D/intruksi_kerja/IK P.06D03G4-Persiapan-Potansta/isinya7.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'aqwwqa', '', '', '', '', null, 'aws', '1');
INSERT INTO `validasi_ik` VALUES ('60', '2017', '9', '11/UPP/2017', '2017-09-13', 'Maklon', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '2', '84', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/11/isinya1.txt', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', 'IK R.0101A2-Searching-Paku yang Hilang', '2018-01-01', 'file_upload/upp_user/2017/11/isinya6.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-13 15:06:52', '2017-09-13', '2017-09-13', 'file_upload/master_prosedur/R/P.01D/intruksi_kerja/IK R.0101A2-Searching-Paku yang Hilang/1_isinya6.txt', '2017-09-13', '2017-09-13', '2017-09-13 10:07:01', '0000-00-00', '', 'file_upload/prosedur/R/P.01D/intruksi_kerja/IK R.0101A2-Searching-Paku yang Hilang/isinya1.txt', '', '2017-09-13', '2017-09-13', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'IK R.0101A2-Searching-Paku yang Hilang', '', '', '', '', null, 'IK R.0101A2-Searching-Paku yang Hilang', '1');
INSERT INTO `validasi_ik` VALUES ('61', '2017', '9', '12/UPP/2017', '2017-09-18', 'Ciawi, Sentul, Cibitung', 'Sudimulya', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '81', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/12/xat.jpg', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', 'IK P.01B01M019-Validasi-Potansta', '2018-01-01', 'file_upload/upp_user/2017/12/xat.jpg', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-18 14:45:24', '2017-09-18', '2017-09-18', 'file_upload/master_prosedur/P/P.01B/intruksi_kerja/IK P.01B01M019-Validasi-Potansta/1_xat.jpg', '2017-09-18', '2017-09-18', '2017-09-18 09:45:34', '0000-00-00', '', 'file_upload/prosedur/P/P.01B/intruksi_kerja/IK P.01B01M019-Validasi-Potansta/xat.jpg', '', '2017-09-18', '2017-09-18', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'IK P.01B01M019-Validasi-Potansta', '', '', '', '', null, 'IK P.01B01M019-Validasi-Potansta', '1');
INSERT INTO `validasi_ik` VALUES ('62', '2017', '9', '13/UPP/2017', '2017-09-19', 'Ciawi', 'Bima Putra S', 'admin@admin.admin', 'admin@admin.admin', 'admin@admin.admin', '1', '1', '-', '2', '2', 'file_upload/upp_ik_fmea/2017/13/isinya1.txt', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', 'IK P.06D02C001-Maintenance-IK Coba Baru', '2018-01-01', 'file_upload/upp_user/2017/13/isinya1.txt', 'Modifikasi alat / mesin eksis', 'Utility', '484ea5618aaf3e9c851c28c6dbca6a1f', 'tidak', '', '', '0000-00-00', '', '2017-09-19 13:53:09', '2017-09-19', '2017-09-19', 'file_upload/master_prosedur/P/P.01A/intruksi_kerja/IK P.06D02C001-Maintenance-IK Coba Baru/1_isinya1.txt', '2017-09-19', '2017-09-19', '2017-09-19 08:53:23', '0000-00-00', '', 'file_upload/prosedur/P/P.01A/intruksi_kerja/IK P.06D02C001-Maintenance-IK Coba Baru/isinya6.txt', '', '2017-09-19', '2017-09-19', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '1', '-', '0000-00-00', 'puas', '', 'bmasajalha@yahoo.co.id', '', '', '', '', null, 'Ket1', '1');

-- ----------------------------
-- Table structure for validasi_ik_tmp
-- ----------------------------
DROP TABLE IF EXISTS `validasi_ik_tmp`;
CREATE TABLE `validasi_ik_tmp` (
  `no_upp` varchar(200) NOT NULL,
  `vi_status_ik` enum('Percobaan','Expired') NOT NULL DEFAULT 'Percobaan',
  `vi_file` varchar(255) DEFAULT NULL,
  `vi_status_lj` varchar(255) DEFAULT NULL,
  `vi_tgl_penarikan` date DEFAULT NULL,
  `vi_alasan_penarikan` text,
  `vi_list_email` text NOT NULL,
  `vi_pic_email` varchar(255) DEFAULT NULL,
  `vi_pic_app` date DEFAULT NULL,
  PRIMARY KEY (`no_upp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of validasi_ik_tmp
-- ----------------------------
INSERT INTO `validasi_ik_tmp` VALUES ('1/UPP/2017', 'Expired', 'file_upload/upp_ik_fmea/2017/1/review/isinya6.txt', 'Berlaku', null, null, '', 'admin@admin.admin', '2017-09-08');
INSERT INTO `validasi_ik_tmp` VALUES ('11/UPP/2017', 'Expired', 'file_upload/upp_ik_fmea/2017/11/review/isinya3.txt', 'Berlaku', null, null, '', 'admin@admin.admin', '2017-09-13');
INSERT INTO `validasi_ik_tmp` VALUES ('12/UPP/2017', 'Expired', null, 'Tarik', '2017-09-18', 'Potaaaa', '', null, null);
INSERT INTO `validasi_ik_tmp` VALUES ('13/UPP/2017', 'Expired', 'file_upload/upp_ik_fmea/2017/13/review/isinya6.txt', 'Berlaku', null, null, '', 'admin@admin.admin', '2017-09-19');
INSERT INTO `validasi_ik_tmp` VALUES ('4/UPP/2017', 'Expired', 'file_upload/upp_ik_fmea/2017/4/review/isinya6.txt', 'Berlaku', null, null, 'admin@admin.admin,\r\nbima@gmail.com', 'admin@admin.admin', '2017-09-11');
INSERT INTO `validasi_ik_tmp` VALUES ('6/UPP/2017', 'Expired', 'file_upload/upp_ik_fmea/2017/6/review/isinya4.txt', 'Berlaku', null, null, '', 'admin@admin.admin', '2017-09-11');
INSERT INTO `validasi_ik_tmp` VALUES ('7/UPP/2017', 'Expired', null, 'Tarik', '2017-09-13', 'asw', '', null, null);
INSERT INTO `validasi_ik_tmp` VALUES ('8/UPP/2017', 'Expired', 'file_upload/upp_ik_fmea/2017/8/review/isinya7.txt', 'Berlakukan - Waiting Approval', null, null, '', 'admin@admin.admin', '2017-09-13');
SET FOREIGN_KEY_CHECKS=1;
