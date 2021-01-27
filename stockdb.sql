/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80022
 Source Host           : localhost:3306
 Source Schema         : stockdb1

 Target Server Type    : MySQL
 Target Server Version : 80022
 File Encoding         : 65001

 Date: 27/01/2021 22:22:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of categories
-- ----------------------------
BEGIN;
INSERT INTO `categories` VALUES (1, 'Computer', 1, '2019-09-22 16:15:33');
INSERT INTO `categories` VALUES (2, 'Mouse', 1, '2019-09-22 16:15:36');
INSERT INTO `categories` VALUES (3, 'Keyboard', 1, '2019-09-22 16:15:39');
INSERT INTO `categories` VALUES (4, 'Monitor', 1, '2019-09-22 16:15:43');
INSERT INTO `categories` VALUES (5, 'VGA', 1, '2019-09-22 16:15:45');
INSERT INTO `categories` VALUES (6, 'Cable', 1, '2019-09-22 16:15:49');
INSERT INTO `categories` VALUES (7, 'Router', 1, '2019-09-22 16:15:52');
INSERT INTO `categories` VALUES (8, 'Switch', 1, '2019-09-22 16:15:55');
INSERT INTO `categories` VALUES (9, 'Power Supply', 1, '2019-09-22 16:15:59');
INSERT INTO `categories` VALUES (10, 'RAM', 1, '2019-09-22 16:16:02');
INSERT INTO `categories` VALUES (11, 'CPU Core i7', 1, '2019-09-22 16:16:03');
INSERT INTO `categories` VALUES (12, 'Phone', 0, '2019-09-22 16:16:53');
INSERT INTO `categories` VALUES (13, 'TEST', 0, '2019-10-05 17:31:39');
INSERT INTO `categories` VALUES (14, 'hello world', 0, '2019-10-05 17:32:29');
INSERT INTO `categories` VALUES (15, 'hello', 1, '2019-10-27 14:49:46');
INSERT INTO `categories` VALUES (16, 'hello', 1, '2019-10-27 14:49:51');
INSERT INTO `categories` VALUES (17, 'sdfsdfsdf', 1, '2019-10-27 14:50:29');
INSERT INTO `categories` VALUES (18, 'abc', 1, '2019-10-27 14:50:44');
INSERT INTO `categories` VALUES (19, 'Printer', 1, '2019-10-27 14:52:53');
INSERT INTO `categories` VALUES (20, 'Monitor 4K', 1, '2019-10-27 14:53:39');
COMMIT;

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `kh_name` varchar(120) NOT NULL,
  `en_name` varchar(120) NOT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `logo` varchar(120) DEFAULT NULL,
  `header_text` varchar(200) DEFAULT NULL,
  `foot_text` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of companies
-- ----------------------------
BEGIN;
INSERT INTO `companies` VALUES (1, 'ក្រុមហ៊ុន ABCDE', 'ABCDE Co., Ltd', 'Phnom Penh, Cambodia', 'abcde@gmail.com', '017837754', 'logo.png', 'Header Text of The Company!', 'Footer Text of The Company!');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
INSERT INTO `permissions` VALUES (1, 'role', 'Roles');
INSERT INTO `permissions` VALUES (2, 'user', 'Users');
INSERT INTO `permissions` VALUES (3, 'dashboard', 'Dashboard');
COMMIT;

