/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : 127.0.0.1:3306
 Source Schema         : tenant_foo1

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 07/04/2023 07:40:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activity
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resource` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resource_id` int UNSIGNED NULL DEFAULT NULL,
  `allowed_roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `allowed_department` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of activity
-- ----------------------------
INSERT INTO `activity` VALUES (4, 2, 'Created Programme #39', '<i class=\"mdi mdi-book-edit-outline\"></i>', '/programmes/39', NULL, NULL, NULL, NULL, '2023-03-27 19:09:22', NULL);
INSERT INTO `activity` VALUES (5, 2, 'Created Programme #40', '<i class=\"mdi mdi-book-edit-outline\"></i>', '/programmes/40', NULL, NULL, NULL, NULL, '2023-03-27 19:20:58', NULL);
INSERT INTO `activity` VALUES (6, 2, 'Created Programme #41', '<i class=\"mdi mdi-book-edit-outline\"></i>', '/programmes/41', NULL, NULL, NULL, NULL, '2023-03-27 19:37:55', NULL);
INSERT INTO `activity` VALUES (7, 2, 'Created Programme #42', '<i class=\"mdi mdi-book-edit-outline\"></i>', '/programmes/42', NULL, NULL, NULL, NULL, '2023-04-03 03:09:17', NULL);
INSERT INTO `activity` VALUES (8, 2, 'Submitted new contract #3', '<i class=\"mdi mdi-bank\"></i>', '/contracts/3', NULL, NULL, NULL, NULL, '2023-04-03 17:55:50', NULL);
INSERT INTO `activity` VALUES (9, 2, 'Created Programme #43', '<i class=\"mdi mdi-book-edit-outline\"></i>', '/programmes/43', 'App\\Models\\Programme', 43, NULL, NULL, '2023-04-05 12:35:47', NULL);

-- ----------------------------
-- Table structure for activity_schedules
-- ----------------------------
DROP TABLE IF EXISTS `activity_schedules`;
CREATE TABLE `activity_schedules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `activity_schedules_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `activity_schedules_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of activity_schedules
-- ----------------------------
INSERT INTO `activity_schedules` VALUES (1, 1, '11', '1', '1', '2023-03-21 16:54:14', '2023-03-21 16:54:14', NULL);

-- ----------------------------
-- Table structure for additional_employer_risks
-- ----------------------------
DROP TABLE IF EXISTS `additional_employer_risks`;
CREATE TABLE `additional_employer_risks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `risk` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `additional_employer_risks_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `additional_employer_risks_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of additional_employer_risks
-- ----------------------------
INSERT INTO `additional_employer_risks` VALUES (1, 1, NULL, '2023-03-21 16:53:27', '2023-03-21 16:53:27', NULL, 'employer/client');

-- ----------------------------
-- Table structure for all_tasks
-- ----------------------------
DROP TABLE IF EXISTS `all_tasks`;
CREATE TABLE `all_tasks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `column_id` int NOT NULL,
  `order_id` int NOT NULL,
  `progress` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of all_tasks
-- ----------------------------

-- ----------------------------
-- Table structure for applications
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `measure_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `net` double(8, 2) NOT NULL,
  `period_from` timestamp NOT NULL DEFAULT current_timestamp,
  `period_to` timestamp NOT NULL DEFAULT current_timestamp,
  `status` int NOT NULL COMMENT 'Model ApplicationStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of applications
-- ----------------------------

-- ----------------------------
-- Table structure for assessments
-- ----------------------------
DROP TABLE IF EXISTS `assessments`;
CREATE TABLE `assessments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `application_id` int NULL DEFAULT NULL,
  `profile_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net` double(8, 2) NOT NULL,
  `period_from` timestamp NOT NULL DEFAULT current_timestamp,
  `period_to` timestamp NOT NULL DEFAULT current_timestamp,
  `status` int NOT NULL COMMENT 'Model AssessmentStatus',
  `certified_by` int NULL DEFAULT NULL,
  `certified_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of assessments
-- ----------------------------

-- ----------------------------
-- Table structure for boq_schedules
-- ----------------------------
DROP TABLE IF EXISTS `boq_schedules`;
CREATE TABLE `boq_schedules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `item` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `boq_schedules_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `boq_schedules_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of boq_schedules
-- ----------------------------

-- ----------------------------
-- Table structure for calendar_overrides
-- ----------------------------
DROP TABLE IF EXISTS `calendar_overrides`;
CREATE TABLE `calendar_overrides`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `programme_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `calendar_id` int NULL DEFAULT NULL,
  `start_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `end_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of calendar_overrides
-- ----------------------------
INSERT INTO `calendar_overrides` VALUES (1, '34', 28, '07/03/2023', '11/03/2023', NULL, NULL, NULL);
INSERT INTO `calendar_overrides` VALUES (2, '36', 31, '02/03/2023', '21/03/2023', '2023-03-25 12:32:24', '2023-03-25 12:32:24', NULL);

-- ----------------------------
-- Table structure for calendars
-- ----------------------------
DROP TABLE IF EXISTS `calendars`;
CREATE TABLE `calendars`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `programme_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` tinyint NOT NULL DEFAULT 1,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `start_time` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '07:00',
  `start_hour` int NOT NULL DEFAULT 7,
  `start_minute` int NOT NULL DEFAULT 0,
  `end_time` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '17:00',
  `end_hour` int NOT NULL DEFAULT 7,
  `end_minute` int NOT NULL DEFAULT 0,
  `working_day_monday` tinyint NOT NULL DEFAULT 1,
  `working_day_tuesday` tinyint NOT NULL DEFAULT 1,
  `working_day_wednesday` tinyint NOT NULL DEFAULT 1,
  `working_day_thursday` tinyint NOT NULL DEFAULT 1,
  `working_day_friday` tinyint NOT NULL DEFAULT 1,
  `working_day_saturday` tinyint NOT NULL DEFAULT 1,
  `working_day_sunday` tinyint NOT NULL DEFAULT 1,
  `is_default_task_calendar` tinyint NOT NULL DEFAULT 1,
  `is_default_resource_calendar` tinyint NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of calendars
-- ----------------------------
INSERT INTO `calendars` VALUES (1, '1', 1, 'Default task calendar1111', '07:00', 7, 0, '17:00', 17, 0, 1, 1, 1, 0, 1, 0, 0, 1, 1, '2023-03-18 02:52:42', '2023-03-26 22:51:46', NULL);
INSERT INTO `calendars` VALUES (2, '1', 2, 'Default resource calendar', '07:00', 7, 0, '17:00', 17, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, '2023-03-18 02:52:42', '2023-03-18 02:52:42', NULL);
INSERT INTO `calendars` VALUES (3, '1', 1, 'change', '07:00', 11, 45, '17:00', 13, 45, 1, 0, 0, 1, 0, 0, 0, 0, 1, '2023-03-18 15:42:36', '2023-03-27 16:49:04', NULL);
INSERT INTO `calendars` VALUES (44, '43', 1, 'Default task calendar', '07:00', 7, 0, '17:00', 17, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, '2023-04-05 12:35:47', '2023-04-05 12:35:47', NULL);
INSERT INTO `calendars` VALUES (45, '43', 2, 'Default resource calendar', '07:00', 7, 0, '17:00', 17, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, '2023-04-05 12:35:47', '2023-04-05 12:35:47', NULL);

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `commentable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comments_commentable_type_commentable_id_index`(`commentable_type` ASC, `commentable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for compensation_events
-- ----------------------------
DROP TABLE IF EXISTS `compensation_events`;
CREATE TABLE `compensation_events`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `programme_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `early_warning_notified` tinyint(1) NOT NULL DEFAULT 0,
  `early_warning_id` tinyint(1) NULL DEFAULT NULL,
  `status` smallint NOT NULL COMMENT 'CompensationEventStatus model',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of compensation_events
-- ----------------------------

-- ----------------------------
-- Table structure for contract_access_dates
-- ----------------------------
DROP TABLE IF EXISTS `contract_access_dates`;
CREATE TABLE `contract_access_dates`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `part_of_the_site` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `date` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_access_dates_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_access_dates_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_access_dates
-- ----------------------------
INSERT INTO `contract_access_dates` VALUES (1, 1, '111', '2023-03-22', '2023-03-21 16:51:49', '2023-03-21 16:51:49', NULL);
INSERT INTO `contract_access_dates` VALUES (2, 1, '222', '2023-03-27', '2023-03-21 16:51:49', '2023-03-25 13:26:52', NULL);

-- ----------------------------
-- Table structure for contract_accounting_periods
-- ----------------------------
DROP TABLE IF EXISTS `contract_accounting_periods`;
CREATE TABLE `contract_accounting_periods`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `period` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_accounting_periods_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_accounting_periods_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_accounting_periods
-- ----------------------------

-- ----------------------------
-- Table structure for contract_applications
-- ----------------------------
DROP TABLE IF EXISTS `contract_applications`;
CREATE TABLE `contract_applications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `main_opt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resolution_opt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sec_opt_X1` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X2` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X3` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X4` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X5` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X6` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X7` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X8` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X9` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X10` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X11` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X12` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X13` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X14` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X15` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X16` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X17` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X18` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X19` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X20` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_yUK1` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_yUK2` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_yUK3` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_Z1` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `works_are` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `works_information_is_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `site_information_is_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi100` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi200` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi300` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi400` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi500` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi600` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi700` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi800` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi900` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi1000` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi1100` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi1200` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi1300` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wi2000` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `boundaries_are` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `language_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `law_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `period_for_reply_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `adjudicator_body_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `tribunal_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `risk_register_matters_are` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `starting_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `programme_interval_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `defects_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `defect_correction_period` int NULL DEFAULT NULL,
  `currency_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `assessment_interval` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `interest_rate_percentage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `interest_rate_text_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `interest_rate_text_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_recording_place_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_recording_snow_hour` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_recording_additional` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_recording_supplier` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_data_recorded_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_data_available_from` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weather_data_assumed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `insurance_text_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `insurance_min_text_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `arbitration_proceedure_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `arbitration_place_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `arbitration_chooser_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `completion_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `first_programme_within` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payment_period_yuk2_number` int NULL DEFAULT NULL,
  `payment_period_yuk2_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payment_period_not_yuk2_number` int NULL DEFAULT NULL,
  `payment_period_not_yuk2_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `employer_insurance_plant_materials` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `method_of_measurement_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `method_of_measurement_amendments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `base_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `indices_prepared_by` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `exchange_rates_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `exchange_rates_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `bonus_remainder_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `delay_damages_remainder_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x6_bonus_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x7_delay_damages_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x12_client_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x12_client_objective_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x12_partnering_information_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x13_performance_bond` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x14_advanced_payment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x14_instalments_weeks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x14_bond` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x16_retention_free_amount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x16_retention_percent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x18_indirect_loss` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x18_loss_damage1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x18_loss_damage2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x18_loss_damage3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x17_end_liability_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x20_incentive_schedule` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x20_kpi_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `yuk1_pay_any_charge` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `add_cond_z1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sec_opt_X23` tinyint(1) NOT NULL DEFAULT 0,
  `sec_opt_X24` tinyint(1) NOT NULL DEFAULT 0,
  `subcontract_works_are` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `employer_or_client_id` bigint UNSIGNED NULL DEFAULT NULL,
  `pm_or_sm_id` bigint UNSIGNED NULL DEFAULT NULL,
  `sup_id` bigint UNSIGNED NULL DEFAULT NULL,
  `adj_id` bigint UNSIGNED NULL DEFAULT NULL,
  `sub_adj_id` bigint UNSIGNED NULL DEFAULT NULL,
  `affected_property_is` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `subcontractor_period_for_reply_is` int NULL DEFAULT NULL,
  `service_period_is` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `insurance_min_amount_to_emp_prop` double(8, 2) NULL DEFAULT NULL,
  `ynz1_payment_period` int NULL DEFAULT NULL,
  `max_prepare_forcast_week_interval` int NULL DEFAULT NULL,
  `share_range_less_than` double(8, 2) NULL DEFAULT NULL,
  `less_than_share_percentage` double(8, 2) NULL DEFAULT NULL,
  `share_range_from_1` double(8, 2) NULL DEFAULT NULL,
  `share_range_to_1` double(8, 2) NULL DEFAULT NULL,
  `from_to_share_percentage_1` double(8, 2) NULL DEFAULT NULL,
  `share_range_from_2` double(8, 2) NULL DEFAULT NULL,
  `share_range_to_2` double(8, 2) NULL DEFAULT NULL,
  `from_to_share_percentage_2` double(8, 2) NULL DEFAULT NULL,
  `share_range_greater_than` double(8, 2) NULL DEFAULT NULL,
  `greater_than_share_percentage` double(8, 2) NULL DEFAULT NULL,
  `share_assesed_on` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x3_exchange_rates_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x3_exchange_rates_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x12_shedule_is_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x14_instalments_amount_or_percentage` double(8, 2) NULL DEFAULT NULL,
  `x17_slt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x19_end_task_order_programme_days_number` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_applications_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  INDEX `contract_applications_employer_or_client_id_foreign`(`employer_or_client_id` ASC) USING BTREE,
  INDEX `contract_applications_pm_or_sm_id_foreign`(`pm_or_sm_id` ASC) USING BTREE,
  INDEX `contract_applications_sup_id_foreign`(`sup_id` ASC) USING BTREE,
  INDEX `contract_applications_adj_id_foreign`(`adj_id` ASC) USING BTREE,
  INDEX `contract_applications_sub_adj_id_foreign`(`sub_adj_id` ASC) USING BTREE,
  CONSTRAINT `contract_applications_adj_id_foreign` FOREIGN KEY (`adj_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_applications_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_applications_employer_or_client_id_foreign` FOREIGN KEY (`employer_or_client_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_applications_pm_or_sm_id_foreign` FOREIGN KEY (`pm_or_sm_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_applications_sub_adj_id_foreign` FOREIGN KEY (`sub_adj_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_applications_sup_id_foreign` FOREIGN KEY (`sup_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_applications
