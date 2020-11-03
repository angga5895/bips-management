/*
Navicat PGSQL Data Transfer

Source Server         : postgresql
Source Server Version : 90416
Source Host           : localhost:5432
Source Database       : bipsmanagement2
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90416
File Encoding         : 65001

Date: 2020-11-03 20:07:15
*/


-- ----------------------------
-- Table structure for stat_monthly_login_idx
-- ----------------------------
DROP TABLE IF EXISTS "public"."stat_monthly_login_idx";
CREATE TABLE "public"."stat_monthly_login_idx" (
"year_month" varchar(10) COLLATE "default" NOT NULL,
"total_cust_login" int8,
"cust_general" int8,
"cust_academic" int8,
"cust_trial" int8,
"sales" int8
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of stat_monthly_login_idx
-- ----------------------------
INSERT INTO "public"."stat_monthly_login_idx" VALUES ('2020-06', '500', '400', '20', '0', '2');
INSERT INTO "public"."stat_monthly_login_idx" VALUES ('2020-07', '777', '600', '30', '0', '5');
INSERT INTO "public"."stat_monthly_login_idx" VALUES ('2020-08', '988', '767', '35', '0', '7');
INSERT INTO "public"."stat_monthly_login_idx" VALUES ('2020-09', '1002', '989', '40', '0', '9');
INSERT INTO "public"."stat_monthly_login_idx" VALUES ('2020-10', '2288', '2164', '106', '0', '18');
INSERT INTO "public"."stat_monthly_login_idx" VALUES ('2020-11', '1233', '1174', '48', '0', '11');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table stat_monthly_login_idx
-- ----------------------------
ALTER TABLE "public"."stat_monthly_login_idx" ADD PRIMARY KEY ("year_month");