-- ----------------------------
-- Table structure for product_warehouses
-- ----------------------------
DROP TABLE IF EXISTS `product_warehouses`;
CREATE TABLE `product_warehouses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `warehouse_id` int NOT NULL,
  `product_id` int NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product_warehouses
-- ----------------------------
BEGIN;
INSERT INTO `product_warehouses` VALUES (1, 1, 1, -10);
INSERT INTO `product_warehouses` VALUES (2, 2, 1, 13);
INSERT INTO `product_warehouses` VALUES (3, 2, 2, 2);
COMMIT;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `barcode` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `qrcode` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int NOT NULL,
  `unit_id` int NOT NULL,
  `onhand` int NOT NULL DEFAULT '0',
  `photo` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `cost` float NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
BEGIN;
INSERT INTO `products` VALUES (1, '123', 'Dell XPS', NULL, NULL, 'TT', 1, 1, 3, NULL, 0, 0, 'Test', 1, '2019-10-06 17:04:57');
INSERT INTO `products` VALUES (2, 't12', 'b', NULL, NULL, 'TT', 1, 1, 12, NULL, 0, 1, 'Test', 1, '2019-10-06 17:04:57');
INSERT INTO `products` VALUES (3, '1', 'A', '123', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'TEST', 1, '2020-12-18 16:48:38');
INSERT INTO `products` VALUES (4, '2', 'B', '456', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'TEST', 1, '2020-12-18 16:48:38');
INSERT INTO `products` VALUES (5, '3', 'C', '789', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'TEST', 1, '2020-12-18 16:48:38');
INSERT INTO `products` VALUES (6, '4', 'D', '1122', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'TEST', 1, '2020-12-18 16:48:38');
INSERT INTO `products` VALUES (7, '5', 'E', '1455', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'TEST', 1, '2020-12-18 16:48:38');
INSERT INTO `products` VALUES (8, '6', 'F', '1788', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'TEST', 1, '2020-12-18 16:48:38');
COMMIT;

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `list` tinyint NOT NULL DEFAULT '0',
  `create` tinyint NOT NULL DEFAULT '0',
  `edit` tinyint NOT NULL DEFAULT '0',
  `delete` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_permissions
-- ----------------------------
BEGIN;
INSERT INTO `role_permissions` VALUES (1, 7, 1, 1, 1, 1, 1);
INSERT INTO `role_permissions` VALUES (2, 7, 2, 1, 1, 1, 1);
INSERT INTO `role_permissions` VALUES (3, 3, 1, 1, 1, 1, 1);
INSERT INTO `role_permissions` VALUES (4, 3, 2, 1, 1, 1, 1);
INSERT INTO `role_permissions` VALUES (5, 2, 2, 1, 1, 1, 1);
INSERT INTO `role_permissions` VALUES (6, 4, 1, 1, 0, 0, 0);
INSERT INTO `role_permissions` VALUES (7, 4, 2, 1, 0, 0, 0);
INSERT INTO `role_permissions` VALUES (8, 4, 3, 0, 0, 0, 0);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES (1, 'Root Level', 1, '2019-09-21 13:10:12');
INSERT INTO `roles` VALUES (2, 'Administrator', 1, '2019-09-21 13:11:11');
INSERT INTO `roles` VALUES (3, 'Manager', 1, '2019-09-21 13:11:14');
INSERT INTO `roles` VALUES (4, 'Officer', 1, '2019-09-21 13:11:19');
INSERT INTO `roles` VALUES (5, 'Sale Manager', 1, '2019-09-21 13:11:21');
INSERT INTO `roles` VALUES (6, 'Accountant', 1, '2019-09-21 13:11:24');
INSERT INTO `roles` VALUES (7, 'IT Admin', 1, '2019-09-21 13:11:28');
COMMIT;

-- ----------------------------
-- Table structure for stock_in_details
-- ----------------------------
DROP TABLE IF EXISTS `stock_in_details`;
CREATE TABLE `stock_in_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stock_in_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` float NOT NULL,
  `warehouse_id` int NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock_in_details
-- ----------------------------
BEGIN;
INSERT INTO `stock_in_details` VALUES (4, 4, 1, 3, 2, '2019-10-26 14:45:19');
INSERT INTO `stock_in_details` VALUES (5, 4, 2, 2, 2, '2019-10-27 15:15:45');
INSERT INTO `stock_in_details` VALUES (6, 4, 1, 10, 2, '2019-10-27 15:16:08');
COMMIT;

-- ----------------------------
-- Table structure for stock_ins
-- ----------------------------
DROP TABLE IF EXISTS `stock_ins`;
CREATE TABLE `stock_ins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `in_date` date NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `po_no` varchar(50) DEFAULT NULL,
  `in_by` int DEFAULT NULL,
  `description` text,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `warehouse_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock_ins
-- ----------------------------
BEGIN;
INSERT INTO `stock_ins` VALUES (4, '2019-11-17', '0022896', 'P002', 1, NULL, 1, '2019-10-26 14:45:19', 2);
COMMIT;

-- ----------------------------
-- Table structure for stock_out_details
-- ----------------------------
DROP TABLE IF EXISTS `stock_out_details`;
CREATE TABLE `stock_out_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stock_out_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` float NOT NULL,
  `warehouse_id` int NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock_out_details
-- ----------------------------
BEGIN;
INSERT INTO `stock_out_details` VALUES (3, 2, 1, 1, 1, '2019-11-16 00:08:54');
COMMIT;

-- ----------------------------
-- Table structure for stock_outs
-- ----------------------------
DROP TABLE IF EXISTS `stock_outs`;
CREATE TABLE `stock_outs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `out_date` date NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `out_by` int DEFAULT NULL,
  `description` text,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `warehouse_id` int NOT NULL,
  `request_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock_outs
-- ----------------------------
BEGIN;
INSERT INTO `stock_outs` VALUES (2, '2019-11-16', 'RF009', 1, 'some description or note here...', 1, '2019-11-16 00:08:54', 1, NULL);
COMMIT;

-- ----------------------------
-- Table structure for units
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of units
-- ----------------------------
BEGIN;
INSERT INTO `units` VALUES (1, 'Kg', 1, '2019-10-06 08:11:18');
INSERT INTO `units` VALUES (2, 'm', 1, '2019-10-06 08:11:18');
INSERT INTO `units` VALUES (3, 'TEST', 0, '2019-10-06 08:13:38');
INSERT INTO `units` VALUES (4, 'PCS', 1, '2019-10-27 14:57:35');
INSERT INTO `units` VALUES (5, 'Ton', 1, '2019-10-27 14:57:45');
INSERT INTO `units` VALUES (6, 'Cm', 1, '2019-10-27 14:58:32');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int NOT NULL,
  `language` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'Admin', 'admin', 'admin@gmail.com', NULL, 'uploads/users/kY3xUMWwuWCb8yD4PsvOOB80JmIsxsDG4QcZrP7O.jpeg', '$2y$10$NQWDjZp2xWjAqdV/pTNUK./l3sQ3sIG9NXvkvcSCn/0hEDhP2rqNa', NULL, '2019-09-21 04:03:37', '2019-09-21 04:03:37', 7, 'en');
INSERT INTO `users` VALUES (4, 'Sopheak', 'sopheak', 'sopheak@gmail.com', NULL, 'uploads/users/L6iPzsItRCJTiY9OiuN1Mieo976WJbxOFxJ9LsqQ.png', '$2y$10$8ePT8pJtRqo4SQbVNtnanORsaSfHhvxSPo4X8Cl/wntNPIV0cjwpi', NULL, NULL, NULL, 7, 'km');
COMMIT;

-- ----------------------------
-- Table structure for warehouses
-- ----------------------------
DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE `warehouses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `active` tinyint NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of warehouses
-- ----------------------------
BEGIN;
INSERT INTO `warehouses` VALUES (1, 'WH001', 'Warehouse 1', NULL, 1, '2019-10-05 18:43:35');
INSERT INTO `warehouses` VALUES (2, 'WH002', 'Warehouse 2', NULL, 1, '2019-10-05 18:43:35');
INSERT INTO `warehouses` VALUES (9, 'TEST', 'Test', 'test', 0, '2019-10-06 07:51:02');
INSERT INTO `warehouses` VALUES (10, 'TEST2', 'test3', 'test1', 0, '2019-10-06 07:52:27');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
