/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pemkos

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-07-06 22:41:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `anak_kos`
-- ----------------------------
DROP TABLE IF EXISTS `anak_kos`;
CREATE TABLE `anak_kos` (
  `id_anak_kos` int(5) NOT NULL AUTO_INCREMENT,
  `id_kamar` int(5) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `foto` varchar(225) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id_anak_kos`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of anak_kos
-- ----------------------------
INSERT INTO `anak_kos` VALUES ('65', '13', 'coki', '12', 'L', '0812', 'jl  jakarta', '2024-07-06', '', '123');
INSERT INTO `anak_kos` VALUES ('66', '19', 'gaga', '123', 'L', '0823', 'jl surabaya', '2024-07-06', '', '123');

-- ----------------------------
-- Table structure for `bill`
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `id_bill` int(5) NOT NULL AUTO_INCREMENT,
  `id_anak_kos` int(11) NOT NULL,
  `tgl_bill` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `status` int(5) NOT NULL,
  `metode_pembayaran` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_bill`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of bill
-- ----------------------------
INSERT INTO `bill` VALUES ('42', '66', '2024-01-06', '750000', '1', 'cash');
INSERT INTO `bill` VALUES ('43', '65', '2024-01-06', '500000', '0', null);

-- ----------------------------
-- Table structure for `kamar`
-- ----------------------------
DROP TABLE IF EXISTS `kamar`;
CREATE TABLE `kamar` (
  `id_kamar` int(5) NOT NULL AUTO_INCREMENT,
  `id_kos` int(5) NOT NULL,
  `kode` varchar(25) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `fasilitas` varchar(225) NOT NULL,
  `biaya` int(11) NOT NULL,
  `foto` varchar(225) NOT NULL,
  `status_kamar` int(11) NOT NULL,
  PRIMARY KEY (`id_kamar`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of kamar
-- ----------------------------
INSERT INTO `kamar` VALUES ('13', '2', '001', 'Single', 'P', 'AC, Kamar mandi dalam, meja kerja, tv ', '500000', '666a69d213953.png', '1');
INSERT INTO `kamar` VALUES ('15', '2', '467', 'ok', 'P', 'ok', '1000000', '666c2936175cd.png', '0');
INSERT INTO `kamar` VALUES ('19', '1', '16', 'small', 'L', 'ac, tempat tidur, meja', '750000', '6687782ebc766.png', '1');
INSERT INTO `kamar` VALUES ('20', '1', 'coc', 'medium', 'L', 'ac, lemari', '800000', '66879cdcd183a.png', '0');

-- ----------------------------
-- Table structure for `kos`
-- ----------------------------
DROP TABLE IF EXISTS `kos`;
CREATE TABLE `kos` (
  `id_kos` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kos` varchar(25) NOT NULL,
  PRIMARY KEY (`id_kos`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of kos
-- ----------------------------
INSERT INTO `kos` VALUES ('1', 'KOS 1');
INSERT INTO `kos` VALUES ('2', 'KOS 2');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `password` varchar(55) NOT NULL,
  `status` enum('aktif','block') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('20', 'admin', '1111', '123', 'aktif');
