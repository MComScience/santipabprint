/*
 Navicat Premium Data Transfer

 Source Server         : localhost_wamp
 Source Server Type    : MariaDB
 Source Server Version : 100309
 Source Host           : localhost:3307
 Source Schema         : santipab-prod

 Target Server Type    : MariaDB
 Target Server Version : 100309
 File Encoding         : 65001

 Date: 25/01/2019 11:38:34
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
INSERT INTO `auto_number` VALUES ('0e3762718b3badc7c5bf7c0ca5be6af7', 4, 3, 1547986669);
INSERT INTO `auto_number` VALUES ('115aee6886fb14bacf70789686cb4a8f', 2, 1, 1548084070);
INSERT INTO `auto_number` VALUES ('13af8b6c435422ff246c091a4a994e93', 11, 10, 1547981368);
INSERT INTO `auto_number` VALUES ('160275192b1cf070d355d510f2f00f7f', 5, 4, 1547987658);
INSERT INTO `auto_number` VALUES ('1781a2a4bc36a2e63c9216071173b7cd', 1, NULL, 1547366134);
INSERT INTO `auto_number` VALUES ('2fffe6fe1672abb559bbc71c122b6382', 5, 4, 1547365191);
INSERT INTO `auto_number` VALUES ('3dc9d4da488e68689fed892022db3c5f', 1, NULL, 1547614959);
INSERT INTO `auto_number` VALUES ('42b4811dc1f7b16608733019c4184162', 5, 4, 1547953251);
INSERT INTO `auto_number` VALUES ('46385349dfa34b3c00eb32e6f99b20e1', 4, 3, 1548322104);
INSERT INTO `auto_number` VALUES ('4eccfc65df194d88c011db4f242eaa20', 11, 10, 1547615224);
INSERT INTO `auto_number` VALUES ('5015530f4642d6508c908cacaec53e31', 4, 3, 1547903736);
INSERT INTO `auto_number` VALUES ('5d790029966eb95421d5017e7dd94132', 4, 3, 1547186196);
INSERT INTO `auto_number` VALUES ('736f9a6b5abeac6ed79c6514322f6f08', 2, 1, 1547985710);
INSERT INTO `auto_number` VALUES ('787b9754a1de68048520d31240fd250a', 5, 4, 1548058888);
INSERT INTO `auto_number` VALUES ('802fdaf8090c5062b25b17f275cacb6a', 2, 1, 1548233656);
INSERT INTO `auto_number` VALUES ('80bddb44bdb0cc5703bb1db91c64e97b', 7, 6, 1547114437);
INSERT INTO `auto_number` VALUES ('871717ec9fd7d82de4ccb3988217618f', 9, 8, 1547615068);
INSERT INTO `auto_number` VALUES ('9dded4a35bac719be2524158c08a424e', 4, 3, 1547953164);
INSERT INTO `auto_number` VALUES ('a00383d9e582a583d30797af380cf49b', 5, 4, 1547365295);
INSERT INTO `auto_number` VALUES ('a00e2db3a300ba23c0f24d26a39959c5', 1, NULL, 1548298467);
INSERT INTO `auto_number` VALUES ('bb3f2db12ac4d8a8f919230b521bd94b', 6, 5, 1547365154);
INSERT INTO `auto_number` VALUES ('c2f70a20663722f24ad0144b2efe038d', 4, 3, 1548388884);
INSERT INTO `auto_number` VALUES ('d5edebc861751b8874aefe03d756cbe0', 3, 2, 1547981368);
INSERT INTO `auto_number` VALUES ('d73712c84cbef363b4d5af6eed8e9f7d', 5, 4, 1547365076);
INSERT INTO `auto_number` VALUES ('dbe099c1cca17381b00b0b26b4dccb48', 3, 2, 1547969112);
INSERT INTO `auto_number` VALUES ('deed1f1c3a1a7ecc54729be22bb7010a', 8, 7, 1547615161);
INSERT INTO `auto_number` VALUES ('dfc978044e41743a28f6ff8078cd6f42', 3, 2, 1548233966);
INSERT INTO `auto_number` VALUES ('e9ecc18f3e512237de4dc2c66b254f73', 5, 4, 1548235897);
INSERT INTO `auto_number` VALUES ('ffc3e576142970463ef0cbe90c803a5c', 2, 1, 1547973996);

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
) ENGINE = MyISAM AUTO_INCREMENT = 60 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `file_storage_item` VALUES (49, 'fileStorage', '/uploads', '\\1\\tKbcm6RqVK18OcT55r3vyEvUvS0CChAw.png', 'image/png', 6037, 'tKbcm6RqVK18OcT55r3vyEvUvS0CChAw', '127.0.0.1', 1548049025);
INSERT INTO `file_storage_item` VALUES (50, 'fileStorage', '/uploads', '\\1\\BvYtTnOULi6LCb9ucroQkufzd207YMrV.png', 'image/png', 6037, 'BvYtTnOULi6LCb9ucroQkufzd207YMrV', '127.0.0.1', 1548049427);
INSERT INTO `file_storage_item` VALUES (51, 'fileStorage', '/uploads', '\\1\\iJR3mdLDJ_let8TJRbtgKk42mhvJP-s6.png', 'image/png', 6037, 'iJR3mdLDJ_let8TJRbtgKk42mhvJP-s6', '127.0.0.1', 1548053198);
INSERT INTO `file_storage_item` VALUES (52, 'fileStorage', '/uploads', '\\1\\wY_PUt0vsdKYKbi4PLlEU_XELc_zmAYe.png', 'image/png', 6037, 'wY_PUt0vsdKYKbi4PLlEU_XELc_zmAYe', '127.0.0.1', 1548053231);
INSERT INTO `file_storage_item` VALUES (53, 'fileStorage', '/uploads', '\\1\\y7Q6IQ-JEEJI6guMaLIS3EgtaG2jMC40.png', 'image/png', 6037, 'y7Q6IQ-JEEJI6guMaLIS3EgtaG2jMC40', '127.0.0.1', 1548053283);
INSERT INTO `file_storage_item` VALUES (54, 'fileStorage', '/uploads', '\\1\\o4NvCBqzVhgdZ4tpIRsR3He4dFgQCFcL.png', 'image/png', 6037, 'o4NvCBqzVhgdZ4tpIRsR3He4dFgQCFcL', '127.0.0.1', 1548053374);
INSERT INTO `file_storage_item` VALUES (55, 'fileStorage', '/uploads', '\\1\\6d1cXcZ8WcjmUZd4tz9Bte3Jg1Arug2G.png', 'image/png', 5725, '6d1cXcZ8WcjmUZd4tz9Bte3Jg1Arug2G', '127.0.0.1', 1548058485);
INSERT INTO `file_storage_item` VALUES (57, 'fileStorage', '/uploads', '\\1\\68_xVZJpTeL1rFrdt33wCwRAvH-x1VZy.png', 'image/png', 6961, '68_xVZJpTeL1rFrdt33wCwRAvH-x1VZy', '127.0.0.1', 1548084030);
INSERT INTO `file_storage_item` VALUES (58, 'fileStorage', '/uploads', '\\1\\fz8kkd3Ik7feH3jLaWgoo4zgZnLZuyye.png', 'image/png', 6037, 'fz8kkd3Ik7feH3jLaWgoo4zgZnLZuyye', '127.0.0.1', 1548233611);
INSERT INTO `file_storage_item` VALUES (59, 'fileStorage', '/uploads', '\\1\\B2HzOcUgNPsNh7pe9ZDuyYK-IF6Lm0g7.png', 'image/png', 3972, 'B2HzOcUgNPsNh7pe9ZDuyYK-IF6Lm0g7', '127.0.0.1', 1548298219);

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
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
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
  CONSTRAINT `social_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
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
INSERT INTO `tbl_coating` VALUES ('C-00001', 'เคลือบ pvc ด้าน หน้าเดียว', '');
INSERT INTO `tbl_coating` VALUES ('C-00002', 'เคลือบ pvc ด้าน สองหน้า', '');

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
INSERT INTO `tbl_color_printing` VALUES ('PT-00001', 'พิมพ์ 4 สี', 'รายละเอียด');
INSERT INTO `tbl_color_printing` VALUES ('PT-00002', '1 สี (ไม่ใช่สีดำ)', '');
INSERT INTO `tbl_color_printing` VALUES ('PT-00004', '1 สี (สีดำ)', '');

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
INSERT INTO `tbl_diecut` VALUES ('D-00007', 'DG-00002', '1 มุมซ้ายล่าง', '');
INSERT INTO `tbl_diecut` VALUES ('D-00005', 'DG-00002', '1 มุมซ้ายบน', '');
INSERT INTO `tbl_diecut` VALUES ('D-00006', 'DG-00002', '1 มุมขวาบน', '');
INSERT INTO `tbl_diecut` VALUES ('D-00009', 'DG-00002', '1 มุมขวาล่าง', '');
INSERT INTO `tbl_diecut` VALUES ('D-00010', 'DG-00003', '2 มุมซ้ายบน', '');
INSERT INTO `tbl_diecut` VALUES ('D-00011', 'DG-00003', '2 มุมขวาบน', '');

-- ----------------------------
-- Table structure for tbl_diecut_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_diecut_group`;
CREATE TABLE `tbl_diecut_group`  (
  `diecut_group_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `diecut_group_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รูปแบบไดคัท',
  PRIMARY KEY (`diecut_group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_diecut_group
-- ----------------------------
INSERT INTO `tbl_diecut_group` VALUES ('DG-00002', 'มุมมน 1 มุม');
INSERT INTO `tbl_diecut_group` VALUES ('DG-00003', 'มุมมน 2 มุม');

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
  `fold_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`fold_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_fold
-- ----------------------------
INSERT INTO `tbl_fold` VALUES ('FOLD-00001', 'ไม่พับ', 'รายละเอียด');
INSERT INTO `tbl_fold` VALUES ('FOLD-00003', 'พับครึ่ง', 'รายละเอียด');

-- ----------------------------
-- Table structure for tbl_paper
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper`;
CREATE TABLE `tbl_paper`  (
  `paper_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสประเภท',
  `paper_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อกระดาษ',
  `paper_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  PRIMARY KEY (`paper_id`) USING BTREE,
  INDEX `paper_type_id`(`paper_type_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper
-- ----------------------------
INSERT INTO `tbl_paper` VALUES ('P-00001', 'PT-00001', 'ปอนด์ 60 แกรม', 'รายละเอียด');
INSERT INTO `tbl_paper` VALUES ('P-00002', 'PT-00001', 'ปอนด์ 70 แกรม', '');
INSERT INTO `tbl_paper` VALUES ('P-00003', 'PT-00004', 'สติกเกอร์ PVC ใส', '');
INSERT INTO `tbl_paper` VALUES ('P-00004', 'PT-00004', 'สติกเกอร์ PVC ขาวเงา', '');
INSERT INTO `tbl_paper` VALUES ('P-00005', 'PT-00004', 'สติกเกอร์กระดาษขาวเงา', '');

-- ----------------------------
-- Table structure for tbl_paper_size
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_size`;
CREATE TABLE `tbl_paper_size`  (
  `paper_size_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_size_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อขนาด',
  `paper_size_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียด',
  `paper_size_width` int(11) NULL DEFAULT NULL COMMENT 'ความกว้าง',
  `paper_size_height` int(11) NULL DEFAULT NULL COMMENT 'ความยาว',
  `paper_unit_id` int(11) NULL DEFAULT NULL COMMENT 'หน่วย',
  PRIMARY KEY (`paper_size_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_size
-- ----------------------------
INSERT INTO `tbl_paper_size` VALUES ('PS-00002', 'A4', 'รายละเอียด', 100, 100, 2);
INSERT INTO `tbl_paper_size` VALUES ('PS-00004', 'A5', 'รายละเอียด', 150, 150, 2);

-- ----------------------------
-- Table structure for tbl_paper_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_paper_type`;
CREATE TABLE `tbl_paper_type`  (
  `paper_type_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัส',
  `paper_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อประเภทกระดาษ',
  PRIMARY KEY (`paper_type_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_paper_type
-- ----------------------------
INSERT INTO `tbl_paper_type` VALUES ('PT-00001', 'กระดาษปอนด์');
INSERT INTO `tbl_paper_type` VALUES ('PT-00002', 'กระดาษคาร์บอน');
INSERT INTO `tbl_paper_type` VALUES ('PT-00003', 'กระดาษแบงค์');
INSERT INTO `tbl_paper_type` VALUES ('PT-00004', 'สติกเกอร์');

-- ----------------------------
-- Table structure for tbl_product
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE `tbl_product`  (
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `product_category_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสหมวดหมู่',
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสินค้า',
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
INSERT INTO `tbl_product` VALUES ('P.20190121.00004', 'PC-00003', 'นามบัตร', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', '\\1\\6d1cXcZ8WcjmUZd4tz9Bte3Jg1Arug2G.png', '/uploads', 1, '2019-01-21 15:14:54', 1, '2019-01-24 13:57:09');
INSERT INTO `tbl_product` VALUES ('P.20190121.00003', 'PC-00002', 'การ์ด', NULL, '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"1\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"0\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', '\\1\\o4NvCBqzVhgdZ4tpIRsR3He4dFgQCFcL.png', '/uploads', 1, '2019-01-21 13:44:13', 1, '2019-01-24 13:56:32');
INSERT INTO `tbl_product` VALUES ('P-20190121-00002', 'PC-00004', 'ใบปลิว', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"1\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"1\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', '\\1\\68_xVZJpTeL1rFrdt33wCwRAvH-x1VZy.png', '/uploads', 1, '2019-01-21 22:21:10', 1, '2019-01-24 13:57:24');
INSERT INTO `tbl_product` VALUES ('P-20190123-00001', 'PC-00002', 'โปสการ์ด', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-01-23 15:52:21', 1, '2019-01-24 13:56:40');
INSERT INTO `tbl_product` VALUES ('P-20190123-00002', 'PC-00002', 'การ์ดแต่งงาน', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', '\\1\\fz8kkd3Ik7feH3jLaWgoo4zgZnLZuyye.png', '/uploads', 1, '2019-01-23 15:54:16', 1, '2019-01-24 13:56:49');
INSERT INTO `tbl_product` VALUES ('P-2019012300001', 'PC-00002', 'การ์ดงานบวช', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-01-23 15:57:23', 1, '2019-01-24 13:56:56');
INSERT INTO `tbl_product` VALUES ('P-2019012300002', 'PC-00002', 'การ์ดขึ้นบ้านใหม่', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-01-23 15:58:18', 1, '2019-01-24 13:57:02');
INSERT INTO `tbl_product` VALUES ('P-2019012300003', 'PC-00003', 'ใบสะสมแต้ม', NULL, '{\"paper_size_id\":{\"value\":\"0\",\"label\":\"ขนาด\",\"required\":\"0\"},\"paper_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_height\":{\"value\":\"0\",\"label\":\"ยาว(กำหนดเอง)\",\"required\":\"0\"},\"paper_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(กำหนดเอง)\",\"required\":\"0\"},\"page_qty\":{\"value\":\"0\",\"label\":\"จำนวนหน้า/แผ่น\",\"required\":\"0\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"0\",\"label\":\"กระดาษ\",\"required\":\"0\"},\"coating_id\":{\"value\":\"0\",\"label\":\"เคลือบ\",\"required\":\"0\"},\"diecut_id\":{\"value\":\"0\",\"label\":\"ไดคัท\",\"required\":\"0\"},\"fold_id\":{\"value\":\"0\",\"label\":\"วิธีพับ\",\"required\":\"0\"},\"foil_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ฟอยล์)\",\"required\":\"0\"},\"foil_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ฟอยล์)\",\"required\":\"0\"},\"foil_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ฟอยล์)\",\"required\":\"0\"},\"foil_color_id\":{\"value\":\"0\",\"label\":\"สีฟอยล์\",\"required\":\"0\"},\"emboss_size_width\":{\"value\":\"0\",\"label\":\"กว้าง(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_height\":{\"value\":\"0\",\"label\":\"ยาว(ปั๊มนูน)\",\"required\":\"0\"},\"emboss_size_unit\":{\"value\":\"0\",\"label\":\"หน่วย(ปั๊มนุน)\",\"required\":\"0\"},\"land_orient\":{\"value\":\"0\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"0\"},\"book_binding_id\":{\"value\":\"0\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"0\"}}', NULL, NULL, 1, '2019-01-23 15:59:26', 1, '2019-01-24 13:57:17');
INSERT INTO `tbl_product` VALUES ('P-2019012400001', 'PC-00005', 'ฉลากติดสินค้า', '<h4>รายละเอียดการสั่งพิมพ์ฉลากติดสินค้า:</h4><ul><li>เพื่อให้เห็นชัดเจนมากขึ้นในการเปรียบเทียบการจัดส่งฉลากติดสินค้า 3 รูปแบบ, <a href=\"https://www.gogoprint.co.th/media/wysiwyg/product_view/GGP_stickers.png\" class=\"fancybox-media\">คลิ๊กที่นี่</a></li><li>ในการทำตามขั้นตอนการเตรียมไฟล์งานและปิดอาร์ตเวิร์คสำหรับฉลากติดสินค้า หาข้อมูลเพิ่มเติม<a href=\"https://www.gogoprint.co.th/%E0%B8%9A%E0%B8%A5%E0%B9%8A%E0%B8%AD%E0%B8%81/%E0%B9%80%E0%B8%95%E0%B8%A3%E0%B8%B5%E0%B8%A2%E0%B8%A1-%E0%B8%AD%E0%B8%B2%E0%B8%A3%E0%B9%8C%E0%B8%95%E0%B9%80%E0%B8%A7%E0%B8%B4%E0%B8%A3%E0%B9%8C%E0%B8%84-%E0%B8%AA%E0%B8%95%E0%B8%B4%E0%B9%8A%E0%B8%81%E0%B9%80%E0%B8%81%E0%B8%AD%E0%B8%A3%E0%B9%8C/\" target=\"blank\">ได้ที่นี่</a></li><li>ปริมาณชิ้นของฉลากติดสินค้า คือปริมาณฉลากติดสินค้าต่อดวง จะไม่นับปริมาณเป็นจำนวนแผ่น A3/A4</li><li><strong>1 ไดคัท ต่อ 1 อาร์ตเวิร์ค ต่อ 1 item</strong></li></ul>', '{\"paper_size_id\":{\"value\":\"1\",\"label\":\"ขนาด\",\"required\":\"1\"},\"paper_size_width\":{\"value\":\"1\",\"label\":\"กว้าง\",\"required\":\"1\"},\"paper_size_height\":{\"value\":\"1\",\"label\":\"ยาว\",\"required\":\"1\"},\"paper_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย\",\"required\":\"1\"},\"page_qty\":{\"value\":\"1\",\"label\":\"จำนวนหน้า\",\"required\":\"1\"},\"before_print\":{\"value\":\"1\",\"label\":\"ด้านหน้าพิมพ์\",\"required\":\"1\"},\"after_print\":{\"value\":\"1\",\"label\":\"ด้านหลังพิมพ์\",\"required\":\"1\"},\"paper_id\":{\"value\":\"1\",\"label\":\"กระดาษ\",\"required\":\"1\"},\"coating_id\":{\"value\":\"1\",\"label\":\"เคลือบ\",\"required\":\"1\"},\"diecut_id\":{\"value\":\"1\",\"label\":\"ไดคัท\",\"required\":\"1\"},\"fold_id\":{\"value\":\"1\",\"label\":\"วิธีพับ\",\"required\":\"1\"},\"foil_size_width\":{\"value\":\"1\",\"label\":\"กว้าง\",\"required\":\"1\"},\"foil_size_height\":{\"value\":\"1\",\"label\":\"ยาว\",\"required\":\"1\"},\"foil_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย\",\"required\":\"1\"},\"foil_color_id\":{\"value\":\"1\",\"label\":\"สีฟอยล์\",\"required\":\"1\"},\"emboss_size_width\":{\"value\":\"1\",\"label\":\"กว้าง\",\"required\":\"1\"},\"emboss_size_height\":{\"value\":\"1\",\"label\":\"ยาว\",\"required\":\"1\"},\"emboss_size_unit\":{\"value\":\"1\",\"label\":\"หน่วย\",\"required\":\"1\"},\"land_orient\":{\"value\":\"1\",\"label\":\"แนวตั้ง/แนวนอน\",\"required\":\"1\"},\"book_binding_id\":{\"value\":\"1\",\"label\":\"วิธีเข้าเล่ม\",\"required\":\"1\"}}', '\\1\\B2HzOcUgNPsNh7pe9ZDuyYK-IF6Lm0g7.png', '/uploads', 1, '2019-01-24 09:54:27', 1, '2019-01-25 09:58:45');

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
INSERT INTO `tbl_product_category` VALUES ('PC-00002', 'การ์ด');
INSERT INTO `tbl_product_category` VALUES ('PC-00003', 'นามบัตร');
INSERT INTO `tbl_product_category` VALUES ('PC-00004', 'ใบปลิว');
INSERT INTO `tbl_product_category` VALUES ('PC-00005', 'สติ๊กเกอร์');

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
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_product_option
-- ----------------------------
INSERT INTO `tbl_product_option` VALUES ('P.20190121.00003', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\",\"P-00003\",\"P-00004\",\"P-00005\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P.20190121.00004', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\",\"P-00003\",\"P-00004\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-20190121-00002', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-20190123-00001', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-20190123-00002', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-2019012300001', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-2019012300002', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-2019012300003', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00001\",\"P-00002\"]', NULL, NULL, NULL, NULL, NULL, '', '');
INSERT INTO `tbl_product_option` VALUES ('P-2019012400001', '[\"PS-00002\",\"PS-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"PT-00001\",\"PT-00002\",\"PT-00004\"]', '[\"P-00003\",\"P-00004\",\"P-00005\"]', '[\"C-00001\",\"C-00002\"]', '[\"D-00007\",\"D-00005\",\"D-00006\",\"D-00009\",\"D-00010\",\"D-00011\"]', '[\"FOLD-00001\",\"FOLD-00003\"]', '[\"FOIL-00003\",\"FOIL-00004\",\"FOIL-00005\"]', '[\"BD-00001\"]', '', '');

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
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  PRIMARY KEY (`quotation_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_quotation
-- ----------------------------
INSERT INTO `tbl_quotation` VALUES ('QO-2019012400001', 'ทดสอบ', '22/87', NULL, '0822222222', '2019-01-24 15:03:56', '2019-01-24 15:03:56');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012400002', 'BBA', '22/87', NULL, '0222222222', '2019-01-24 15:10:05', '2019-01-24 15:10:05');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012400003', 'BBA1', '22/87', NULL, '0822222222', '2019-01-24 16:24:14', '2019-01-24 16:24:14');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012400004', 'ทดสอบ ใบเสนอราคา', '22/87', NULL, '0875268522', '2019-01-24 16:28:24', '2019-01-24 16:28:24');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012500001', 'VDD1 TEST', '22/87', '', '0522222222', '2019-01-25 10:22:22', '2019-01-25 10:22:22');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012500002', 'DFF TEST', '22/87', '', '0266666666', '2019-01-25 10:24:58', '2019-01-25 10:24:58');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012500003', 'Das Foo', '22/87', '', '085555555', '2019-01-25 10:54:54', '2019-01-25 10:54:54');
INSERT INTO `tbl_quotation` VALUES ('QO-2019012500004', 'DSA GGG', '22/87', '', '0566665544', '2019-01-25 11:01:24', '2019-01-25 11:01:24');

-- ----------------------------
-- Table structure for tbl_quotation_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_quotation_detail`;
CREATE TABLE `tbl_quotation_detail`  (
  `quotation_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `quotation_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่ใบเสนอราคา',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสสินค้า',
  `paper_size_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ขนาด',
  `paper_size_width` int(11) NULL DEFAULT NULL COMMENT 'กว้าง(กำหนดเอง)',
  `paper_size_height` int(11) NULL DEFAULT NULL COMMENT 'ยาว(กำหนดเอง)',
  `paper_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(กำหนดเอง)',
  `page_qty` int(11) NULL DEFAULT NULL COMMENT 'จำนวนหน้า/จำนวนแผ่น',
  `before_print` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ด้านหน้าพิมพ์',
  `after_print` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ด้านหลังพิมพ์',
  `paper_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'กระดาษ',
  `coating_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เคลือบ',
  `diecut_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไดคัท',
  `fold_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีพับ',
  `foil_size_width` int(11) NULL DEFAULT NULL COMMENT 'กว้าง(ฟอยล์)',
  `foil_size_height` int(11) NULL DEFAULT NULL COMMENT 'ยาว(ฟอยล์)',
  `foil_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(ฟอยล์)',
  `foil_color_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สีฟอยล์',
  `emboss_size_width` int(11) NULL DEFAULT NULL COMMENT 'กว้าง(ปั๊มนูน)',
  `emboss_size_height` int(11) NULL DEFAULT NULL COMMENT 'ยาว(ปั๊มนูน)',
  `emboss_size_unit` int(11) NULL DEFAULT NULL COMMENT 'หน่วย(ปั๊มนุน)',
  `land_orient` int(11) NULL DEFAULT NULL COMMENT 'แนวตั้ง/แนวนอน',
  `book_binding_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'วิธีเข้าเล่ม',
  PRIMARY KEY (`quotation_detail_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_quotation_detail
-- ----------------------------
INSERT INTO `tbl_quotation_detail` VALUES (1, 'QO-2019012400001', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 100, 'PT-00001', 'PT-00002', 'P-00003', 'C-00001', 'D-00006', 'FOLD-00001', 100, 100, 2, 'FOIL-00004', 20, 20, 2, 1, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (2, 'QO-2019012400002', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 100, 'PT-00001', 'PT-00002', 'P-00003', 'C-00001', 'D-00006', 'FOLD-00001', 100, 100, 2, 'FOIL-00004', 20, 20, 2, 1, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (3, 'QO-2019012400003', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 100, 'PT-00001', 'PT-00002', 'P-00003', 'C-00001', 'D-00006', 'FOLD-00001', 100, 100, 2, 'FOIL-00004', 20, 20, 2, 1, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (4, 'QO-2019012400004', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 120, 'PT-00001', 'PT-00004', 'P-00003', 'C-00001', 'D-00006', 'FOLD-00001', 25, 25, 2, 'FOIL-00004', 35, 35, 2, 2, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (5, 'QO-2019012500001', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 100, 'PT-00001', 'PT-00002', 'P-00003', 'C-00001', 'D-00005', 'FOLD-00001', 100, 100, 2, 'FOIL-00003', 20, 20, 2, 1, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (6, 'QO-2019012500002', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 100, 'PT-00001', 'PT-00002', 'P-00003', 'C-00001', 'D-00005', 'FOLD-00001', 100, 100, 2, 'FOIL-00003', 20, 20, 2, 1, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (7, 'QO-2019012500003', 'P-2019012400001', 'PS-00002', NULL, NULL, NULL, 180, 'PT-00001', 'PT-00002', 'P-00003', 'C-00002', 'D-00009', 'FOLD-00003', 12, 12, 2, 'FOIL-00003', 15, 15, 2, 2, 'BD-00001');
INSERT INTO `tbl_quotation_detail` VALUES (8, 'QO-2019012500004', 'P-2019012400001', 'custom', 10, 10, 2, 12, 'PT-00001', 'PT-00001', 'P-00003', 'C-00001', 'D-00009', 'FOLD-00003', 33, 33, 2, 'FOIL-00005', 2, 2, 2, 1, 'BD-00001');

-- ----------------------------
-- Table structure for tbl_unit
-- ----------------------------
DROP TABLE IF EXISTS `tbl_unit`;
CREATE TABLE `tbl_unit`  (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อหน่วย',
  PRIMARY KEY (`unit_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
  CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
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
INSERT INTO `user` VALUES (1, 'admin', 'kidz@webkidz.com', '$2y$12$V1/vLHR46yYQQZ71ovqV4u/QJZGiTWV7LfdwYQEDldR3QsJQ.6lTa', '_o_e_OfGKRYSxkiTZssrLknzUsnixCk4', 1545020656, NULL, NULL, NULL, 1545020656, 1545020656, 0, 1548381836);
INSERT INTO `user` VALUES (4, 'tp.sci', 'tp.sci@santipab.info.com', '$2y$12$s2ASzmu2A5R1Xm1uT16J2.m7wc2jPMkh/K8WUiLobJdMUu9cwOfY.', 'AKHIsE0CiIw_4A7NJWoxHJuWvUAtOBCm', 1545116268, NULL, NULL, '127.0.0.1', 1545116268, 1545116268, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
