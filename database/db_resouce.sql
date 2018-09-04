/*
SQLyog Job Agent v12.09 (64 bit) Copyright(c) Webyog Inc. All Rights Reserved.


MySQL - 5.6.38 : Database - db_resource
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_resource` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_resource`;

/*Table structure for table `tb_accelerator` */

DROP TABLE IF EXISTS `tb_accelerator`;

CREATE TABLE `tb_accelerator` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '加速器主键',
  `name` varchar(255) DEFAULT '' COMMENT '商品名称',
  `description` varchar(255) DEFAULT '' COMMENT '商品描述',
  `price` varchar(180) DEFAULT '' COMMENT '商品价格',
  `publish_time` datetime DEFAULT NULL COMMENT '发布时间',
  `category_id` int(12) DEFAULT NULL COMMENT '分类',
  `picture` varchar(255) DEFAULT '' COMMENT '封面图',
  `address` text COMMENT '联系地址',
  `limit` int(8) DEFAULT NULL COMMENT '人数限制',
  `register` int(8) DEFAULT NULL COMMENT '注册人数',
  `begin_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `apply_time` datetime DEFAULT NULL COMMENT '申请时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `audit_method` tinyint(2) DEFAULT '0' COMMENT '审核状态',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `recommend` tinyint(2) DEFAULT '1' COMMENT '推荐',
  `rich_text` text COMMENT '富文本',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tb_accelerator` */

insert  into `tb_accelerator` values (1,'加速器','测试加速器','1234','2018-08-30 10:19:31',1,'/images/qhujf13asdnfjhasdfasdfdfsdf.png',NULL,1,1,'2018-08-30 10:19:50','2018-09-05 10:19:52','2018-08-30 10:19:54','2018-09-04 15:48:07',NULL,'2018-09-03 17:47:49',0,1,1,NULL);

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '管理员主键',
  `mobile` varchar(40) DEFAULT '' COMMENT '管理员手机',
  `password` varchar(64) DEFAULT '' COMMENT '管理员密码',
  `nick_name` varchar(40) DEFAULT NULL COMMENT '管理员昵称',
  `email` varchar(80) DEFAULT NULL COMMENT '管理员邮箱',
  `real_name` varchar(40) DEFAULT NULL COMMENT '管理员真实姓名',
  `status` tinyint(2) DEFAULT '1' COMMENT '管理员状态',
  `create_time` datetime DEFAULT NULL COMMENT '管理员创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '管理员更新时间',
  `create_ip` varchar(120) DEFAULT NULL COMMENT '管理员创建的IP',
  `login_time` datetime DEFAULT NULL COMMENT '管理员登陆时间',
  `login_ip` varchar(120) DEFAULT NULL COMMENT '管理员登陆IP',
  `authentication` tinyint(2) DEFAULT '0' COMMENT '授权认证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tb_admin` */

insert  into `tb_admin` values (1,'15900785383','7eadafc40e72c85d36be5edcb7a7368d',NULL,NULL,'chencongye',1,'2018-08-20 16:07:11','2018-08-30 19:12:52','127.0.0.1','2018-08-30 10:08:04','127.0.0.1',1),(3,'15900785382','7eadafc40e72c85d36be5edcb7a7368d',NULL,NULL,'cctv',1,'2018-08-30 19:26:08',NULL,'127.0.0.1',NULL,NULL,0);

/*Table structure for table `tb_admin_role` */

DROP TABLE IF EXISTS `tb_admin_role`;

