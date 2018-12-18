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

 Date: 18/12/2018 14:26:57
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
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `user` VALUES (1, 'admin', 'kidz@webkidz.com', '$2y$12$V1/vLHR46yYQQZ71ovqV4u/QJZGiTWV7LfdwYQEDldR3QsJQ.6lTa', '_o_e_OfGKRYSxkiTZssrLknzUsnixCk4', 1545020656, NULL, NULL, NULL, 1545020656, 1545020656, 0, 1545117811);
INSERT INTO `user` VALUES (4, 'tp.sci', 'tp.sci@santipab.info.com', '$2y$12$s2ASzmu2A5R1Xm1uT16J2.m7wc2jPMkh/K8WUiLobJdMUu9cwOfY.', 'AKHIsE0CiIw_4A7NJWoxHJuWvUAtOBCm', 1545116268, NULL, NULL, '127.0.0.1', 1545116268, 1545116268, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
