/*
Navicat PGSQL Data Transfer

Source Server         : db_pmo
Source Server Version : 90325
Source Host           : 192.168.26.67:5432
Source Database       : bipsmanagement
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90325
File Encoding         : 65001

Date: 2020-02-10 11:42:36
*/


-- ----------------------------
-- Sequence structure for customer_id
-- ----------------------------
DROP SEQUENCE "public"."customer_id";
CREATE SEQUENCE "public"."customer_id"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for dealer_id
-- ----------------------------
DROP SEQUENCE "public"."dealer_id";
CREATE SEQUENCE "public"."dealer_id"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE "public"."migrations_id_seq";
CREATE SEQUENCE "public"."migrations_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 9
 CACHE 1;
SELECT setval('"public"."migrations_id_seq"', 9, true);

-- ----------------------------
-- Sequence structure for role_app_id_seq
-- ----------------------------
DROP SEQUENCE "public"."role_app_id_seq";
CREATE SEQUENCE "public"."role_app_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for sales_id
-- ----------------------------
DROP SEQUENCE "public"."sales_id";
CREATE SEQUENCE "public"."sales_id"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for user_group_id_seq
-- ----------------------------
DROP SEQUENCE "public"."user_group_id_seq";
CREATE SEQUENCE "public"."user_group_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 6
 CACHE 1;
SELECT setval('"public"."user_group_id_seq"', 6, true);

-- ----------------------------
-- Sequence structure for user_id_seq
-- ----------------------------
DROP SEQUENCE "public"."user_id_seq";
CREATE SEQUENCE "public"."user_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;
SELECT setval('"public"."user_id_seq"', 1, true);