-- ----------------------------
INSERT INTO `contract_applications` VALUES (1, 1, 'Option A: Priced contract with Activity Schedule', 'W1 (consensual adjudication outside the Construction Act)', 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-03-18 14:50:45', '2023-03-21 16:53:52', NULL, NULL, '111', '111', '111', '111', '111', '1111', '111', '111', '111', '111', '11', '111', '111', '111', '111', '111', '11', 'English', 'England', '1', '1', '1', '1', '2023-03-22', '2', '1', 1, '1111', '1', '11', '1', '1', '1111', '11:11', '1', '1', '1', '1', '1', '1', '1', '11', '11', '11', '2023-03-22', '11', 1, 'weeks.', 1, 'weeks.', '1', NULL, NULL, '2023-03-22', '1', NULL, NULL, NULL, NULL, NULL, '1', '2', '1', '1', NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contract_applications` VALUES (2, 2, 'Option A: Priced contract with Activity Schedule', 'W1 (consensual adjudication outside the Construction Act)', 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-03-25 14:02:54', '2023-03-25 14:04:03', NULL, NULL, 'asdf', 'fasdfafsd', 'asdf', 'afdsf', 'fasdf', 'asdf', 'asfd', 'afds', 'df', 'asdfafd', 'asfd', 'asdfasfd', 'asfdfsda', 'fdsfsafasd', 'fdffa', 'afdsas', 'fasdsafdsd', 'English', 'England', '2', '1', '1', 'dfasdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `contract_applications` VALUES (3, 3, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-04-03 17:55:50', '2023-04-03 17:55:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for contract_benificiary_terms
-- ----------------------------
DROP TABLE IF EXISTS `contract_benificiary_terms`;
CREATE TABLE `contract_benificiary_terms`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `term` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `benificiary` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_benificiary_terms_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_benificiary_terms_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_benificiary_terms
-- ----------------------------

-- ----------------------------
-- Table structure for contract_defect_correction_except_periods
-- ----------------------------
DROP TABLE IF EXISTS `contract_defect_correction_except_periods`;
CREATE TABLE `contract_defect_correction_except_periods`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `period_for` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `period_is` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_defect_correction_except_periods_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_defect_correction_except_periods_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_defect_correction_except_periods
-- ----------------------------
INSERT INTO `contract_defect_correction_except_periods` VALUES (1, 1, NULL, NULL, '2023-03-21 16:52:24', '2023-03-21 16:52:24', NULL);

-- ----------------------------
-- Table structure for contract_defined_costs
-- ----------------------------
DROP TABLE IF EXISTS `contract_defined_costs`;
CREATE TABLE `contract_defined_costs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `category_of_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Other',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_defined_costs_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_defined_costs_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_defined_costs
-- ----------------------------
INSERT INTO `contract_defined_costs` VALUES (1, 1, '1', NULL, '1', 'Design', '2023-03-21 16:54:30', NULL, '2023-03-21 16:54:30');

-- ----------------------------
-- Table structure for contract_extension_criteria
-- ----------------------------
DROP TABLE IF EXISTS `contract_extension_criteria`;
CREATE TABLE `contract_extension_criteria`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `criteria` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_extension_criteria_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_extension_criteria_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_extension_criteria
-- ----------------------------

-- ----------------------------
-- Table structure for contract_extension_periods
-- ----------------------------
DROP TABLE IF EXISTS `contract_extension_periods`;
CREATE TABLE `contract_extension_periods`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `notice_date` date NULL DEFAULT NULL,
  `period` int NULL DEFAULT NULL COMMENT 'in months',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_extension_periods_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_extension_periods_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_extension_periods
-- ----------------------------

-- ----------------------------
-- Table structure for contract_insurances
-- ----------------------------
DROP TABLE IF EXISTS `contract_insurances`;
CREATE TABLE `contract_insurances`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `insurance_against` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cover_or_indemnity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `deductibles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_additional` tinyint(1) NOT NULL DEFAULT 0,
  `service_period_is` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `provider` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_insurances_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_insurances_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_insurances
-- ----------------------------
INSERT INTO `contract_insurances` VALUES (1, 1, NULL, NULL, NULL, 0, NULL, 'employer/client', '2023-03-21 16:53:27', '2023-03-21 16:53:27', NULL);
INSERT INTO `contract_insurances` VALUES (2, 1, NULL, NULL, NULL, 1, NULL, 'employer/client', '2023-03-21 16:53:27', '2023-03-21 16:53:27', NULL);
INSERT INTO `contract_insurances` VALUES (3, 1, NULL, NULL, NULL, 1, NULL, 'contractor', '2023-03-21 16:53:27', '2023-03-21 16:53:27', NULL);

-- ----------------------------
-- Table structure for contract_key_peoples
-- ----------------------------
DROP TABLE IF EXISTS `contract_key_peoples`;
CREATE TABLE `contract_key_peoples`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `job` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsibility` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_key_peoples_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_key_peoples_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_key_peoples
-- ----------------------------
INSERT INTO `contract_key_peoples` VALUES (1, 1, '1', '1', '1', '1', '1', '2023-03-21 16:54:14', NULL, '2023-03-21 16:54:14');

-- ----------------------------
-- Table structure for contract_low_performance_damage_amounts
-- ----------------------------
DROP TABLE IF EXISTS `contract_low_performance_damage_amounts`;
CREATE TABLE `contract_low_performance_damage_amounts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `performance_level` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `amount` double(8, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_low_performance_damage_amounts_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_low_performance_damage_amounts_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_low_performance_damage_amounts
-- ----------------------------

-- ----------------------------
-- Table structure for contract_part_two_senior_representatives
-- ----------------------------
DROP TABLE IF EXISTS `contract_part_two_senior_representatives`;
CREATE TABLE `contract_part_two_senior_representatives`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_part_two_senior_representatives_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  INDEX `contract_part_two_senior_representatives_profile_id_foreign`(`profile_id` ASC) USING BTREE,
  CONSTRAINT `contract_part_two_senior_representatives_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_part_two_senior_representatives_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_part_two_senior_representatives
-- ----------------------------

-- ----------------------------
-- Table structure for contract_pay_item_activities
-- ----------------------------
DROP TABLE IF EXISTS `contract_pay_item_activities`;
CREATE TABLE `contract_pay_item_activities`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `item_or_activity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `other_currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_max_payment` double(8, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_pay_item_activities_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_pay_item_activities_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_pay_item_activities
-- ----------------------------

-- ----------------------------
-- Table structure for contract_price_adjustment_factors
-- ----------------------------
DROP TABLE IF EXISTS `contract_price_adjustment_factors`;
CREATE TABLE `contract_price_adjustment_factors`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `proportion` double(8, 2) NULL DEFAULT NULL,
  `factor` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_non_adjustable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_price_adjustment_factors_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_price_adjustment_factors_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_price_adjustment_factors
-- ----------------------------
INSERT INTO `contract_price_adjustment_factors` VALUES (1, 1, 1.00, NULL, 1, '2023-03-21 16:53:27', '2023-03-21 16:53:52', NULL);
INSERT INTO `contract_price_adjustment_factors` VALUES (2, 1, 1.00, NULL, 0, '2023-03-21 16:53:52', '2023-03-21 16:53:52', NULL);

-- ----------------------------
-- Table structure for contract_senior_representatives
-- ----------------------------
DROP TABLE IF EXISTS `contract_senior_representatives`;
CREATE TABLE `contract_senior_representatives`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_senior_representatives_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  INDEX `contract_senior_representatives_profile_id_foreign`(`profile_id` ASC) USING BTREE,
  CONSTRAINT `contract_senior_representatives_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contract_senior_representatives_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_senior_representatives
-- ----------------------------

-- ----------------------------
-- Table structure for contract_shared_service_defined_costs
-- ----------------------------
DROP TABLE IF EXISTS `contract_shared_service_defined_costs`;
CREATE TABLE `contract_shared_service_defined_costs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `category_of_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shared_service` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_shared_service_defined_costs_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_shared_service_defined_costs_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_shared_service_defined_costs
-- ----------------------------

-- ----------------------------
-- Table structure for contract_size_base_equipments
-- ----------------------------
DROP TABLE IF EXISTS `contract_size_base_equipments`;
CREATE TABLE `contract_size_base_equipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Other',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_size_base_equipments_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_size_base_equipments_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_size_base_equipments
-- ----------------------------
INSERT INTO `contract_size_base_equipments` VALUES (1, 1, '1', '11', '1', 'Other', '2023-03-21 16:54:30', NULL, '2023-03-21 16:54:30');

-- ----------------------------
-- Table structure for contract_time_base_equipments
-- ----------------------------
DROP TABLE IF EXISTS `contract_time_base_equipments`;
CREATE TABLE `contract_time_base_equipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_related_charge` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_time_period` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_time_base_equipments_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_time_base_equipments_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_time_base_equipments
-- ----------------------------

-- ----------------------------
-- Table structure for contract_undertakings_to_clients
-- ----------------------------
DROP TABLE IF EXISTS `contract_undertakings_to_clients`;
CREATE TABLE `contract_undertakings_to_clients`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `work` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_undertakings_to_clients_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_undertakings_to_clients_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_undertakings_to_clients
-- ----------------------------

-- ----------------------------
-- Table structure for contract_undertakings_to_others
-- ----------------------------
DROP TABLE IF EXISTS `contract_undertakings_to_others`;
CREATE TABLE `contract_undertakings_to_others`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `provided_to` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_undertakings_to_others_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_undertakings_to_others_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_undertakings_to_others
-- ----------------------------

-- ----------------------------
-- Table structure for contract_work_conditions
-- ----------------------------
DROP TABLE IF EXISTS `contract_work_conditions`;
CREATE TABLE `contract_work_conditions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `condition` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `key_date` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_work_conditions_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_work_conditions_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_work_conditions
-- ----------------------------
INSERT INTO `contract_work_conditions` VALUES (2, 1, '11', '2023-03-25', '2023-03-25 13:40:53', '2023-03-25 13:40:53', NULL);
INSERT INTO `contract_work_conditions` VALUES (3, 1, 'aa', '2023-03-25', '2023-03-25 13:40:53', '2023-03-25 13:40:53', NULL);

-- ----------------------------
-- Table structure for contract_work_section_bonuses
-- ----------------------------
DROP TABLE IF EXISTS `contract_work_section_bonuses`;
CREATE TABLE `contract_work_section_bonuses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `amount_per_day` double(8, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_work_section_bonuses_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_work_section_bonuses_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_work_section_bonuses
-- ----------------------------

-- ----------------------------
-- Table structure for contract_work_section_completion_dates
-- ----------------------------
DROP TABLE IF EXISTS `contract_work_section_completion_dates`;
CREATE TABLE `contract_work_section_completion_dates`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `completion_date` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_work_section_completion_dates_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_work_section_completion_dates_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_work_section_completion_dates
-- ----------------------------

-- ----------------------------
-- Table structure for contract_work_section_delay_damages
-- ----------------------------
DROP TABLE IF EXISTS `contract_work_section_delay_damages`;
CREATE TABLE `contract_work_section_delay_damages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `amount_per_day` double(8, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_work_section_delay_damages_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `contract_work_section_delay_damages_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contract_work_section_delay_damages
-- ----------------------------

-- ----------------------------
-- Table structure for contracts
-- ----------------------------
DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_ref` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kml_filepath` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contract_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `profile_id` bigint UNSIGNED NULL DEFAULT NULL,
  `subcontractor_profile_id` int NULL DEFAULT NULL,
  `latitude` decimal(20, 16) NOT NULL,
  `longitude` decimal(20, 16) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contracts_profile_id_foreign`(`profile_id` ASC) USING BTREE,
  CONSTRAINT `contracts_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of contracts
-- ----------------------------
INSERT INTO `contracts` VALUES (1, 'Test', 'Test Contract', '111', 2, '2023-03-18 14:50:45', '2023-03-21 16:49:56', NULL, 'ECC', 3, NULL, 50.6757788192030000, -1.2834913927579000);
INSERT INTO `contracts` VALUES (2, '11', 'TEST 1', '11111', 2, '2023-03-25 14:02:54', '2023-03-25 14:02:54', NULL, 'ECC', 3, 4, 50.6757788192030000, -1.2834913927579000);
INSERT INTO `contracts` VALUES (3, 'aaa', 'aaa', 'aaa', 2, '2023-04-03 17:55:50', '2023-04-03 17:55:50', NULL, 'NEC4_ECS', 3, 4, 50.6757788192030000, -1.2834913927579000);

-- ----------------------------
-- Table structure for daily_direct_personnels
-- ----------------------------
DROP TABLE IF EXISTS `daily_direct_personnels`;
CREATE TABLE `daily_direct_personnels`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `direct_personnel_id` bigint UNSIGNED NOT NULL,
  `worked_hours` double NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `daily_direct_personnels_daily_work_record_id_foreign`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `daily_direct_personnels_direct_personnel_id_foreign`(`direct_personnel_id` ASC) USING BTREE,
  CONSTRAINT `daily_direct_personnels_daily_work_record_id_foreign` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `daily_direct_personnels_direct_personnel_id_foreign` FOREIGN KEY (`direct_personnel_id`) REFERENCES `direct_personnel` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_direct_personnels
-- ----------------------------

-- ----------------------------
-- Table structure for daily_direct_vehicles_and_plants
-- ----------------------------
DROP TABLE IF EXISTS `daily_direct_vehicles_and_plants`;
CREATE TABLE `daily_direct_vehicles_and_plants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `direct_vehicles_and_plant_id` bigint UNSIGNED NOT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dvp_id`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `dvp_id`(`direct_vehicles_and_plant_id` ASC) USING BTREE,
  CONSTRAINT `dvp_id` FOREIGN KEY (`direct_vehicles_and_plant_id`) REFERENCES `direct_vehicles_and_plants` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `dwr_dvp_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_direct_vehicles_and_plants
-- ----------------------------

-- ----------------------------
-- Table structure for daily_operational_timing_operations
-- ----------------------------
DROP TABLE IF EXISTS `daily_operational_timing_operations`;
CREATE TABLE `daily_operational_timing_operations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `operation_id` bigint UNSIGNED NOT NULL,
  `started` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `completed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_doto_id`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `op_doto_id`(`operation_id` ASC) USING BTREE,
  CONSTRAINT `dwr_doto_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `op_doto_id` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_operational_timing_operations
-- ----------------------------

-- ----------------------------
-- Table structure for daily_operational_timing_plant_haulages
-- ----------------------------
DROP TABLE IF EXISTS `daily_operational_timing_plant_haulages`;
CREATE TABLE `daily_operational_timing_plant_haulages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `plant_haulage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `started` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `completed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dotph_id`(`daily_work_record_id` ASC) USING BTREE,
  CONSTRAINT `dwr_dotph_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_operational_timing_plant_haulages
-- ----------------------------

-- ----------------------------
-- Table structure for daily_operational_timing_supplied_materials
-- ----------------------------
DROP TABLE IF EXISTS `daily_operational_timing_supplied_materials`;
CREATE TABLE `daily_operational_timing_supplied_materials`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `started` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `completed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dotsm_id`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `mat_dotsm_id`(`material_id` ASC) USING BTREE,
  CONSTRAINT `dwr_dotsm_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mat_dotsm_id` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_operational_timing_supplied_materials
-- ----------------------------

-- ----------------------------
-- Table structure for daily_operational_timing_to_client_infos
-- ----------------------------
DROP TABLE IF EXISTS `daily_operational_timing_to_client_infos`;
CREATE TABLE `daily_operational_timing_to_client_infos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `demoblished_or_offsite` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `informed_client` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dotci_id`(`daily_work_record_id` ASC) USING BTREE,
  CONSTRAINT `dwr_dotci_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_operational_timing_to_client_infos
-- ----------------------------

-- ----------------------------
-- Table structure for daily_ordered_supplied_materials
-- ----------------------------
DROP TABLE IF EXISTS `daily_ordered_supplied_materials`;
CREATE TABLE `daily_ordered_supplied_materials`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `prog` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `on_site` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `supplied` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dosm_id`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `mat_dosm_id`(`material_id` ASC) USING BTREE,
  CONSTRAINT `dwr_dosm_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mat_dosm_id` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_ordered_supplied_materials
-- ----------------------------

-- ----------------------------
-- Table structure for daily_site_risks
-- ----------------------------
DROP TABLE IF EXISTS `daily_site_risks`;
CREATE TABLE `daily_site_risks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `description_of_issue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dsr_id`(`daily_work_record_id` ASC) USING BTREE,
  CONSTRAINT `dwr_dsr_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_site_risks
-- ----------------------------

-- ----------------------------
-- Table structure for daily_sub_contract_client_operations
-- ----------------------------
DROP TABLE IF EXISTS `daily_sub_contract_client_operations`;
CREATE TABLE `daily_sub_contract_client_operations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `subcontract_or_client_operation_id` bigint UNSIGNED NOT NULL,
  `operation_id` bigint UNSIGNED NOT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_id`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `sco_id`(`subcontract_or_client_operation_id` ASC) USING BTREE,
  INDEX `daily_sub_contract_client_operations_operation_id_foreign`(`operation_id` ASC) USING BTREE,
  CONSTRAINT `daily_sub_contract_client_operations_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `dwr_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sco_id` FOREIGN KEY (`subcontract_or_client_operation_id`) REFERENCES `subcontract_or_client_operations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_sub_contract_client_operations
-- ----------------------------

-- ----------------------------
-- Table structure for daily_sub_contract_or_hired_vehicles_and_plants
-- ----------------------------
DROP TABLE IF EXISTS `daily_sub_contract_or_hired_vehicles_and_plants`;
CREATE TABLE `daily_sub_contract_or_hired_vehicles_and_plants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `subcontract_or_hired_vehicles_and_plant_id` bigint UNSIGNED NOT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_sc_hvp_id`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `sc_hvp_id`(`subcontract_or_hired_vehicles_and_plant_id` ASC) USING BTREE,
  CONSTRAINT `dwr_sc_hvp_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sc_hvp_id` FOREIGN KEY (`subcontract_or_hired_vehicles_and_plant_id`) REFERENCES `subcontract_or_hired_vehicles_and_plants` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_sub_contract_or_hired_vehicles_and_plants
-- ----------------------------

-- ----------------------------
-- Table structure for daily_subcontract_personnels
-- ----------------------------
DROP TABLE IF EXISTS `daily_subcontract_personnels`;
CREATE TABLE `daily_subcontract_personnels`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `subcontract_personnel_id` bigint UNSIGNED NOT NULL,
  `worked_hours` double NULL DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `daily_subcontract_personnels_daily_work_record_id_foreign`(`daily_work_record_id` ASC) USING BTREE,
  INDEX `daily_subcontract_personnels_subcontract_personnel_id_foreign`(`subcontract_personnel_id` ASC) USING BTREE,
  CONSTRAINT `daily_subcontract_personnels_daily_work_record_id_foreign` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `daily_subcontract_personnels_subcontract_personnel_id_foreign` FOREIGN KEY (`subcontract_personnel_id`) REFERENCES `subcontract_personnel` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_subcontract_personnels
-- ----------------------------

-- ----------------------------
-- Table structure for daily_weather_conditions
-- ----------------------------
DROP TABLE IF EXISTS `daily_weather_conditions`;
CREATE TABLE `daily_weather_conditions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_work_record_id` bigint UNSIGNED NOT NULL,
  `time` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `air` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `ground` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `wind` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dwr_dwc_id`(`daily_work_record_id` ASC) USING BTREE,
  CONSTRAINT `dwr_dwc_id` FOREIGN KEY (`daily_work_record_id`) REFERENCES `daily_work_records` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_weather_conditions
-- ----------------------------

-- ----------------------------
-- Table structure for daily_work_records
-- ----------------------------
DROP TABLE IF EXISTS `daily_work_records`;
CREATE TABLE `daily_work_records`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `client_profile_id` int NOT NULL DEFAULT 2,
  `reference_no` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `crew_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `site_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `supervisor_profile_id` int NOT NULL DEFAULT 2,
  `foreman` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of daily_work_records
-- ----------------------------

-- ----------------------------
-- Table structure for direct_personnel
-- ----------------------------
DROP TABLE IF EXISTS `direct_personnel`;
CREATE TABLE `direct_personnel`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of direct_personnel
-- ----------------------------

-- ----------------------------
-- Table structure for direct_vehicles_and_plants
-- ----------------------------
DROP TABLE IF EXISTS `direct_vehicles_and_plants`;
CREATE TABLE `direct_vehicles_and_plants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_or_plant_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_no` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of direct_vehicles_and_plants
-- ----------------------------

-- ----------------------------
-- Table structure for early_warnings
-- ----------------------------
DROP TABLE IF EXISTS `early_warnings`;
CREATE TABLE `early_warnings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `programme_id` int NOT NULL,
  `contract_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `effect1` int NOT NULL,
  `effect2` int NOT NULL,
  `effect3` int NOT NULL,
  `effect4` int NOT NULL,
  `risk_score` tinyint NOT NULL DEFAULT 0 COMMENT 'risk Score',
  `score_order` tinyint NOT NULL DEFAULT 0 COMMENT 'risk Score Order',
  `status` int NOT NULL COMMENT 'Model EarlyWarningStatus',
  `date_notified` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of early_warnings
-- ----------------------------

-- ----------------------------
-- Table structure for except_reply_periods
-- ----------------------------
DROP TABLE IF EXISTS `except_reply_periods`;
CREATE TABLE `except_reply_periods`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `reply_for` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `reply_is` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_by_sub_contractor` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `except_reply_periods_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `except_reply_periods_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of except_reply_periods
-- ----------------------------

-- ----------------------------
-- Table structure for gantt_columns
-- ----------------------------
DROP TABLE IF EXISTS `gantt_columns`;
CREATE TABLE `gantt_columns`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `programme_id` int NULL DEFAULT NULL,
  `task_columns` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_columns` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wbs` int NOT NULL DEFAULT 42,
  `text` int NOT NULL DEFAULT 154,
  `start_date` int NOT NULL DEFAULT 110,
  `end_date` int NOT NULL DEFAULT 110,
  `progress` int NOT NULL DEFAULT 80,
  `duration_worked` int NOT NULL DEFAULT 80,
  `baseline_start` int NOT NULL DEFAULT 110,
  `baseline_end` int NOT NULL DEFAULT 110,
  `reference_number` int NOT NULL DEFAULT 80,
  `task_calendar` int NOT NULL DEFAULT 80,
  `deadline` int NOT NULL DEFAULT 110,
  `constraint_type` int NOT NULL DEFAULT 80,
  `constraint_date` int NOT NULL DEFAULT 110,
  `comments` int NOT NULL DEFAULT 80,
  `resource_id` int NOT NULL DEFAULT 110,
  `status` int NOT NULL DEFAULT 40,
  `resource_calendar` int NOT NULL DEFAULT 80,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gantt_columns
-- ----------------------------
INSERT INTO `gantt_columns` VALUES (1, 2, 1, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 02:52:42', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (2, 2, 2, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 08:45:40', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (3, 2, 3, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 08:47:48', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (4, 2, 4, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 08:49:05', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (5, 2, 5, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 09:14:49', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (6, 2, 6, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 09:16:01', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (7, 2, 7, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 11:14:50', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (8, 2, 8, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-18 11:15:31', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (9, 2, 9, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:41:34', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (10, 2, 10, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:41:47', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (11, 2, 11, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:41:52', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (12, 2, 12, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:41:59', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (13, 2, 13, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:46:51', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (14, 2, 14, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:46:56', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (15, 2, 15, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:49:03', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (16, 2, 16, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:49:57', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (17, 2, 17, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:50:18', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (18, 2, 18, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:50:28', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (19, 2, 19, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:58:12', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (20, 2, 20, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 07:59:59', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (21, 2, 21, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:18:12', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (22, 2, 22, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:20:03', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (23, 2, 23, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:20:46', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (24, 2, 24, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:21:12', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (25, 2, 25, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:21:41', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (26, 2, 26, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:22:54', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (27, 2, 27, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:23:29', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (28, 2, 28, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:23:45', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (29, 2, 29, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:27:56', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (30, 2, 30, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:29:45', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (31, 2, 31, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-19 08:30:30', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (32, 2, 32, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-24 04:21:03', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (33, 2, 33, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-24 06:37:43', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (34, 2, 34, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-24 06:39:18', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (35, 2, 35, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-25 12:30:00', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (36, 2, 36, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-25 12:32:24', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (37, 2, 37, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-27 07:02:33', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (38, 2, 38, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-27 07:02:46', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (39, 2, 39, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-27 07:09:22', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (40, 2, 40, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-27 07:20:58', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (41, 2, 41, '[{\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":true,\"baseline_end\":true,\"task_calendar\":false,\"resource_id\":false,\"duration_worked\":true}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-03-27 07:37:55', '2023-04-01 20:35:13', NULL);
INSERT INTO `gantt_columns` VALUES (42, 2, 42, '[{\"status\": true,\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":false,\"baseline_end\":false,\"task_calendar\":true,\"deadline\":false,\"resource_id\":true,\"duration_worked\":false}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-04-03 03:09:17', '2023-04-03 03:09:17', NULL);
INSERT INTO `gantt_columns` VALUES (43, 2, 43, '[{\"status\": true,\"wbs\":false,\"text\":true,\"start_date\":true,\"end_date\":false,\"progress\":true,\"baseline_start\":false,\"baseline_end\":false,\"task_calendar\":true,\"deadline\":false,\"resource_id\":true,\"duration_worked\":false}]', '[{\"name\":true,\"resource_calendar\":false,\"complete\":true,\"workload\":true,\"unit_cost\":true}]', 42, 154, 110, 110, 80, 80, 110, 110, 80, 80, 110, 80, 110, 80, 110, 40, 80, '2023-04-05 12:35:47', '2023-04-05 12:35:47', NULL);

-- ----------------------------
-- Table structure for gantt_programmes
-- ----------------------------
DROP TABLE IF EXISTS `gantt_programmes`;
CREATE TABLE `gantt_programmes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int NOT NULL DEFAULT 0,
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sharing_identifier` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_project_guid` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_save_time` int NULL DEFAULT NULL,
  `last_save_author_id` int NULL DEFAULT NULL,
  `created` int NOT NULL,
  `current_snapshot` int NOT NULL DEFAULT 0,
  `current_version_id` int NULL DEFAULT NULL,
  `undo_redo_version_id` int NULL DEFAULT NULL,
  `active` int NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gantt_programmes
-- ----------------------------

-- ----------------------------
-- Table structure for gantt_task_assignees
-- ----------------------------
DROP TABLE IF EXISTS `gantt_task_assignees`;
CREATE TABLE `gantt_task_assignees`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `assignee_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `gantt_task_assignees_task_id_foreign`(`task_id` ASC) USING BTREE,
  INDEX `gantt_task_assignees_assignee_id_foreign`(`assignee_id` ASC) USING BTREE,
  CONSTRAINT `gantt_task_assignees_assignee_id_foreign` FOREIGN KEY (`assignee_id`) REFERENCES `profiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `gantt_task_assignees_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `gantt_tasks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gantt_task_assignees
-- ----------------------------

-- ----------------------------
-- Table structure for gantt_task_process
-- ----------------------------
DROP TABLE IF EXISTS `gantt_task_process`;
CREATE TABLE `gantt_task_process`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `progress` int NULL DEFAULT NULL,
  `datetime_recorded` datetime NULL DEFAULT NULL,
  `date_recorded` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gantt_task_process
-- ----------------------------

-- ----------------------------
-- Table structure for gantt_tasks
-- ----------------------------
DROP TABLE IF EXISTS `gantt_tasks`;
CREATE TABLE `gantt_tasks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent` int NULL DEFAULT NULL,
  `programme_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `start_date` datetime NULL DEFAULT NULL,
  `end_date` datetime NULL DEFAULT NULL,
  `position` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `baseline_start` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `baseline_end` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `baseline_progress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deadline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `duration` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `duration_unit` int NOT NULL DEFAULT 0,
  `duration_hours` int NULL DEFAULT NULL,
  `duration_worked` int NULL DEFAULT NULL,
  `opened` int NOT NULL DEFAULT 1,
  `progress` double NULL DEFAULT 0,
  `sortorder` int NOT NULL DEFAULT 0,
  `calendar_id` int NULL DEFAULT 0,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'task',
  `resource_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` int NOT NULL DEFAULT 1,
  `status` int NULL DEFAULT 1,
  `workload_quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `workload_quantity_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resource_group_id` int NULL DEFAULT 0,
  `order_ui` int NULL DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_summary` int NOT NULL DEFAULT 0,
  `pending_deletion` int NOT NULL DEFAULT 0,
  `constraint_type` int NOT NULL DEFAULT 0,
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#299cb4',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1680790894465 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gantt_tasks
-- ----------------------------
INSERT INTO `gantt_tasks` VALUES (1, '3AA10C8B-7F48-2539-1698-88C1116BE8F0', 0, '1', 'New task', '2023-03-25 12:00:00', '2023-03-28 12:00:00', NULL, '2023-03-25 12:00:00', '2023-03-28 12:00:00', NULL, NULL, NULL, 0, NULL, NULL, 1, 0, 0, 1, 'project', '0', 1, 1, NULL, NULL, 0, NULL, '', 0, 0, 0, 'rgb(41, 156, 180)', NULL, '2023-04-06 15:23:38', '2023-04-06 15:23:50');
INSERT INTO `gantt_tasks` VALUES (2, '0DC2CC79-6420-36AE-DC10-005E96B1C733', 1, '1', 'New task', '2023-03-25 12:00:00', '2023-03-27 12:00:00', NULL, '2023-03-25 12:00:00', '2023-03-27 12:00:00', NULL, NULL, NULL, 0, NULL, NULL, 1, 0, 0, 1, 'task', '0', 1, 1, NULL, NULL, 0, NULL, '', 0, 0, 0, 'rgb(41, 156, 180)', NULL, '2023-04-06 15:23:48', '2023-04-06 15:23:48');

-- ----------------------------
-- Table structure for gantt_versions
-- ----------------------------
DROP TABLE IF EXISTS `gantt_versions`;
CREATE TABLE `gantt_versions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `programme_id` int NOT NULL,
  `gantt_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `aux_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `user_id` int NOT NULL,
  `created` int NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `primary_object_guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `secondary_object_guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` int NOT NULL DEFAULT 1,
  `is_reference_version` int NOT NULL DEFAULT 0,
  `ui_string` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `to_finalise` int NULL DEFAULT 0,
  `pending` int NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gantt_versions
-- ----------------------------

-- ----------------------------
-- Table structure for instructions
-- ----------------------------
DROP TABLE IF EXISTS `instructions`;
CREATE TABLE `instructions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `profile_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(20, 16) NOT NULL,
  `longitude` decimal(20, 16) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp,
  `finish` timestamp NOT NULL DEFAULT current_timestamp,
  `duration` int NOT NULL,
  `pattern` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL COMMENT 'Model InstructionStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instructions
-- ----------------------------

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `profile_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net` double(8, 2) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp,
  `finish` timestamp NOT NULL DEFAULT current_timestamp,
  `status` int NOT NULL COMMENT 'Model InvoiceStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoices
-- ----------------------------

-- ----------------------------
-- Table structure for links
-- ----------------------------
DROP TABLE IF EXISTS `links`;
CREATE TABLE `links`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` int NOT NULL,
  `target` int NOT NULL,
  `lag` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 498 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of links
-- ----------------------------

-- ----------------------------
-- Table structure for materials
-- ----------------------------
DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of materials
-- ----------------------------

-- ----------------------------
-- Table structure for measures
-- ----------------------------
DROP TABLE IF EXISTS `measures`;
CREATE TABLE `measures`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `site_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantified_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `linear_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_id` int NOT NULL,
  `status` int NOT NULL COMMENT 'Model MeasureStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of measures
-- ----------------------------

-- ----------------------------
-- Table structure for media
-- ----------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `collection_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `disk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `media_model_type_model_id_index`(`model_type` ASC, `model_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of media
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 161 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (4, '2022_01_30_185138_initial_project_tables', 1);
INSERT INTO `migrations` VALUES (5, '2022_02_04_185606_change_assessments_table_fields', 1);
INSERT INTO `migrations` VALUES (6, '2022_02_05_101803_remove_measure_id_field_in_applications_table', 1);
INSERT INTO `migrations` VALUES (7, '2022_02_05_124634_update_applications_table', 1);
INSERT INTO `migrations` VALUES (8, '2022_02_06_094234_change_profiles_table_to_correspond_department_model', 1);
INSERT INTO `migrations` VALUES (9, '2022_02_06_131331_add_roles_to_profiles_table', 1);
INSERT INTO `migrations` VALUES (10, '2022_02_11_214303_add_allowed_roles_to_activities_and_notification_tables', 1);
INSERT INTO `migrations` VALUES (11, '2022_02_11_222625_add_profiles_notified_table', 1);
INSERT INTO `migrations` VALUES (12, '2022_02_12_092913_create_comments_table', 1);
INSERT INTO `migrations` VALUES (13, '2022_02_15_183401_create_media_table', 1);
INSERT INTO `migrations` VALUES (14, '2022_02_15_204434_create_profile_folders_table', 1);
INSERT INTO `migrations` VALUES (15, '2022_02_17_075741_create_tasks_table', 1);
INSERT INTO `migrations` VALUES (16, '2022_02_17_075811_create_links_table', 1);
INSERT INTO `migrations` VALUES (17, '2022_02_17_114654_add_sortorder_to_tasks_table', 1);
INSERT INTO `migrations` VALUES (18, '2022_02_26_083018_add_missing_fields_to_taskk_table', 1);
INSERT INTO `migrations` VALUES (19, '2022_03_04_105621_add_missing_fields_to_taskks_table', 1);
INSERT INTO `migrations` VALUES (20, '2022_03_04_135122_add_missing_fields_to_taskks_table2', 1);
INSERT INTO `migrations` VALUES (21, '2022_03_09_054714_create_programmes_table', 1);
INSERT INTO `migrations` VALUES (22, '2022_03_11_112523_create_user_programme_links_table', 1);
INSERT INTO `migrations` VALUES (23, '2022_03_15_054635_create_gantt_columns_table', 1);
INSERT INTO `migrations` VALUES (24, '2022_03_21_054241_create_calendars_table', 1);
INSERT INTO `migrations` VALUES (25, '2022_03_21_091043_create_calendar_overrides_table', 1);
INSERT INTO `migrations` VALUES (26, '2022_03_24_064345_gantt_task_process_table', 1);
INSERT INTO `migrations` VALUES (27, '2022_04_06_052456_create_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (28, '2022_04_06_105946_add_step_3_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (29, '2022_04_06_105946_add_step_4_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (30, '2022_04_07_094846_add_score_field', 1);
INSERT INTO `migrations` VALUES (31, '2022_04_07_105946_add_step_5_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (32, '2022_04_07_105947_add_step_6_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (33, '2022_04_07_105947_add_step_7_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (34, '2022_04_07_105947_add_step_8_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (35, '2022_04_07_105947_add_step_9_fields_to_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (36, '2022_04_08_105947_create_part_two_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (37, '2022_04_11_105947_create_boq_schedules_table', 1);
INSERT INTO `migrations` VALUES (38, '2022_04_12_105947_create_activity_schedules_table', 1);
INSERT INTO `migrations` VALUES (39, '2022_04_12_105947_create_price_lists_table', 1);
INSERT INTO `migrations` VALUES (40, '2022_04_15_105947_add_contract_type_to_contracts_table', 1);
INSERT INTO `migrations` VALUES (41, '2022_05_03_000001_add_spark_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (42, '2022_05_03_000002_create_subscriptions_table', 1);
INSERT INTO `migrations` VALUES (43, '2022_05_03_000003_create_receipts_table', 1);
INSERT INTO `migrations` VALUES (44, '2022_05_03_000003_create_subscription_items_table', 1);
INSERT INTO `migrations` VALUES (45, '2022_05_03_000003_create_tax_rates_table', 1);
INSERT INTO `migrations` VALUES (46, '2022_05_09_053348_create_direct_personnel_table', 1);
INSERT INTO `migrations` VALUES (47, '2022_05_09_054242_create_subcontract_personnel_table', 1);
INSERT INTO `migrations` VALUES (48, '2022_05_09_054531_create_direct_vehicles_and_plants_table', 1);
INSERT INTO `migrations` VALUES (49, '2022_05_09_054831_create_subcontract_or_hired_vehicles_and_plants_table', 1);
INSERT INTO `migrations` VALUES (50, '2022_05_09_055216_create_materials_table', 1);
INSERT INTO `migrations` VALUES (51, '2022_05_09_055314_create_operations_table', 1);
INSERT INTO `migrations` VALUES (52, '2022_05_09_055505_create_subcontract_or_client_operations_table', 1);
INSERT INTO `migrations` VALUES (53, '2022_05_09_055506_create_daily_work_records_table', 1);
INSERT INTO `migrations` VALUES (54, '2022_05_09_055507_create_daily_subcontract_personnels_table', 1);
INSERT INTO `migrations` VALUES (55, '2022_05_09_055508_create_daily_direct_personnels_table', 1);
INSERT INTO `migrations` VALUES (56, '2022_05_11_015243_create_daily_sub_contract_client_operations_table', 1);
INSERT INTO `migrations` VALUES (57, '2022_05_11_032054_create_daily_direct_vehicles_and_plants_table', 1);
INSERT INTO `migrations` VALUES (58, '2022_05_11_032140_create_daily_sub_contract_or_hired_vehicles_and_plants_table', 1);
INSERT INTO `migrations` VALUES (59, '2022_05_12_034417_create_daily_weather_conditions_table', 1);
INSERT INTO `migrations` VALUES (60, '2022_05_12_080440_create_daily_operational_timing_operations_table', 1);
INSERT INTO `migrations` VALUES (61, '2022_05_12_080532_create_daily_operational_timing_supplied_materials_table', 1);
INSERT INTO `migrations` VALUES (62, '2022_05_12_080711_create_daily_operational_timing_plant_haulages_table', 1);
INSERT INTO `migrations` VALUES (63, '2022_05_12_104105_create_daily_ordered_supplied_materials_table', 1);
INSERT INTO `migrations` VALUES (64, '2022_05_13_051053_create_daily_operational_timing_to_client_infos_table', 1);
INSERT INTO `migrations` VALUES (65, '2022_05_13_052958_create_daily_site_risks_table', 1);
INSERT INTO `migrations` VALUES (66, '2022_05_13_125028_add_or_edit_super_user', 1);
INSERT INTO `migrations` VALUES (67, '2022_05_13_132641_add_team_users_count_field_to_profiles_table', 1);
INSERT INTO `migrations` VALUES (68, '2022_05_18_040556_create_tsc_contracts_table', 1);
INSERT INTO `migrations` VALUES (69, '2022_05_18_111036_add_tsc_columns_to_part_two_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (70, '2022_06_06_183549_add_created_by_admin_field_to_profiles_table', 1);
INSERT INTO `migrations` VALUES (71, '2022_06_07_125641_remove_date_of_birth_field_from_profiles_table', 1);
INSERT INTO `migrations` VALUES (72, '2022_07_15_062210_create_include_columns_to_contracts_table', 1);
INSERT INTO `migrations` VALUES (73, '2022_07_19_150454_add_missing_db_tables', 1);
INSERT INTO `migrations` VALUES (74, '2022_07_28_162832_add_unitcost_field_into_resources_table', 1);
INSERT INTO `migrations` VALUES (75, '2022_08_08_054803_create_gantt_task_assignees_table', 1);
INSERT INTO `migrations` VALUES (76, '2022_08_12_154123_update_contract_table_fields', 1);
INSERT INTO `migrations` VALUES (77, '2022_08_23_201541_add_programme_id_field_to_early_warnings_table', 1);
INSERT INTO `migrations` VALUES (78, '2022_08_29_114824_remove_task_orders_field', 1);
INSERT INTO `migrations` VALUES (79, '2022_09_03_203636_add_deleted_at_fields', 1);
INSERT INTO `migrations` VALUES (80, '2022_09_06_160528_add_contract_id_in_daily_work_records_table', 1);
INSERT INTO `migrations` VALUES (81, '2022_09_06_163610_add_mission_deleted_at_field_to_callendar_overrides', 1);
INSERT INTO `migrations` VALUES (82, '2022_09_06_194125_add_deleted_at_field_to_contract_application', 1);
INSERT INTO `migrations` VALUES (83, '2022_09_07_121026_create_nec4_tsc_contracts_table', 1);
INSERT INTO `migrations` VALUES (84, '2022_09_08_034825_create_workflows_table', 1);
INSERT INTO `migrations` VALUES (85, '2022_09_08_111037_create_part_two_nec4_tsc_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (86, '2022_09_11_121200_update_work_records_profiles_fields', 1);
INSERT INTO `migrations` VALUES (87, '2022_09_11_143747_add_contract_id_field_to_measures', 1);
INSERT INTO `migrations` VALUES (88, '2022_09_11_160820_add_contract_id_field_to_applications', 1);
INSERT INTO `migrations` VALUES (89, '2022_09_12_085956_remove_works_from_measures', 1);
INSERT INTO `migrations` VALUES (90, '2022_09_12_194127_add_secondary_options_fields_to_nec4_tsc_contracts', 1);
INSERT INTO `migrations` VALUES (91, '2022_09_13_085956_remove_works_from_rate_cards', 1);
INSERT INTO `migrations` VALUES (92, '2022_09_14_141648_change_allowed_roles_field_in_activity_and_notifications', 1);
INSERT INTO `migrations` VALUES (93, '2022_09_15_085956_remove_except_reply_periods_from_nec4_tsc_contracts', 1);
INSERT INTO `migrations` VALUES (94, '2022_09_15_111037_create_except_reply_periods_table', 1);
INSERT INTO `migrations` VALUES (95, '2022_09_21_190710_remove_works_id_from_early_warnings', 1);
INSERT INTO `migrations` VALUES (96, '2022_09_23_044013_add_contract_id_to_programmes_table', 1);
INSERT INTO `migrations` VALUES (97, '2022_09_24_092614_create_rate_card_pins_table', 1);
INSERT INTO `migrations` VALUES (98, '2022_09_28_123029_change_category_field_type_in_workflows', 1);
INSERT INTO `migrations` VALUES (99, '2022_10_12_083303_create_settings_table', 1);
INSERT INTO `migrations` VALUES (100, '2022_10_12_151077_create_notification_settings_table', 1);
INSERT INTO `migrations` VALUES (101, '2022_10_20_165640_remove_works_id_fields', 1);
INSERT INTO `migrations` VALUES (102, '2022_10_22_220242_add_organisation_logo_field_to_profiles_table', 1);
INSERT INTO `migrations` VALUES (103, '2022_10_25_202749_create_mitigations_table', 1);
INSERT INTO `migrations` VALUES (104, '2022_10_27_175433_create_quotations_table', 1);
INSERT INTO `migrations` VALUES (105, '2022_11_01_205641_change_quotation_contract_date_effect_field', 1);
INSERT INTO `migrations` VALUES (106, '2022_11_02_105128_quotations_add_assessment_and_instruction_fields', 1);
INSERT INTO `migrations` VALUES (107, '2022_11_10_235938_create_riskmanagement_table', 1);
INSERT INTO `migrations` VALUES (108, '2022_11_12_223135_create_compensation_events_table', 1);
INSERT INTO `migrations` VALUES (109, '2022_11_23_220242_add_rate_field_to_price_lists_table', 1);
INSERT INTO `migrations` VALUES (110, '2022_12_01_083303_create_additional_employer_risks_table', 1);
INSERT INTO `migrations` VALUES (111, '2022_12_01_083303_create_contract_insurances_table', 1);
INSERT INTO `migrations` VALUES (112, '2022_12_01_165640_remove_contract_insurance_fields', 1);
INSERT INTO `migrations` VALUES (113, '2022_12_11_053140_programme_image_table', 1);
INSERT INTO `migrations` VALUES (114, '2022_12_15_083302_add_provider_to_additional_employer_risks_table', 1);
INSERT INTO `migrations` VALUES (115, '2022_12_15_083303_add_column_to_except_reply_periods_table', 1);
INSERT INTO `migrations` VALUES (116, '2022_12_15_083304_create_contract_work_conditions_table', 1);
INSERT INTO `migrations` VALUES (117, '2022_12_15_083305_create_contract_access_dates_table', 1);
INSERT INTO `migrations` VALUES (118, '2022_12_15_083306_create_contract_defect_correction_except_periods_table', 1);
INSERT INTO `migrations` VALUES (119, '2022_12_15_105947_create_part_two_nec4_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (120, '2022_12_16_083306_create_contract_price_adjustment_factors_table', 1);
INSERT INTO `migrations` VALUES (121, '2022_12_16_083307_create_contract_pay_item_activities_table', 1);
INSERT INTO `migrations` VALUES (122, '2022_12_16_083308_create_contract_work_section_completion_dates_table', 1);
INSERT INTO `migrations` VALUES (123, '2022_12_16_083309_create_contract_work_section_bonuses_table', 1);
INSERT INTO `migrations` VALUES (124, '2022_12_16_083310_create_contract_work_section_delay_damages_table', 1);
INSERT INTO `migrations` VALUES (125, '2022_12_16_083311_create_contract_undertakings_to_others_table', 1);
INSERT INTO `migrations` VALUES (126, '2022_12_16_083312_create_contract_undertakings_to_clients_table', 1);
INSERT INTO `migrations` VALUES (127, '2022_12_16_083313_create_subcontractor_undertakings_to_others_table', 1);
INSERT INTO `migrations` VALUES (128, '2022_12_16_083314_create_contract_low_performance_damage_amounts_table', 1);
INSERT INTO `migrations` VALUES (129, '2022_12_16_083315_create_contract_extension_periods_table', 1);
INSERT INTO `migrations` VALUES (130, '2022_12_16_083316_create_contract_extension_criteria_table', 1);
INSERT INTO `migrations` VALUES (131, '2022_12_16_083317_create_contract_accounting_periods_table', 1);
INSERT INTO `migrations` VALUES (132, '2022_12_16_083318_create_contract_benificiary_terms_table', 1);
INSERT INTO `migrations` VALUES (133, '2022_12_16_105947_create_contract_key_peoples_table', 1);
INSERT INTO `migrations` VALUES (134, '2022_12_16_105950_create_contract_defined_costs_table', 1);
INSERT INTO `migrations` VALUES (135, '2022_12_16_105950_create_contract_part_two_senior_representatives_table', 1);
INSERT INTO `migrations` VALUES (136, '2022_12_16_105950_create_contract_shared_service_defined_costs_table', 1);
INSERT INTO `migrations` VALUES (137, '2022_12_16_105950_create_contract_size_base_equipments_table', 1);
INSERT INTO `migrations` VALUES (138, '2022_12_16_105950_create_contract_time_base_equipments_table', 1);
INSERT INTO `migrations` VALUES (139, '2022_12_18_220242_change_columns_of_contract_applications_table', 1);
INSERT INTO `migrations` VALUES (140, '2022_12_18_220243_add_columns_of_part_two_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (141, '2022_12_19_105950_create_contract_senior_representatives_table', 1);
INSERT INTO `migrations` VALUES (142, '2022_12_19_105950_create_nec4_contracts_table', 1);
INSERT INTO `migrations` VALUES (143, '2022_12_22_105947_change_columns_of_part_two_nec4_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (144, '2022_12_22_105950_change_columns_of_contract_part_two_senior_representatives_table', 1);
INSERT INTO `migrations` VALUES (145, '2022_12_22_105952_change_columns_of_part_two_contract_datas_table', 1);
INSERT INTO `migrations` VALUES (146, '2022_12_23_105950_add_deleted_at_column_to_contract_part_two_relations_table', 1);
INSERT INTO `migrations` VALUES (147, '2022_12_25_105951_change_column_type_of_date_in_contract_access_dates_table', 1);
INSERT INTO `migrations` VALUES (148, '2022_12_25_105952_drop_tsc_tables', 1);
INSERT INTO `migrations` VALUES (149, '2023_01_16_213827_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (150, '2023_02_03_093524_add_remove_fields_from_profiles_table', 1);
INSERT INTO `migrations` VALUES (151, '2023_02_03_171658_add_subcontractor_profile_id_field_to_contracts_table', 1);
INSERT INTO `migrations` VALUES (152, '2023_02_18_162252_add_missing_updated_at_and_created_at_fields', 1);
INSERT INTO `migrations` VALUES (153, '2023_02_18_204520_remove_unnecessary_tables', 1);
INSERT INTO `migrations` VALUES (154, '2023_02_19_153516_update_risk_score_indexes', 1);
INSERT INTO `migrations` VALUES (155, '2023_03_16_222845_add_lag_column_to_links_table', 1);
INSERT INTO `migrations` VALUES (156, '2023_03_24_211037_create_uuid_fields_for_tenants_and_profiles', 2);
INSERT INTO `migrations` VALUES (157, '2023_03_26_173810_add_link_col_to_activities_and_notifications', 2);
INSERT INTO `migrations` VALUES (158, '2023_03_31_201932_create_media_table', 3);
INSERT INTO `migrations` VALUES (159, '2023_04_01_141030_add_status_and_accepted_at_field_to_programmes_table', 3);
INSERT INTO `migrations` VALUES (160, '2023_04_04_220123_add_resource_fields_to_activity_and_notifications_table', 3);

-- ----------------------------
-- Table structure for mitigations
-- ----------------------------
DROP TABLE IF EXISTS `mitigations`;
CREATE TABLE `mitigations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `early_warning_id` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of mitigations
-- ----------------------------

-- ----------------------------
-- Table structure for mmb_tasks
-- ----------------------------
DROP TABLE IF EXISTS `mmb_tasks`;
CREATE TABLE `mmb_tasks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `column_id` int NOT NULL,
  `order_id` int NOT NULL,
  `progress` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of mmb_tasks
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------

-- ----------------------------
-- Table structure for nec4_contracts
-- ----------------------------
DROP TABLE IF EXISTS `nec4_contracts`;
CREATE TABLE `nec4_contracts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `inflation_adjustment_dates` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_takeover_completion_date` tinyint(1) NOT NULL DEFAULT 0,
  `takeover_completion_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x10_info_exec_plan_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x10_min_insurance_amount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x10_service_period_end` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x12_shedule_is_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x15_retention_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x15_min_insurance_amount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x15_completion_or_termination_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x16_retention_bond` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x19_min_service_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x19_notice_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x23_max_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `outside_works_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `early_warnings_no_longer_than` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revised_plans_interval_no_longer_than` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `end_task_order_programme_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `quality_policy_plan_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `final_assessment_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `a_value_engineering_percentage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `additional_compansation_events` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `yuk2_accounting_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `yuk2_due_payment_period` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `nec4_contracts_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `nec4_contracts_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nec4_contracts
-- ----------------------------
INSERT INTO `nec4_contracts` VALUES (1, 3, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-03 17:55:50', '2023-04-03 17:55:50', NULL);

-- ----------------------------
-- Table structure for notification_settings
-- ----------------------------
DROP TABLE IF EXISTS `notification_settings`;
CREATE TABLE `notification_settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of notification_settings
-- ----------------------------

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resource` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resource_id` int UNSIGNED NULL DEFAULT NULL,
  `allowed_roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `allowed_department` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for operations
-- ----------------------------
DROP TABLE IF EXISTS `operations`;
CREATE TABLE `operations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of operations
-- ----------------------------

-- ----------------------------
-- Table structure for part_two_contract_datas
-- ----------------------------
DROP TABLE IF EXISTS `part_two_contract_datas`;
CREATE TABLE `part_two_contract_datas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `direct_fee` double NULL DEFAULT NULL,
  `subcontracted_fee` double NULL DEFAULT NULL,
  `contractor_ident_prog` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `contractor_wi1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `contractor_wi2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `project_bank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `named_suppliers` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `total_prices` double NULL DEFAULT NULL,
  `people_oh_percent` double NULL DEFAULT NULL,
  `equipment_publisher` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `equipment_adj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `design_oh_percent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `design_expenses_cats` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `risk_register` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `contractor_plan_service_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `contractor_ident_plan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price_list` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `manufacture_fab_oh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `percent_work_area_oh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `contract_working_areas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `completion_date_works` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `part_two_contract_datas_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `part_two_contract_datas_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of part_two_contract_datas
-- ----------------------------
INSERT INTO `part_two_contract_datas` VALUES (1, 1, 1, 0.98, NULL, '11', NULL, NULL, NULL, 1, 11, '1', '1', '1', '1', '2023-03-18 14:50:45', '2023-03-21 16:54:30', NULL, '11', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `part_two_contract_datas` VALUES (2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-25 14:02:54', '2023-03-25 14:02:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `part_two_contract_datas` VALUES (3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-03 17:55:50', '2023-04-03 17:55:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for part_two_nec4_contract_datas
-- ----------------------------
DROP TABLE IF EXISTS `part_two_nec4_contract_datas`;
CREATE TABLE `part_two_nec4_contract_datas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `activity_schedule_is` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `x10_info_execution_plan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `part_two_nec4_contract_datas_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `part_two_nec4_contract_datas_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of part_two_nec4_contract_datas
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `assessment_id` int NOT NULL,
  `cuml_net` double(8, 2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `from_date` timestamp NOT NULL DEFAULT current_timestamp,
  `due_date` timestamp NOT NULL DEFAULT current_timestamp,
  `status` int NOT NULL COMMENT 'Model PaymentStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payments
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for price_lists
-- ----------------------------
DROP TABLE IF EXISTS `price_lists`;
CREATE TABLE `price_lists`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `item` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `price_lists_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `price_lists_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of price_lists
-- ----------------------------

-- ----------------------------
-- Table structure for profile_folders
-- ----------------------------
DROP TABLE IF EXISTS `profile_folders`;
CREATE TABLE `profile_folders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `folder_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `profile_folders_profile_id_folder_name_unique`(`profile_id` ASC, `folder_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of profile_folders
-- ----------------------------

-- ----------------------------
-- Table structure for profiles
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int NOT NULL DEFAULT 0 COMMENT 'Model Static/Role',
  `created_by` int NULL DEFAULT NULL,
  `department` int NOT NULL COMMENT 'Model Department',
  `organisation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `organisation_logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Path to Contractor\'s organisation logo',
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int NULL DEFAULT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `card_brand` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `card_last_four` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `card_expiration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `extra_billing_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `billing_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `billing_address_line_2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `billing_city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `billing_state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `billing_postal_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vat_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `receipt_emails` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `billing_country` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `team_users_count` int NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  INDEX `profiles_stripe_id_index`(`stripe_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of profiles
-- ----------------------------
INSERT INTO `profiles` VALUES (1, 'Ibex', 'Support', 'support@ibex-consulting.co.uk', '2023-03-18 00:00:00', '$2y$10$1Z0YRvS9ebcC01BWoI1tR.KyKjbxrNDnTXavPOsLxF0/wfNzBHmUy', 1, NULL, 1, NULL, NULL, NULL, '/assets/images/svg/help-support.svg', NULL, '1ce32f66-2adf-4f2d-a617-677c2d7d9a45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, '2023-03-27 19:07:35', NULL);
INSERT INTO `profiles` VALUES (2, 'Geoffrey', 'Dicki', 'udickens@hotmail.com', NULL, '$2y$10$ehW.BBYnXUqcEFwCq4zuLe/hMuxFdoeyCAi8Dz9D5EZD3n8pb/hhq', 2, NULL, 1, 'foo1', NULL, NULL, '/assets/images/svg/help-support.svg', NULL, '1ecf5598-6bb3-4fec-8373-e1e0bc7b7ca4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2023-03-18 14:48:05', '2023-03-27 19:07:35', NULL);
INSERT INTO `profiles` VALUES (3, 'Consalo', 'Gudin', 'consalo@hotmail.com', NULL, '$2y$10$/SEHc9XbMYpjvaxI0ZjcV.eEyJixd.WA/3OQC9utHXiuM3rIxCk7i', 4, NULL, 2, 'ibex', NULL, NULL, 'd42aqRTZXqLQkUbb.jpg', NULL, 'ae1f51d6-e818-4f8b-84ec-72c4870aaf1d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2023-03-18 14:49:54', '2023-03-27 19:07:35', NULL);
INSERT INTO `profiles` VALUES (4, 'Consalo1', 'Gudin', 'consalo1@hotmail.com', NULL, '$2y$10$58XorpUTFGJbcuCfLkzM1etaTrm6X0aX2tvG7wNHFhlsF5.kveaZK', 9, NULL, 1, 'foo1', NULL, NULL, 'YEiqSWbgEhWmtUgO.jpg', 3, 'd6d2d7f0-d8ed-4343-972e-0f983ecb3aed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2023-03-25 13:54:05', '2023-03-27 19:07:35', NULL);

-- ----------------------------
-- Table structure for profiles_notified
-- ----------------------------
DROP TABLE IF EXISTS `profiles_notified`;
CREATE TABLE `profiles_notified`  (
  `profile_id` int NOT NULL,
  `notification_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE INDEX `profiles_notified_profile_id_notification_id_unique`(`profile_id` ASC, `notification_id` ASC) USING BTREE,
  INDEX `profiles_notified_profile_id_notification_id_index`(`profile_id` ASC, `notification_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of profiles_notified
-- ----------------------------

-- ----------------------------
-- Table structure for programme_images
-- ----------------------------
DROP TABLE IF EXISTS `programme_images`;
CREATE TABLE `programme_images`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `programme_id` int NULL DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of programme_images
-- ----------------------------

-- ----------------------------
-- Table structure for programmes
-- ----------------------------
DROP TABLE IF EXISTS `programmes`;
CREATE TABLE `programmes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_by` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_id` int NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT 4,
  `sharing_identifier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `accepted_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of programmes
-- ----------------------------
INSERT INTO `programmes` VALUES (1, 2, 'Test1', 1, 4, '785DA5F1-BF67-8926-CF09-0B0FB315CB21', NULL, '2023-03-18 14:52:42', '2023-03-25 00:11:34', NULL);
INSERT INTO `programmes` VALUES (43, 2, 'aaaa', 1, 4, 'ddbb7cd5-59fc-4285-8bbd-c261c534580c', NULL, '2023-04-05 12:35:47', '2023-04-05 12:35:47', NULL);

-- ----------------------------
-- Table structure for quotations
-- ----------------------------
DROP TABLE IF EXISTS `quotations`;
CREATE TABLE `quotations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `programme_id` int NOT NULL,
  `assessment_id` int NULL DEFAULT NULL,
  `instruction_id` int NULL DEFAULT NULL,
  `early_warning_id` int NULL DEFAULT NULL,
  `contract_completion_date_effect` int NOT NULL COMMENT '+/- days',
  `contract_key_date_1_effect` int NOT NULL COMMENT '+/- days',
  `contract_key_date_2_effect` int NOT NULL COMMENT '+/- days',
  `contract_key_date_3_effect` int NOT NULL COMMENT '+/- days',
  `price_effect` decimal(10, 2) NOT NULL COMMENT '+/- £',
  `status` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotations
-- ----------------------------

-- ----------------------------
-- Table structure for quotes
-- ----------------------------
DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `profile_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `narrative` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(20, 16) NOT NULL,
  `longitude` decimal(20, 16) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp,
  `finish` timestamp NOT NULL DEFAULT current_timestamp,
  `duration` int NOT NULL,
  `pattern` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL COMMENT 'Model QuoteStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotes
-- ----------------------------

-- ----------------------------
-- Table structure for rate_card_pins
-- ----------------------------
DROP TABLE IF EXISTS `rate_card_pins`;
CREATE TABLE `rate_card_pins`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Default',
  `rate_card_unit` int NOT NULL COMMENT 'RateCardUnit model',
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `line_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `line_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fill_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rate_card_pins
-- ----------------------------

-- ----------------------------
-- Table structure for rate_cards
-- ----------------------------
DROP TABLE IF EXISTS `rate_cards`;
CREATE TABLE `rate_cards`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `ref` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` int NOT NULL COMMENT 'Model RateCardUnit',
  `rate` double(8, 2) NOT NULL,
  `pin_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rate_cards
-- ----------------------------

-- ----------------------------
-- Table structure for receipts
-- ----------------------------
DROP TABLE IF EXISTS `receipts`;
CREATE TABLE `receipts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` bigint UNSIGNED NOT NULL,
  `provider_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `receipts_profile_id_index`(`profile_id` ASC) USING BTREE,
  INDEX `receipts_provider_id_index`(`provider_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of receipts
-- ----------------------------

-- ----------------------------
-- Table structure for resources
-- ----------------------------
DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `programme_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_id` int NOT NULL,
  `calendar_id` int NULL DEFAULT NULL,
  `active` int NOT NULL DEFAULT 1,
  `unit_cost` double(8, 2) NOT NULL DEFAULT 0.00 COMMENT 'Unit Cost',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of resources
-- ----------------------------
INSERT INTO `resources` VALUES (1, 'civil crew 1', '1', 0, 2, 0, 50.00, NULL);
INSERT INTO `resources` VALUES (2, 'Operative 1', '1', 1, 2, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (3, 'TM crew', '1', 0, 2, 0, 40.00, NULL);
INSERT INTO `resources` VALUES (4, 'Driver', '1', 3, 2, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (5, 'civil crew 1', '2', 0, 5, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (6, 'Operative 1', '2', 5, 5, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (7, 'TM crew', '2', 0, 5, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (8, 'Driver', '2', 7, 5, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (9, 'civil crew 1', '3', 0, 7, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (10, 'Operative 1', '3', 9, 7, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (11, 'TM crew', '3', 0, 7, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (12, 'Driver', '3', 11, 7, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (13, 'civil crew 1', '4', 0, 9, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (14, 'Operative 1', '4', 13, 9, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (15, 'TM crew', '4', 0, 9, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (16, 'Driver', '4', 15, 9, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (17, 'civil crew 1', '5', 0, 11, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (18, 'Operative 1', '5', 17, 11, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (19, 'TM crew', '5', 0, 11, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (20, 'Driver', '5', 19, 11, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (21, 'civil crew 1', '6', 0, 13, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (22, 'Operative 1', '6', 21, 13, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (23, 'TM crew', '6', 0, 13, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (24, 'Driver', '6', 23, 13, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (25, 'civil crew 1', '19', 0, 15, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (26, 'Operative 1', '19', 25, 15, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (27, 'TM crew', '19', 0, 15, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (28, 'Driver', '19', 27, 15, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (29, 'civil crew 1', '20', 0, 17, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (30, 'Operative 1', '20', 29, 17, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (31, 'TM crew', '20', 0, 17, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (32, 'Driver', '20', 31, 17, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (33, 'civil crew 1', '29', 0, 22, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (34, 'Operative 1', '29', 33, 22, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (35, 'TM crew', '29', 0, 22, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (36, 'Driver', '29', 35, 22, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (37, 'civil crew 1', '30', 0, 24, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (38, 'Operative 1', '30', 37, 24, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (39, 'TM crew', '30', 0, 24, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (40, 'Driver', '30', 39, 24, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (41, 'civil crew 1', '37', 0, 33, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (42, 'Operative 1', '37', 41, 33, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (43, 'TM crew', '37', 0, 33, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (44, 'Driver', '37', 43, 33, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (45, 'civil crew 1', '38', 0, 35, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (46, 'Operative 1', '38', 45, 35, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (47, 'TM crew', '38', 0, 35, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (48, 'Driver', '38', 47, 35, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (49, 'civil crew 1', '39', 0, 37, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (50, 'Operative 1', '39', 49, 37, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (51, 'TM crew', '39', 0, 37, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (52, 'Driver', '39', 51, 37, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (53, 'civil crew 1', '40', 0, 39, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (54, 'Operative 1', '40', 53, 39, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (55, 'TM crew', '40', 0, 39, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (56, 'Driver', '40', 55, 39, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (57, 'civil crew 1', '41', 0, 41, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (58, 'Operative 1', '41', 57, 41, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (59, 'TM crew', '41', 0, 41, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (60, 'Driver', '41', 59, 41, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (61, 'civil crew 1', '42', 0, 43, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (62, 'Operative 1', '42', 61, 43, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (63, 'TM crew', '42', 0, 43, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (64, 'Driver', '42', 63, 43, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (65, 'ibex', '1', 0, 2, 0, 0.00, NULL);
INSERT INTO `resources` VALUES (66, 'civil crew 1', '43', 0, 45, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (67, 'Operative 1', '43', 66, 45, 1, 50.00, NULL);
INSERT INTO `resources` VALUES (68, 'TM crew', '43', 0, 45, 1, 40.00, NULL);
INSERT INTO `resources` VALUES (69, 'Driver', '43', 68, 45, 1, 40.00, NULL);

-- ----------------------------
-- Table structure for riskmanagement
-- ----------------------------
DROP TABLE IF EXISTS `riskmanagement`;
CREATE TABLE `riskmanagement`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` int NULL DEFAULT NULL,
  `contract_id` int NULL DEFAULT NULL,
  `risk_type` int NOT NULL,
  `probability` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` int NOT NULL,
  `to` int NOT NULL,
  `score` int NOT NULL,
  `impact` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `severity` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of riskmanagement
-- ----------------------------

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  UNIQUE INDEX `settings_key_unique`(`key` ASC) USING BTREE,
  INDEX `settings_key_index`(`key` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------

-- ----------------------------
-- Table structure for subcontract_or_client_operations
-- ----------------------------
DROP TABLE IF EXISTS `subcontract_or_client_operations`;
CREATE TABLE `subcontract_or_client_operations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `operation_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subbie_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcontract_or_client_operations
-- ----------------------------

-- ----------------------------
-- Table structure for subcontract_or_hired_vehicles_and_plants
-- ----------------------------
DROP TABLE IF EXISTS `subcontract_or_hired_vehicles_and_plants`;
CREATE TABLE `subcontract_or_hired_vehicles_and_plants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_or_plant_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_no` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcontract_or_hired_vehicles_and_plants
-- ----------------------------

-- ----------------------------
-- Table structure for subcontract_personnel
-- ----------------------------
DROP TABLE IF EXISTS `subcontract_personnel`;
CREATE TABLE `subcontract_personnel`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subbie_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcontract_personnel
-- ----------------------------

-- ----------------------------
-- Table structure for subcontractor_undertakings_to_others
-- ----------------------------
DROP TABLE IF EXISTS `subcontractor_undertakings_to_others`;
CREATE TABLE `subcontractor_undertakings_to_others`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint UNSIGNED NOT NULL,
  `work` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `provided_to` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subcontractor_undertakings_to_others_contract_id_foreign`(`contract_id` ASC) USING BTREE,
  CONSTRAINT `subcontractor_undertakings_to_others_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcontractor_undertakings_to_others
-- ----------------------------

-- ----------------------------
-- Table structure for subscription_items
-- ----------------------------
DROP TABLE IF EXISTS `subscription_items`;
CREATE TABLE `subscription_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `subscription_items_subscription_id_stripe_plan_unique`(`subscription_id` ASC, `stripe_plan` ASC) USING BTREE,
  INDEX `subscription_items_stripe_id_index`(`stripe_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subscription_items
-- ----------------------------
INSERT INTO `subscription_items` VALUES (1, 1, 'MuV2818prz', 'test123', 5, '2023-03-18 14:48:05', '2023-03-18 14:48:05', NULL);

-- ----------------------------
-- Table structure for subscriptions
-- ----------------------------
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subscriptions_profile_id_stripe_status_index`(`profile_id` ASC, `stripe_status` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subscriptions
-- ----------------------------
INSERT INTO `subscriptions` VALUES (1, 2, 'default', 'MuV2818prz', 'active', 'test123', 1, NULL, NULL, '2023-03-18 14:48:05', '2023-03-18 14:48:05', NULL);

-- ----------------------------
-- Table structure for taskks
-- ----------------------------
DROP TABLE IF EXISTS `taskks`;
CREATE TABLE `taskks`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  `progress` double(8, 2) NOT NULL,
  `start_date` datetime NOT NULL,
  `parent` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sortorder` int NOT NULL DEFAULT 0,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `owner_id` int NULL DEFAULT NULL,
  `priority` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deadline` datetime NOT NULL DEFAULT '2023-03-18 14:47:59',
  `planned_start` datetime NOT NULL DEFAULT '2023-03-18 14:47:59',
  `planned_end` datetime NOT NULL DEFAULT '2023-03-18 14:47:59',
  `open` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of taskks
-- ----------------------------

-- ----------------------------
-- Table structure for taskks_back
-- ----------------------------
DROP TABLE IF EXISTS `taskks_back`;
CREATE TABLE `taskks_back`  (
  `id` int UNSIGNED NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  `progress` double(8, 2) NOT NULL,
  `start_date` datetime NOT NULL,
  `parent` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sortorder` int NOT NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of taskks_back
-- ----------------------------

-- ----------------------------
-- Table structure for taskks_back_multi
-- ----------------------------
DROP TABLE IF EXISTS `taskks_back_multi`;
CREATE TABLE `taskks_back_multi`  (
  `id` int UNSIGNED NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  `progress` double(8, 2) NOT NULL,
  `start_date` datetime NOT NULL,
  `parent` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sortorder` int NOT NULL DEFAULT 0,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `owner_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `priority` int NULL DEFAULT NULL,
  `level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `project_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `open` int NULL DEFAULT NULL,
  `end_date` datetime NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of taskks_back_multi
-- ----------------------------

-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` int NOT NULL,
  `profile_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `measured_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `deducted_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net` double(8, 2) NOT NULL,
  `period_from` timestamp NOT NULL DEFAULT current_timestamp,
  `period_to` timestamp NOT NULL DEFAULT current_timestamp,
  `status` int NOT NULL COMMENT 'Model TaskStatus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tasks
-- ----------------------------

-- ----------------------------
-- Table structure for tax_rates
-- ----------------------------
DROP TABLE IF EXISTS `tax_rates`;
CREATE TABLE `tax_rates`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tax_rates_stripe_id_index`(`stripe_id` ASC) USING BTREE,
  INDEX `tax_rates_percentage_index`(`percentage` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tax_rates
-- ----------------------------

-- ----------------------------
-- Table structure for uploads
-- ----------------------------
DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_id` int NOT NULL,
  `instruction_id` int NOT NULL,
  `early_warning_id` int NOT NULL,
  `application_id` int NOT NULL,
  `assessment_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of uploads
-- ----------------------------

-- ----------------------------
-- Table structure for user_programme_links
-- ----------------------------
DROP TABLE IF EXISTS `user_programme_links`;
CREATE TABLE `user_programme_links`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `programme_id` int NULL DEFAULT NULL,
  `permission_type` int NOT NULL DEFAULT 1,
  `date_range_start` date NULL DEFAULT NULL,
  `date_range_end` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_programme_links
-- ----------------------------

-- ----------------------------
-- Table structure for workflows
-- ----------------------------
DROP TABLE IF EXISTS `workflows`;
CREATE TABLE `workflows`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int NOT NULL COMMENT 'WorkflowCategory Model',
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of workflows
-- ----------------------------

-- ----------------------------
-- Table structure for works
-- ----------------------------
DROP TABLE IF EXISTS `works`;
CREATE TABLE `works`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of works
-- ----------------------------
INSERT INTO `works` VALUES (1, 'Civils', '2023-03-18 14:47:58', '2023-03-18 14:47:58', NULL);
INSERT INTO `works` VALUES (2, 'Cabling', '2023-03-18 14:47:58', '2023-03-18 14:47:58', NULL);
INSERT INTO `works` VALUES (3, 'Civils & Cabling', '2023-03-18 14:47:58', '2023-03-18 14:47:58', NULL);

SET FOREIGN_KEY_CHECKS = 1;