CREATE TABLE `tb_admin_role` (
  `user_id` int(12) NOT NULL COMMENT '管理员主键',
  `role_id` int(12) NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_admin_role` */

insert  into `tb_admin_role` values (1,1),(2,2),(3,2),(3,45),(3,46);

/*Table structure for table `tb_admission` */

DROP TABLE IF EXISTS `tb_admission`;

CREATE TABLE `tb_admission` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '入驻主键',
  `mobile` varchar(64) DEFAULT '' COMMENT '入驻手机号',
  `company` varchar(255) DEFAULT '' COMMENT '入驻公司名',
  `industry` varchar(255) DEFAULT '' COMMENT '入驻行业',
  `duty` varchar(255) DEFAULT '' COMMENT '入驻职务',
  `name` varchar(255) DEFAULT '' COMMENT '入驻姓名',
  `email` varchar(255) DEFAULT '' COMMENT '入驻邮箱',
  `status` tinyint(2) DEFAULT '0' COMMENT '入驻状态',
  `plan` varchar(255) DEFAULT '' COMMENT '商业企划书',
  `plan_name` varchar(255) DEFAULT '' COMMENT '商业企划书名称',
  `create_time` datetime DEFAULT NULL COMMENT '入驻创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '入驻更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `tb_admission` */

insert  into `tb_admission` values (1,'','sdgfw4tqwerewr','qwerer','werwerw','werwrfwerwer','cvhje@sdf.com',1,'/images/20180828/26f2a08cef789c24e4bd9fb98653d6aa.png','26f2a08cef789c24e4bd9fb98653d6aa.png','2018-08-28 15:50:48','2018-08-28 17:08:18'),(2,'','许巍','流行歌曲','werwerasdfasdw','曾今的你','cvhje@sdf.com',1,'/images/20180828/e8ffa6237349933cf0a622a9eaf2ce9f.png','e8ffa6237349933cf0a622a9eaf2ce9f.png','2018-08-28 17:08:45','2018-08-28 17:12:16'),(3,'','Beyond','香港','werwerasdfasdw','过去与今天','cvhje@sdf.com',1,'/images/20180828/c80dfce4b6a69917185f922c99507b7b.jpg','c80dfce4b6a69917185f922c99507b7b.jpg','2018-08-28 17:11:41','2018-08-28 17:12:16'),(4,'','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com',0,'/images/20180829/97a05d40a1518e0bca8f928dfa1fe219.png','97a05d40a1518e0bca8f928dfa1fe219.png','2018-08-29 13:35:54','2018-08-29 13:35:54'),(5,'15900785383','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com',0,'/images/20180829/ade167b2a363e2f1d4ef58682d4bc53f.rar','ade167b2a363e2f1d4ef58682d4bc53f.rar','2018-08-29 15:57:25','2018-08-29 15:57:25'),(7,'15900785383','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com',0,'/images/20180829/404e2328d1be78a962d2af871c6da7be.zip','404e2328d1be78a962d2af871c6da7be.zip','2018-08-29 15:59:39','2018-08-29 15:59:39'),(8,'15900785383','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com',0,'/images/20180829/4a7ed7e561252876a6e23497eb7f01fe.zip','4a7ed7e561252876a6e23497eb7f01fe.zip','2018-08-29 16:04:18','2018-08-29 16:04:18'),(9,'','亏过呀','我无法','为而我','车暴雨哦','撒旦法w@qq.com',0,NULL,'','2018-08-31 16:51:20','2018-08-31 16:51:20'),(10,'15900785383','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com',0,'/images/20180904/ff6c2bd2daa0c3ae116cb213243194d2.rar','ff6c2bd2daa0c3ae116cb213243194d2.rar','2018-09-04 10:54:59','2018-09-04 10:54:59');

/*Table structure for table `tb_booster` */

DROP TABLE IF EXISTS `tb_booster`;

CREATE TABLE `tb_booster` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '加速器申请表',
  `user_id` int(12) DEFAULT NULL COMMENT '用户主键',
  `accelerator_id` int(12) DEFAULT NULL COMMENT '加速器资源Id',
  `mobile` varchar(64) DEFAULT '' COMMENT '手机号',
  `company` varchar(255) DEFAULT '' COMMENT '公司名称',
  `industry` varchar(255) DEFAULT '' COMMENT '行业名称',
  `duty` varchar(255) DEFAULT '' COMMENT '职务',
  `name` varchar(255) DEFAULT '' COMMENT '姓名',
  `email` varchar(255) DEFAULT '' COMMENT '电子邮箱',
  `reason` varbinary(255) DEFAULT '' COMMENT '申请理由',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `apply_time` datetime DEFAULT NULL COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tb_booster` */

insert  into `tb_booster` values (1,NULL,NULL,'15900785383','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com','阿斯顿发送到',0,'2018-08-29 14:41:18','2018-08-29 14:41:18','2018-08-29 14:41:18'),(2,NULL,NULL,'15900785383','werwa','werwer','aerawerwaerw','awerwr','chncong@qq.com','阿斯顿发送到',0,'2018-08-29 15:12:30','2018-08-29 15:12:30','2018-08-29 15:12:30');

/*Table structure for table `tb_category` */

DROP TABLE IF EXISTS `tb_category`;

CREATE TABLE `tb_category` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(255) DEFAULT '' COMMENT '分类名称',
  `sort` int(8) DEFAULT '0' COMMENT '分类排序',
  `status` tinyint(2) DEFAULT '1' COMMENT '分类状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tb_category` */

insert  into `tb_category` values (1,'CCYZNL01',0,1,'2018-08-16 17:52:47','2018-08-16 17:52:49'),(2,'CCYZNL01',0,1,'2018-08-16 17:52:54','2018-08-16 17:52:56');

/*Table structure for table `tb_column` */

DROP TABLE IF EXISTS `tb_column`;

CREATE TABLE `tb_column` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '栏目主键',
  `name` varchar(120) DEFAULT '' COMMENT '栏目名称',
  `sort` int(12) DEFAULT NULL COMMENT '栏目排序',
  `status` tinyint(2) DEFAULT '1' COMMENT '栏目状态',
  `create_time` datetime DEFAULT NULL COMMENT '栏目创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '栏目更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tb_column` */

insert  into `tb_column` values (1,'ZNLCCY01',1,1,'2018-08-16 17:36:00','2018-08-16 17:36:00'),(2,'ZNLCCY02',2,1,'2018-08-16 17:36:06','2018-08-16 17:36:06'),(3,'ZNLCCY03',3,1,'2018-08-16 17:36:12','2018-08-16 17:36:12'),(4,'ZNLCCY04',3,1,'2018-08-16 17:36:16','2018-08-16 17:36:16'),(5,'ZNLCCY05',1,1,'2018-08-31 10:46:20','2018-08-31 10:47:22');

/*Table structure for table `tb_dynamic` */

DROP TABLE IF EXISTS `tb_dynamic`;

CREATE TABLE `tb_dynamic` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '动态主键',
  `column_id` int(12) DEFAULT NULL COMMENT '栏目主键',
  `title` varchar(255) DEFAULT '' COMMENT '动态标题',
  `description` varchar(255) DEFAULT '' COMMENT '动态简介',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `publish_time` datetime DEFAULT NULL COMMENT '发布时间',
  `picture` varchar(255) DEFAULT NULL COMMENT '动态图片',
  `recommend` tinyint(2) DEFAULT '0' COMMENT '是否推荐',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `publisher` varchar(30) DEFAULT '' COMMENT '发布人',
  `rich_text` text COMMENT '富文本',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tb_dynamic` */

insert  into `tb_dynamic` values (1,1,'暗示法大神的','撒地方的撒旦法萨法','2018-08-17 10:44:19','2018-08-17 10:44:19','2018-08-17 10:44:18',NULL,1,1,'chen','&lt;img src=&quot;/static/images/logo.png&quot; /&gt;&lt;p&gt;这是啥玩意&lt;/p&gt;&lt;img src=&quot;/static/images/logo.png&quot; /&gt;'),(2,1,'ewr','dfwertfewrfdsf','2018-08-22 17:34:58','2018-08-22 17:35:00','2018-08-22 17:35:02',NULL,1,1,'dsfsdf','sfasdffasdfds'),(4,1,'多钱我二无','阿萨德饭 奥术大师','2018-08-31 14:21:00','2018-08-31 14:21:00','2018-08-31 14:21:00',NULL,1,1,'15900785383','阿斯顿发送到撒旦法');

/*Table structure for table `tb_group` */

DROP TABLE IF EXISTS `tb_group`;

CREATE TABLE `tb_group` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `name` varchar(255) DEFAULT '' COMMENT '分组名称',
  `sort` int(8) DEFAULT NULL COMMENT '分组排序',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tb_group` */

insert  into `tb_group` values (1,'CEO',1,'2018-08-15 16:34:19','2018-08-15 16:34:19'),(2,'CTO',2,'2018-08-15 16:34:44','2018-08-15 16:35:17'),(3,'CIO',2,'2018-08-15 16:34:56','2018-08-15 16:35:36'),(4,'CFO',2,'2018-08-15 17:04:23','2018-08-15 17:04:23'),(5,'CMO',4,'2018-08-16 10:02:18','2018-08-16 10:02:18');

/*Table structure for table `tb_information` */

DROP TABLE IF EXISTS `tb_information`;

CREATE TABLE `tb_information` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '消息主键',
  `title` varchar(255) DEFAULT '' COMMENT '消息主题',
  `create_time` datetime DEFAULT NULL COMMENT '消息创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '消息更新时间',
  `publisher` varchar(80) DEFAULT '' COMMENT '消息发布人',
  `status` tinyint(2) DEFAULT '1' COMMENT '消息状态',
  `publish_time` datetime DEFAULT NULL COMMENT '发布时间',
  `rich_text` text COMMENT '消息富文本',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tb_information` */

insert  into `tb_information` values (1,'测试新闻',NULL,'2018-08-21 09:04:57',NULL,1,'2018-08-21 09:04:57','Hello World');

/*Table structure for table `tb_permission` */

DROP TABLE IF EXISTS `tb_permission`;

CREATE TABLE `tb_permission` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '权限主键',
  `name` varchar(80) DEFAULT '' COMMENT '权限名称',
  `path` varchar(255) DEFAULT '' COMMENT '权限路径',
  `pid` int(12) DEFAULT NULL COMMENT '父节点',
  `description` varchar(255) DEFAULT '' COMMENT '权限描述',
  `sort` int(12) DEFAULT NULL COMMENT '权限描述',
  `level` int(12) DEFAULT NULL COMMENT '权限等级',
  `status` tinyint(2) DEFAULT NULL COMMENT '权限状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `icon` varchar(32) DEFAULT '' COMMENT '权限图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

/*Data for the table `tb_permission` */

insert  into `tb_permission` values (1,'加速器资源列表','/admin/accelerator/entry',1,'对于加速器进行展示',1,1,1,'2018-08-20 15:15:38','2018-08-23 10:48:23','carousel icon'),(2,'加速器资源添加更新','/admin/accelerator/save',1,'对于加速器进行添加更新',1,1,1,'2018-08-20 15:16:23','2018-08-23 10:48:25','carousel icon'),(3,'加速器资源详情','/admin/accelerator/detail',1,'对于轮播详细进行展示',1,1,1,'2018-08-23 09:10:31','2018-08-23 09:10:35','carousel icon'),(4,'加速器资源删除','/admin/accelerator/delete',1,'对于轮播进行删除',1,1,1,'2018-08-23 09:10:33','2018-08-23 09:10:38','carousel icon'),(5,'角色列表','/admin/role/entry',1,'对于角色进行展示',1,1,1,'2018-08-23 09:47:37','2018-08-23 09:47:39','role icon'),(6,'角色添加','/admin/role/save',1,'对于角色进行添加更新',1,1,1,'2018-08-23 09:48:51','2018-08-23 09:48:53','role icon'),(7,'角色详情','/admin/role/detail',1,'对于角色详细进行展示',1,1,1,'2018-08-23 09:50:27','2018-08-23 09:50:30','role icon'),(8,'角色删除','/admin/role/delete',1,'对于角色进行删除',1,1,1,'2018-08-23 09:51:29','2018-08-23 09:51:32','role icon'),(9,'分配角色权限','/admin/role/assign_role_permission',1,'对于角色进行分配权限',1,1,1,'2018-08-23 10:05:28','2018-08-23 10:05:30','role icon'),(10,'获取角色权限','/admin/role/get_role_permission',1,'获取角色对应的权限',1,1,1,'2018-08-23 10:06:49','2018-08-23 10:06:50','role icon'),(11,'管理员列表','/admin/admin/entry',1,'对于管理员进行展示',1,1,1,'2018-08-23 10:47:26','2018-08-23 10:47:28','admin icon'),(12,'管理员详情','/admin/admin/detail',1,'对于管理员详细进行展示',1,1,1,'2018-08-23 10:48:18','2018-08-23 10:48:21','admin icon'),(13,'管理员删除','/admin/admin/delete',1,'',NULL,NULL,NULL,NULL,NULL,''),(14,'管理员修改自身密码','/admin/admin/change_password',1,'',NULL,NULL,NULL,NULL,NULL,''),(15,'管理员个人信息','/admin/admin/info',1,'',NULL,NULL,NULL,NULL,NULL,''),(16,'管理员退出','/admin/admin/logout',1,'',NULL,NULL,NULL,NULL,NULL,''),(17,'角色下拉列表','/admin/admin/spinner',1,'',NULL,NULL,NULL,NULL,NULL,''),(18,'分配用户角色权限','/admin/admin/assign_admin_role',2,'',NULL,NULL,NULL,NULL,NULL,''),(19,'消息列表','/admin/information/entry',1,'',NULL,NULL,NULL,NULL,NULL,''),(20,'消息添加更新','/admin/information/save',2,'',NULL,NULL,NULL,NULL,NULL,''),(21,'消息详情','/admin/information/detail',1,'',NULL,NULL,NULL,NULL,NULL,''),(22,'消息删除','/admin/information/delete',3,'',NULL,NULL,NULL,NULL,NULL,''),(23,'活动列表','/admin/activity/entry',1,'',NULL,NULL,NULL,NULL,NULL,''),(24,'活动保存更新','/admin/activity/save',1,'',NULL,NULL,NULL,NULL,NULL,''),(25,'活动详情','/admin/activity/detail',2,'',NULL,NULL,NULL,NULL,NULL,''),(26,'活动删除','/admin/activity/delete',3,'',NULL,NULL,NULL,NULL,NULL,''),(27,'权限列表','/admin/permission/entry',2,'',NULL,NULL,NULL,NULL,NULL,''),(28,'权限保存更新','/admin/permission/save',2,'',NULL,NULL,NULL,NULL,NULL,''),(29,'权限详情','/admin/permission/detail',2,'',NULL,NULL,NULL,NULL,NULL,''),(30,'活动删除','/admin/permission/delete',2,'',NULL,NULL,NULL,NULL,NULL,''),(31,'权限节点','/admin/permission/node',2,'',NULL,NULL,NULL,NULL,NULL,''),(32,'服务资源列表','/admin/service/entry',2,'对于服务资源的展示',1,2,1,'2018-08-23 14:11:35','2018-08-23 14:13:00','service icon'),(33,'服务资源添加更新','/admin/service/save',2,'对于服务资源的展示',1,2,1,'2018-08-23 14:12:09',NULL,'service icon'),(34,'服务资源详情','/admin/service/detail',2,'对于服务资源的详情展示',1,2,1,'2018-08-23 14:13:29',NULL,'service icon'),(35,'服务资源删除','/admin/service/delete',2,'对于服务资源删除',1,2,1,'2018-08-23 14:13:48',NULL,'service icon'),(36,'获取下拉分类列表','/admin/service/spinner',1,'asfsdf',1,1,1,'2018-08-23 14:18:28',NULL,'service icon'),(37,'服务栏目列表','/admin/category/entry',1,'awerw',1,1,1,'2018-08-23 14:20:04',NULL,'service icon'),(38,'服务栏目添加更新','/admin/category/save',1,'awerw',1,1,1,'2018-08-23 14:20:30',NULL,'service icon'),(39,'服务栏目详情','/admin/category/detail',1,'1',1,1,1,'2018-08-23 14:34:32',NULL,'1'),(40,'服务栏目删除','/admin/category/delete',1,'1',1,1,1,'2018-08-23 14:34:43',NULL,'1'),(41,'联盟成员审核','/admin/user/auditor',1,'wdfwerw',1,1,1,'2018-08-23 17:21:44','2018-08-23 17:21:48','1'),(43,'获取分组下拉列表','/admin/user/group_spinner',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(44,'成员等待审核列表','/admin/user/wait_auditor_entry',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(45,'活动报名列表','/admin/activity/apply_entry',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(46,'项目添加更新','/admin/star/save',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(47,'项目详情','/admin/star/detail',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(48,'项目删除','/admin/star/delete',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(49,'项目列表','/admin/star/entry',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(50,'加速动态列表','/admin/dynamic/entry',1,'获取加速动态列表',1,1,1,'2018-08-30 13:52:50',NULL,'user icon'),(51,'动态添加更新','/admin/dynamic/save',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(52,'动态详情','/admin/dynamic/detail',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(53,'动态删除','/admin/dynamic/delete',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(54,'动态栏目列表','/admin/column/entry',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(55,'动态栏目添加更新','/admin/column/save',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(56,'动态栏目详情','/admin/column/detail',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(57,'动态栏目删除','/admin/column/delete',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(58,'用户列表','/admin/user/entry',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(59,'用户添加更新','/admin/user/save',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(60,'用户详情','/admin/user/detail',NULL,'',NULL,NULL,NULL,NULL,NULL,''),(61,'用户删除','/admin/user/delete',NULL,'',NULL,NULL,NULL,NULL,NULL,'');

/*Table structure for table `tb_role` */

DROP TABLE IF EXISTS `tb_role`;

CREATE TABLE `tb_role` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '角色主键',
  `name` varchar(60) DEFAULT '' COMMENT '角色名称',
  `parent_id` int(12) DEFAULT '0' COMMENT '父节点',
  `description` varchar(255) DEFAULT '' COMMENT '角色描述',
  `status` tinyint(2) DEFAULT '1' COMMENT '角色状态',
  `sort` int(12) DEFAULT NULL COMMENT '角色排序',
  `left_key` int(12) DEFAULT '0' COMMENT '左键值',
  `right_key` int(12) DEFAULT '0' COMMENT '右键值',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `level` int(12) DEFAULT '0' COMMENT '等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tb_role` */

insert  into `tb_role` values (1,'超级管理员',1,'不知道',1,1,1,8,'2018-08-20 13:48:29','2018-08-20 12:01:01',1),(2,'管理员',1,'啥玩意',1,2,6,7,'2018-08-20 12:01:18','2018-08-20 13:48:27',1);

/*Table structure for table `tb_role_permission` */

DROP TABLE IF EXISTS `tb_role_permission`;

CREATE TABLE `tb_role_permission` (
  `role_id` int(12) NOT NULL COMMENT '角色主键',
  `permission_id` int(12) NOT NULL COMMENT '权限主键',
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_role_permission` */

insert  into `tb_role_permission` values (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(1,44),(1,45),(1,46),(1,47),(1,48),(1,49),(1,50),(1,51),(1,52),(1,53),(1,54),(1,55),(1,56),(1,57),(1,58),(1,59),(1,60),(1,61);

/*Table structure for table `tb_sms` */

DROP TABLE IF EXISTS `tb_sms`;

CREATE TABLE `tb_sms` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '短信验证主键',
  `mobile` varchar(18) DEFAULT '' COMMENT '手机号码',
  `code` int(8) DEFAULT NULL COMMENT '短信验证码',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `expiration_time` datetime DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tb_sms` */

insert  into `tb_sms` values (1,'15787845545',519705,'2018-08-16 09:53:23','2018-08-16 09:55:08','2018-08-16 10:05:08'),(2,'15900785383',204699,'2018-09-04 11:35:43','2018-09-04 13:01:02','2018-09-04 13:11:02'),(3,'15001056491',811337,'2018-08-16 10:08:03','2018-08-16 10:08:03','2018-08-16 10:18:03');

/*Table structure for table `tb_star` */

DROP TABLE IF EXISTS `tb_star`;

CREATE TABLE `tb_star` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '明星项目主键',
  `name` varchar(255) DEFAULT '' COMMENT '明星项目名称',
  `status` tinyint(2) DEFAULT '1' COMMENT '明星项目状态',
  `sort` int(8) DEFAULT '0' COMMENT '明星项目排序',
  `picture` varchar(255) DEFAULT '' COMMENT '明星项目图片',
  `introduce` text COMMENT '明星简介',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tb_star` */

insert  into `tb_star` values (1,'awerwe',1,1,'/images/20180827/4f56633b46192d6c9c3ba2197020728e.png','wq4er3wq4er3q4r134qwdfasdfasdfasdfasdfasdfasdfawq4er3q4r134qwdfasdfasdfasdfasdfasdfasdfasfsfswqerwrqweirquwerqweiruqsfsfswqerwrqweirquwerqweiruqq4r134qwdfasdfasdfasdfasdfasdfasdfasfsfswqerwrqweirquwerqweiruqwueqweioqwuerqwejwherhwherqwerwqerwqe','2018-08-27 16:15:56','2018-08-27 16:15:56'),(2,'zdsvwerwer',1,2,'/images/20180827/7e2eabdd1ab97c23f46d241d369c7c81.png','wq4er成为 晚上发送到发送 第三方第三的3wasdefafq4er3q4r134qwdfasdfasdfasdfasdfasdfasdfawq4er3q4r134qwdfasdfasdfasdfasdfasdfasdfasfsfswqerwrqweirquwerqweiruqsfsfswqerwrqweirquwerqweiruqq4r134qwdfasdfasdfasdfasdfasdfasdfasfsfswqerwrqweirquwerqweiruqwueqweioqwuerqwejwherhwherqwerwqerwqe','2018-08-27 16:16:48','2018-08-27 16:16:48');

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(30) DEFAULT '' COMMENT '姓名',
  `password` varchar(40) DEFAULT '' COMMENT '密码',
  `real_name` varchar(60) DEFAULT '' COMMENT '真实姓名',
  `mobile` varchar(40) DEFAULT NULL COMMENT '手机账号',
  `email` varchar(30) DEFAULT '' COMMENT '电子邮件',
  `company` varchar(60) DEFAULT '' COMMENT '公司',
  `duty` varchar(30) DEFAULT '' COMMENT '职业',
  `industry` varchar(23) DEFAULT '' COMMENT '行业',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `login_time` datetime DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(38) DEFAULT '' COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `tb_user` */

insert  into `tb_user` values (1,'znlccy','e35cf7b66449df565f93c607d5a81d09','','15900795242','752255448@qq.com','上海游达网络科技有限公司','Java开发','IT行业',0,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00','127.0.0.1'),(2,'','a5dafec32f5fa8a644f94a1ba32dfbb4','','15900785382','','','','',0,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',''),(3,'张三丰','7eadafc40e72c85d36be5edcb7a7368d','','15900785387','12345678@qq.com','上海游达网络科技邮箱公司','Java架构师','IT软件行业',0,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00','127.0.0.1'),(6,'','220466675e31b9d20c051d5e57974150','','18915542276','','','','',0,'0000-00-00 00:00:00',NULL,NULL,''),(7,'','554b87ed693d97518fb73869f36e4dba','','18915542277','','','','',0,'0000-00-00 00:00:00',NULL,NULL,''),(8,'guo jun','52030ea4ad1ef3ba886605eec0c6a5ad','','18915542275','1@1.com','1','2','3',0,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00','222.71.239.112'),(9,'于东','25d55ad283aa400af464c76d713c07ad','','18237177660','ycplay@qq.com','上海游达','5','60303',0,'0000-00-00 00:00:00',NULL,NULL,''),(13,'过骏','65235524','','18915542280','4922@q.com','1212','1','1',0,'2018-08-08 15:12:34',NULL,NULL,''),(15,'过骏2','652355241','','18915542281','4922@q.com','1212','1','1',0,'2018-08-08 15:14:26',NULL,NULL,''),(17,'1123123','3dbe00a167653a1aaee01d93e77e730e','','18915542312','123@q.com','1','1','1',0,'2018-08-08 16:09:42',NULL,NULL,''),(18,'11231234444','3dbe00a167653a1aaee01d93e77e730e','','18915542311','12443@q.com','14','2','2',0,'2018-08-08 16:12:09',NULL,NULL,''),(19,'qeradf','7eadafc40e72c85d36be5edcb7a7368d','','15907811210','adsfadsfa@qq.com','qeqwerqw','qwerqwda','qwedradas',0,'2018-08-14 15:48:28',NULL,NULL,''),(21,'cahsudfhdfghjukukju','7eadafc40e72c85d36be5edcb7a7368d','','15900785380','chensoigwerfn@163.com','asdf234rdsfvdsgfdsds','qe4rqdfasdf','wdqr424523dsfs',0,'2018-08-21 13:38:43',NULL,NULL,''),(22,'sdhfuas','73f1dd6d0fd485637c967340712f73f7','','15725655981','chen@qsc.com','ewrwrwerw','waerfwaer','awerfwrew',1,'2018-09-03 11:53:21',NULL,NULL,''),(24,'sfsfs','25d55ad283aa400af464c76d713c07ad','','15900785383','chen@qq.com','sdfasdfsf','fdsadfas','asdfsa',0,NULL,'2018-09-04 16:32:45','2018-09-04 16:45:32','127.0.0.1');

/*Table structure for table `tb_user_accelerator` */

DROP TABLE IF EXISTS `tb_user_accelerator`;

CREATE TABLE `tb_user_accelerator` (
  `user_id` int(12) NOT NULL COMMENT '用户主键',
  `accelerator_id` int(12) NOT NULL COMMENT '加速器主键',
  `apply_time` datetime DEFAULT NULL COMMENT '申请时间',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态',
  `reason` varchar(255) DEFAULT NULL COMMENT '申请理由',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`accelerator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_user_accelerator` */

insert  into `tb_user_accelerator` values (1,1,NULL,NULL,0,NULL,NULL,NULL),(24,1,'2018-09-04 16:28:12','2018-09-04 16:28:12',0,'asfdeasdfhausdhfuhasjdf','2018-09-04 16:28:12','2018-09-04 16:28:12');

/*Table structure for table `tb_user_group` */

DROP TABLE IF EXISTS `tb_user_group`;

CREATE TABLE `tb_user_group` (
  `user_id` int(12) NOT NULL COMMENT '用户主键',
  `group_id` int(12) NOT NULL COMMENT '分组主键',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_user_group` */

insert  into `tb_user_group` values (1,1,NULL,NULL),(2,1,NULL,NULL),(3,1,NULL,NULL);

/*Table structure for table `tb_user_info` */

DROP TABLE IF EXISTS `tb_user_info`;

CREATE TABLE `tb_user_info` (
  `user_id` int(12) NOT NULL COMMENT '用户主键',
  `info_id` int(12) NOT NULL COMMENT '消息主键',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`user_id`,`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_user_info` */

insert  into `tb_user_info` values (24,1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