-- ----------------------------
-- Sequence structure for user_status_id_seq
-- ----------------------------
DROP SEQUENCE "public"."user_status_id_seq";
CREATE SEQUENCE "public"."user_status_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for user_type_id_seq
-- ----------------------------
DROP SEQUENCE "public"."user_type_id_seq";
CREATE SEQUENCE "public"."user_type_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;
SELECT setval('"public"."users_id_seq"', 1, true);

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS "public"."customers";
CREATE TABLE "public"."customers" (
"id" int4 DEFAULT nextval('customer_id'::regclass) NOT NULL,
"custcode" varchar(50) COLLATE "default" NOT NULL,
"custname" varchar(50) COLLATE "default" NOT NULL,
"custinit" varchar(50) COLLATE "default" NOT NULL,
"sid" varchar(50) COLLATE "default" NOT NULL,
"custstatus" varchar(50) COLLATE "default" NOT NULL,
"idcardtype" varchar(50) COLLATE "default",
"idcardno" varchar(50) COLLATE "default",
"idexpiredate" varchar(50) COLLATE "default",
"namaoccupation" varchar(50) COLLATE "default",
"opendate" varchar(50) COLLATE "default",
"closedate" varchar(50) COLLATE "default",
"iswhtax" varchar(50) COLLATE "default",
"srebasetax" varchar(50) COLLATE "default",
"feetype" varchar(50) COLLATE "default",
"custfee" varchar(50) COLLATE "default",
"bncode" varchar(50) COLLATE "default",
"cbaccname" varchar(50) COLLATE "default",
"cbaccno" varchar(50) COLLATE "default",
"cbbranch" varchar(50) COLLATE "default",
"rdnbncode" varchar(50) COLLATE "default",
"rdncbaccname" varchar(50) COLLATE "default",
"rdncbaccno" varchar(50) COLLATE "default",
"rdncbbranch" varchar(50) COLLATE "default",
"birthplace" varchar(50) COLLATE "default",
"birthdate" varchar(50) COLLATE "default",
"email" varchar(50) COLLATE "default",
"phone" varchar(50) COLLATE "default",
"phonecell" varchar(50) COLLATE "default",
"address" varchar(50) COLLATE "default",
"city" varchar(50) COLLATE "default",
"zip" varchar(50) COLLATE "default",
"slscode" varchar(50) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO "public"."customers" VALUES ('1', 'DX001', 'Asep', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80004');
INSERT INTO "public"."customers" VALUES ('2', 'DX002', 'Bedu', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80001');
INSERT INTO "public"."customers" VALUES ('3', 'DX003', 'Chokky', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80007');
INSERT INTO "public"."customers" VALUES ('4', 'DX004', 'Darmian', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80004');
INSERT INTO "public"."customers" VALUES ('5', 'DX005', 'Emir', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80010');
INSERT INTO "public"."customers" VALUES ('6', 'DX006', 'Fuzaki', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80001');
INSERT INTO "public"."customers" VALUES ('7', 'DX007', 'Gian', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80004');
INSERT INTO "public"."customers" VALUES ('8', 'DX008', 'Harmono', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80001');
INSERT INTO "public"."customers" VALUES ('9', 'DX009', 'Ishizaky', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80002');
INSERT INTO "public"."customers" VALUES ('10', 'DX010', 'Junaedi', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '80007');

-- ----------------------------
-- Table structure for dealer
-- ----------------------------
DROP TABLE IF EXISTS "public"."dealer";
CREATE TABLE "public"."dealer" (
"id" int4 DEFAULT nextval('dealer_id'::regclass) NOT NULL,
"dlrcode" varchar(50) COLLATE "default" NOT NULL,
"dlrname" varchar(50) COLLATE "default",
"address" varchar(50) COLLATE "default",
"phone" varchar(50) COLLATE "default",
"mobilephone" varchar(50) COLLATE "default",
"email" varchar(50) COLLATE "default",
"groupid" int8
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of dealer
-- ----------------------------
INSERT INTO "public"."dealer" VALUES ('1', 'SW001', 'Khamir', 'Bandung', '', '087821717181', 'k@gmail.com', '5');
INSERT INTO "public"."dealer" VALUES ('2', 'SW002', 'Leonardo', 'Jakarta', '', '087821717182', 'l@gmail.com', '2');
INSERT INTO "public"."dealer" VALUES ('3', 'SW003', 'Maman', 'Bali', '', '087821717183', 'm@gmail.com', '323');
INSERT INTO "public"."dealer" VALUES ('4', 'SW004', 'Nuri', 'Palembang', '', '087821717184', 'n@gmail.com', '33263');
INSERT INTO "public"."dealer" VALUES ('5', 'SW005', 'Odang', 'Makasar', '', '087821717185', 'o@gmail.com', '1763');
INSERT INTO "public"."dealer" VALUES ('6', 'SW006', 'Pirmansyah', 'Banten', '', '087821717186', 'p@gmail.com', '114595');
INSERT INTO "public"."dealer" VALUES ('7', 'SW007', 'Qori', 'Sukabumi', '', '087821717187', 'q@gmail.com', '18183');
INSERT INTO "public"."dealer" VALUES ('8', 'SW008', 'Risma', 'Bogor', '', '087821717188', 'r@gmail.com', '7770');
INSERT INTO "public"."dealer" VALUES ('9', 'SW009', 'Stefani', 'Medan', '', '087821717189', 's@gmail.com', '437');
INSERT INTO "public"."dealer" VALUES ('10', 'SW010', 'Temon', 'Garut', '', '087821717180', 't@gmail.com', '310');

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS "public"."group";
CREATE TABLE "public"."group" (
"group_id" int8 NOT NULL,
"name" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp,
"updated_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO "public"."group" VALUES ('2', 'group jaki', '2020-02-05 17:09:55', '2020-02-05 17:09:59');
INSERT INTO "public"."group" VALUES ('3', 'group faisal', '2020-02-05 23:02:12', '2020-02-05 23:02:12');
INSERT INTO "public"."group" VALUES ('5', 'group bahana', '2020-02-05 23:02:38', '2020-02-05 23:02:38');
INSERT INTO "public"."group" VALUES ('7', 'group rcs', '2020-02-05 23:02:56', '2020-02-05 23:02:56');
INSERT INTO "public"."group" VALUES ('11', 'group bandung', '2020-02-05 23:20:43', '2020-02-05 23:20:43');
INSERT INTO "public"."group" VALUES ('13', 'Group apa', '2020-02-06 09:38:24', '2020-02-06 13:50:16');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
"id" int4 DEFAULT nextval('migrations_id_seq'::regclass) NOT NULL,
"migration" varchar(255) COLLATE "default" NOT NULL,
"batch" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO "public"."migrations" VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO "public"."migrations" VALUES ('3', '2020_01_30_082330_create_group_table', '1');
INSERT INTO "public"."migrations" VALUES ('4', '2020_01_30_082752_create_user_group_table', '1');
INSERT INTO "public"."migrations" VALUES ('5', '2020_01_30_082938_create_user_type_table', '1');
INSERT INTO "public"."migrations" VALUES ('6', '2020_01_30_082955_create_user_status_table', '1');
INSERT INTO "public"."migrations" VALUES ('7', '2020_01_30_092849_create_user_table', '1');
INSERT INTO "public"."migrations" VALUES ('8', '2020_01_30_093304_create_role_app_table', '1');
INSERT INTO "public"."migrations" VALUES ('9', '2020_02_05_084449_create_baru', '2');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_resets";
CREATE TABLE "public"."password_resets" (
"email" varchar(255) COLLATE "default" NOT NULL,
"token" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for role_app
-- ----------------------------
DROP TABLE IF EXISTS "public"."role_app";
CREATE TABLE "public"."role_app" (
"id" int8 DEFAULT nextval('role_app_id_seq'::regclass) NOT NULL,
"name" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp,
"updated_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of role_app
-- ----------------------------
INSERT INTO "public"."role_app" VALUES ('1', 'Super Admin', '2020-01-30 16:52:30', '2020-01-30 16:52:36');
INSERT INTO "public"."role_app" VALUES ('2', 'User Admin', '2020-01-30 16:52:30', '2020-01-30 16:52:30');
INSERT INTO "public"."role_app" VALUES ('3', 'IT Admin', '2020-01-30 16:52:30', '2020-01-30 16:52:30');
INSERT INTO "public"."role_app" VALUES ('4', 'Risk Management', '2020-01-30 16:52:30', '2020-01-30 16:52:30');
INSERT INTO "public"."role_app" VALUES ('5', 'Finance', '2020-01-30 16:52:30', '2020-01-30 16:52:30');
INSERT INTO "public"."role_app" VALUES ('6', 'Custodian', '2020-01-30 16:52:30', '2020-01-30 16:52:30');
INSERT INTO "public"."role_app" VALUES ('7', 'Call Center', '2020-01-30 16:52:30', '2020-01-30 16:52:30');

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS "public"."sales";
CREATE TABLE "public"."sales" (
"id" int4 DEFAULT nextval('sales_id'::regclass) NOT NULL,
"slscode" varchar(50) COLLATE "default" NOT NULL,
"slsname" varchar(50) COLLATE "default",
"address" varchar(50) COLLATE "default",
"phone" varchar(50) COLLATE "default",
"mobilephone" varchar(50) COLLATE "default",
"email" varchar(50) COLLATE "default",
"groupid" int8
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of sales
-- ----------------------------
INSERT INTO "public"."sales" VALUES ('1', '80001', 'Amir', 'Bandung', null, '087821717181', 'a@gmail.com', '2');
INSERT INTO "public"."sales" VALUES ('2', '80002', 'Budi', 'Jakarta', '', '087821717182', 'b@gmail.com', '2');
INSERT INTO "public"."sales" VALUES ('3', '80003', 'Candra', 'Bali', '', '087821717183', 'c@gmail.com', '3');
INSERT INTO "public"."sales" VALUES ('4', '80004', 'Deni', 'Palembang', '', '087821717184', 'd@gmail.com', '19');
INSERT INTO "public"."sales" VALUES ('5', '80005', 'Endang', 'Makasar', '', '087821717185', 'e@gmail.com', '3');
INSERT INTO "public"."sales" VALUES ('6', '80006', 'Fahmi', 'Banten', '', '087821717186', 'f@gmail.com', '37');
INSERT INTO "public"."sales" VALUES ('7', '80007', 'Gery', 'Sukabumi', '', '087821717187', 'g@gmail.com', '13');
INSERT INTO "public"."sales" VALUES ('8', '80008', 'Hanung', 'Bogor', '', '087821717188', 'h@gmail.com', '17');
INSERT INTO "public"."sales" VALUES ('9', '80009', 'Ismail', 'Medan', '', '087821717189', 'i@gmail.com', '17');
INSERT INTO "public"."sales" VALUES ('10', '80010', 'Jonny', 'Garut', '', '087821717180', 'j@gmail.com', '2');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS "public"."user";
CREATE TABLE "public"."user" (
"id" int8 DEFAULT nextval('user_id_seq'::regclass) NOT NULL,
"username" varchar(255) COLLATE "default" NOT NULL,
"password" varchar(255) COLLATE "default" NOT NULL,
"user_type" int8 NOT NULL,
"client_id" varchar(255) COLLATE "default" NOT NULL,
"user_status" int8 NOT NULL,
"expire_date" timestamp NOT NULL,
"sales_id" varchar(255) COLLATE "default" NOT NULL,
"remember_token" varchar(100) COLLATE "default",
"created_at" timestamp,
"updated_at" timestamp,
"aktif" int2 DEFAULT 1 NOT NULL,
"group" int8
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO "public"."user" VALUES ('1', 'zaky98', '$2y$10$rGM11rDdUBWMRBQc6sk8ruem5qcHowIPYhFSRKVOSG2nxVg1z1Uzq', '1', '80005', '1', '2020-02-10 00:00:00', '80005', null, '2020-02-10 03:40:58', '2020-02-10 10:42:22', '1', '3');

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_group";
CREATE TABLE "public"."user_group" (
"id" int8 DEFAULT nextval('user_group_id_seq'::regclass) NOT NULL,
"user_id" int8 NOT NULL,
"group_id" int8 NOT NULL,
"created_at" timestamp,
"updated_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO "public"."user_group" VALUES ('6', '1', '3', '2020-02-10 03:42:22', '2020-02-10 03:42:22');

-- ----------------------------
-- Table structure for user_status
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_status";
CREATE TABLE "public"."user_status" (
"id" int8 DEFAULT nextval('user_status_id_seq'::regclass) NOT NULL,
"name" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp,
"updated_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user_status
-- ----------------------------
INSERT INTO "public"."user_status" VALUES ('1', 'Active', '2020-02-04 13:36:34', '2020-02-04 13:36:34');
INSERT INTO "public"."user_status" VALUES ('2', 'Suspend', '2020-02-04 13:36:34', '2020-02-04 13:36:34');
INSERT INTO "public"."user_status" VALUES ('3', 'Closed', '2020-02-04 13:36:34', '2020-02-04 13:36:34');

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_type";
CREATE TABLE "public"."user_type" (
"id" int8 DEFAULT nextval('user_type_id_seq'::regclass) NOT NULL,
"name" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp,
"updated_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO "public"."user_type" VALUES ('1', 'Trader', '2020-02-04 13:36:34', '2020-02-04 13:36:34');
INSERT INTO "public"."user_type" VALUES ('2', 'Dealer', '2020-02-04 13:36:34', '2020-02-04 13:36:34');
INSERT INTO "public"."user_type" VALUES ('3', 'Customer', '2020-02-04 13:36:34', '2020-02-04 13:36:34');
INSERT INTO "public"."user_type" VALUES ('4', 'Super Trader', '2020-02-04 13:36:34', '2020-02-04 13:36:34');
INSERT INTO "public"."user_type" VALUES ('5', 'Trial', '2020-02-04 13:36:34', '2020-02-04 13:36:34');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
"id" int8 DEFAULT nextval('users_id_seq'::regclass) NOT NULL,
"username" varchar(255) COLLATE "default" NOT NULL,
"email_verified_at" timestamp,
"password" varchar(255) COLLATE "default" NOT NULL,
"role_app" int8 NOT NULL,
"remember_token" varchar(100) COLLATE "default",
"created_at" timestamp,
"updated_at" timestamp
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES ('1', 'admin', null, '$2b$10$6wJ43Ja2jnHN2oljmyIG2.RXwSi7Dakp2xPv8P4hUf.WZmGmeOUfe', '1', 'bbbkKw0o5SmjNtxUb2UBT1ja8p7np6CeU7yrSmKIhIsiqTH249gqdaBiYMSY', '2020-02-04 13:28:15', '2020-02-04 13:28:25');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------
ALTER SEQUENCE "public"."migrations_id_seq" OWNED BY "migrations"."id";
ALTER SEQUENCE "public"."role_app_id_seq" OWNED BY "role_app"."id";
ALTER SEQUENCE "public"."user_group_id_seq" OWNED BY "user_group"."id";
ALTER SEQUENCE "public"."user_id_seq" OWNED BY "user"."id";
ALTER SEQUENCE "public"."user_status_id_seq" OWNED BY "user_status"."id";
ALTER SEQUENCE "public"."user_type_id_seq" OWNED BY "user_type"."id";
ALTER SEQUENCE "public"."users_id_seq" OWNED BY "users"."id";

-- ----------------------------
-- Uniques structure for table customers
-- ----------------------------
ALTER TABLE "public"."customers" ADD UNIQUE ("custcode");

-- ----------------------------
-- Primary Key structure for table customers
-- ----------------------------
ALTER TABLE "public"."customers" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table dealer
-- ----------------------------
ALTER TABLE "public"."dealer" ADD UNIQUE ("dlrcode");

-- ----------------------------
-- Primary Key structure for table dealer
-- ----------------------------
ALTER TABLE "public"."dealer" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "public"."migrations" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table password_resets
-- ----------------------------
CREATE INDEX "password_resets_email_index" ON "public"."password_resets" USING btree (email);

-- ----------------------------
-- Primary Key structure for table role_app
-- ----------------------------
ALTER TABLE "public"."role_app" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table sales
-- ----------------------------
ALTER TABLE "public"."sales" ADD UNIQUE ("slscode");

-- ----------------------------
-- Primary Key structure for table sales
-- ----------------------------
ALTER TABLE "public"."sales" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE "public"."user" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table user_group
-- ----------------------------
ALTER TABLE "public"."user_group" ADD UNIQUE ("group_id");

-- ----------------------------
-- Primary Key structure for table user_group
-- ----------------------------
ALTER TABLE "public"."user_group" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table user_status
-- ----------------------------
ALTER TABLE "public"."user_status" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table user_type
-- ----------------------------
ALTER TABLE "public"."user_type" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD UNIQUE ("username");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table "public"."users"
-- ----------------------------
ALTER TABLE "public"."users" ADD FOREIGN KEY ("role_app") REFERENCES "public"."role_app" ("id") ON DELETE RESTRICT ON UPDATE CASCADE;
