/*
 Navicat Premium Data Transfer

 Source Server         : โรงพิมพ์สันติภาพ
 Source Server Type    : MariaDB
 Source Server Version : 100311
 Source Host           : 203.150.78.203:3306
 Source Schema         : santipab

 Target Server Type    : MariaDB
 Target Server Version : 100311
 File Encoding         : 65001

 Date: 25/07/2019 10:06:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `auth_assignment_user_id_idx`(`user_id`) USING BTREE,
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('admin', '1', 1545056711);
INSERT INTO `auth_assignment` VALUES ('admin', '13', 1553834062);
INSERT INTO `auth_assignment` VALUES ('user', '11', 1545188565);
INSERT INTO `auth_assignment` VALUES ('user', '12', 1545192169);
INSERT INTO `auth_assignment` VALUES ('user', '2', 1545115852);
INSERT INTO `auth_assignment` VALUES ('user', '3', 1545116188);
INSERT INTO `auth_assignment` VALUES ('user', '4', 1545116268);

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `data` blob NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/*', 2, NULL, NULL, NULL, 1545056519, 1545056519);
INSERT INTO `auth_item` VALUES ('/site/*', 2, NULL, NULL, NULL, 1545056525, 1545056525);
INSERT INTO `auth_item` VALUES ('/user/settings/*', 2, NULL, NULL, NULL, 1545056552, 1545056552);
INSERT INTO `auth_item` VALUES ('admin', 1, NULL, NULL, NULL, 1545056606, 1545056606);
INSERT INTO `auth_item` VALUES ('App', 2, NULL, NULL, NULL, 1545056593, 1545056593);
INSERT INTO `auth_item` VALUES ('Profile', 2, 'ข้อมูลส่วนตัว', NULL, NULL, 1545056572, 1545056572);
INSERT INTO `auth_item` VALUES ('user', 1, NULL, NULL, NULL, 1545106525, 1545106525);

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('admin', '/*');
INSERT INTO `auth_item_child` VALUES ('admin', 'App');
INSERT INTO `auth_item_child` VALUES ('admin', 'Profile');
INSERT INTO `auth_item_child` VALUES ('App', '/site/*');
INSERT INTO `auth_item_child` VALUES ('Profile', '/user/settings/*');
INSERT INTO `auth_item_child` VALUES ('user', 'App');
INSERT INTO `auth_item_child` VALUES ('user', 'Profile');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` blob NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for auto_number
-- ----------------------------
DROP TABLE IF EXISTS `auto_number`;
CREATE TABLE `auto_number`  (
  `group` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` int(11) NULL DEFAULT NULL,
  `optimistic_lock` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`group`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auto_number
-- ----------------------------
INSERT INTO `auto_number` VALUES ('05ad9541cfdd57495a55d53c197341cf', 14, 13, 1547112834);
INSERT INTO `auto_number` VALUES ('0e3762718b3badc7c5bf7c0ca5be6af7', 9, 8, 1563855528);
INSERT INTO `auto_number` VALUES ('115aee6886fb14bacf70789686cb4a8f', 2, 1, 1548084070);
INSERT INTO `auto_number` VALUES ('13af8b6c435422ff246c091a4a994e93', 19, 18, 1563873637);
INSERT INTO `auto_number` VALUES ('148e99460b20f2e2408c6e7f92d19e8f', 1, NULL, 1563936751);
INSERT INTO `auto_number` VALUES ('160275192b1cf070d355d510f2f00f7f', 7, 6, 1563857245);
INSERT INTO `auto_number` VALUES ('1781a2a4bc36a2e63c9216071173b7cd', 1, NULL, 1547366134);
INSERT INTO `auto_number` VALUES ('2fffe6fe1672abb559bbc71c122b6382', 5, 4, 1547365191);
INSERT INTO `auto_number` VALUES ('34fd5c32131a381556dee5606d0f474b', 2, 1, 1563789149);
INSERT INTO `auto_number` VALUES ('3bed554304dc1964a5d18f9ec2bb6e0b', 4, 3, 1563869198);
INSERT INTO `auto_number` VALUES ('3dc9d4da488e68689fed892022db3c5f', 1, NULL, 1547614959);
INSERT INTO `auto_number` VALUES ('41120e32d92b74b0f6dea9685a7c1925', 2, 1, 1564022468);
INSERT INTO `auto_number` VALUES ('42b4811dc1f7b16608733019c4184162', 77, 76, 1563852086);
INSERT INTO `auto_number` VALUES ('4311d276f83fb6542b046b04d44998ef', 3, 2, 1548925177);
INSERT INTO `auto_number` VALUES ('46385349dfa34b3c00eb32e6f99b20e1', 4, 3, 1548322104);
INSERT INTO `auto_number` VALUES ('4eccfc65df194d88c011db4f242eaa20', 11, 10, 1547615224);
INSERT INTO `auto_number` VALUES ('5015530f4642d6508c908cacaec53e31', 53, 52, 1563951662);
INSERT INTO `auto_number` VALUES ('5c679dd549f987a8a9666e852bcc0f07', 1, NULL, 1563956473);
INSERT INTO `auto_number` VALUES ('5d790029966eb95421d5017e7dd94132', 4, 3, 1547186196);
INSERT INTO `auto_number` VALUES ('6b28e9cfacd9966282b45f7b62571792', 1, NULL, 1554259054);
INSERT INTO `auto_number` VALUES ('736f9a6b5abeac6ed79c6514322f6f08', 3, 2, 1563855264);
INSERT INTO `auto_number` VALUES ('787b9754a1de68048520d31240fd250a', 5, 4, 1548058888);
INSERT INTO `auto_number` VALUES ('78fe72ceb344524afac86433094564e5', 1, NULL, 1559890995);
INSERT INTO `auto_number` VALUES ('802fdaf8090c5062b25b17f275cacb6a', 2, 1, 1548233656);
INSERT INTO `auto_number` VALUES ('80bddb44bdb0cc5703bb1db91c64e97b', 7, 6, 1547114437);
INSERT INTO `auto_number` VALUES ('81c7f21e6e507efc7f5a2199281c042b', 1, NULL, 1553834160);
INSERT INTO `auto_number` VALUES ('871717ec9fd7d82de4ccb3988217618f', 9, 8, 1547615068);
INSERT INTO `auto_number` VALUES ('8717ffc434b9dc576ea02ea696734ebc', 2, 1, 1559724812);
INSERT INTO `auto_number` VALUES ('8a3dac5787c50e706325a0f26b189a46', 1, NULL, 1554433759);
INSERT INTO `auto_number` VALUES ('9a614cec3b28cf7eaad89e4ff854193c', 1, NULL, 1560224649);
INSERT INTO `auto_number` VALUES ('9d8d97efc5ffde7cfd6b065e4ce4f720', 1, NULL, 1553700083);
INSERT INTO `auto_number` VALUES ('9dded4a35bac719be2524158c08a424e', 15, 14, 1563851823);
INSERT INTO `auto_number` VALUES ('a00383d9e582a583d30797af380cf49b', 5, 4, 1547365295);
INSERT INTO `auto_number` VALUES ('a00e2db3a300ba23c0f24d26a39959c5', 1, NULL, 1548298467);
INSERT INTO `auto_number` VALUES ('bb3f2db12ac4d8a8f919230b521bd94b', 6, 5, 1547365154);
INSERT INTO `auto_number` VALUES ('c2f70a20663722f24ad0144b2efe038d', 6, 5, 1548392599);
INSERT INTO `auto_number` VALUES ('c4dffeade2b36088e8e4e79f4148ffa0', 3, 2, 1553837002);
INSERT INTO `auto_number` VALUES ('d5edebc861751b8874aefe03d756cbe0', 10, 9, 1563873637);
INSERT INTO `auto_number` VALUES ('d73712c84cbef363b4d5af6eed8e9f7d', 5, 4, 1547365076);
INSERT INTO `auto_number` VALUES ('dbe099c1cca17381b00b0b26b4dccb48', 11, 10, 1563871240);
INSERT INTO `auto_number` VALUES ('deed1f1c3a1a7ecc54729be22bb7010a', 8, 7, 1547615161);
INSERT INTO `auto_number` VALUES ('dfc978044e41743a28f6ff8078cd6f42', 3, 2, 1548233966);
INSERT INTO `auto_number` VALUES ('e96c7e19c9b77a950f400be7677702f1', 1, NULL, 1554343805);
INSERT INTO `auto_number` VALUES ('e9ecc18f3e512237de4dc2c66b254f73', 6, 5, 1563852253);
INSERT INTO `auto_number` VALUES ('ee3237038204605c162d476ecc18f72f', 1, NULL, 1548587456);
INSERT INTO `auto_number` VALUES ('ffc3e576142970463ef0cbe90c803a5c', 4, 3, 1563852336);

-- ----------------------------
-- Table structure for file_attachment
-- ----------------------------
DROP TABLE IF EXISTS `file_attachment`;
CREATE TABLE `file_attachment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `base_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `size` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ref_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ref_table_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `upload_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of file_attachment
-- ----------------------------
INSERT INTO `file_attachment` VALUES (4, 'fileStorage', '/uploads', '/1/ypcaqHXsTRu-4THqFmf6rPE4EEkKon7b.png', 'image/png', 581323, 'Carlendar 01.png', 'P-2019032900001', 'tbl_product', '172.68.106.38', 1553832094);
INSERT INTO `file_attachment` VALUES (5, 'fileStorage', '/uploads', '/1/UjK50Vzi-5qAKmSwqAgxB3WCg18DlLbh.png', 'image/png', 626909, 'ปฎิทิน-3_03.png', 'P-2019032900001', 'tbl_product', '172.68.106.38', 1553832094);
INSERT INTO `file_attachment` VALUES (6, 'fileStorage', '/uploads', '/1/5O01hwNoWkDdONfGVN7gi_a7pfFSiogj.png', 'image/png', 965184, 'ปฎิทินุ0-6_03.png', 'P-2019032900001', 'tbl_product', '172.68.106.38', 1553832094);
INSERT INTO `file_attachment` VALUES (7, 'fileStorage', '/uploads', '/1/l3vjcnG59fQa0A-iRO1TPn-qR2KXMeMr.png', 'image/png', 627358, 'ปฏิทิน-1_03.png', 'P-2019032900001', 'tbl_product', '172.68.106.38', 1553832094);
INSERT INTO `file_attachment` VALUES (8, 'fileStorage', '/uploads', '/1/h6lkKTAFvldeVk8hiKyIAaiTsw2wrLLZ.jpg', 'image/jpeg', 469688, 'Book 1.JPG', 'P-2019032900002', 'tbl_product', '172.68.106.38', 1553832799);
INSERT INTO `file_attachment` VALUES (9, 'fileStorage', '/uploads', '/1/ognS-DoYqeyKjY5iK6AgW5Vg0Ke7Ta8c.png', 'image/png', 386524, 'Book 2.png', 'P-2019032900002', 'tbl_product', '172.68.106.38', 1553832799);
INSERT INTO `file_attachment` VALUES (10, 'fileStorage', '/uploads', '/1/8V1E7JZXPgjYi5sVxZNpRxKeW-fKpB-p.jpg', 'image/jpeg', 642327, 'Book 3.JPG', 'P-2019032900002', 'tbl_product', '172.68.106.38', 1553832799);
INSERT INTO `file_attachment` VALUES (11, 'fileStorage', '/uploads', '/1/0wdvs79e83sLhAEddiTNFYB8mFT-KMH7.png', 'image/png', 292605, 'book-01-1_03.png', 'P-2019032900002', 'tbl_product', '172.68.106.38', 1553832799);
INSERT INTO `file_attachment` VALUES (12, 'fileStorage', '/uploads', '/1/ItTvc1VD5lrD3NmUg1tlj7o7iNGsLblV.png', 'image/png', 661416, 'Leaflets (2).png', 'P-20190121-00002', 'tbl_product', '172.68.106.98', 1553832941);
INSERT INTO `file_attachment` VALUES (13, 'fileStorage', '/uploads', '/1/wTv_xXvEWAuBzwMgaJ7O3ycpHQ-qCSiV.jpg', 'image/jpeg', 73314, 'Leaflets (10).jpg', 'P-20190121-00002', 'tbl_product', '172.68.106.98', 1553832941);
INSERT INTO `file_attachment` VALUES (14, 'fileStorage', '/uploads', '/1/JzQy_vnbyEgCVEby9M3vtGSP88rrG3ov.jpg', 'image/jpeg', 48044, 'Leaflets (11).jpg', 'P-20190121-00002', 'tbl_product', '172.68.106.98', 1553832941);
INSERT INTO `file_attachment` VALUES (15, 'fileStorage', '/uploads', '/1/0iWOVAMJM28RfPQRwm-cOtj7L7o9RgFT.png', 'image/png', 411057, 'Label (1).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (16, 'fileStorage', '/uploads', '/1/6ll41URxgQ598Y2vNxINPD9P_xJAe5oY.png', 'image/png', 309273, 'Label (2).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (17, 'fileStorage', '/uploads', '/1/f6aiwKm7DB70fzxEb7K1DM0DL3l7Nbe0.png', 'image/png', 380008, 'Label (3).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (18, 'fileStorage', '/uploads', '/1/zROf7Rrz0wdQ50DHNVK0blc0IrmT7r0k.png', 'image/png', 411135, 'Label (10).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (19, 'fileStorage', '/uploads', '/1/Cl-bIj40Ou1uAfkzL2j7orWH_iSeLYjj.png', 'image/png', 516414, 'Label (11).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (20, 'fileStorage', '/uploads', '/1/t_BORnA3LzZNqJ9lR3smTZj3SYBbrUmZ.png', 'image/png', 413042, 'Label (12).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (21, 'fileStorage', '/uploads', '/1/zt4LycFsygG1pGmAwPhK69SzQX_IxFmZ.png', 'image/png', 437708, 'Label (20).png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (22, 'fileStorage', '/uploads', '/1/IhZXRX23A8gP5pBHUReHj9QxmfjBfU1u.png', 'image/png', 376951, 'สลาก-11_03.png', 'P-2019012400001', 'tbl_product', '162.158.6.62', 1553833777);
INSERT INTO `file_attachment` VALUES (23, 'fileStorage', '/uploads', '/1/TSxMaxBGuRR8Dz3ndzYHY29U_Ut6gh2R.png', 'image/png', 146290, '-02_03.png', 'P-2019032900003', 'tbl_product', '172.68.106.92', 1553837002);
INSERT INTO `file_attachment` VALUES (24, 'fileStorage', '/uploads', '/1/X6ahp9_d7V8P0Gt-Q7HtuULPrq4aYUPT.png', 'image/png', 801249, 'paperbag (1).png', 'P-2019032900003', 'tbl_product', '172.68.106.92', 1553837002);
INSERT INTO `file_attachment` VALUES (25, 'fileStorage', '/uploads', '/1/J9XtHBCbV-_9OSHpBJGrUZ16m_dl7XK6.jpg', 'image/jpeg', 1359517, 'paperbag (2).JPG', 'P-2019032900003', 'tbl_product', '172.68.106.92', 1553837002);
INSERT INTO `file_attachment` VALUES (26, 'fileStorage', '/uploads', '/1/OeTnX7UVdFrH6xj5lSUEkgZJzjEBnHgS.png', 'image/png', 112182, 'ถุง-1_03.png', 'P-2019032900003', 'tbl_product', '172.68.106.92', 1553837002);
INSERT INTO `file_attachment` VALUES (27, 'fileStorage', '/uploads', '/1/aRzpWP_0gnua7ovoJeySOXpeFtLeMQB8.jpg', 'image/jpeg', 82140, 'uTctphUDeXduFQbdjRtBY5DyEocIRAKj.jpg', 'P.20190121.00004', 'tbl_product', '172.68.106.98', 1554697597);

-- ----------------------------
-- Table structure for file_storage_item
-- ----------------------------
DROP TABLE IF EXISTS `file_storage_item`;
CREATE TABLE `file_storage_item`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `base_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `path` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `size` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `upload_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 108 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of file_storage_item
-- ----------------------------
INSERT INTO `file_storage_item` VALUES (10, 'fileStorage', '/uploads', '\\1\\a0R2WFeFqtYawLIB8h2SniZtDUaqHY8E.jpeg', 'image/jpeg', 330062, 'a0R2WFeFqtYawLIB8h2SniZtDUaqHY8E', '192.168.1.5', 1542738764);
INSERT INTO `file_storage_item` VALUES (12, 'fileStorage', '/uploads', '\\1\\aTM3vWgAB6IG2MGeqkxCiqJtsS-N9EKq.jpg', 'image/jpeg', 172102, 'aTM3vWgAB6IG2MGeqkxCiqJtsS-N9EKq', '192.168.1.15', 1542773169);
INSERT INTO `file_storage_item` VALUES (13, 'fileStorage', '/uploads', '\\1\\0uw2iyBjYAsFc7eLZg6Snec_m27BL_5L.jpeg', 'image/jpeg', 1189336, '0uw2iyBjYAsFc7eLZg6Snec_m27BL_5L', '192.168.1.5', 1542778193);
INSERT INTO `file_storage_item` VALUES (18, 'fileStorage', '/uploads', '\\1\\IqkFMNCpO2EiuZr1aYfsfbQt4681sym_.jpeg', 'image/jpeg', 1312243, 'IqkFMNCpO2EiuZr1aYfsfbQt4681sym_', '192.168.1.5', 1543236298);
INSERT INTO `file_storage_item` VALUES (19, 'fileStorage', '/uploads', '/1/HJBL2qvPvIy32n5unzjHaXMKL_vS7R6v.png', 'image/png', 25843, 'HJBL2qvPvIy32n5unzjHaXMKL_vS7R6v', '113.53.147.112', 1543407200);
INSERT INTO `file_storage_item` VALUES (21, 'fileStorage', '/uploads', '/1/8hGcCpVhEOXB4wELwRF1ZLP4rLzyGNvj.png', 'image/png', 25843, '8hGcCpVhEOXB4wELwRF1ZLP4rLzyGNvj', '172.68.106.92', 1543548850);
INSERT INTO `file_storage_item` VALUES (22, 'fileStorage', '/uploads', '/1/mj7apInGC3jzwkrT5Iz7OHEOjxMKzay4.jpeg', 'image/jpeg', 72061, 'mj7apInGC3jzwkrT5Iz7OHEOjxMKzay4', '172.68.106.98', 1543591002);
INSERT INTO `file_storage_item` VALUES (25, 'fileStorage', '/uploads', '/1/X-piW0Vnh9tENwf2Mqtx5Sy6itWVcXdk.jpeg', 'image/jpeg', 1312243, 'X-piW0Vnh9tENwf2Mqtx5Sy6itWVcXdk', '172.68.106.92', 1544085115);
INSERT INTO `file_storage_item` VALUES (24, 'fileStorage', '/uploads', '/1/ZeZyiEo8sfi9Xk2M8ql6pldhjXIG2CZW.png', 'image/png', 55200, 'ZeZyiEo8sfi9Xk2M8ql6pldhjXIG2CZW', '172.69.134.31', 1543911228);
INSERT INTO `file_storage_item` VALUES (26, 'fileStorage', '/uploads', '\\1\\ARZG3iEQNBUt-n7y9y5nN9ctTFShqZfW.jpg', 'image/jpeg', 61174, 'ARZG3iEQNBUt-n7y9y5nN9ctTFShqZfW', '127.0.0.1', 1545029219);
INSERT INTO `file_storage_item` VALUES (29, 'fileStorage', '/uploads', '\\1\\0D9e3h0Wmuep0Y6JfienIZRxpDgmfLVg.jpg', 'image/jpeg', 61174, '0D9e3h0Wmuep0Y6JfienIZRxpDgmfLVg', '127.0.0.1', 1545035249);
INSERT INTO `file_storage_item` VALUES (30, 'fileStorage', '/uploads', '/1/waI7BrOBfJUdH289GVcND45W7IrIRoOw.jpg', 'image/jpeg', 61174, 'waI7BrOBfJUdH289GVcND45W7IrIRoOw', '101.109.212.132', 1545187534);
INSERT INTO `file_storage_item` VALUES (31, 'fileStorage', '/uploads', '/1/r34CoKVq7KgwmhuUFK-odP-xXreE7vZf.jpeg', 'image/jpeg', 1312243, 'r34CoKVq7KgwmhuUFK-odP-xXreE7vZf', '101.109.212.132', 1545188614);
INSERT INTO `file_storage_item` VALUES (32, 'fileStorage', '/uploads', '/1/K3t91hDepAqxlEb8p3bLb3YldF8hQK9m.jpeg', 'image/jpeg', 1312243, 'K3t91hDepAqxlEb8p3bLb3YldF8hQK9m', '118.172.249.112', 1545195447);
INSERT INTO `file_storage_item` VALUES (33, 'fileStorage', '/uploads', '/1/nnGEZ0VOiXZ1PgGPCcwVCgLTrZYZ3Trh.png', 'image/png', 6037, 'nnGEZ0VOiXZ1PgGPCcwVCgLTrZYZ3Trh', '172.68.106.92', 1548392025);
INSERT INTO `file_storage_item` VALUES (61, 'fileStorage', '/uploads', '/1/DIEPxjR8zXU4c5OwuALp8sgjE-KYf7zH.jpg', 'image/jpeg', 1359517, 'DIEPxjR8zXU4c5OwuALp8sgjE-KYf7zH', '172.68.106.98', 1553836057);
INSERT INTO `file_storage_item` VALUES (100, 'fileStorage', '/uploads', '/1/SUgQqUXJ0Fb7RlDOzrYXys2TciHfD3h4.png', 'image/png', 414409, 'SUgQqUXJ0Fb7RlDOzrYXys2TciHfD3h4', '172.68.106.92', 1563867447);
INSERT INTO `file_storage_item` VALUES (98, 'fileStorage', '/uploads', '/1/JK6inJ9Fa0_Z4EdpSaSIF2q7viyhQtRe.png', 'image/png', 263025, 'JK6inJ9Fa0_Z4EdpSaSIF2q7viyhQtRe', '172.68.106.38', 1563864487);
INSERT INTO `file_storage_item` VALUES (97, 'fileStorage', '/uploads', '/1/dxDDzySjYX0jNM6jx5DCHM-TZbbZTVYm.png', 'image/png', 263025, 'dxDDzySjYX0jNM6jx5DCHM-TZbbZTVYm', '172.68.106.98', 1563861848);
INSERT INTO `file_storage_item` VALUES (38, 'fileStorage', '/uploads', '/1/ypcaqHXsTRu-4THqFmf6rPE4EEkKon7b.png', 'image/png', 581323, 'ypcaqHXsTRu-4THqFmf6rPE4EEkKon7b', '172.68.106.38', 1553832068);
INSERT INTO `file_storage_item` VALUES (39, 'fileStorage', '/uploads', '/1/UjK50Vzi-5qAKmSwqAgxB3WCg18DlLbh.png', 'image/png', 626909, 'UjK50Vzi-5qAKmSwqAgxB3WCg18DlLbh', '172.68.106.38', 1553832068);
INSERT INTO `file_storage_item` VALUES (40, 'fileStorage', '/uploads', '/1/5O01hwNoWkDdONfGVN7gi_a7pfFSiogj.png', 'image/png', 965184, '5O01hwNoWkDdONfGVN7gi_a7pfFSiogj', '172.68.106.38', 1553832068);
INSERT INTO `file_storage_item` VALUES (41, 'fileStorage', '/uploads', '/1/l3vjcnG59fQa0A-iRO1TPn-qR2KXMeMr.png', 'image/png', 627358, 'l3vjcnG59fQa0A-iRO1TPn-qR2KXMeMr', '172.68.106.38', 1553832068);
INSERT INTO `file_storage_item` VALUES (42, 'fileStorage', '/uploads', '/1/eExnnV87x15aBNqQzzylY9sECdrEct7u.png', 'image/png', 627358, 'eExnnV87x15aBNqQzzylY9sECdrEct7u', '172.68.106.38', 1553832089);
INSERT INTO `file_storage_item` VALUES (104, 'fileStorage', '/uploads', '/1/8ALOsY8oFzwWVoCooKftbvlptp-f0nsD.jpg', 'image/jpeg', 48044, '8ALOsY8oFzwWVoCooKftbvlptp-f0nsD', '172.68.106.98', 1563935153);
INSERT INTO `file_storage_item` VALUES (105, 'fileStorage', '/uploads', '/1/mMt_mZ82MiC7GcApHljVLT519nyJEKuE.png', 'image/png', 437708, 'mMt_mZ82MiC7GcApHljVLT519nyJEKuE', '172.68.106.98', 1563935532);
INSERT INTO `file_storage_item` VALUES (49, 'fileStorage', '/uploads', '/1/ItTvc1VD5lrD3NmUg1tlj7o7iNGsLblV.png', 'image/png', 661416, 'ItTvc1VD5lrD3NmUg1tlj7o7iNGsLblV', '172.68.106.38', 1553832939);
INSERT INTO `file_storage_item` VALUES (50, 'fileStorage', '/uploads', '/1/wTv_xXvEWAuBzwMgaJ7O3ycpHQ-qCSiV.jpg', 'image/jpeg', 73314, 'wTv_xXvEWAuBzwMgaJ7O3ycpHQ-qCSiV', '172.68.106.38', 1553832939);
INSERT INTO `file_storage_item` VALUES (51, 'fileStorage', '/uploads', '/1/JzQy_vnbyEgCVEby9M3vtGSP88rrG3ov.jpg', 'image/jpeg', 48044, 'JzQy_vnbyEgCVEby9M3vtGSP88rrG3ov', '172.68.106.38', 1553832939);
INSERT INTO `file_storage_item` VALUES (86, 'fileStorage', '/uploads', '/1/XNgEGcCyngZNim5O1rHC-CdmdGIZpRAk.png', 'image/png', 146290, 'XNgEGcCyngZNim5O1rHC-CdmdGIZpRAk', '162.158.204.160', 1554351520);
INSERT INTO `file_storage_item` VALUES (53, 'fileStorage', '/uploads', '/1/0iWOVAMJM28RfPQRwm-cOtj7L7o9RgFT.png', 'image/png', 411057, '0iWOVAMJM28RfPQRwm-cOtj7L7o9RgFT', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (54, 'fileStorage', '/uploads', '/1/6ll41URxgQ598Y2vNxINPD9P_xJAe5oY.png', 'image/png', 309273, '6ll41URxgQ598Y2vNxINPD9P_xJAe5oY', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (55, 'fileStorage', '/uploads', '/1/f6aiwKm7DB70fzxEb7K1DM0DL3l7Nbe0.png', 'image/png', 380008, 'f6aiwKm7DB70fzxEb7K1DM0DL3l7Nbe0', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (56, 'fileStorage', '/uploads', '/1/zROf7Rrz0wdQ50DHNVK0blc0IrmT7r0k.png', 'image/png', 411135, 'zROf7Rrz0wdQ50DHNVK0blc0IrmT7r0k', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (57, 'fileStorage', '/uploads', '/1/Cl-bIj40Ou1uAfkzL2j7orWH_iSeLYjj.png', 'image/png', 516414, 'Cl-bIj40Ou1uAfkzL2j7orWH_iSeLYjj', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (58, 'fileStorage', '/uploads', '/1/t_BORnA3LzZNqJ9lR3smTZj3SYBbrUmZ.png', 'image/png', 413042, 't_BORnA3LzZNqJ9lR3smTZj3SYBbrUmZ', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (59, 'fileStorage', '/uploads', '/1/zt4LycFsygG1pGmAwPhK69SzQX_IxFmZ.png', 'image/png', 437708, 'zt4LycFsygG1pGmAwPhK69SzQX_IxFmZ', '172.68.106.38', 1553833625);
INSERT INTO `file_storage_item` VALUES (60, 'fileStorage', '/uploads', '/1/IhZXRX23A8gP5pBHUReHj9QxmfjBfU1u.png', 'image/png', 376951, 'IhZXRX23A8gP5pBHUReHj9QxmfjBfU1u', '172.68.106.38', 1553833633);
INSERT INTO `file_storage_item` VALUES (62, 'fileStorage', '/uploads', '/1/TSxMaxBGuRR8Dz3ndzYHY29U_Ut6gh2R.png', 'image/png', 146290, 'TSxMaxBGuRR8Dz3ndzYHY29U_Ut6gh2R', '172.68.106.98', 1553836064);
INSERT INTO `file_storage_item` VALUES (63, 'fileStorage', '/uploads', '/1/X6ahp9_d7V8P0Gt-Q7HtuULPrq4aYUPT.png', 'image/png', 801249, 'X6ahp9_d7V8P0Gt-Q7HtuULPrq4aYUPT', '172.68.106.98', 1553836082);
INSERT INTO `file_storage_item` VALUES (64, 'fileStorage', '/uploads', '/1/J9XtHBCbV-_9OSHpBJGrUZ16m_dl7XK6.jpg', 'image/jpeg', 1359517, 'J9XtHBCbV-_9OSHpBJGrUZ16m_dl7XK6', '172.68.106.98', 1553836082);
INSERT INTO `file_storage_item` VALUES (65, 'fileStorage', '/uploads', '/1/OeTnX7UVdFrH6xj5lSUEkgZJzjEBnHgS.png', 'image/png', 112182, 'OeTnX7UVdFrH6xj5lSUEkgZJzjEBnHgS', '172.68.106.98', 1553836082);
INSERT INTO `file_storage_item` VALUES (81, 'fileStorage', '/uploads', '/1/QiduBNiPaFMRPEy5DZ92dpcWZ677E7Wi.png', 'image/png', 414992, 'QiduBNiPaFMRPEy5DZ92dpcWZ677E7Wi', '172.68.106.98', 1554111327);
INSERT INTO `file_storage_item` VALUES (82, 'fileStorage', '/uploads', '/1/PN8D3gxHu40-kidIwZup9_Ok_p3hGIy_.png', 'image/png', 661416, 'PN8D3gxHu40-kidIwZup9_Ok_p3hGIy_', '172.68.106.98', 1554111482);
INSERT INTO `file_storage_item` VALUES (71, 'fileStorage', '/uploads', '/1/FVQIdDg_64DFypEe72yBErV-nc4rd9fN.png', 'image/png', 292605, 'FVQIdDg_64DFypEe72yBErV-nc4rd9fN', '172.68.106.98', 1554099373);
INSERT INTO `file_storage_item` VALUES (101, 'fileStorage', '/uploads', '/1/Owb9j-tl7ipp8quD_SIP6dVNC-vtyMDv.png', 'image/png', 488488, 'Owb9j-tl7ipp8quD_SIP6dVNC-vtyMDv', '172.68.106.92', 1563867544);
INSERT INTO `file_storage_item` VALUES (72, 'fileStorage', '/uploads', '/1/kD_n9eKCNJ6A-ZhgCIj8Th0s7gxyTWwQ.jpg', 'image/jpeg', 642327, 'kD_n9eKCNJ6A-ZhgCIj8Th0s7gxyTWwQ', '172.68.106.98', 1554099508);
INSERT INTO `file_storage_item` VALUES (73, 'fileStorage', '/uploads', '/1/mM3gTXMCZUNdNYdbhcWfepEHfJpgnkTc.png', 'image/png', 661416, 'mM3gTXMCZUNdNYdbhcWfepEHfJpgnkTc', '172.68.106.98', 1554099581);
INSERT INTO `file_storage_item` VALUES (74, 'fileStorage', '/uploads', '/1/Fr41j4oJpg7AhEF3dGbp3RWeM1shi551.jpg', 'image/jpeg', 218780, 'Fr41j4oJpg7AhEF3dGbp3RWeM1shi551', '172.68.106.74', 1554104501);
INSERT INTO `file_storage_item` VALUES (75, 'fileStorage', '/uploads', '/1/LcW7eSM0hkTRV_vNqwLysCbHtVubsoL_.jpg', 'image/jpeg', 469987, 'LcW7eSM0hkTRV_vNqwLysCbHtVubsoL_', '172.68.106.74', 1554104577);
INSERT INTO `file_storage_item` VALUES (76, 'fileStorage', '/uploads', '/1/IszmMXwrV1oxvwKzdg0o5GqJ3UKfNcHm.png', 'image/png', 474386, 'IszmMXwrV1oxvwKzdg0o5GqJ3UKfNcHm', '172.68.106.98', 1554105035);
INSERT INTO `file_storage_item` VALUES (77, 'fileStorage', '/uploads', '/1/EVVGMb00DvM80jEupC8ygGiUZYubBkl8.png', 'image/png', 627358, 'EVVGMb00DvM80jEupC8ygGiUZYubBkl8', '172.68.106.74', 1554106167);
INSERT INTO `file_storage_item` VALUES (78, 'fileStorage', '/uploads', '/1/uiuFCB_pvMv-vqlGjy-R1ef2T4yCvph5.png', 'image/png', 581323, 'uiuFCB_pvMv-vqlGjy-R1ef2T4yCvph5', '172.68.106.74', 1554106221);
INSERT INTO `file_storage_item` VALUES (79, 'fileStorage', '/uploads', '/1/mhxcYB-Sm_Y3weSybyqemQMFdJoH9_OB.png', 'image/png', 580432, 'mhxcYB-Sm_Y3weSybyqemQMFdJoH9_OB', '172.68.106.74', 1554108447);
INSERT INTO `file_storage_item` VALUES (84, 'fileStorage', '/uploads', '/1/0QHtfLSLg7kkWB8IhEYNPWzvSF-LErgQ.png', 'image/png', 516414, '0QHtfLSLg7kkWB8IhEYNPWzvSF-LErgQ', '162.158.6.62', 1554172356);
INSERT INTO `file_storage_item` VALUES (107, 'fileStorage', '/uploads', '/1/ayKqvWWy-3qDRT8XUMg9i6sH0p3AiWU-.png', 'image/png', 734251, 'ayKqvWWy-3qDRT8XUMg9i6sH0p3AiWU-', '172.68.106.98', 1563936445);
INSERT INTO `file_storage_item` VALUES (87, 'fileStorage', '/uploads', '/1/P4LeU0-M2JoDblHIeKrbbavTbXM-AHt9.png', 'image/png', 112182, 'P4LeU0-M2JoDblHIeKrbbavTbXM-AHt9', '162.158.204.160', 1554351936);
INSERT INTO `file_storage_item` VALUES (88, 'fileStorage', '/uploads', '/1/w8T9aQLSesOQQPijcatYinVvTl2AKBWI.png', 'image/png', 146290, 'w8T9aQLSesOQQPijcatYinVvTl2AKBWI', '172.68.6.70', 1554353319);
INSERT INTO `file_storage_item` VALUES (89, 'fileStorage', '/uploads', '/1/KnvHZDAin84n1zLc3vrB2TXefN_xZ5zY.jpg', 'image/jpeg', 82140, 'KnvHZDAin84n1zLc3vrB2TXefN_xZ5zY', '172.68.6.70', 1554355601);
INSERT INTO `file_storage_item` VALUES (90, 'fileStorage', '/uploads', '/1/uTctphUDeXduFQbdjRtBY5DyEocIRAKj.jpg', 'image/jpeg', 82140, 'uTctphUDeXduFQbdjRtBY5DyEocIRAKj', '172.68.6.70', 1554355638);
INSERT INTO `file_storage_item` VALUES (91, 'fileStorage', '/uploads', '/1/L3bGsmMS6ixVDMPWEB49qrRnAMltT3q_.jpg', 'image/jpeg', 82140, 'L3bGsmMS6ixVDMPWEB49qrRnAMltT3q_', '172.68.106.98', 1554697588);
INSERT INTO `file_storage_item` VALUES (92, 'fileStorage', '/uploads', '/1/aRzpWP_0gnua7ovoJeySOXpeFtLeMQB8.jpg', 'image/jpeg', 82140, 'aRzpWP_0gnua7ovoJeySOXpeFtLeMQB8', '172.68.106.98', 1554697593);
INSERT INTO `file_storage_item` VALUES (102, 'fileStorage', '/uploads', '/1/8JTk8jcl9qjVh3fZYT2yxkdeONqf-h9Q.png', 'image/png', 309273, '8JTk8jcl9qjVh3fZYT2yxkdeONqf-h9Q', '172.68.106.92', 1563867597);
INSERT INTO `file_storage_item` VALUES (103, 'fileStorage', '/uploads', '/1/Pp9bm3Nve-rbb3qhyN5tbNxbZ1RFuYmI.png', 'image/png', 178544, 'Pp9bm3Nve-rbb3qhyN5tbNxbZ1RFuYmI', '172.68.106.92', 1563869172);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1545020339);
INSERT INTO `migration` VALUES ('m140209_132017_init', 1545020341);
INSERT INTO `migration` VALUES ('m140403_174025_create_account_table', 1545020341);
INSERT INTO `migration` VALUES ('m140504_113157_update_tables', 1545020341);
INSERT INTO `migration` VALUES ('m140504_130429_create_token_table', 1545020341);
INSERT INTO `migration` VALUES ('m140830_171933_fix_ip_field', 1545020341);
INSERT INTO `migration` VALUES ('m140830_172703_change_account_table_name', 1545020341);
INSERT INTO `migration` VALUES ('m141222_110026_update_ip_field', 1545020341);
INSERT INTO `migration` VALUES ('m141222_135246_alter_username_length', 1545020341);
INSERT INTO `migration` VALUES ('m150614_103145_update_social_account_table', 1545020341);
INSERT INTO `migration` VALUES ('m150623_212711_fix_username_notnull', 1545020341);
INSERT INTO `migration` VALUES ('m151218_234654_add_timezone_to_profile', 1545020341);
INSERT INTO `migration` VALUES ('m160929_103127_add_last_login_at_to_user_table', 1545020341);
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', 1545056503);
INSERT INTO `migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1545056503);

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile`  (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `public_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gravatar_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gravatar_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `bio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `timezone` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `avatar_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `avatar_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sex_id` int(11) NULL DEFAULT NULL COMMENT 'เพศ',
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'ชื่อ',
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'นามสกุล',
  `birthday` date NULL DEFAULT NULL COMMENT 'ว/ด/ป เกิด',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'จังหวัด',
  PRIMARY KEY (`user_id`) USING BTREE,
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES (1, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Asia/Bangkok', '/1/waI7BrOBfJUdH289GVcND45W7IrIRoOw.jpg', '/uploads', 1, 'Tanakorn', 'Phompak', '1992-11-15', '086-323-2323', '1');
INSERT INTO `profile` VALUES (12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '/1/K3t91hDepAqxlEb8p3bLb3YldF8hQK9m.jpeg', '/uploads', 1, 'tp', 'sci', '1993-12-12', '086-578-8999', '1');
INSERT INTO `profile` VALUES (13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for social_account
-- ----------------------------
DROP TABLE IF EXISTS `social_account`;
CREATE TABLE `social_account`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account_unique`(`provider`, `client_id`) USING BTREE,
  UNIQUE INDEX `account_unique_code`(`code`) USING BTREE,
  INDEX `fk_user_account`(`user_id`) USING BTREE,
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of social_account
-- ----------------------------
INSERT INTO `social_account` VALUES (5, 12, 'line', 'Uab3ff8507aba5e8f125e72ec98d62454', '{\"userId\":\"Uab3ff8507aba5e8f125e72ec98d62454\",\"pictureUrl\":\"https://profile.line-scdn.net/0h7SfRxh8iaHxbK0XgYP0XK2duZhEsBW40IxkhGnp7Y0gkEiYsMh4lHSx4Yk8lGCZ_NEkiTyx-ZEp0\",\"email\":null,\"id\":\"Uab3ff8507aba5e8f125e72ec98d62454\"}', NULL, NULL, NULL, NULL);
INSERT INTO `social_account` VALUES (6, NULL, 'line', 'U433daa111fd860fac4a2b223bf5942b4', '{\"userId\":\"U433daa111fd860fac4a2b223bf5942b4\",\"pictureUrl\":\"https://profile.line-scdn.net/0het7k-XeKOlsKEhbrYRZFDDZXNDZ9PDwTcnZ0OykXZWIud34KYSAlOn0TMWJwci4INSMlOn8bNzlz\",\"email\":null,\"id\":\"U433daa111fd860fac4a2b223bf5942b4\"}', 'f452c860596976ef57eb34aa45a7c612', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_province
-- ----------------------------
DROP TABLE IF EXISTS `tb_province`;
CREATE TABLE `tb_province`  (
  `province_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'ไอดี',
  `province_code` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสจังหวัด',
  `province_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อจังหวัด',
  `geo_id` int(5) NOT NULL DEFAULT 0 COMMENT 'GEO ID',
  PRIMARY KEY (`province_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_province
-- ----------------------------
INSERT INTO `tb_province` VALUES (1, '10', 'กรุงเทพมหานคร   ', 2);
INSERT INTO `tb_province` VALUES (2, '11', 'สมุทรปราการ   ', 2);
INSERT INTO `tb_province` VALUES (3, '12', 'นนทบุรี   ', 2);
INSERT INTO `tb_province` VALUES (4, '13', 'ปทุมธานี   ', 2);
INSERT INTO `tb_province` VALUES (5, '14', 'พระนครศรีอยุธยา   ', 2);
INSERT INTO `tb_province` VALUES (6, '15', 'อ่างทอง   ', 2);
INSERT INTO `tb_province` VALUES (7, '16', 'ลพบุรี   ', 2);
INSERT INTO `tb_province` VALUES (8, '17', 'สิงห์บุรี   ', 2);
INSERT INTO `tb_province` VALUES (9, '18', 'ชัยนาท   ', 2);
INSERT INTO `tb_province` VALUES (10, '19', 'สระบุรี', 2);
INSERT INTO `tb_province` VALUES (11, '20', 'ชลบุรี   ', 5);
INSERT INTO `tb_province` VALUES (12, '21', 'ระยอง   ', 5);
INSERT INTO `tb_province` VALUES (13, '22', 'จันทบุรี   ', 5);
INSERT INTO `tb_province` VALUES (14, '23', 'ตราด   ', 5);
INSERT INTO `tb_province` VALUES (15, '24', 'ฉะเชิงเทรา   ', 5);
INSERT INTO `tb_province` VALUES (16, '25', 'ปราจีนบุรี   ', 5);
INSERT INTO `tb_province` VALUES (17, '26', 'นครนายก   ', 2);
INSERT INTO `tb_province` VALUES (18, '27', 'สระแก้ว   ', 5);
INSERT INTO `tb_province` VALUES (19, '30', 'นครราชสีมา   ', 3);
INSERT INTO `tb_province` VALUES (20, '31', 'บุรีรัมย์   ', 3);
INSERT INTO `tb_province` VALUES (21, '32', 'สุรินทร์   ', 3);
INSERT INTO `tb_province` VALUES (22, '33', 'ศรีสะเกษ   ', 3);
INSERT INTO `tb_province` VALUES (23, '34', 'อุบลราชธานี   ', 3);
INSERT INTO `tb_province` VALUES (24, '35', 'ยโสธร   ', 3);
INSERT INTO `tb_province` VALUES (25, '36', 'ชัยภูมิ   ', 3);
INSERT INTO `tb_province` VALUES (26, '37', 'อำนาจเจริญ   ', 3);
INSERT INTO `tb_province` VALUES (27, '39', 'หนองบัวลำภู   ', 3);
INSERT INTO `tb_province` VALUES (28, '40', 'ขอนแก่น   ', 3);
INSERT INTO `tb_province` VALUES (29, '41', 'อุดรธานี   ', 3);
INSERT INTO `tb_province` VALUES (30, '42', 'เลย   ', 3);
INSERT INTO `tb_province` VALUES (31, '43', 'หนองคาย   ', 3);
INSERT INTO `tb_province` VALUES (32, '44', 'มหาสารคาม   ', 3);
INSERT INTO `tb_province` VALUES (33, '45', 'ร้อยเอ็ด   ', 3);
INSERT INTO `tb_province` VALUES (34, '46', 'กาฬสินธุ์   ', 3);
INSERT INTO `tb_province` VALUES (35, '47', 'สกลนคร   ', 3);
INSERT INTO `tb_province` VALUES (36, '48', 'นครพนม   ', 3);
INSERT INTO `tb_province` VALUES (37, '49', 'มุกดาหาร   ', 3);
INSERT INTO `tb_province` VALUES (38, '50', 'เชียงใหม่   ', 1);
INSERT INTO `tb_province` VALUES (39, '51', 'ลำพูน   ', 1);
INSERT INTO `tb_province` VALUES (40, '52', 'ลำปาง   ', 1);
INSERT INTO `tb_province` VALUES (41, '53', 'อุตรดิตถ์   ', 1);
INSERT INTO `tb_province` VALUES (42, '54', 'แพร่   ', 1);
INSERT INTO `tb_province` VALUES (43, '55', 'น่าน   ', 1);
INSERT INTO `tb_province` VALUES (44, '56', 'พะเยา   ', 1);
INSERT INTO `tb_province` VALUES (45, '57', 'เชียงราย   ', 1);
INSERT INTO `tb_province` VALUES (46, '58', 'แม่ฮ่องสอน   ', 1);
INSERT INTO `tb_province` VALUES (47, '60', 'นครสวรรค์   ', 2);
INSERT INTO `tb_province` VALUES (48, '61', 'อุทัยธานี   ', 2);
INSERT INTO `tb_province` VALUES (49, '62', 'กำแพงเพชร   ', 2);
INSERT INTO `tb_province` VALUES (50, '63', 'ตาก   ', 4);
INSERT INTO `tb_province` VALUES (51, '64', 'สุโขทัย   ', 2);
INSERT INTO `tb_province` VALUES (52, '65', 'พิษณุโลก   ', 2);
INSERT INTO `tb_province` VALUES (53, '66', 'พิจิตร   ', 2);
INSERT INTO `tb_province` VALUES (54, '67', 'เพชรบูรณ์   ', 2);
INSERT INTO `tb_province` VALUES (55, '70', 'ราชบุรี   ', 4);
INSERT INTO `tb_province` VALUES (56, '71', 'กาญจนบุรี   ', 4);
INSERT INTO `tb_province` VALUES (57, '72', 'สุพรรณบุรี   ', 2);
INSERT INTO `tb_province` VALUES (58, '73', 'นครปฐม   ', 2);
INSERT INTO `tb_province` VALUES (59, '74', 'สมุทรสาคร   ', 2);
INSERT INTO `tb_province` VALUES (60, '75', 'สมุทรสงคราม   ', 2);
INSERT INTO `tb_province` VALUES (61, '76', 'เพชรบุรี   ', 4);
INSERT INTO `tb_province` VALUES (62, '77', 'ประจวบคีรีขันธ์   ', 4);
INSERT INTO `tb_province` VALUES (63, '80', 'นครศรีธรรมราช   ', 6);
INSERT INTO `tb_province` VALUES (64, '81', 'กระบี่   ', 6);
INSERT INTO `tb_province` VALUES (65, '82', 'พังงา   ', 6);
INSERT INTO `tb_province` VALUES (66, '83', 'ภูเก็ต   ', 6);
INSERT INTO `tb_province` VALUES (67, '84', 'สุราษฎร์ธานี   ', 6);
INSERT INTO `tb_province` VALUES (68, '85', 'ระนอง   ', 6);
INSERT INTO `tb_province` VALUES (69, '86', 'ชุมพร   ', 6);
INSERT INTO `tb_province` VALUES (70, '90', 'สงขลา   ', 6);
INSERT INTO `tb_province` VALUES (71, '91', 'สตูล   ', 6);
INSERT INTO `tb_province` VALUES (72, '92', 'ตรัง   ', 6);
INSERT INTO `tb_province` VALUES (73, '93', 'พัทลุง   ', 6);
INSERT INTO `tb_province` VALUES (74, '94', 'ปัตตานี   ', 6);
INSERT INTO `tb_province` VALUES (75, '95', 'ยะลา   ', 6);
INSERT INTO `tb_province` VALUES (76, '96', 'นราธิวาส   ', 6);
INSERT INTO `tb_province` VALUES (77, '97', 'บึงกาฬ', 3);

-- ----------------------------
-- Table structure for tb_sex
-- ----------------------------
DROP TABLE IF EXISTS `tb_sex`;
CREATE TABLE `tb_sex`  (
  `sex_id` int(11) NOT NULL AUTO_INCREMENT,
  `sex_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'คำนำหน้า',
  PRIMARY KEY (`sex_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_sex
-- ----------------------------
INSERT INTO `tb_sex` VALUES (1, 'ชาย');
INSERT INTO `tb_sex` VALUES (12, 'หญิง');

-- ----------------------------
-- Table structure for tbl_book_binding
-- ----------------------------
DROP TABLE IF EXISTS `tbl_book_binding`;
CREATE TABLE `tbl_book_binding`  (
  `book_binding_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `book_binding_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'วิธีเข้าเล่ม',
  `book_binding_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`book_binding_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_book_binding
-- ----------------------------
INSERT INTO `tbl_book_binding` VALUES ('BD-00001', 'เย็บลวด', 'รายละเอียด');

-- ----------------------------
-- Table structure for tbl_catalog
-- ----------------------------
DROP TABLE IF EXISTS `tbl_catalog`;
CREATE TABLE `tbl_catalog`  (
  `catalog_id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสินค้า',
  `catalog_detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รายละเอียด',
  `catalog_type_id` int(11) NOT NULL COMMENT 'หมวดหมู่',
  `image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่รูปภาพ',
  `image_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ลิงค์ภาพ',
  PRIMARY KEY (`catalog_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_catalog
-- ----------------------------
INSERT INTO `tbl_catalog` VALUES (3, 'ใบปลิว ทดสอบ', '<h3><span style=\"background-color: #ffffff; color: #8e44ad;\">ทดสอบ</span></h3>\r\n<p>ขนาด: 8.25 x 11.50 นิ้ว</p>\r\n<p>ปก กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 160g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>เนื้อใน กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 100g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>', 3, '/1/QiduBNiPaFMRPEy5DZ92dpcWZ677E7Wi.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (5, 'หนังสือ ทดสอบ', '<p><span style=\"font-size: 18pt; color: #18bc9b;\">ทดสอบ</span></p>\r\n<p>ขนาด: 8.25 x 11.50 นิ้ว</p>\r\n<p>ปก กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 160g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>เนื้อใน กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 100g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>จำนวนหน้า: 56 หน้า</p>', 4, '/1/kD_n9eKCNJ6A-ZhgCIj8Th0s7gxyTWwQ.jpg', '/uploads');
INSERT INTO `tbl_catalog` VALUES (6, 'วารสาร ทดสอบ', '<p><span style=\"font-size: 18pt; color: #e74c3c;\">ทดสอบ</span></p>\r\n<p>ขนาด: 8.25 x 11.50 นิ้ว</p>\r\n<p>ปก กระดาษ: กระดาษอาร์ตการ์ด 190</p>\r\n<p>เนื้อใน กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 100gด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>จำนวนหน้า: 40 หน้า</p>', 4, '/1/mM3gTXMCZUNdNYdbhcWfepEHfJpgnkTc.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (11, 'แผ่นพับ ทดสอบ', '<p>ขนาด: 8.25 x 11.50 นิ้ว</p>\r\n<p>ปก กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 160g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>เนื้อใน กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 100g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>', 3, '/1/PN8D3gxHu40-kidIwZup9_Ok_p3hGIy_.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (7, 'สมุด ทดสอบ', '<p><span style=\"font-size: 18pt; color: #d35400;\">ทดสอบ</span></p>\r\n<p>ขนาด: 8.25 x 11.50 นิ้ว</p>\r\n<p>ปก กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 160g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>เนื้อใน กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 100g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>จำนวนหน้า: 30&nbsp; หน้า</p>\r\n<p>เข้าเล่ม: เข้าเล่มแบบสันกาว</p>', 5, '/1/LcW7eSM0hkTRV_vNqwLysCbHtVubsoL_.jpg', '/uploads');
INSERT INTO `tbl_catalog` VALUES (8, 'ไดอารี่ ทดสอบ', '<p><span style=\"font-size: 18pt; color: #a1de1f;\">ทดสอบ</span></p>\r\n<p>ขนาด: 8.25 x 11.50 นิ้ว</p>\r\n<p>ปก กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 160g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>เนื้อใน กระดาษ: กระดาษอาร์ตการ์ด-มัน อาร์ตมัน 100g</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>จำนวนหน้า: 56 หน้า</p>\r\n<p>เข้าเล่ม: เย็บลวด</p>', 5, '/1/IszmMXwrV1oxvwKzdg0o5GqJ3UKfNcHm.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (9, 'ปฏิทิน ทดสอบ', '<p><span style=\"font-size: 18pt; color: #f66409;\">ทดสอบ</span></p>\r\n<p>ปฏิทินตั้งโต๊ะ</p>\r\n<p>ขนาด : 5 X 7 นิ้ว&nbsp;</p>\r\n<p>จำนวนหน้า : 14 แผ่น 28 หน้า</p>\r\n<p>ด้านหน้าพิมพ์: 4 สี ด้านหลังพิมพ์: 4 สี</p>\r\n<p>กระดาษ : กระดาษการ์ดอาร์ต 2 หน้า</p>\r\n<p>เข้าเล่ม: เย็บลวด</p>', 6, '/1/uiuFCB_pvMv-vqlGjy-R1ef2T4yCvph5.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (12, 'ถุงไวน์ | Wine Bag', '<p><span style=\"font-family: verdana, geneva;\"><strong>กระดาษ : </strong>คราฟน้ำตาล KA 230 แกรม</span></p>\r\n<p><span style=\"font-family: verdana, geneva;\"><strong>การพิมพ์</strong> : พิมพ์สีเดียว หน้าเดียว</span></p>\r\n<p><strong><span style=\"font-family: verdana, geneva;\">อื่น ๆ : </span></strong><span style=\"font-family: verdana, geneva;\">ร้อยเชือกหูถุงสีดำ</span></p>\r\n<p><span style=\"font-family: verdana, geneva;\"><strong>จำนวน</strong> 200 ถุง <strong>ราคาถุงละ</strong> 22.50 บาท</span></p>', 8, '/1/P4LeU0-M2JoDblHIeKrbbavTbXM-AHt9.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (13, 'ถุงกระดาษขนาด 18.5*20*12.5 ซม.', '<p><strong>ขนาด :</strong> 18.5 x 20 x 12.5 ซม.</p>\r\n<p><strong>กระดาษ :</strong> อาร์ตการ์ด 190 แกรม</p>\r\n<p><strong>การพิมพ์ :</strong> พิมพ์สีเดียว หน้าเดียว (สีทอง)</p>\r\n<p><strong>อื่น ๆ :</strong> เคลือบ pvc ด้าน ร้อยเชือกหูถุงสีขาว</p>\r\n<p><strong>จำนวน 1000 ใบ ราคาใบละ 14 บาท</strong></p>\r\n<p>&nbsp;</p>', 8, '/1/w8T9aQLSesOQQPijcatYinVvTl2AKBWI.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (14, 'นามบัตรกระดาษนำเข้า', '<p><strong>ขนาด :</strong> 5.5*9 ซม.</p>\r\n<p><strong>กระดาษ :</strong> Conqueror Laid Diamond White 250 gram</p>\r\n<p><strong>การพิมพ์ :</strong> offset 4 สี สองหน้า</p>\r\n<p><strong>จำนวน : 1000 ใบ ใบละ 4 บาท</strong></p>', 9, '/1/uTctphUDeXduFQbdjRtBY5DyEocIRAKj.jpg', '/uploads');
INSERT INTO `tbl_catalog` VALUES (15, 'ป้ายสินค้า', '<p>ทดสอบ</p>', 7, '/1/Owb9j-tl7ipp8quD_SIP6dVNC-vtyMDv.png', '/uploads');
INSERT INTO `tbl_catalog` VALUES (16, 'ฉลากติดสินค้า', '<p>ทดสอบ</p>', 7, '/1/8JTk8jcl9qjVh3fZYT2yxkdeONqf-h9Q.png', '/uploads');

-- ----------------------------
-- Table structure for tbl_catalog_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_catalog_type`;
CREATE TABLE `tbl_catalog_type`  (
  `catalog_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อหมวดหมู่',
  `image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่รูปภาพ',
  `image_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ลิงค์ภาพ',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  PRIMARY KEY (`catalog_type_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_catalog_type
-- ----------------------------
INSERT INTO `tbl_catalog_type` VALUES (3, 'ใบปลิวและแผ่นพับ', '/1/mhxcYB-Sm_Y3weSybyqemQMFdJoH9_OB.png', '/uploads', 1, '2019-03-29 15:24:36', 1, '2019-04-01 15:47:31');
INSERT INTO `tbl_catalog_type` VALUES (4, 'หนังสือและวารสาร', '/1/FVQIdDg_64DFypEe72yBErV-nc4rd9fN.png', '/uploads', 1, '2019-04-01 13:16:21', 1, '2019-04-01 13:16:21');
INSERT INTO `tbl_catalog_type` VALUES (5, 'ไดอารี่และสมุด', '/1/Fr41j4oJpg7AhEF3dGbp3RWeM1shi551.jpg', '/uploads', 1, '2019-04-01 13:43:40', 1, '2019-04-01 14:41:45');
INSERT INTO `tbl_catalog_type` VALUES (6, 'ปฏิทิน', '/1/EVVGMb00DvM80jEupC8ygGiUZYubBkl8.png', '/uploads', 1, '2019-04-01 15:09:28', 1, '2019-04-01 15:09:28');
INSERT INTO `tbl_catalog_type` VALUES (7, 'ฉลาก และ ป้ายสินค้า', '/1/SUgQqUXJ0Fb7RlDOzrYXys2TciHfD3h4.png', '/uploads', 1, '2019-04-02 09:31:32', 1, '2019-07-23 14:37:34');
INSERT INTO `tbl_catalog_type` VALUES (8, 'ถุงกระดาษ | Paper Bags', '/1/XNgEGcCyngZNim5O1rHC-CdmdGIZpRAk.png', '/uploads', 13, '2019-04-04 11:18:43', 13, '2019-04-04 11:18:43');
INSERT INTO `tbl_catalog_type` VALUES (9, 'นามบัตร | Business Card', '/1/KnvHZDAin84n1zLc3vrB2TXefN_xZ5zY.jpg', '/uploads', 13, '2019-04-04 12:26:43', 13, '2019-04-04 12:26:43');

-- ----------------------------
-- Table structure for tbl_coating
-- ----------------------------
DROP TABLE IF EXISTS `tbl_coating`;
CREATE TABLE `tbl_coating`  (
  `coating_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `coating_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'วิธีเคลือบ',
  `coating_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`coating_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_coating
-- ----------------------------
INSERT INTO `tbl_coating` VALUES ('C-00001', 'เคลือบ pvc ด้าน', '');
INSERT INTO `tbl_coating` VALUES ('C-00002', 'เคลือบ pvc เงา', '');
INSERT INTO `tbl_coating` VALUES ('C-00003', 'เคลือบ UV', '');

-- ----------------------------
-- Table structure for tbl_coating_price
-- ----------------------------
DROP TABLE IF EXISTS `tbl_coating_price`;
CREATE TABLE `tbl_coating_price`  (
  `coating_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `coating_price_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'งานเคลือบ',
  `coating_uv_price` decimal(10, 2) NOT NULL COMMENT 'ราคาเคลือบ UV',
  `coating_varnish_price` decimal(10, 2) NOT NULL COMMENT 'ราคาเคลือบเงา',
  `coating_matte_price` decimal(10, 2) NOT NULL COMMENT 'ราคาเคลือบด้าน',
  `coating_sq_in` int(11) NOT NULL COMMENT 'ตารางนิ้ว',
  PRIMARY KEY (`coating_price_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_coating_price
-- ----------------------------
INSERT INTO `tbl_coating_price` VALUES (1, 'ตัด 8 (10x15)', 0.60, 1.75, 2.00, 150);
INSERT INTO `tbl_coating_price` VALUES (2, 'ตัด 5 (12x18)', 0.70, 2.00, 2.50, 216);
INSERT INTO `tbl_coating_price` VALUES (3, 'ตัด 4 (15x21)', 0.80, 2.50, 3.00, 315);
INSERT INTO `tbl_coating_price` VALUES (4, 'ตัด 4 พิเศษ (18x25)', 0.90, 3.50, 4.00, 450);
INSERT INTO `tbl_coating_price` VALUES (5, 'ตัด 2 (21x31)', 1.50, 4.50, 5.00, 651);
INSERT INTO `tbl_coating_price` VALUES (6, 'ตัด 2 (25x36)', 1.80, 5.50, 6.00, 900);

-- ----------------------------
-- Table structure for tbl_color_printing
-- ----------------------------
DROP TABLE IF EXISTS `tbl_color_printing`;
CREATE TABLE `tbl_color_printing`  (
  `color_printing_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `color_printing_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'หน้าพิมพ์/หลังพิมพ์',
  `color_printing_descriotion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`color_printing_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_color_printing
-- ----------------------------
INSERT INTO `tbl_color_printing` VALUES ('PT-00005', 'พิมพ์ 1 สี (สีดำ)', '');
INSERT INTO `tbl_color_printing` VALUES ('PT-00006', 'พิมพ์ 1 สี (ไม่ใช่สีดำ)', '');
INSERT INTO `tbl_color_printing` VALUES ('PT-00007', 'พิมพ์ 2 สี', '');
INSERT INTO `tbl_color_printing` VALUES ('PT-00008', 'พิมพ์ 4 สี', '');

-- ----------------------------
-- Table structure for tbl_diecut
-- ----------------------------
DROP TABLE IF EXISTS `tbl_diecut`;
CREATE TABLE `tbl_diecut`  (
  `diecut_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `diecut_group_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสรูปแบบ',
  `diecut_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ไดคัท',
  `diecut_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`diecut_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_diecut
-- ----------------------------
INSERT INTO `tbl_diecut` VALUES ('D-00007', 'DG-00002', '1 มุม', '');
INSERT INTO `tbl_diecut` VALUES ('D-00010', 'DG-00003', '2 มุม', '');
INSERT INTO `tbl_diecut` VALUES ('D-00018', 'DG-00009', '3 มุม', '');
INSERT INTO `tbl_diecut` VALUES ('D-00019', 'DG-00010', '4 มุม', '');

-- ----------------------------
-- Table structure for tbl_diecut_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_diecut_group`;
CREATE TABLE `tbl_diecut_group`  (
  `diecut_group_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `diecut_group_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รูปแบบไดคัท',
  `diecut_group_value` int(11) NOT NULL COMMENT 'จำนวนมุม',
  PRIMARY KEY (`diecut_group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_diecut_group
-- ----------------------------
INSERT INTO `tbl_diecut_group` VALUES ('DG-00002', 'มุมมน 1 มุม', 1);
INSERT INTO `tbl_diecut_group` VALUES ('DG-00003', 'มุมมน 2 มุม', 2);
INSERT INTO `tbl_diecut_group` VALUES ('DG-00010', 'มุมมน 4 มุม', 4);
INSERT INTO `tbl_diecut_group` VALUES ('DG-00009', 'มุมมน 3 มุม', 3);

-- ----------------------------
-- Table structure for tbl_emboss_price
-- ----------------------------
DROP TABLE IF EXISTS `tbl_emboss_price`;
CREATE TABLE `tbl_emboss_price`  (
  `emboss_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `emboss_price_size` int(11) NOT NULL COMMENT 'ขนาด (ตารางนิ้ว)',
  `emboss_price` decimal(10, 2) NOT NULL COMMENT 'ราคา',
  PRIMARY KEY (`emboss_price_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_emboss_price
-- ----------------------------
INSERT INTO `tbl_emboss_price` VALUES (1, 1, 140.00);
INSERT INTO `tbl_emboss_price` VALUES (2, 2, 150.00);
INSERT INTO `tbl_emboss_price` VALUES (3, 3, 170.00);
INSERT INTO `tbl_emboss_price` VALUES (4, 4, 180.00);
INSERT INTO `tbl_emboss_price` VALUES (5, 5, 195.00);
INSERT INTO `tbl_emboss_price` VALUES (6, 6, 210.00);
INSERT INTO `tbl_emboss_price` VALUES (7, 7, 220.00);
INSERT INTO `tbl_emboss_price` VALUES (8, 8, 240.00);
INSERT INTO `tbl_emboss_price` VALUES (9, 9, 250.00);
INSERT INTO `tbl_emboss_price` VALUES (10, 10, 265.00);
INSERT INTO `tbl_emboss_price` VALUES (11, 11, 280.00);
INSERT INTO `tbl_emboss_price` VALUES (12, 12, 290.00);
INSERT INTO `tbl_emboss_price` VALUES (13, 13, 300.00);
INSERT INTO `tbl_emboss_price` VALUES (14, 14, 320.00);
INSERT INTO `tbl_emboss_price` VALUES (15, 15, 335.00);
INSERT INTO `tbl_emboss_price` VALUES (16, 16, 350.00);
INSERT INTO `tbl_emboss_price` VALUES (17, 17, 360.00);
INSERT INTO `tbl_emboss_price` VALUES (18, 18, 380.00);
INSERT INTO `tbl_emboss_price` VALUES (19, 19, 390.00);
INSERT INTO `tbl_emboss_price` VALUES (20, 20, 405.00);
INSERT INTO `tbl_emboss_price` VALUES (21, 21, 420.00);
INSERT INTO `tbl_emboss_price` VALUES (22, 22, 430.00);
INSERT INTO `tbl_emboss_price` VALUES (23, 23, 450.00);
INSERT INTO `tbl_emboss_price` VALUES (24, 24, 460.00);
INSERT INTO `tbl_emboss_price` VALUES (25, 25, 475.00);
INSERT INTO `tbl_emboss_price` VALUES (26, 26, 490.00);
INSERT INTO `tbl_emboss_price` VALUES (27, 27, 500.00);
INSERT INTO `tbl_emboss_price` VALUES (28, 28, 520.00);
INSERT INTO `tbl_emboss_price` VALUES (29, 29, 530.00);
INSERT INTO `tbl_emboss_price` VALUES (30, 30, 18.00);

-- ----------------------------
-- Table structure for tbl_foil_color
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foil_color`;
CREATE TABLE `tbl_foil_color`  (
  `foil_color_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `foil_color_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสีฟอยล์',
  `foil_color_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'โค้ดสี',
  `foil_color_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`foil_color_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_foil_color
-- ----------------------------
INSERT INTO `tbl_foil_color` VALUES ('FOIL-00003', 'สีเงิน', '#d9d9d9', '');
INSERT INTO `tbl_foil_color` VALUES ('FOIL-00004', 'สีพิเศษ', '', '');
INSERT INTO `tbl_foil_color` VALUES ('FOIL-00005', 'สีทอง', '#f6e306', '');

-- ----------------------------
-- Table structure for tbl_fold
-- ----------------------------
DROP TABLE IF EXISTS `tbl_fold`;
CREATE TABLE `tbl_fold`  (
  `fold_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `fold_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'วิธีพับ',
  `fold_count` int(11) NULL DEFAULT NULL COMMENT 'ตอนพับ',
  `fold_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`fold_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_fold
-- ----------------------------
INSERT INTO `tbl_fold` VALUES ('FOLD-00010', 'พับซิกแซก 4 ตอน', 4, '');
INSERT INTO `tbl_fold` VALUES ('FOLD-00011', 'พับซิกแซกหน้าต่าง 4 ตอน', 4, '');
INSERT INTO `tbl_fold` VALUES ('FOLD-00006', 'พับ 1', 1, '');
INSERT INTO `tbl_fold` VALUES ('FOLD-00007', 'พับ 2', 2, '');
INSERT INTO `tbl_fold` VALUES ('FOLD-00008', 'พับซิกแซก 3 ตอน', 3, '');

-- ----------------------------
-- Table structure for tbl_package_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_package_type`;
CREATE TABLE `tbl_package_type`  (
  `package_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `product_category_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รหัส',
  `package_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อประเภท',
  PRIMARY KEY (`package_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_package_type
-- ----------------------------
INSERT INTO `tbl_package_type` VALUES (4, 'PC-00002', 'การ์ด');
INSERT INTO `tbl_package_type` VALUES (5, 'PC-00002', 'หนังสือ');
INSERT INTO `tbl_package_type` VALUES (6, 'PC-00002', 'นามบัตร');
INSERT INTO `tbl_package_type` VALUES (10, 'PC-00002', 'ใบปลิว');
INSERT INTO `tbl_package_type` VALUES (11, 'PC-00002', 'โปสการ์ด');
INSERT INTO `tbl_package_type` VALUES (13, 'PC-00002', 'บัตร');
INSERT INTO `tbl_package_type` VALUES (14, 'PC-00002', 'ปฏิทิน');
INSERT INTO `tbl_package_type` VALUES (15, 'PC-00002', 'ป้าย tag');
INSERT INTO `tbl_package_type` VALUES (20, 'PC-00003', 'ถุงกระดาษ');
INSERT INTO `tbl_package_type` VALUES (21, 'PC-00003', 'กล่องกระดาษ');
INSERT INTO `tbl_package_type` VALUES (22, 'PC-00003', 'กล่องกระดาษหุ้มแข็ง');
INSERT INTO `tbl_package_type` VALUES (24, 'PC-00002', 'บิล');
INSERT INTO `tbl_package_type` VALUES (25, 'PC-00003', 'ป้ายติดสินค้า');

-- ----------------------------
-- Table structure for tbl_paper
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper`;
CREATE TABLE `tbl_paper`  (
  `paper_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสประเภท',
  `paper_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อกระดาษ',
  `paper_gram` int(11) NULL DEFAULT NULL COMMENT 'ขนาดแกรม',
  `paper_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `paper_price` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ราคากระดาษ',
  `paper_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง',
  `paper_length` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว',
  PRIMARY KEY (`paper_id`) USING BTREE,
  INDEX `paper_type_id`(`paper_type_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper
-- ----------------------------
INSERT INTO `tbl_paper` VALUES ('P-00006', 'PT-00001', 'ปอนด์', 80, '', 1.75, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00007', 'PT-00001', 'ปอนด์', 80, '', 2.75, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00008', 'PT-00006', 'อาร์ตมัน', 105, '', 2.20, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00009', 'PT-00006', 'อาร์ตมัน', 105, '', 3.60, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00010', 'PT-00007', 'อาร์ตด้าน ', 105, '', 2.20, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00011', 'PT-00007', 'อาร์ตด้าน ', 105, '', 3.60, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00012', 'PT-00006', 'อาร์ตมัน', 120, '', 2.60, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00013', 'PT-00006', 'อาร์ตมัน', 120, '', 4.13, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00014', 'PT-00007', 'อาร์ตด้าน', 120, '', 2.60, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00015', 'PT-00007', 'อาร์ตด้าน', 120, '', 4.13, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00016', 'PT-00006', 'อาร์ตมัน', 160, '', 3.40, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00017', 'PT-00006', 'อาร์ตมัน', 160, '', 5.75, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00018', 'PT-00007', 'อาร์ตด้าน', 160, '', 3.40, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00019', 'PT-00007', 'อาร์ตด้าน', 160, '', 5.75, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00020', 'PT-00008', 'อาร์ตการ์ด', 190, '', 4.60, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00021', 'PT-00008', 'อาร์ตการ์ด', 190, '', 6.70, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00022', 'PT-00008', 'อาร์ตการ์ด', 210, '', 4.95, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00023', 'PT-00008', 'อาร์ตการ์ด', 210, '', 7.50, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00024', 'PT-00008', 'อาร์ตการ์ด', 230, '', 5.25, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00025', 'PT-00008', 'อาร์ตการ์ด', 230, '', 8.15, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00026', 'PT-00015', 'อาร์ตการ์ดสองหน้า ', 260, '', 6.16, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00027', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 260, '', 9.13, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00028', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 300, '', 7.50, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00029', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 300, '', 10.85, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00030', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 300, '', 7.50, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00031', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 300, '', 10.78, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00032', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 350, '', 8.58, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00033', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 350, '', 12.66, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00034', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 350, '', 8.58, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00035', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 350, '', 12.66, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00036', 'PT-00009', 'ถนอมสายตา', 75, '', 1.80, 24.00, 35.00);
INSERT INTO `tbl_paper` VALUES ('P-00037', 'PT-00009', 'ถนอมสายตา', 75, '', 2.88, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00038', 'PT-00010', 'กรีนการ์ด', 250, '', 9.85, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00039', 'PT-00010', 'กรีนการ์ด', 250, '', 14.20, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00040', 'PT-00011', 'คราฟน้ำตาล', 300, '', 9.00, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00041', 'PT-00011', 'คราฟน้ำตาล', 300, '', 14.00, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00042', 'PT-00011', 'คราฟน้ำตาล', 375, '', 10.50, 25.00, 36.00);
INSERT INTO `tbl_paper` VALUES ('P-00043', 'PT-00011', 'คราฟน้ำตาล', 375, '', 15.50, 31.00, 43.00);
INSERT INTO `tbl_paper` VALUES ('P-00044', 'PT-00012', 'กระดาษมี texture', 100, '', 7.00, 17.00, 24.00);
INSERT INTO `tbl_paper` VALUES ('P-00045', 'PT-00012', 'กระดาษมี texture', 120, '', 25.00, 31.00, 40.00);
INSERT INTO `tbl_paper` VALUES ('P-00046', 'PT-00012', 'กระดาษมี texture', 250, '', 35.00, 27.50, 39.30);
INSERT INTO `tbl_paper` VALUES ('P-00047', 'PT-00012', 'กระดาษมี texture', 300, '', 60.00, 27.50, 39.30);
INSERT INTO `tbl_paper` VALUES ('P-00048', 'PT-00004', 'pp ใส', 0, '', 25.50, 27.50, 39.30);
INSERT INTO `tbl_paper` VALUES ('P-00049', 'PT-00004', 'pp ขาวเงา', 0, '', 26.50, 27.50, 39.30);
INSERT INTO `tbl_paper` VALUES ('P-00050', 'PT-00004', 'pp ขาวด้าน', 0, '', 25.50, 27.50, 39.30);
INSERT INTO `tbl_paper` VALUES ('P-00051', 'PT-00004', 'กระดาษขาวเงา', 0, '', 13.00, 27.50, 39.30);
INSERT INTO `tbl_paper` VALUES ('P-00052', 'PT-00004', 'กระดาษขาวด้าน', 0, '', 15.00, 27.50, 39.30);

-- ----------------------------
-- Table structure for tbl_paper_1
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_1`;
CREATE TABLE `tbl_paper_1`  (
  `paper_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสประเภท',
  `paper_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อกระดาษ',
  `paper_gram` int(11) NULL DEFAULT NULL COMMENT 'ขนาดแกรม',
  `paper_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `paper_price` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ราคากระดาษ',
  `paper_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง',
  `paper_length` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว',
  PRIMARY KEY (`paper_id`) USING BTREE,
  INDEX `paper_type_id`(`paper_type_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_1
-- ----------------------------
INSERT INTO `tbl_paper_1` VALUES ('P-00006', 'PT-00001', 'ปอนด์', 80, '', 1.75, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00007', 'PT-00001', 'ปอนด์', 80, '', 2.75, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00008', 'PT-00006', 'อาร์ตมัน', 105, '', 2.20, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00009', 'PT-00006', 'อาร์ตมัน', 105, '', 3.60, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00010', 'PT-00007', 'อาร์ตด้าน ', 105, '', 2.20, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00011', 'PT-00007', 'อาร์ตด้าน ', 105, '', 3.60, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00012', 'PT-00006', 'อาร์ตมัน', 120, '', 2.60, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00013', 'PT-00006', 'อาร์ตมัน', 120, '', 4.13, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00014', 'PT-00007', 'อาร์ตด้าน', 120, '', 2.60, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00015', 'PT-00007', 'อาร์ตด้าน', 120, '', 4.13, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00016', 'PT-00006', 'อาร์ตมัน', 160, '', 3.40, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00017', 'PT-00006', 'อาร์ตมัน', 160, '', 5.75, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00018', 'PT-00007', 'อาร์ตด้าน', 160, '', 3.40, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00019', 'PT-00007', 'อาร์ตด้าน', 160, '', 5.75, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00020', 'PT-00008', 'อาร์ตการ์ด', 190, '', 4.60, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00021', 'PT-00008', 'อาร์ตการ์ด', 190, '', 6.70, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00022', 'PT-00008', 'อาร์ตการ์ด', 210, '', 4.95, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00023', 'PT-00008', 'อาร์ตการ์ด', 210, '', 7.50, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00024', 'PT-00008', 'อาร์ตการ์ด', 230, '', 5.25, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00025', 'PT-00008', 'อาร์ตการ์ด', 230, '', 8.15, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00026', 'PT-00015', 'อาร์ตการ์ดสองหน้า ', 260, '', 6.16, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00027', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 260, '', 9.13, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00028', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 300, '', 7.50, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00029', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 300, '', 10.85, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00030', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 300, '', 7.50, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00031', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 300, '', 10.78, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00032', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 350, '', 8.58, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00033', 'PT-00016', 'อาร์ตการ์ดหน้าเดียว', 350, '', 12.66, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00034', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 350, '', 8.58, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00035', 'PT-00015', 'อาร์ตการ์ดสองหน้า', 350, '', 12.66, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00036', 'PT-00009', 'ถนอมสายตา', 75, '', 1.80, 24.00, 35.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00037', 'PT-00009', 'ถนอมสายตา', 75, '', 2.88, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00038', 'PT-00010', 'กรีนการ์ด', 250, '', 9.85, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00039', 'PT-00010', 'กรีนการ์ด', 250, '', 14.20, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00040', 'PT-00011', 'คราฟน้ำตาล', 300, '', 9.00, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00041', 'PT-00011', 'คราฟน้ำตาล', 300, '', 14.00, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00042', 'PT-00011', 'คราฟน้ำตาล', 375, '', 10.50, 25.00, 36.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00043', 'PT-00011', 'คราฟน้ำตาล', 375, '', 15.50, 31.00, 43.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00044', 'PT-00012', 'กระดาษมี texture', 100, '', 7.00, 17.00, 24.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00045', 'PT-00012', 'กระดาษมี texture', 120, '', 25.00, 31.00, 40.00);
INSERT INTO `tbl_paper_1` VALUES ('P-00046', 'PT-00012', 'กระดาษมี texture', 250, '', 35.00, 27.50, 39.30);
INSERT INTO `tbl_paper_1` VALUES ('P-00047', 'PT-00012', 'กระดาษมี texture', 300, '', 60.00, 27.50, 39.30);
INSERT INTO `tbl_paper_1` VALUES ('P-00048', 'PT-00004', 'pp ใส', 0, '', 25.50, 27.50, 39.30);
INSERT INTO `tbl_paper_1` VALUES ('P-00049', 'PT-00004', 'pp ขาวเงา', 0, '', 26.50, 27.50, 39.30);
INSERT INTO `tbl_paper_1` VALUES ('P-00050', 'PT-00004', 'pp ขาวด้าน', 0, '', 25.50, 27.50, 39.30);
INSERT INTO `tbl_paper_1` VALUES ('P-00051', 'PT-00004', 'กระดาษขาวเงา', 0, '', 13.00, 27.50, 39.30);
INSERT INTO `tbl_paper_1` VALUES ('P-00052', 'PT-00004', 'กระดาษขาวด้าน', 0, '', 15.00, 27.50, 39.30);

-- ----------------------------
-- Table structure for tbl_paper_cut
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_cut`;
CREATE TABLE `tbl_paper_cut`  (
  `paper_size_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `paper_cut` int(11) NOT NULL COMMENT 'ขนาดกระดาษตัด',
  `paper_print_area_width` decimal(10, 2) NOT NULL COMMENT 'ความกว้าง',
  `paper_print_area_length` decimal(10, 2) NOT NULL COMMENT 'ความยาว',
  `paper_size` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ไชส์กระดาษ',
  `paper_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ประเภท',
  `paper_sticker` int(11) NOT NULL COMMENT 'สติ๊กเกอร์',
  PRIMARY KEY (`paper_size_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_cut
-- ----------------------------
INSERT INTO `tbl_paper_cut` VALUES (1, 2, 31.00, 21.50, 'L', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (2, 4, 15.50, 21.50, 'L', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (3, 6, 15.50, 14.33, 'L', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (4, 8, 10.75, 15.50, 'L', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (5, 2, 18.00, 25.00, 'S-1', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (6, 4, 18.00, 12.50, 'S-1', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (7, 6, 12.50, 12.00, 'S-1', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (8, 8, 12.50, 9.00, 'S-1', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (9, 2, 17.50, 24.00, 'S-2', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (10, 4, 17.50, 12.00, 'S-2', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (11, 6, 12.00, 11.67, 'S-2', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (12, 8, 12.00, 9.00, 'S-2', 'offset', 0);
INSERT INTO `tbl_paper_cut` VALUES (13, 2, 27.50, 19.70, 'S-T', 'offset', 1);
INSERT INTO `tbl_paper_cut` VALUES (14, 4, 13.75, 19.70, 'S-T', 'offset', 1);
INSERT INTO `tbl_paper_cut` VALUES (15, 6, 13.75, 13.13, 'S-T', 'offset', 1);
INSERT INTO `tbl_paper_cut` VALUES (16, 8, 9.85, 13.75, 'S-T', 'offset', 1);
INSERT INTO `tbl_paper_cut` VALUES (17, 4, 12.50, 18.00, 'S', 'digital', 0);
INSERT INTO `tbl_paper_cut` VALUES (18, 5, 13.00, 18.00, 'L', 'digital', 0);
INSERT INTO `tbl_paper_cut` VALUES (19, 8, 15.50, 10.75, 'L', 'digital', 0);
INSERT INTO `tbl_paper_cut` VALUES (20, 4, 13.00, 19.00, 'L', 'digital', 1);
INSERT INTO `tbl_paper_cut` VALUES (21, 4, 11.90, 16.50, 'L', 'digital', 1);

-- ----------------------------
-- Table structure for tbl_paper_size
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_size`;
CREATE TABLE `tbl_paper_size`  (
  `paper_size_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_size_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อขนาด',
  `paper_size_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `paper_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ความกว้าง',
  `paper_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ความยาว',
  `paper_height` decimal(10, 0) NULL DEFAULT NULL COMMENT 'ความสูง',
  `paper_unit_id` int(11) NULL DEFAULT NULL COMMENT 'หน่วย',
  PRIMARY KEY (`paper_size_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_size
-- ----------------------------
INSERT INTO `tbl_paper_size` VALUES ('PS-00035', 'A6', '', 4.13, 5.83, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00034', 'A5', '', 5.83, 8.27, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00033', 'A4', '', 8.27, 11.69, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00032', 'A3', '', 11.69, 16.54, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00031', 'A2', '', 16.54, 23.39, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00024', '5.5*9', '', 5.50, 9.00, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00025', '9.9*21', '', 9.90, 21.00, NULL, 2);
INSERT INTO `tbl_paper_size` VALUES ('PS-00026', '15*21', '', 15.00, 21.00, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00027', '21*29', '', 21.00, 29.00, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00028', '2A', '', 46.81, 66.22, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00029', 'A0', '', 33.11, 46.81, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00030', 'A1', '', 23.39, 33.11, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00023', '5.5*8.5', '', 5.50, 8.50, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00022', '5*8', '', 5.00, 8.00, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00021', '5*7', '', 5.00, 7.00, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00020', '4*6', '', 4.00, 6.00, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00036', 'A7', '', 2.91, 4.13, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00037', 'A8', '', 2.05, 2.91, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00038', 'A9', '', 1.46, 2.05, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00039', 'A10', '', 1.02, 1.46, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00040', 'B0', '', 39.37, 55.67, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00041', 'B1', '', 27.83, 39.37, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00042', 'B2', '', 19.68, 27.83, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00043', 'B3', '', 13.90, 19.68, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00044', 'B4', '', 9.84, 13.90, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00045', 'B5', '', 6.93, 9.84, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00046', 'B6', '', 4.92, 6.93, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00047', 'B7', '', 3.46, 4.92, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00048', 'B8', '', 2.44, 3.46, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00049', 'B9', '', 1.73, 2.44, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00050', 'B10', '', 1.22, 1.73, NULL, 3);
INSERT INTO `tbl_paper_size` VALUES ('PS-00051', 'A4 (21*29)', 'บิล/ใบเสร็จ/ใบส่งของ', 21.00, 29.00, NULL, 2);
INSERT INTO `tbl_paper_size` VALUES ('PS-00052', 'A5 (14.85*21)', 'บิล/ใบเสร็จ/ใบส่งของ', 14.85, 21.00, NULL, 2);
INSERT INTO `tbl_paper_size` VALUES ('PS-00053', 'A5 (17.6*25)', 'บิล/ใบเสร็จ/ใบส่งของ', 17.60, 25.00, NULL, 2);

-- ----------------------------
-- Table structure for tbl_paper_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_type`;
CREATE TABLE `tbl_paper_type`  (
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อประเภทกระดาษ',
  `paper_type_flag` int(11) NOT NULL COMMENT 'เป็นสติ๊กเกอร์ หรือไม่?',
  PRIMARY KEY (`paper_type_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_type
-- ----------------------------
INSERT INTO `tbl_paper_type` VALUES ('PT-00001', 'กระดาษปอนด์', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00002', 'กระดาษคาร์บอน', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00003', 'กระดาษแบงค์', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00004', 'สติกเกอร์', 1);
INSERT INTO `tbl_paper_type` VALUES ('PT-00005', 'กระดาษปรู๊ฟ', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00006', 'กระดาษอาร์ตมัน', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00007', 'กระดาษอาร์ตด้าน', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00008', 'อาร์ตการ์ด', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00009', 'กระดาษถนอมสายตา', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00010', 'กระดาษกรีนการ์ด', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00011', 'กระดาษคราฟน้ำตาล', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00012', 'กระดาษมี texture', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00013', 'กระดาษธรรมดา  บิล/ใบเสร็จ/ใบส่งของ', 0);
INSERT INTO `tbl_paper_type` VALUES ('PT-00014', 'กระดาษเคมี copy ในตัว', 0);

-- ----------------------------
-- Table structure for tbl_perforate
-- ----------------------------
DROP TABLE IF EXISTS `tbl_perforate`;
CREATE TABLE `tbl_perforate`  (
  `perforate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรูปแบบป้ายtag/ที่คั่นหนังสือ',
  `perforate_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อรูปแบบ',
  PRIMARY KEY (`perforate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_perforate
-- ----------------------------
INSERT INTO `tbl_perforate` VALUES (2, 'เจาะมุม');

-- ----------------------------
-- Table structure for tbl_perforate_option
-- ----------------------------
DROP TABLE IF EXISTS `tbl_perforate_option`;
CREATE TABLE `tbl_perforate_option`  (
  `perforate_option_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `perforate_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสรูปแบบ',
  `perforate_option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อมุมเจาะ',
  `perforate_option_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`perforate_option_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_perforate_option
-- ----------------------------
INSERT INTO `tbl_perforate_option` VALUES (3, 2, 'มุมบนซ้าย', '');
INSERT INTO `tbl_perforate_option` VALUES (4, 2, 'ตรงกลาง', '');
INSERT INTO `tbl_perforate_option` VALUES (5, 2, 'มุมบนขวา', '');

-- ----------------------------
-- Table structure for tbl_print_price
-- ----------------------------
DROP TABLE IF EXISTS `tbl_print_price`;
CREATE TABLE `tbl_print_price`  (
  `print_price_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `print_sheet_qty` decimal(10, 2) NOT NULL COMMENT 'จำนวนรอบ',
  `print_paper_cut` int(11) NOT NULL COMMENT 'เครื่องพิมพ์ ตัด',
  `price` decimal(10, 2) NOT NULL COMMENT 'ราคาพิมพ์',
  PRIMARY KEY (`print_price_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_print_price
-- ----------------------------
INSERT INTO `tbl_print_price` VALUES (1, 1000.00, 2, 4000.00);
INSERT INTO `tbl_print_price` VALUES (2, 2000.00, 2, 4500.00);
INSERT INTO `tbl_print_price` VALUES (3, 3000.00, 2, 5000.00);
INSERT INTO `tbl_print_price` VALUES (4, 4000.00, 2, 5500.00);
INSERT INTO `tbl_print_price` VALUES (5, 5000.00, 2, 6000.00);
INSERT INTO `tbl_print_price` VALUES (6, 6000.00, 2, 6500.00);
INSERT INTO `tbl_print_price` VALUES (7, 7000.00, 2, 7000.00);
INSERT INTO `tbl_print_price` VALUES (8, 8000.00, 2, 7500.00);
INSERT INTO `tbl_print_price` VALUES (9, 9000.00, 2, 8000.00);
INSERT INTO `tbl_print_price` VALUES (10, 10000.00, 2, 8500.00);
INSERT INTO `tbl_print_price` VALUES (11, 1000.00, 3, 3000.00);
INSERT INTO `tbl_print_price` VALUES (12, 2000.00, 3, 3400.00);
INSERT INTO `tbl_print_price` VALUES (13, 3000.00, 3, 3800.00);
INSERT INTO `tbl_print_price` VALUES (14, 4000.00, 3, 4200.00);
INSERT INTO `tbl_print_price` VALUES (15, 5000.00, 3, 4600.00);
INSERT INTO `tbl_print_price` VALUES (16, 6000.00, 3, 5000.00);
INSERT INTO `tbl_print_price` VALUES (17, 7000.00, 3, 5400.00);
INSERT INTO `tbl_print_price` VALUES (18, 8000.00, 3, 5800.00);
INSERT INTO `tbl_print_price` VALUES (19, 9000.00, 3, 6200.00);
INSERT INTO `tbl_print_price` VALUES (20, 10000.00, 3, 6600.00);
INSERT INTO `tbl_print_price` VALUES (21, 1000.00, 4, 2000.00);
INSERT INTO `tbl_print_price` VALUES (22, 2000.00, 4, 2300.00);
INSERT INTO `tbl_print_price` VALUES (23, 3000.00, 4, 2600.00);
INSERT INTO `tbl_print_price` VALUES (24, 4000.00, 4, 2900.00);
INSERT INTO `tbl_print_price` VALUES (25, 5000.00, 4, 3200.00);
INSERT INTO `tbl_print_price` VALUES (26, 6000.00, 4, 3500.00);
INSERT INTO `tbl_print_price` VALUES (27, 7000.00, 4, 3800.00);
INSERT INTO `tbl_print_price` VALUES (28, 8000.00, 4, 4100.00);
INSERT INTO `tbl_print_price` VALUES (29, 9000.00, 4, 4400.00);
INSERT INTO `tbl_print_price` VALUES (30, 10000.00, 4, 4700.00);

-- ----------------------------
-- Table structure for tbl_product
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE `tbl_product`  (
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `product_category_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสหมวดหมู่',
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสินค้า',
  `package_type_id` int(11) NULL DEFAULT NULL COMMENT 'ประเภทสินค้า',
  `product_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ตัวเลือก',
  `product_image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่รูปภาพ',
  `product_image_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ลิงค์ภาพ',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product
-- ----------------------------
INSERT INTO `tbl_product` VALUES ('P.20190121.00004', 'PC-00002', 'นามบัตร', 6, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"1\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"พิมพ์สองหน้า\",\"required\":\"0\"},\"after_print\":{\"value\":\"1\",\"label\":\"พิมพ์หน้าเดียว\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/L3bGsmMS6ixVDMPWEB49qrRnAMltT3q_.jpg', '/uploads', 1, '2019-01-21 15:14:54', 1, '2019-07-24 15:22:15');
INSERT INTO `tbl_product` VALUES ('P.20190121.00003', 'PC-00002', 'การ์ด', 4, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"1\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"1\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"1\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"1\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนแผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"0\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"0\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"1\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/nnGEZ0VOiXZ1PgGPCcwVCgLTrZYZ3Trh.png', '/uploads', 1, '2019-01-21 13:44:13', 1, '2019-07-24 14:37:26');
INSERT INTO `tbl_product` VALUES ('P-20190121-00002', 'PC-00002', 'ใบปลิว', 10, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"1\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"1\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"1\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"0\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"1\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/8ALOsY8oFzwWVoCooKftbvlptp-f0nsD.jpg', '/uploads', 1, '2019-01-21 22:21:10', 1, '2019-07-24 15:02:23');
INSERT INTO `tbl_product` VALUES ('P-20190123-00001', 'PC-00002', 'โปสการ์ด', 11, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาดสาเร็จ\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"1\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"1\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"1\",\"label\":\"วิธีพับ\",\"required\":\"1\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"1\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"1\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"1\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"1\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"1\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"1\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"1\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-01-23 15:52:21', 1, '2019-07-23 14:46:04');
INSERT INTO `tbl_product` VALUES ('P-2019061100001', 'PC-00002', 'ป้าย tag', 15, '', '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/จำนวนแผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"0\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัทมุมมน\",\"required\":\"0\"},\"perforate\":{\"value\":\"1\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"1\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-06-11 10:44:09', 1, '2019-07-23 16:32:34');
INSERT INTO `tbl_product` VALUES ('P-2019032900003', 'PC-00003', 'ถุงกระดาษ', 20, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"1\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"1\"},\"paper_height\":{\"value\":\"1\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"1\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/จำนวนแผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"0\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัทมุมมน\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/DIEPxjR8zXU4c5OwuALp8sgjE-KYf7zH.jpg', '/uploads', 13, '2019-03-29 12:23:22', 1, '2019-07-24 11:01:53');
INSERT INTO `tbl_product` VALUES ('P-2019012300003', 'PC-00002', 'บัตรสะสมแต้ม', 13, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"1\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"1\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"1\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"1\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"1\",\"label\":\"วิธีพับ\",\"required\":\"1\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"1\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"1\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"1\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"1\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"1\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"1\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"1\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-01-23 15:59:26', 1, '2019-07-23 16:28:20');
INSERT INTO `tbl_product` VALUES ('P-2019012400001', 'PC-00003', 'ฉลากติดสินค้า', 25, '<p>ป้ายสินค้า ใช้เพื่อบ่งบอกชื่อ คุณสมบัติสินค้า โดยที่ขนาดและรูปแบบของฉลากจะขึ้นอยู่กับ ภาพลักษณ์ ความเหมาะสมของสินค้า มีทั้งแบบไม่กันน้ำและกันน้ำ <br> ฉลากสติกเกอร์เป็นสิ่งที่จะติดตัวสินค้า โดยการออกแบบสติ๊กเกอร์สามารถที่จะออกแบบให้มีรูปร่างและขนาดขึ้นอยู่กับการใช้งาน แบ่งได้เป็นสองแบบ <br> สติกเกอร์กระดาษ เป็นที่นิยมใช้ ราคาถูก ใช้ติดสินค้าที่ไม่ต้องเปียก เช่น สติกเกอร์บาร์โค้ด สติกเกอร์บอกวันหมดอายุ</p>', '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง\",\"required\":\"1\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว\",\"required\":\"1\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย\",\"required\":\"1\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนที่ต้องการ\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"หนา้แรก \",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"1\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"1\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"perforate\":{\"value\":\"1\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/mMt_mZ82MiC7GcApHljVLT519nyJEKuE.png', '/uploads', 1, '2019-01-24 09:54:27', 1, '2019-07-24 15:05:13');
INSERT INTO `tbl_product` VALUES ('P-2019060700001', 'PC-00002', 'บิล/ใบเสร็จ/ใบส่งของ', 24, '', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"1\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"1\",\"label\":\"จำนวนแผ่นต่อชุด (2 แผ่น/ 3 แผ่น/ 4 แผ่น)\",\"required\":\"1\"},\"before_print\":{\"value\":\"0\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"0\"},\"after_print\":{\"value\":\"0\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"0\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"0\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัทมุมมน\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-06-07 14:03:15', 1, '2019-07-23 14:49:25');
INSERT INTO `tbl_product` VALUES ('P-2019032900001', 'PC-00002', 'ปฏิทิน', 14, '<p>ปัจจุบันหลายๆองค์กรมีการสร้างสรรค์ออกแบบปฏิทินให้มีความน่าสนใจละแตกต่าง เพื่อเป็นของขวัญมอบให้ลูกค้าช่วงปีใหม่</p><p style=\"margin-left: 20px;\"><span></span>รวมถึงเพื่อแย่งพื้นที่บนโต๊ะทำงานของลูกค้า เพื่อให้แบรนด์ของตัวเองอยู่กับลูกค้าตลอด 365 วัน </p><center><p>เพราะปฎิทินไม่ได้ใช้เพียงแค่แสดงถึงวัน เดือน ปืเท่านั้น แต่ยังเป็นสื่อประชาสัมพันธ์ที่ช่วยสะท้อนภาพลักษณ์ให้กับบริษัท/องค์กรที่เป็นผู้จัดทำด้วย</p></center>', '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/จำนวนแผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"0\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"0\"},\"after_print\":{\"value\":\"0\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"0\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"0\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัทมุมมน\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"1\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"1\"},\"book_binding_id\":{\"value\":\"1\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"1\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"Cust Quantity\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/eExnnV87x15aBNqQzzylY9sECdrEct7u.png', '/uploads', 1, '2019-03-29 11:01:34', 1, '2019-07-23 14:49:52');
INSERT INTO `tbl_product` VALUES ('P-2019072400001', 'PC-00003', 'สติ๊กเกอร์', 25, '', '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"1\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"1\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"1\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/จำนวนแผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"พิมพ์สองหน้า\",\"required\":\"0\"},\"after_print\":{\"value\":\"1\",\"label\":\"พิมพ์หน้าเดียว\",\"required\":\"0\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"1\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"1\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ตัวเลือก ไดคัทมุมมน\",\"required\":\"0\"},\"perforate\":{\"value\":\"1\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(ปั๊มนูน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"จำนวนที่ต้องการ\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/ayKqvWWy-3qDRT8XUMg9i6sH0p3AiWU-.png', '/uploads', 1, '2019-07-24 09:52:31', 1, '2019-07-24 15:03:46');
INSERT INTO `tbl_product` VALUES ('P-2019072300004', 'PC-00003', 'กล่อง', 21, '', '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_height\":{\"value\":\"0\",\"label\":\"สูง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/จำนวนแผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"0\",\"label\":\"พิมพ์สองหน้า\",\"required\":\"0\"},\"after_print\":{\"value\":\"0\",\"label\":\"พิมพ์หน้าเดียว\",\"required\":\"0\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"coating_option\":{\"value\":\"0\",\"label\":\"เคลือบด้านเดียวหรือสองด้าน\",\"required\":\"0\"},\"diecut\":{\"value\":\"0\",\"label\":\"ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ตัวเลือก ไดคัทมุมมน\",\"required\":\"0\"},\"perforate\":{\"value\":\"0\",\"label\":\"ตัดเป็นตัว/เจาะมุม\",\"required\":\"0\"},\"perforate_option_id\":{\"value\":\"0\",\"label\":\"มุมที่เจาะ\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนูน)\",\"required\":\"0\"},\"glue\":{\"value\":\"0\",\"label\":\"ปะกาว\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"},\"cust_quantity\":{\"value\":\"0\",\"label\":\"จำนวนที่ต้องการ\",\"required\":\"0\"},\"final_price\":{\"value\":\"0\",\"label\":\"ราคา\",\"required\":\"0\"}}', '/1/Pp9bm3Nve-rbb3qhyN5tbNxbZ1RFuYmI.png', '/uploads', 1, '2019-07-23 15:06:38', 1, '2019-07-23 15:06:38');

-- ----------------------------
-- Table structure for tbl_product_catalog
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_catalog`;
CREATE TABLE `tbl_product_catalog`  (
  `product_catalog_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `paper_size_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ขนาด',
  `paper_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง(กำหนดเอง)',
  `paper_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว(กำหนดเอง)',
  `paper_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(กำหนดเอง)',
  `page_qty` int(11) NULL DEFAULT NULL COMMENT 'จำนวนหน้า/จำนวนแผ่น',
  `before_print` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'พิมพ์สองหน้า',
  `after_print` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'พิมพ์ด้านเดียว',
  `paper_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'กระดาษ',
  `coating_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบ',
  `coating_option` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบด้านเดียวหรือสองด้าน',
  `diecut` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ',
  `diecut_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไดคัทมุมมน',
  `fold_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีพับ',
  `foil_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง(ฟอยล์)',
  `foil_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว(ฟอยล์)',
  `foil_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(ฟอยล์)',
  `foil_color_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สีฟอยล์',
  `emboss_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง(ปั๊มนูน)',
  `emboss_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว(ปั๊มนูน)',
  `emboss_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(ปั๊มนุน)',
  `land_orient` int(11) NULL DEFAULT NULL COMMENT 'แนวตั้ง/แนวนอน',
  `book_binding_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีเข้าเล่ม',
  `cust_quantity` decimal(10, 2) NULL DEFAULT NULL COMMENT 'จำนวนที่ต้องการ',
  `final_price` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ราคา',
  PRIMARY KEY (`product_catalog_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_catalog
-- ----------------------------
INSERT INTO `tbl_product_catalog` VALUES (1, 'P.20190121.00004', 'custom', 10.00, 15.00, 3, NULL, 'PT-00002', 'PT-00001', 'P-00002', '', '', '', '', 'N', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 'N', NULL, NULL);
INSERT INTO `tbl_product_catalog` VALUES (2, 'P-20190123-00001', 'PS-00008', NULL, NULL, NULL, NULL, 'PT-00001', 'PT-00002', 'P-00044', 'C-00001', 'two_page', 'Curve', 'D-00007', 'FOLD-00006', 2.00, 2.00, 2, 'FOIL-00003', 2.00, 2.00, 2, NULL, 'N', 1.00, NULL);
INSERT INTO `tbl_product_catalog` VALUES (3, 'P-2019032900001', 'custom', 10.00, 18.00, 3, NULL, '', '', 'P-00034', '', '', '', '', 'N', NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 'N', NULL, NULL);
INSERT INTO `tbl_product_catalog` VALUES (4, 'P-2019012300003', 'PS-00009', NULL, NULL, NULL, NULL, 'PT-00001', 'PT-00001', 'P-00044', 'N', '', 'N', '', 'N', 2.00, 2.00, 2, 'FOIL-00003', 2.00, 2.00, 2, NULL, 'N', NULL, NULL);
INSERT INTO `tbl_product_catalog` VALUES (5, 'P-2019012400001', 'custom', 10.00, 18.00, 2, NULL, 'PT-00001', '', 'P-00022', 'N', '', 'Default', '', 'N', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 'N', 20.00, NULL);
INSERT INTO `tbl_product_catalog` VALUES (6, 'P-2019032900003', 'custom', 15.00, 15.00, 2, NULL, 'PT-00001', 'PT-00001', 'P-00036', 'N', '', '', '', 'N', 2.00, 2.00, 2, 'FOIL-00003', 2.00, 2.00, 2, NULL, 'N', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_product_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_category`;
CREATE TABLE `tbl_product_category`  (
  `product_category_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `product_category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'หมวดหมู่',
  PRIMARY KEY (`product_category_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_category
-- ----------------------------
INSERT INTO `tbl_product_category` VALUES ('PC-00002', 'สื่อสิ่งพิมพ์');
INSERT INTO `tbl_product_category` VALUES ('PC-00003', 'บรรจุภัณฑ์');

-- ----------------------------
-- Table structure for tbl_product_option
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_option`;
CREATE TABLE `tbl_product_option`  (
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `paper_size_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ขนาดกระดาษ',
  `before_printing` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ด้านหน้าพิมพ์',
  `after_printing` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ด้านหลังพิมพ์',
  `paper_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'กระดาษ',
  `coating_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบ',
  `diecut_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไดคัท',
  `fold_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีพับ',
  `foil_color_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สีฟอยล์',
  `book_binding_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีเข้าเล่ม',
  `two_page_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'พิมพ์หน้าหลัง',
  `one_page_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'พิมพ์หน้าเดียว',
  `perforate_option` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รูปแบบ tag/ที่คั่นหนังสือ',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_option
-- ----------------------------
INSERT INTO `tbl_product_option` VALUES ('P.20190121.00003', '[\"PS-00020\",\"PS-00021\",\"PS-00034\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00028\",\"P-00029\",\"P-00030\",\"P-00031\",\"P-00038\",\"P-00039\",\"P-00046\",\"P-00047\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00010\"]', '[\"FOLD-00006\",\"FOLD-00007\",\"FOLD-00008\"]', '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P.20190121.00004', '[\"PS-00022\",\"PS-00023\",\"PS-00024\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00028\",\"P-00029\",\"P-00030\",\"P-00031\",\"P-00038\",\"P-00039\",\"P-00046\",\"P-00047\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', NULL, '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-20190121-00002', '[\"PS-00033\",\"PS-00034\",\"PS-00035\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00006\",\"P-00007\",\"P-00008\",\"P-00009\",\"P-00010\",\"P-00011\",\"P-00012\",\"P-00013\",\"P-00014\",\"P-00015\",\"P-00016\",\"P-00017\",\"P-00018\",\"P-00019\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', '[\"FOLD-00006\",\"FOLD-00007\",\"FOLD-00008\",\"FOLD-00010\",\"FOLD-00011\"]', '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-20190123-00001', '[\"PS-00005\",\"PS-00006\",\"PS-00008\"]', NULL, NULL, '[\"P-00044\",\"P-00045\",\"P-00046\",\"P-00047\",\"P-00054\",\"P-00055\",\"P-00062\",\"P-00063\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00005\",\"D-00006\",\"D-00009\",\"D-00010\",\"D-00011\"]', '[\"FOLD-00006\",\"FOLD-00007\",\"FOLD-00008\"]', '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019060700001', '[\"PS-00011\",\"PS-00012\",\"PS-00013\"]', NULL, NULL, '[\"P-00069\",\"P-00070\",\"P-00071\",\"P-00072\",\"P-00073\",\"P-00074\"]', NULL, NULL, NULL, NULL, NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019032900003', NULL, '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00020\",\"P-00021\",\"P-00022\",\"P-00023\"]', '[\"C-00001\",\"C-00002\",\"C-00003\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', NULL, '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019072300004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019012300003', '[\"PS-00009\",\"PS-00010\",\"PS-00015\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00044\",\"P-00045\",\"P-00046\",\"P-00047\",\"P-00054\",\"P-00055\",\"P-00062\",\"P-00063\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', '[\"FOLD-00006\",\"FOLD-00007\",\"FOLD-00008\",\"FOLD-00010\",\"FOLD-00011\"]', '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019012400001', NULL, '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00006\",\"P-00007\",\"P-00008\",\"P-00009\",\"P-00010\",\"P-00011\",\"P-00012\",\"P-00013\",\"P-00014\",\"P-00015\",\"P-00016\",\"P-00017\",\"P-00018\",\"P-00019\"]', '[\"C-00001\",\"C-00002\",\"C-00003\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', NULL, '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019032900001', NULL, NULL, NULL, '[\"P-00034\"]', NULL, NULL, NULL, NULL, NULL, '', '', NULL);
INSERT INTO `tbl_product_option` VALUES ('P-2019061100001', NULL, '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00042\",\"P-00043\",\"P-00044\",\"P-00045\",\"P-00046\",\"P-00047\",\"P-00054\",\"P-00055\",\"P-00056\",\"P-00057\",\"P-00058\",\"P-00059\",\"P-00062\",\"P-00063\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', NULL, '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', '[\"3\",\"4\",\"5\"]');
INSERT INTO `tbl_product_option` VALUES ('P-2019072400001', NULL, '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"PT-00005\",\"PT-00006\",\"PT-00007\",\"PT-00008\"]', '[\"P-00048\",\"P-00049\",\"P-00050\",\"P-00051\",\"P-00052\"]', '[\"C-00001\",\"C-00002\",\"C-00003\"]', '[\"D-00007\",\"D-00010\",\"D-00018\",\"D-00019\"]', NULL, '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', NULL, '', '', NULL);

-- ----------------------------
-- Table structure for tbl_quotation
-- ----------------------------
DROP TABLE IF EXISTS `tbl_quotation`;
CREATE TABLE `tbl_quotation`  (
  `quotation_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่ใบเสนอราคา',
  `quotation_customer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ชื่อลูกค้า',
  `quotation_customer_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่',
  `quotation_customer_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'อีเมล์',
  `quotation_customer_tel` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เบอร์โทร',
  `quotation_customer_fax` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'แฟกซ์',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  PRIMARY KEY (`quotation_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_quotation
-- ----------------------------
INSERT INTO `tbl_quotation` VALUES ('QO-2019032900001', 'santipabprint', 'ถนนแก้วนวรัฐ ต.วัดเกต อ.เมือง จ.เชียงใหม่ 50000', 'santipabprint@gmail.com', '0532486578', NULL, '2019-03-29 11:36:00', '2019-03-29 11:36:00');
INSERT INTO `tbl_quotation` VALUES ('QO-2019040300001', 'รัชฎา นาไชยธง', '17/16 สุธีนีย์อพาสเมน', 'pun.bxxx@gmail.com', '0845195706', NULL, '2019-04-03 09:37:34', '2019-04-03 09:37:34');
INSERT INTO `tbl_quotation` VALUES ('QO-2019040400001', 'รัชฎา  นาไชยธง', '22/78 อันดามันพัฒนา แขวงสีกัน  เขตดอนเมือง จ.กรุงเทพมหานคร', 'pun.bxxx@gmail.com', '0845195706', NULL, '2019-04-04 09:10:05', '2019-04-04 09:10:05');
INSERT INTO `tbl_quotation` VALUES ('QO-2019040500001', 'รัชฎา นาไชยธง', '22/78 ธนินธรณ์ วิภาวดี แขวงสีกัน เขตดอนเมือง กรุงเทพมหานคร', 'pun.bxxx@gmail.com', '0845195706', NULL, '2019-04-05 10:09:19', '2019-04-05 10:09:19');
INSERT INTO `tbl_quotation` VALUES ('QO-2019060500001', 'รัชฎา', '22/87 ถ.วิภาวดีรังสิต ซ.วิภาวดีรังสิต35 แขวงสีกัน เขตดอนเมือง จังหวัดกรุงเทพมหานคร', 'pun_ratchada@hotmail.com', '0845195706', NULL, '2019-06-05 09:53:33', '2019-06-05 09:53:33');
INSERT INTO `tbl_quotation` VALUES ('QO-2019060500002', ' รัชฎา  นาไชยธง', '22/87 อันดามันพัฒนา ถ.วิภาวดีรังสิต ซ.วิภาวดีรังสิต 35 แขวงสีกัน เขตดอนเมือง กรุงเทพมหานคร 10210', 'pun.bxxx@gmail.com', '0845195706', NULL, '2019-06-05 15:53:32', '2019-06-05 15:53:32');
INSERT INTO `tbl_quotation` VALUES ('QO-2019072400001', 'รัชฎา  นาไชยธง', 'หจก.อันดามันพัฒนา 21/12 ซ.วิภาวดีรังสิต  33  แยก 3 แขวง สีกัน เขตดอนเมือง กทม', 'pun.bxxx@gmail.com', '0845195706', '', '2019-07-24 15:21:13', '2019-07-24 15:21:13');
INSERT INTO `tbl_quotation` VALUES ('QO-2019072500001', 'ดวงสมร', '214', '', '0850328565', '', '2019-07-25 09:38:38', '2019-07-25 09:38:38');
INSERT INTO `tbl_quotation` VALUES ('QO-2019072500002', 'กก', 'กก', '', 'ก', '', '2019-07-25 09:41:08', '2019-07-25 09:41:08');

-- ----------------------------
-- Table structure for tbl_quotation_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_quotation_detail`;
CREATE TABLE `tbl_quotation_detail`  (
  `quotation_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `quotation_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่ใบเสนอราคา',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `paper_size_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ขนาด',
  `paper_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง(กำหนดเอง)',
  `paper_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว(กำหนดเอง)',
  `paper_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'สูง(กำหนดเอง)',
  `paper_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(กำหนดเอง)',
  `page_qty` int(11) NULL DEFAULT NULL COMMENT 'จำนวนหน้า/จำนวนแผ่น',
  `before_print` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ด้านหน้าพิมพ์',
  `after_print` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ด้านหลังพิมพ์',
  `paper_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'กระดาษ',
  `coating_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบ',
  `coating_option` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบด้านเดียวหรือสองด้าน',
  `diecut` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ',
  `diecut_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไดคัทมุมมน',
  `perforate` int(11) NULL DEFAULT NULL COMMENT 'ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว',
  `perforate_option_id` int(11) NULL DEFAULT NULL COMMENT 'มุมที่เจาะ',
  `fold_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีพับ',
  `foil_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง(ฟอยล์)',
  `foil_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว(ฟอยล์)',
  `foil_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(ฟอยล์)',
  `foil_color_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สีฟอยล์',
  `emboss_size_width` decimal(10, 2) NULL DEFAULT NULL COMMENT 'กว้าง(ปั๊มนูน)',
  `emboss_size_height` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ยาว(ปั๊มนูน)',
  `emboss_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(ปั๊มนุน)',
  `glue` int(11) NULL DEFAULT NULL COMMENT 'ปะกาว',
  `land_orient` int(11) NULL DEFAULT NULL COMMENT 'แนวตั้ง/แนวนอน',
  `book_binding_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีเข้าเล่ม',
  `cust_quantity` decimal(10, 2) NULL DEFAULT NULL COMMENT 'จำนวนที่ต้องการ',
  `final_price` decimal(10, 2) NULL DEFAULT NULL COMMENT 'ราคา',
  PRIMARY KEY (`quotation_detail_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_quotation_detail
-- ----------------------------
INSERT INTO `tbl_quotation_detail` VALUES (2, 'QO-2019032900001', 'P-2019012400001', 'custom', 10.00, 18.00, NULL, 2, NULL, 'PT-00001', '', 'P-00022', 'N', '', 'Default', '', NULL, NULL, 'N', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 'N', 20.00, 550.00);
INSERT INTO `tbl_quotation_detail` VALUES (3, 'QO-2019040300001', 'P.20190121.00004', 'PS-00009', NULL, NULL, NULL, NULL, NULL, 'PT-00001', 'PT-00001', 'P-00045', 'C-00002', 'two_page', 'Default', '', NULL, NULL, 'FOLD-00006', 2.00, 2.00, 2, 'FOIL-00004', 2.00, 2.00, 2, NULL, NULL, 'N', 200.00, 68890.00);
INSERT INTO `tbl_quotation_detail` VALUES (4, 'QO-2019040400001', 'P.20190121.00004', 'PS-00009', NULL, NULL, NULL, NULL, NULL, 'PT-00001', 'PT-00001', 'P-00045', 'C-00002', 'two_page', 'Default', '', NULL, NULL, 'FOLD-00006', 2.00, 2.00, 2, 'FOIL-00004', 2.00, 2.00, 2, NULL, NULL, 'N', 200.00, 68890.00);
INSERT INTO `tbl_quotation_detail` VALUES (5, 'QO-2019040500001', 'P-2019032900003', 'custom', 4.00, 5.00, NULL, 3, NULL, 'PT-00001', 'PT-00001', 'P-00036', 'N', '', '', '', NULL, NULL, 'N', 2.00, 2.00, 2, 'FOIL-00004', 2.00, 2.00, 2, NULL, NULL, 'N', 200.00, 68500.00);
INSERT INTO `tbl_quotation_detail` VALUES (6, 'QO-2019060500001', 'P.20190121.00004', 'PS-00009', NULL, NULL, NULL, NULL, NULL, 'PT-00002', 'PT-00002', 'P-00044', 'C-00001', 'one_page', 'Default', '', NULL, NULL, 'FOLD-00006', 2.00, 2.00, 2, 'FOIL-00003', 3.00, 3.00, 2, NULL, NULL, 'N', 200.00, 2050.00);
INSERT INTO `tbl_quotation_detail` VALUES (7, 'QO-2019060500002', 'P.20190121.00004', 'PS-00009', NULL, NULL, NULL, NULL, NULL, 'PT-00002', 'PT-00001', 'P-00044', 'C-00001', 'one_page', 'Curve', 'D-00010', NULL, NULL, 'FOLD-00008', 2.00, 2.00, 1, 'FOIL-00003', 2.00, 2.00, 1, NULL, NULL, 'N', 200.00, 1570.00);
INSERT INTO `tbl_quotation_detail` VALUES (8, 'QO-2019072400001', 'P.20190121.00004', 'PS-00024', NULL, NULL, NULL, NULL, NULL, 'PT-00008', '', 'P-00046', 'N', '', 'Curve', 'D-00010', NULL, NULL, 'N', 1.00, 1.00, 3, 'FOIL-00005', 1.00, 1.00, 3, 0, NULL, 'N', 500.00, 6530.00);
INSERT INTO `tbl_quotation_detail` VALUES (9, 'QO-2019072500001', 'P.20190121.00004', 'PS-00024', NULL, NULL, NULL, NULL, NULL, 'PT-00008', '', 'P-00046', 'N', '', 'Curve', 'D-00019', NULL, NULL, 'N', 1.00, 1.00, 3, 'FOIL-00005', NULL, NULL, 3, 0, NULL, 'N', 1000.00, 9090.00);
INSERT INTO `tbl_quotation_detail` VALUES (10, 'QO-2019072500002', 'P.20190121.00004', 'PS-00024', NULL, NULL, NULL, NULL, NULL, 'PT-00008', '', 'P-00038', 'N', '', 'N', '', NULL, NULL, 'N', NULL, NULL, 3, 'FOIL-00005', NULL, NULL, 3, 0, NULL, 'N', 1000.00, 3390.00);

-- ----------------------------
-- Table structure for tbl_unit
-- ----------------------------
DROP TABLE IF EXISTS `tbl_unit`;
CREATE TABLE `tbl_unit`  (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อหน่วย',
  PRIMARY KEY (`unit_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_unit
-- ----------------------------
INSERT INTO `tbl_unit` VALUES (1, 'มล.');
INSERT INTO `tbl_unit` VALUES (2, 'ซม.');
INSERT INTO `tbl_unit` VALUES (3, 'นิ้ว');
INSERT INTO `tbl_unit` VALUES (4, 'เมตร');

-- ----------------------------
-- Table structure for token
-- ----------------------------
DROP TABLE IF EXISTS `token`;
CREATE TABLE `token`  (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE INDEX `token_unique`(`user_id`, `code`, `type`) USING BTREE,
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) NULL DEFAULT NULL,
  `unconfirmed_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `blocked_at` int(11) NULL DEFAULT NULL,
  `registration_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `last_login_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_unique_username`(`username`) USING BTREE,
  UNIQUE INDEX `user_unique_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'kidz@webkidz.com', '$2y$12$V1/vLHR46yYQQZ71ovqV4u/QJZGiTWV7LfdwYQEDldR3QsJQ.6lTa', '_o_e_OfGKRYSxkiTZssrLknzUsnixCk4', 1545020656, NULL, NULL, NULL, 1545020656, 1545020656, 0, 1564023574);
INSERT INTO `user` VALUES (12, 'tp.sci', 'admin.sci@mail.com', '$2y$12$MF2xD67p/sHpu3Bzek2uJOOlZ4XQaf2JNOdxnSnnMB5VL//ka9urG', 'Zi0R2Belruq01BAorEX2RjH_1CoL-gPS', 1545192169, NULL, NULL, '118.172.249.112', 1545192169, 1545192169, 0, 1546585387);
INSERT INTO `user` VALUES (13, 'santipabprint', 'santipabprint@gmail.com', '$2y$12$egD6MJqYGD1giZ/Zd2Kjc.7GwSECvdX4mJtVv7Nylr5cge6nj/FCy', 'm4LEhUvQicDqh_qIUJ9j-IKOr0hvyDIJ', 1553834010, NULL, NULL, '172.68.106.38', 1553834010, 1553834010, 0, 1554351274);

SET FOREIGN_KEY_CHECKS = 1;
