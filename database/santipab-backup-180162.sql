/*
 Navicat Premium Data Transfer

 Source Server         : localhost_wamp
 Source Server Type    : MariaDB
 Source Server Version : 100309
 Source Host           : localhost:3307
 Source Schema         : santipab

 Target Server Type    : MariaDB
 Target Server Version : 100309
 File Encoding         : 65001

 Date: 18/01/2019 16:01:24
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
INSERT INTO `auth_item` VALUES ('/settings/*', 2, NULL, NULL, NULL, 1547105703, 1547105703);
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
INSERT INTO `auto_number` VALUES ('1781a2a4bc36a2e63c9216071173b7cd', 1, NULL, 1547366134);
INSERT INTO `auto_number` VALUES ('2fffe6fe1672abb559bbc71c122b6382', 5, 4, 1547365191);
INSERT INTO `auto_number` VALUES ('3dc9d4da488e68689fed892022db3c5f', 1, NULL, 1547614959);
INSERT INTO `auto_number` VALUES ('4eccfc65df194d88c011db4f242eaa20', 11, 10, 1547615224);
INSERT INTO `auto_number` VALUES ('5d790029966eb95421d5017e7dd94132', 4, 3, 1547186196);
INSERT INTO `auto_number` VALUES ('80bddb44bdb0cc5703bb1db91c64e97b', 7, 6, 1547114437);
INSERT INTO `auto_number` VALUES ('871717ec9fd7d82de4ccb3988217618f', 9, 8, 1547615068);
INSERT INTO `auto_number` VALUES ('a00383d9e582a583d30797af380cf49b', 5, 4, 1547365295);
INSERT INTO `auto_number` VALUES ('bb3f2db12ac4d8a8f919230b521bd94b', 6, 5, 1547365154);
INSERT INTO `auto_number` VALUES ('d73712c84cbef363b4d5af6eed8e9f7d', 5, 4, 1547365076);
INSERT INTO `auto_number` VALUES ('deed1f1c3a1a7ecc54729be22bb7010a', 8, 7, 1547615161);

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
) ENGINE = MyISAM AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `file_storage_item` VALUES (31, 'fileStorage', '/uploads', '\\1\\8kpzZsN9cEuSRv-Dm9d55aGwloOqyHf-.png', 'image/png', 5725, '8kpzZsN9cEuSRv-Dm9d55aGwloOqyHf-', '127.0.0.1', 1547109405);
INSERT INTO `file_storage_item` VALUES (32, 'fileStorage', '/uploads', '\\1\\BMM9S6P-yQb-US8nXbimAfw9Vtsioa9L.png', 'image/png', 5725, 'BMM9S6P-yQb-US8nXbimAfw9Vtsioa9L', '127.0.0.1', 1547109464);
INSERT INTO `file_storage_item` VALUES (33, 'fileStorage', '/uploads', '\\1\\apxvAYEjI8SOSTo1iAzAEXOTVms6yg0m.png', 'image/png', 6961, 'apxvAYEjI8SOSTo1iAzAEXOTVms6yg0m', '127.0.0.1', 1547110699);
INSERT INTO `file_storage_item` VALUES (35, 'fileStorage', '/uploads', '\\1\\CHkVQgANRn-l0cH1KBiIG1is1AKa_61f.png', 'image/png', 9291, 'CHkVQgANRn-l0cH1KBiIG1is1AKa_61f', '127.0.0.1', 1547112560);
INSERT INTO `file_storage_item` VALUES (38, 'fileStorage', '/uploads', '\\1\\CYp9hYpHkb2D8qEE5MZVW1jL1qNTpYZt.png', 'image/png', 6478, 'CYp9hYpHkb2D8qEE5MZVW1jL1qNTpYZt', '127.0.0.1', 1547112787);
INSERT INTO `file_storage_item` VALUES (39, 'fileStorage', '/uploads', '\\1\\UvasOWPAOa9CvydlnsfAgdVQcMpxnIOX.png', 'image/png', 6037, 'UvasOWPAOa9CvydlnsfAgdVQcMpxnIOX', '127.0.0.1', 1547177769);
INSERT INTO `file_storage_item` VALUES (40, 'fileStorage', '/uploads', '\\1\\FMCw9uwqColz0yfOfl1I8a7CT-ffWqtO.png', 'image/png', 5558, 'FMCw9uwqColz0yfOfl1I8a7CT-ffWqtO', '127.0.0.1', 1547177960);
INSERT INTO `file_storage_item` VALUES (45, 'fileStorage', '/uploads', '\\1\\2wgjQINMiNIteK8LsNdp8EyqgjgKggPt.png', 'image/png', 5650, '2wgjQINMiNIteK8LsNdp8EyqgjgKggPt', '127.0.0.1', 1547442096);
INSERT INTO `file_storage_item` VALUES (46, 'fileStorage', '/uploads', '\\1\\vH0yaVvnN7MgWZht2nLkKWmURHEwlY-S.png', 'image/png', 6037, 'vH0yaVvnN7MgWZht2nLkKWmURHEwlY-S', '127.0.0.1', 1547442111);
INSERT INTO `file_storage_item` VALUES (43, 'fileStorage', '/uploads', '\\1\\s91AQkXCe8kVombrnezmWXbmf7fCGraC.png', 'image/png', 5558, 's91AQkXCe8kVombrnezmWXbmf7fCGraC', '127.0.0.1', 1547192556);
INSERT INTO `file_storage_item` VALUES (48, 'fileStorage', '/uploads', '\\1\\r39ZIgTkbcUo75eZ7CR5MpDtb9GxENI5.png', 'image/png', 6961, 'r39ZIgTkbcUo75eZ7CR5MpDtb9GxENI5', '127.0.0.1', 1547626824);

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
INSERT INTO `migration` VALUES ('m140527_084418_auto_number', 1547092842);

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
INSERT INTO `profile` VALUES (1, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Asia/Bangkok', '\\1\\0D9e3h0Wmuep0Y6JfienIZRxpDgmfLVg.jpg', '/uploads', 1, 'Tanakorn', 'Phompak', '1992-11-15', '086-323-2323', '1');
INSERT INTO `profile` VALUES (4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'tp.sci', 'ppak', '1993-12-12', '082-111-5151', '1');

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of social_account
-- ----------------------------
INSERT INTO `social_account` VALUES (3, 4, 'line', 'Uab3ff8507aba5e8f125e72ec98d62454', '{\"userId\":\"Uab3ff8507aba5e8f125e72ec98d62454\",\"pictureUrl\":\"https://profile.line-scdn.net/0h7SfRxh8iaHxbK0XgYP0XK2duZhEsBW40IxkhGnp7Y0gkEiYsMh4lHSx4Yk8lGCZ_NEkiTyx-ZEp0\",\"email\":null,\"id\":\"Uab3ff8507aba5e8f125e72ec98d62454\"}', NULL, NULL, NULL, NULL);

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
-- Table structure for tbl_coating_options
-- ----------------------------
DROP TABLE IF EXISTS `tbl_coating_options`;
CREATE TABLE `tbl_coating_options`  (
  `coating_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสการเคลือบ',
  `coating_option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อรูปแบบการเคลือบ',
  `coating_option_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`coating_option_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_coating_options
-- ----------------------------
INSERT INTO `tbl_coating_options` VALUES ('CO.00001', 'เคลือบ pvc (แบบด้าน) หน้าเดียว', 'รายละเอียด เคลือบ pvc (แบบด้าน) หน้าเดียว', 'SP.20190111.00001');
INSERT INTO `tbl_coating_options` VALUES ('CO.00003', 'เคลือบ pvc (แบบด้าน) สองหน้า', 'รายละเอียด เคลือบ pvc (แบบด้าน) สองหน้า', 'SP.20190111.00001');
INSERT INTO `tbl_coating_options` VALUES ('CO.00004', 'เคลือบ pvc (แบบเงา) หน้าเดียว', '', 'SP.20190111.00001');
INSERT INTO `tbl_coating_options` VALUES ('CO.00005', 'เคลือบ pvc (แบบเงา) สองหน้า', '', 'SP.20190111.00001');

-- ----------------------------
-- Table structure for tbl_dicut_options
-- ----------------------------
DROP TABLE IF EXISTS `tbl_dicut_options`;
CREATE TABLE `tbl_dicut_options`  (
  `dicut_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dicut_option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อไดคัท',
  `dicut_option_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`dicut_option_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_dicut_options
-- ----------------------------
INSERT INTO `tbl_dicut_options` VALUES ('DI.00004', 'ไม่ไดคัท', '', 'SP.20190111.00001');
INSERT INTO `tbl_dicut_options` VALUES ('DI.00005', 'ไดคัทมุมมน (มุมซ้ายบน)', '', 'SP.20190111.00001');
INSERT INTO `tbl_dicut_options` VALUES ('DI.00006', 'ไดคัทมุมมน (มุมซ้ายล่าง)', '', 'SP.20190111.00001');

-- ----------------------------
-- Table structure for tbl_foiling_options
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foiling_options`;
CREATE TABLE `tbl_foiling_options`  (
  `foiling_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `foiling_option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสีฟอยล์',
  `foiling_option_color_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'โค้ดสี',
  `foiling_option_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`foiling_option_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_foiling_options
-- ----------------------------
INSERT INTO `tbl_foiling_options` VALUES ('FO.00003', 'สีเงิน', '#ffffff', '', 'SP.20190111.00001');
INSERT INTO `tbl_foiling_options` VALUES ('FO.00004', 'สีทอง', '#ffff00', '', 'SP.20190111.00001');
INSERT INTO `tbl_foiling_options` VALUES ('FO.00005', 'สีพิเศษ', '', '', 'SP.20190111.00001');

-- ----------------------------
-- Table structure for tbl_fold_options
-- ----------------------------
DROP TABLE IF EXISTS `tbl_fold_options`;
CREATE TABLE `tbl_fold_options`  (
  `fold_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fold_option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อแบบการพับ',
  `fold_option_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`fold_option_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_fold_options
-- ----------------------------
INSERT INTO `tbl_fold_options` VALUES ('F.00004', 'ไม่พับ', '', 'SP.20190111.00001');
INSERT INTO `tbl_fold_options` VALUES ('F.00005', 'พับครึ่ง', '', 'SP.20190111.00001');

-- ----------------------------
-- Table structure for tbl_paper_size
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_size`;
CREATE TABLE `tbl_paper_size`  (
  `paper_size_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสขนาด',
  `paper_size_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อขนาด',
  `paper_size_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `paper_size_width` float NULL DEFAULT NULL COMMENT 'ความกว้าง',
  `paper_size_height` float NULL DEFAULT NULL COMMENT 'ความยาว',
  `paper_unit_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสหน่วย',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`paper_size_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_size
-- ----------------------------
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00003', '4*6', '', 4, 6, 1, 'SP.20190111.00001');
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00004', '5*7', '', 5, 7, 1, 'SP.20190111.00001');
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00005', 'A5', '', NULL, NULL, NULL, 'SP.20190111.00001');
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00006', 'A6', 'รายละเอียด A6', NULL, NULL, NULL, 'SP.20190116.00001');
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00007', 'A5', 'รายละเอียด A5', NULL, NULL, NULL, 'SP.20190116.00001');
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00008', 'A4', 'รายละเอียด A4', NULL, NULL, NULL, 'SP.20190116.00001');
INSERT INTO `tbl_paper_size` VALUES ('PPZ.00009', '9.9x22 cm', 'รายละเอียด 9.9x22 cm', 9.9, 22, 1, 'SP.20190116.00001');

-- ----------------------------
-- Table structure for tbl_paper_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_type`;
CREATE TABLE `tbl_paper_type`  (
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `paper_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อประเภทกระดาษ',
  `paper_type_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`paper_type_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_type
-- ----------------------------
INSERT INTO `tbl_paper_type` VALUES ('PPT.00002', 'กระดาษ กรีนการ์ด 250', 'รายละเอียด กระดาษ กรีนการ์ด 250', 'SP.20190111.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00003', 'อาร์ตการ์ดสองหน้า 300', 'รายละเอียด อาร์ตการ์ดสองหน้า 300', 'SP.20190111.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00004', 'อาร์ตการ์ดหน้าเดียว 300', '', 'SP.20190111.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00005', 'กระดาษมี textureในตัว 250 แกรม', '', 'SP.20190111.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00006', 'กระดาษมี texture ในตัว 300 แกรม', '', 'SP.20190111.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00007', 'ปอนด์ 80 แกรม', 'ปอนด์ 80 แกรม', 'SP.20190116.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00008', 'อาร์ตมัน 105 แกรม', 'อาร์ตมัน 105 แกรม', 'SP.20190116.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00009', 'อาร์ตด้าน 105 แกรม', 'อาร์ตด้าน 105 แกรม', 'SP.20190116.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00010', 'อาร์ตมัน 120 แกรม', 'อาร์ตมัน 120 แกรม', 'SP.20190116.00001');
INSERT INTO `tbl_paper_type` VALUES ('PPT.00011', 'อาร์ตมัน 120 แกรม', 'อาร์ตมัน 120 แกรม', 'SP.20190116.00001');

-- ----------------------------
-- Table structure for tbl_paper_unit
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_unit`;
CREATE TABLE `tbl_paper_unit`  (
  `paper_unit_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหน่วย',
  `paper_unit_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อหน่วย',
  PRIMARY KEY (`paper_unit_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_unit
-- ----------------------------
INSERT INTO `tbl_paper_unit` VALUES (1, 'ซม. (cm)');

-- ----------------------------
-- Table structure for tbl_print_options
-- ----------------------------
DROP TABLE IF EXISTS `tbl_print_options`;
CREATE TABLE `tbl_print_options`  (
  `print_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `print_option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อแบบการพิมพ์',
  `print_option_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `print_img_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่ภาพ',
  `print_img_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'url รูปภาพ',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`print_option_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_print_options
-- ----------------------------
INSERT INTO `tbl_print_options` VALUES ('P.00003', 'พิมพ์ 4 สี', 'รายละเอียดพิมพ์ 4 สี', NULL, NULL, 'SP.20190111.00001');
INSERT INTO `tbl_print_options` VALUES ('P.00004', '1 สี (ไม่ใช่สีดา)', 'รายละเอียด1 สี (ไม่ใช่สีดา)', NULL, NULL, 'SP.20190111.00001');
INSERT INTO `tbl_print_options` VALUES ('P.00005', '1 สี (สีดา)', 'รายละเอียด1 สี (สีดา)', NULL, NULL, 'SP.20190111.00001');
INSERT INTO `tbl_print_options` VALUES ('P.00006', 'พิมพ์ 4 สี', 'รายละเอียด พิมพ์ 4 สี', NULL, NULL, 'SP.20190116.00001');
INSERT INTO `tbl_print_options` VALUES ('P.00007', '1 สี ไม่ใช่สีดำ', '', NULL, NULL, 'SP.20190116.00001');
INSERT INTO `tbl_print_options` VALUES ('P.00008', '1 สี สีดำ', '', NULL, NULL, 'SP.20190116.00001');

-- ----------------------------
-- Table structure for tbl_product
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE `tbl_product`  (
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `product_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสินค้า',
  `product_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `product_icon_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่ภาพ',
  `product_icon_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Url ภาพ',
  `product_status` int(11) NULL DEFAULT NULL COMMENT 'สถานะสินค้า',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'ว/ด/ป ที่บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'ว/ด/ป ที่แก้ไข',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product
-- ----------------------------
INSERT INTO `tbl_product` VALUES ('SP.20190111.00001', 'PT.00001', 'นามบัตร', '<h4>\r\n<p class=\"banneroption--content__infomation__heading\" style=\"margin: 12px 22px; padding: 0px; font-weight: bolder; color: rgb(1, 1, 1); font-family: open_sansregular, Verdana, Arial, sans-serif;\">ข้อดีของใบปลิว\r\n</p>\r\n<p style=\"margin-top: 6px; margin-bottom: 5px; margin-left: 20px; padding: 0px; font-size: 12px;\"><span rel=\"margin: 0px; padding: 0px; background: rgb(110, 247, 200); border-radius: 47%;\"><span class=\"fa fa-check\"></span></span> ใบปลิวคุณภาพดี\r\n	</p>\r\n	<p style=\"margin-top: 6px; margin-bottom: 5px; margin-left: 20px; padding: 0px; font-size: 12px;\"><span rel=\"margin: 0px; padding: 0px; background: rgb(110, 247, 200); border-radius: 47%;\"><span class=\"fa fa-check\"></span></span> พร้อมส่งในวันถัดไป\r\n	</p>\r\n	<p style=\"margin-top: 6px; margin-bottom: 5px; margin-left: 20px; padding: 0px; font-size: 12px;\"><span rel=\"margin: 0px; padding: 0px; background: rgb(110, 247, 200); border-radius: 47%;\"><span class=\"fa fa-check\"></span></span> มีประเภทกระดาษให้เลือกมากมาย\r\n	</p>\r\n\r\n<p class=\"banneroption--content__infomation__detail\" style=\"margin-bottom: 0px; padding: 6px 20px; font-size: 12px; color: rgb(99, 99, 99); font-family: open_sansregular, Verdana, Arial, sans-serif;\">ใบปลิวนั้นเป็นเครื่องมือทางการตลาดที่มีประสิทธิภาพสำหรับธุรกิจและองค์กรที่ต้องการโปรโมตสินค้าหรืออีเวนต์ ด้วยการใช้งานที่หลากหลายและต้นทุนการผลิตต่ำ ใบปลิวจึงสามารถช่วยให้ธุรกิจของคุณเข้าถึงผู้คนจำนวนมากด้วยต้นทุนที่ถูก เนื่องจากจำนวนขั้นต่ำใบปลิวของเราเริ่มต้นที่ 100 แผ่น ทำให้ใบปลิวเป็นเครื่องมือทางการตลาดที่เหมาะกับธุรกิจทุกขนาด<br style=\"margin: 0px; padding: 0px;\"><br style=\"margin: 0px; padding: 0px;\">เรามีตัวเลือกสินค้าที่หลากหลายเพื่อให้เหมาะกับความต้องการของธุรกิจและองค์กรทุกประเภท โดยใบปลิวของเรานั้นมีขนาดใหญ่สุดอยู่ที่ 95 ซม. x 65 ซม. และมีตัวเลือกกระดาษที่มีความหนาตั้งแต่ 80 จนถึง 300 แกรม สำหรับการตกแต่งรายละเอียดสุดท้ายเพื่อความสมบูรณ์ เราขอเสนอการเคลือบยูวี (UV) การเคลือบลามิเนตแบบด้านหรือแบบมันสำหรับใบปลิวของคุณ หากคุณต้องการใบปลิวแบบพับ โปรดไปที่หน้า<a href=\"https://www.gogoprint.co.th/%E0%B9%81%E0%B8%9C%E0%B9%88%E0%B8%99%E0%B8%9E%E0%B8%B1%E0%B8%9A.html\">แผ่นพับ</a>เพื่อดูทางเลือกที่หลากหลายของการพับ\r\n</p><p style=\"text-align: center;\"><img src=\"/uploads/1/8kpzZsN9cEuSRv-Dm9d55aGwloOqyHf-.png\" alt=\"8kpzZsN9cEuSRv-Dm9d55aGwloOqyHf-\"></p><p style=\"text-align: center;\"><img src=\"/uploads/1/BMM9S6P-yQb-US8nXbimAfw9Vtsioa9L.png\" alt=\"BMM9S6P-yQb-US8nXbimAfw9Vtsioa9L\"></p></h4>', '\\1\\UvasOWPAOa9CvydlnsfAgdVQcMpxnIOX.png', '/uploads', 1, 1, '2019-01-11 10:36:26', 1, '2019-01-15 21:07:10');
INSERT INTO `tbl_product` VALUES ('SP.20190111.00002', 'PT.00001', 'นามบัตรพับ', '', '\\1\\FMCw9uwqColz0yfOfl1I8a7CT-ffWqtO.png', '/uploads', 1, 1, '2019-01-11 10:39:39', 1, '2019-01-11 10:39:39');
INSERT INTO `tbl_product` VALUES ('SP.20190111.00003', 'PT.00006', 'สติ๊กเกอร์', '', '\\1\\2wgjQINMiNIteK8LsNdp8EyqgjgKggPt.png', '/uploads', 1, 1, '2019-01-11 10:51:32', 1, '2019-01-14 12:01:38');
INSERT INTO `tbl_product` VALUES ('SP.20190113.00001', 'PT.00001', 'การ์ดแต่งงาน', '', '\\1\\vH0yaVvnN7MgWZht2nLkKWmURHEwlY-S.png', '/uploads', 1, 1, '2019-01-13 14:55:34', 1, '2019-01-14 12:01:52');
INSERT INTO `tbl_product` VALUES ('SP.20190116.00001', 'PT.00002', 'ใบปลิว', '', '\\1\\r39ZIgTkbcUo75eZ7CR5MpDtb9GxENI5.png', '/uploads', 1, 1, '2019-01-16 12:02:39', 1, '2019-01-16 15:20:25');

-- ----------------------------
-- Table structure for tbl_product_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_group`;
CREATE TABLE `tbl_product_group`  (
  `product_group_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสกลุ่มสินค้า',
  `product_group_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อกลุ่ม',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'ว/ด/ป ที่บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'ว/ด/ป ที่แก้ไข',
  PRIMARY KEY (`product_group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_group
-- ----------------------------
INSERT INTO `tbl_product_group` VALUES ('PG.0010', 'บรรจุภัณฑ์', 1, '2019-01-10 13:34:32', 1, '2019-01-10 13:34:32');
INSERT INTO `tbl_product_group` VALUES ('PG.0012', 'หนังสือ', 1, '2019-01-10 14:06:52', 1, '2019-01-10 14:06:52');
INSERT INTO `tbl_product_group` VALUES ('PG.0013', 'สิ่งพิมพ์ขายดี', 1, '2019-01-10 15:37:34', 1, '2019-01-10 15:37:34');
INSERT INTO `tbl_product_group` VALUES ('PG.0014', 'สติ๊กเกอร์', 1, '2019-01-10 16:33:54', 1, '2019-01-10 16:33:54');

-- ----------------------------
-- Table structure for tbl_product_group_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_group_type`;
CREATE TABLE `tbl_product_group_type`  (
  `product_group_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสกลุ่มสินค้า',
  `product_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสประเภทสินค้า'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_group_type
-- ----------------------------
INSERT INTO `tbl_product_group_type` VALUES ('PG.0013', 'PT.00002');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0010', 'PT.00007');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0012', 'PT.00007');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0013', 'PT.00007');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0013', 'PT.00001');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0014', 'PT.00006');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0010', 'PT.00003');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0012', 'PT.00003');
INSERT INTO `tbl_product_group_type` VALUES ('PG.0013', 'PT.00003');

-- ----------------------------
-- Table structure for tbl_product_setting
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_setting`;
CREATE TABLE `tbl_product_setting`  (
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `coating` int(11) NULL DEFAULT NULL COMMENT 'การเคลือบ',
  `dicut` int(11) NULL DEFAULT NULL COMMENT 'ไดคัท',
  `fold` int(11) NULL DEFAULT NULL COMMENT 'การพับ',
  `foiling` int(11) NULL DEFAULT NULL COMMENT 'ฟอยล์',
  `embosser` int(11) NULL DEFAULT NULL COMMENT 'ปั๊มนูน',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_setting
-- ----------------------------
INSERT INTO `tbl_product_setting` VALUES ('SP.20190111.00001', 1, 1, 1, 1, 1);
INSERT INTO `tbl_product_setting` VALUES ('SP.20190111.00002', 1, 1, 1, 1, 1);
INSERT INTO `tbl_product_setting` VALUES ('SP.20190111.00003', 1, 0, 0, 1, 1);
INSERT INTO `tbl_product_setting` VALUES ('SP.20190113.00001', 1, 0, 1, 0, 1);
INSERT INTO `tbl_product_setting` VALUES ('SP.20190116.00001', 0, 0, 0, 0, 0);

-- ----------------------------
-- Table structure for tbl_product_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_type`;
CREATE TABLE `tbl_product_type`  (
  `product_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `product_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อประเภทสินค้า',
  `product_img_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ที่อยู่ภาพ',
  `product_img_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Url รูปภาพ',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'ว/ด/ป ที่บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'ว/ด/ป ที่แก้ไข',
  PRIMARY KEY (`product_type_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_type
-- ----------------------------
INSERT INTO `tbl_product_type` VALUES ('PT.00001', 'นามบัตร', '\\1\\BMM9S6P-yQb-US8nXbimAfw9Vtsioa9L.png', '/uploads', 1, '2019-01-10 15:38:17', 1, '2019-01-10 15:38:17');
INSERT INTO `tbl_product_type` VALUES ('PT.00002', 'ใบปลิว', '\\1\\apxvAYEjI8SOSTo1iAzAEXOTVms6yg0m.png', '/uploads', 1, '2019-01-10 15:58:21', 1, '2019-01-10 15:58:21');
INSERT INTO `tbl_product_type` VALUES ('PT.00003', 'แผ่นพับ', '\\1\\CHkVQgANRn-l0cH1KBiIG1is1AKa_61f.png', '/uploads', 1, '2019-01-10 15:58:36', 1, '2019-01-10 16:29:22');
INSERT INTO `tbl_product_type` VALUES ('PT.00006', 'สติ๊กเกอร์', '\\1\\CYp9hYpHkb2D8qEE5MZVW1jL1qNTpYZt.png', '/uploads', 1, '2019-01-10 16:33:14', 1, '2019-01-10 16:33:14');

-- ----------------------------
-- Table structure for tbl_quotation
-- ----------------------------
DROP TABLE IF EXISTS `tbl_quotation`;
CREATE TABLE `tbl_quotation`  (
  `quotation_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่ใบเสนอราคา',
  `user_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสลูกค้า',
  `quotation_status_id` int(11) NOT NULL COMMENT 'สถานะ',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  PRIMARY KEY (`quotation_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_quotation_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_quotation_detail`;
CREATE TABLE `tbl_quotation_detail`  (
  `quotation_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่ใบเสนอราคา',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `paper_size_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ขนาดกระดาษ',
  `custom_paper` int(11) NULL DEFAULT NULL COMMENT 'กำหนดขนาดเอง',
  `custom_paper_width` int(11) NULL DEFAULT NULL COMMENT 'กว้าง(กำหนดเอง)',
  `custom_paper_height` int(11) NULL DEFAULT NULL COMMENT 'สูง(กำหนดเอง)',
  `custom_paper_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(กำหนดเอง)',
  `quotation_qty` int(11) NOT NULL COMMENT 'จำนวนที่ต้องการ',
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ประเภทกระดาษ',
  `coating_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบ',
  `dicut_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไดคัท',
  `fold_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การพับ',
  `foiling_option_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สีฟอยล์',
  `foiling_width` int(11) NULL DEFAULT NULL COMMENT 'ขนาดฟอยล์ (กว้าง)',
  `foiling_height` int(11) NULL DEFAULT NULL COMMENT 'ขนาดฟอยล์ (สูง)',
  `foiling_unit_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'หน่วยฟอยล์',
  `embosser_width` int(11) NULL DEFAULT NULL COMMENT 'ขนาดปั๊มนูน (กว้าง)',
  `embosser_height` int(11) NULL DEFAULT NULL COMMENT 'ขนาดปั๊มนูน (ยาว)',
  `embosser_unit_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'หน่วยปั๊มนูน',
  `first_page` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'หน้าแรก',
  `last_page` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'หน้าหลัง',
  PRIMARY KEY (`quotation_detail_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_unit
-- ----------------------------
DROP TABLE IF EXISTS `tbl_unit`;
CREATE TABLE `tbl_unit`  (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อหน่วย',
  PRIMARY KEY (`unit_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'kidz@webkidz.com', '$2y$12$V1/vLHR46yYQQZ71ovqV4u/QJZGiTWV7LfdwYQEDldR3QsJQ.6lTa', '_o_e_OfGKRYSxkiTZssrLknzUsnixCk4', 1545020656, NULL, NULL, NULL, 1545020656, 1545020656, 0, 1547781704);
INSERT INTO `user` VALUES (4, 'tp.sci', 'tp.sci@santipab.info.com', '$2y$12$s2ASzmu2A5R1Xm1uT16J2.m7wc2jPMkh/K8WUiLobJdMUu9cwOfY.', 'AKHIsE0CiIw_4A7NJWoxHJuWvUAtOBCm', 1545116268, NULL, NULL, '127.0.0.1', 1545116268, 1545116268, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
