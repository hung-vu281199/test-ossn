# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.5.8-MariaDB)
# Database: ossn
# Generation Time: 2021-11-12 08:15:36 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ossn_annotations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_annotations`;

CREATE TABLE `ossn_annotations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner_guid` bigint(20) NOT NULL,
  `subject_guid` bigint(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `time_created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_guid` (`owner_guid`),
  KEY `subject_guid` (`subject_guid`),
  KEY `time_created` (`time_created`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_annotations` WRITE;
/*!40000 ALTER TABLE `ossn_annotations` DISABLE KEYS */;

INSERT INTO `ossn_annotations` (`id`, `owner_guid`, `subject_guid`, `type`, `time_created`)
VALUES
	(2,2,44,'comments:post',1629980827),
	(3,2,44,'comments:post',1631698050),
	(4,2,46,'comments:post',1631806016),
	(5,3,45,'comments:post',1631806098),
	(6,3,45,'comments:post',1631806256),
	(7,3,45,'comments:post',1631806279),
	(8,3,45,'comments:post',1631806302),
	(9,3,45,'comments:post',1631806325),
	(10,3,45,'comments:post',1631806360),
	(11,3,45,'comments:post',1631806504),
	(12,3,45,'comments:post',1631806560),
	(13,3,45,'comments:post',1631806667),
	(14,3,45,'comments:post',1631806687),
	(15,3,45,'comments:post',1631806760),
	(16,2,48,'comments:post',1631807085),
	(17,2,43,'comments:post',1631807851),
	(18,3,43,'comments:post',1631807871),
	(19,2,49,'comments:post',1633603275),
	(20,3,50,'comments:post',1634302501),
	(21,3,50,'comments:post',1634302510);

/*!40000 ALTER TABLE `ossn_annotations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_categories`;

CREATE TABLE `ossn_categories` (
  `guid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  `enable` int(11) DEFAULT 0,
  `time_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_categories` WRITE;
/*!40000 ALTER TABLE `ossn_categories` DISABLE KEYS */;

INSERT INTO `ossn_categories` (`guid`, `name`, `slug`, `enable`, `time_created`)
VALUES
	(1,'Thú Cưng','thu-cung',1,1629229232),
	(2,'Phim Hoạt Hình','phim-hoat-hinh',1,1629229232),
	(3,'Nghệ Thuật','nghe-thuat',1,1629229277),
	(4,'Ô Tô','o-to',1,1629229307),
	(5,'Làm Đẹp','lam-dep',1,1629261816),
	(6,'Giải Trí','giai-tri',1,1629264795),
	(7,'Phim','phim',1,1629264795);

/*!40000 ALTER TABLE `ossn_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_components
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_components`;

CREATE TABLE `ossn_components` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `com_id` varchar(50) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_components` WRITE;
/*!40000 ALTER TABLE `ossn_components` DISABLE KEYS */;

INSERT INTO `ossn_components` (`id`, `com_id`, `active`)
VALUES
	(1,'OssnProfile',1),
	(2,'OssnWall',1),
	(3,'OssnComments',1),
	(4,'OssnLikes',1),
	(5,'OssnPhotos',0),
	(6,'OssnNotifications',1),
	(7,'OssnSearch',0),
	(8,'OssnMessages',1),
	(9,'OssnAds',0),
	(10,'OssnGroups',0),
	(11,'OssnSitePages',1),
	(12,'OssnBlock',1),
	(13,'OssnChat',1),
	(14,'OssnPoke',1),
	(15,'OssnInvite',0),
	(16,'OssnEmbed',1),
	(17,'OssnSmilies',1),
	(18,'OssnSounds',1),
	(19,'OssnAutoPagination',1),
	(20,'OssnMessageTyping',1),
	(21,'OssnRealTimeComments',0),
	(22,'OssnPostBackground',1),
	(23,'SoundCloudEmbed',1),
	(24,'FacebookEmbed',1),
	(26,'Points',1),
	(28,'OssnWallet',1),
	(29,'OssnJackpot',1),
	(30,'TiktokEmbed',1),
	(31,'SharePost',1),
	(32,'SocialLogin',1),
	(33,'TwitterEmbed',1);

/*!40000 ALTER TABLE `ossn_components` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_deposit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_deposit`;

CREATE TABLE `ossn_deposit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `to_address` varchar(255) DEFAULT NULL,
  `tx_hash` varchar(255) DEFAULT NULL COMMENT 'Transaction ID',
  `time_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table ossn_entities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_entities`;

CREATE TABLE `ossn_entities` (
  `guid` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner_guid` bigint(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `subtype` varchar(50) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `permission` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`guid`),
  KEY `owner_guid` (`owner_guid`),
  KEY `time_created` (`time_created`),
  KEY `time_updated` (`time_updated`),
  KEY `active` (`active`),
  KEY `permission` (`permission`),
  KEY `type` (`type`),
  KEY `subtype` (`subtype`),
  KEY `eky_ts` (`type`,`subtype`),
  KEY `eky_tso` (`type`,`subtype`,`owner_guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_entities` WRITE;
/*!40000 ALTER TABLE `ossn_entities` DISABLE KEYS */;

INSERT INTO `ossn_entities` (`guid`, `owner_guid`, `type`, `subtype`, `time_created`, `time_updated`, `permission`, `active`)
VALUES
	(1,1,'user','birthdate',1626198833,0,2,1),
	(2,1,'user','gender',1626198833,0,2,1),
	(3,1,'user','password_algorithm',1626198833,0,2,1),
	(167,31,'object','item_guid',1629278962,0,2,1),
	(166,31,'object','item_type',1629278962,0,2,1),
	(165,30,'object','time_updated',1629278929,0,2,1),
	(162,30,'object','item_guid',1629278929,0,2,1),
	(163,30,'object','poster_guid',1629278929,0,2,1),
	(164,30,'object','access',1629278929,0,2,1),
	(156,29,'object','item_type',1629278662,0,2,1),
	(157,29,'object','item_guid',1629278662,0,2,1),
	(14,1,'user','cover_time',1626199701,0,2,1),
	(15,2,'user','birthdate',1626338232,0,2,1),
	(16,2,'user','gender',1626338232,1629222306,2,1),
	(17,2,'user','password_algorithm',1626338232,0,2,1),
	(18,3,'user','gender',1626345109,0,2,1),
	(19,3,'user','password_algorithm',1626345109,0,2,1),
	(20,2,'user','cover_time',1626352961,0,2,1),
	(21,4,'user','gender',1626366518,0,2,1),
	(22,4,'user','password_algorithm',1626366518,0,2,1),
	(170,31,'object','time_updated',1629278962,0,2,1),
	(169,31,'object','access',1629278962,0,2,1),
	(168,31,'object','poster_guid',1629278962,0,2,1),
	(158,29,'object','poster_guid',1629278662,0,2,1),
	(159,29,'object','access',1629278662,0,2,1),
	(160,29,'object','time_updated',1629278662,0,2,1),
	(161,30,'object','item_type',1629278929,0,2,1),
	(145,26,'object','time_updated',1629278366,0,2,1),
	(114,21,'object','item_type',1626944260,0,2,1),
	(115,21,'object','item_guid',1626944260,0,2,1),
	(116,21,'object','poster_guid',1626944260,0,2,1),
	(117,21,'object','access',1626944260,0,2,1),
	(118,21,'object','time_updated',1626944260,0,2,1),
	(119,22,'object','item_type',1626944298,0,2,1),
	(120,22,'object','item_guid',1626944298,0,2,1),
	(121,22,'object','poster_guid',1626944298,0,2,1),
	(122,22,'object','access',1626944298,0,2,1),
	(123,22,'object','time_updated',1626944298,0,2,1),
	(124,23,'object','item_type',1626944313,0,2,1),
	(125,23,'object','item_guid',1626944313,0,2,1),
	(126,23,'object','poster_guid',1626944313,0,2,1),
	(127,23,'object','access',1626944313,0,2,1),
	(128,23,'object','time_updated',1626944313,0,2,1),
	(129,17,'component','compatibility_mode',1629213898,1629213909,2,1),
	(130,17,'component','close_anywhere',1629213898,1629213909,2,1),
	(131,24,'object','item_type',1629266348,0,2,1),
	(132,24,'object','item_guid',1629266348,0,2,1),
	(133,24,'object','poster_guid',1629266348,0,2,1),
	(134,24,'object','access',1629266348,0,2,1),
	(135,24,'object','time_updated',1629266348,0,2,1),
	(136,25,'object','item_type',1629277306,0,2,1),
	(137,25,'object','item_guid',1629277306,0,2,1),
	(138,25,'object','poster_guid',1629277306,0,2,1),
	(139,25,'object','access',1629277306,0,2,1),
	(140,25,'object','time_updated',1629277306,0,2,1),
	(141,26,'object','item_type',1629278366,0,2,1),
	(142,26,'object','item_guid',1629278366,0,2,1),
	(143,26,'object','poster_guid',1629278366,0,2,1),
	(144,26,'object','access',1629278366,0,2,1),
	(89,16,'object','item_type',1626942621,0,2,1),
	(90,16,'object','item_guid',1626942621,0,2,1),
	(91,16,'object','poster_guid',1626942621,0,2,1),
	(92,16,'object','access',1626942621,0,2,1),
	(93,16,'object','time_updated',1626942621,0,2,1),
	(171,32,'object','item_type',1629279007,0,2,1),
	(172,32,'object','item_guid',1629279007,0,2,1),
	(173,32,'object','poster_guid',1629279007,0,2,1),
	(174,32,'object','access',1629279007,0,2,1),
	(175,32,'object','time_updated',1629279007,0,2,1),
	(176,33,'object','item_type',1629279046,0,2,1),
	(177,33,'object','item_guid',1629279046,0,2,1),
	(178,33,'object','poster_guid',1629279046,0,2,1),
	(179,33,'object','access',1629279046,0,2,1),
	(180,33,'object','time_updated',1629279046,0,2,1),
	(181,34,'object','item_type',1629279062,0,2,1),
	(182,34,'object','item_guid',1629279062,0,2,1),
	(183,34,'object','poster_guid',1629279062,0,2,1),
	(184,34,'object','access',1629279062,0,2,1),
	(185,34,'object','time_updated',1629279062,0,2,1),
	(186,35,'object','item_type',1629279073,0,2,1),
	(187,35,'object','item_guid',1629279073,0,2,1),
	(188,35,'object','poster_guid',1629279073,0,2,1),
	(189,35,'object','access',1629279073,0,2,1),
	(190,35,'object','time_updated',1629279073,0,2,1),
	(191,36,'object','item_type',1629279114,0,2,1),
	(192,36,'object','item_guid',1629279114,0,2,1),
	(193,36,'object','poster_guid',1629279114,0,2,1),
	(194,36,'object','access',1629279114,0,2,1),
	(195,36,'object','time_updated',1629279114,0,2,1),
	(196,37,'object','item_type',1629279151,0,2,1),
	(197,37,'object','item_guid',1629279151,0,2,1),
	(198,37,'object','poster_guid',1629279151,0,2,1),
	(199,37,'object','access',1629279151,0,2,1),
	(200,37,'object','time_updated',1629279151,0,2,1),
	(201,38,'object','item_type',1629279225,0,2,1),
	(202,38,'object','item_guid',1629279225,0,2,1),
	(203,38,'object','poster_guid',1629279225,0,2,1),
	(204,38,'object','access',1629279225,0,2,1),
	(205,38,'object','time_updated',1629279225,0,2,1),
	(206,39,'object','item_type',1629279246,0,2,1),
	(207,39,'object','item_guid',1629279246,0,2,1),
	(208,39,'object','poster_guid',1629279246,0,2,1),
	(209,39,'object','access',1629279246,0,2,1),
	(210,39,'object','time_updated',1629279246,0,2,1),
	(211,40,'object','item_type',1629279340,0,2,1),
	(212,40,'object','item_guid',1629279340,0,2,1),
	(213,40,'object','poster_guid',1629279340,0,2,1),
	(214,40,'object','access',1629279340,0,2,1),
	(215,40,'object','time_updated',1629279340,0,2,1),
	(216,41,'object','item_type',1629279354,0,2,1),
	(217,41,'object','item_guid',1629279354,0,2,1),
	(218,41,'object','poster_guid',1629279354,0,2,1),
	(219,41,'object','access',1629279354,0,2,1),
	(220,41,'object','time_updated',1629279354,0,2,1),
	(221,42,'object','item_type',1629279379,0,2,1),
	(222,42,'object','item_guid',1629279379,0,2,1),
	(223,42,'object','poster_guid',1629279379,0,2,1),
	(224,42,'object','access',1629279379,0,2,1),
	(225,42,'object','time_updated',1629279379,0,2,1),
	(226,43,'object','item_type',1629294140,0,2,1),
	(227,43,'object','item_guid',1629294140,0,2,1),
	(228,43,'object','poster_guid',1629294140,0,2,1),
	(229,43,'object','access',1629294140,0,2,1),
	(230,43,'object','time_updated',1629294140,0,2,1),
	(231,43,'object','file:wallphoto',1629294140,0,2,1),
	(232,44,'object','item_type',1629978888,0,2,1),
	(233,44,'object','item_guid',1629978888,0,2,1),
	(234,44,'object','poster_guid',1629978888,0,2,1),
	(235,44,'object','access',1629978888,0,2,1),
	(236,44,'object','time_updated',1629978888,0,2,1),
	(237,2,'user','userPoints',1629978888,1631790004,2,1),
	(238,2,'annotation','comments:post',1629980827,0,2,1),
	(239,45,'object','item_type',1630329745,0,2,1),
	(240,45,'object','item_guid',1630329745,0,2,1),
	(241,45,'object','poster_guid',1630329745,0,2,1),
	(242,45,'object','access',1630329745,0,2,1),
	(243,45,'object','time_updated',1630329745,0,2,1),
	(244,45,'object','postbackground_type',1630329745,0,2,1),
	(245,46,'object','item_type',1631599179,0,2,1),
	(246,46,'object','item_guid',1631599179,0,2,1),
	(247,46,'object','poster_guid',1631599179,0,2,1),
	(248,46,'object','access',1631599179,0,2,1),
	(249,46,'object','time_updated',1631599179,0,2,1),
	(250,46,'object','postbackground_type',1631599179,0,2,1),
	(251,47,'object','item_type',1631678932,0,2,1),
	(252,47,'object','item_guid',1631678932,0,2,1),
	(253,47,'object','poster_guid',1631678932,0,2,1),
	(254,47,'object','access',1631678932,0,2,1),
	(255,47,'object','time_updated',1631678932,0,2,1),
	(256,48,'object','item_type',1631678970,0,2,1),
	(257,48,'object','item_guid',1631678970,0,2,1),
	(258,48,'object','poster_guid',1631678970,0,2,1),
	(259,48,'object','access',1631678970,0,2,1),
	(260,48,'object','time_updated',1631678970,0,2,1),
	(261,3,'annotation','comments:post',1631698050,0,2,1),
	(262,2,'user','balanceABC',1631804723,0,2,1),
	(263,4,'annotation','comments:post',1631806016,0,2,1),
	(264,5,'annotation','comments:post',1631806098,0,2,1),
	(265,3,'user','cover_time',1631806103,0,2,1),
	(266,6,'annotation','comments:post',1631806256,0,2,1),
	(267,7,'annotation','comments:post',1631806279,0,2,1),
	(268,8,'annotation','comments:post',1631806302,0,2,1),
	(269,9,'annotation','comments:post',1631806325,0,2,1),
	(270,10,'annotation','comments:post',1631806360,0,2,1),
	(271,11,'annotation','comments:post',1631806504,0,2,1),
	(272,12,'annotation','comments:post',1631806560,0,2,1),
	(273,13,'annotation','comments:post',1631806667,0,2,1),
	(274,14,'annotation','comments:post',1631806687,0,2,1),
	(275,15,'annotation','comments:post',1631806760,0,2,1),
	(276,16,'annotation','comments:post',1631807085,0,2,1),
	(277,17,'annotation','comments:post',1631807851,0,2,1),
	(278,18,'annotation','comments:post',1631807871,0,2,1),
	(279,49,'object','item_type',1631971371,0,2,1),
	(280,49,'object','item_guid',1631971371,0,2,1),
	(281,49,'object','poster_guid',1631971371,0,2,1),
	(282,49,'object','access',1631971371,0,2,1),
	(283,49,'object','time_updated',1631971371,0,2,1),
	(284,1,'message','is_deleted_from',1633162605,0,2,1),
	(285,1,'message','is_deleted_to',1633162605,0,2,1),
	(286,2,'message','is_deleted_from',1633529290,0,2,1),
	(287,2,'message','is_deleted_to',1633529290,0,2,1),
	(288,3,'message','is_deleted_from',1633529304,0,2,1),
	(289,3,'message','is_deleted_to',1633529304,0,2,1),
	(290,4,'message','is_deleted_from',1633533316,0,2,1),
	(291,4,'message','is_deleted_to',1633533316,0,2,1),
	(292,5,'message','is_deleted_from',1633533329,0,2,1),
	(293,5,'message','is_deleted_to',1633533329,0,2,1),
	(294,19,'annotation','comments:post',1633603275,0,2,1),
	(295,50,'object','item_type',1633603280,0,2,1),
	(296,50,'object','item_guid',1633603280,0,2,1),
	(297,50,'object','poster_guid',1633603280,0,2,1),
	(298,50,'object','access',1633603280,0,2,1),
	(299,50,'object','time_updated',1633603280,0,2,1),
	(300,50,'object','postbackground_type',1633603280,0,2,1),
	(301,20,'annotation','comments:post',1634302501,0,2,1),
	(302,21,'annotation','comments:post',1634302510,0,2,1),
	(388,63,'object','time_updated',1636000015,0,2,1),
	(387,63,'object','access',1636000015,0,2,1),
	(386,63,'object','poster_guid',1636000015,0,2,1),
	(385,63,'object','item_guid',1636000015,0,2,1),
	(377,2,'user','icon_guid',1635999995,1636000381,2,1),
	(378,62,'object','item_type',1635999995,0,2,1),
	(379,62,'object','item_guid',1635999995,0,2,1),
	(380,62,'object','poster_guid',1635999995,0,2,1),
	(381,62,'object','access',1635999995,0,2,1),
	(382,62,'object','time_updated',1635999995,0,2,1),
	(383,2,'user','file:profile:photo',1636000014,0,2,1),
	(384,63,'object','item_type',1636000015,0,2,1),
	(337,32,'component','tw_consumer_key',1635496802,0,2,1),
	(336,32,'component','fb_consumer_secret',1635496802,1635497086,2,1),
	(376,2,'user','icon_time',1635999995,1636000381,2,1),
	(335,32,'component','fb_consumer_key',1635496802,1635497086,2,1),
	(339,32,'component','fb_enable',1635497086,0,2,1),
	(338,32,'component','tw_consumer_secret',1635496802,0,2,1),
	(375,2,'user','file:profile:photo',1635999995,0,2,1),
	(341,32,'component','tw_consumer_secret',1635497086,0,2,1),
	(340,32,'component','tw_consumer_key',1635497086,0,2,1),
	(342,32,'component','tw_enable',1635497086,0,2,1),
	(343,32,'component','google_client_id',1635497086,0,2,1),
	(344,32,'component','google_client_secret',1635497086,0,2,1),
	(345,32,'component','google_enable',1635497086,0,2,1),
	(346,32,'component','apple_client_id',1635497086,0,2,1),
	(347,32,'component','apple_team_id',1635497086,0,2,1),
	(348,32,'component','apple_keyfile_id',1635497086,0,2,1),
	(349,32,'component','apple_enable',1635497086,0,2,1),
	(394,64,'object','time_updated',1636000381,0,2,1),
	(393,64,'object','access',1636000381,0,2,1),
	(389,2,'user','file:profile:photo',1636000381,0,2,1),
	(390,64,'object','item_type',1636000381,0,2,1),
	(391,64,'object','item_guid',1636000381,0,2,1),
	(392,64,'object','poster_guid',1636000381,0,2,1),
	(402,2,'user','file:profile:kyc',1636002369,0,2,1),
	(401,2,'user','file:profile:kyc',1636002240,0,2,1),
	(400,2,'user','file:profile:kyc',1636002196,0,2,1),
	(399,2,'user','file:profile:kyc',1636001993,0,2,1),
	(403,2,'user','file:profile:kyc',1636002658,0,2,1),
	(404,2,'user','file:profile:kyc',1636002668,0,2,1),
	(405,2,'user','file:profile:kyc',1636002684,0,2,1),
	(406,2,'user','file:profile:kyc',1636002694,0,2,1),
	(407,2,'user','file:profile:kyc',1636002732,0,2,1),
	(408,2,'user','file:profile:kyc',1636002736,0,2,1),
	(409,2,'user','file:profile:kyc',1636003030,0,2,1),
	(410,2,'user','file:profile:kyc',1636003102,0,2,1),
	(411,2,'user','file:profile:kyc',1636003154,0,2,1),
	(412,2,'user','file:profile:kyc',1636003214,0,2,1),
	(413,65,'object','item_type',1636386749,0,2,1),
	(414,65,'object','item_guid',1636386749,0,2,1),
	(415,65,'object','poster_guid',1636386749,0,2,1),
	(416,65,'object','access',1636386749,0,2,1),
	(417,65,'object','time_updated',1636386749,0,2,1),
	(418,66,'object','item_type',1636387125,0,2,1),
	(419,66,'object','item_guid',1636387125,0,2,1),
	(420,66,'object','poster_guid',1636387125,0,2,1),
	(421,66,'object','access',1636387125,0,2,1),
	(422,66,'object','time_updated',1636387125,0,2,1),
	(423,67,'object','item_type',1636704222,0,2,1),
	(424,67,'object','item_guid',1636704222,0,2,1),
	(425,67,'object','poster_guid',1636704222,0,2,1),
	(426,67,'object','access',1636704222,0,2,1),
	(427,67,'object','time_updated',1636704222,0,2,1);

/*!40000 ALTER TABLE `ossn_entities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_entities_metadata
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_entities_metadata`;

CREATE TABLE `ossn_entities_metadata` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guid` bigint(20) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `guid` (`guid`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_entities_metadata` WRITE;
/*!40000 ALTER TABLE `ossn_entities_metadata` DISABLE KEYS */;

INSERT INTO `ossn_entities_metadata` (`id`, `guid`, `value`)
VALUES
	(1,1,'01/01/1990'),
	(2,2,'female'),
	(3,3,'bcrypt'),
	(156,156,''),
	(157,157,''),
	(158,158,'2'),
	(159,159,'3'),
	(160,160,'0'),
	(161,161,''),
	(14,14,'1626199701'),
	(15,15,'15/07/2021'),
	(16,16,'male'),
	(17,17,'bcrypt'),
	(18,18,'male'),
	(19,19,'bcrypt'),
	(20,20,'1626352961'),
	(21,21,'male'),
	(22,22,'bcrypt'),
	(145,145,'0'),
	(144,144,'2'),
	(143,143,'2'),
	(142,142,''),
	(114,114,''),
	(115,115,''),
	(116,116,'1'),
	(117,117,'2'),
	(118,118,'0'),
	(119,119,''),
	(120,120,''),
	(121,121,'1'),
	(122,122,'2'),
	(123,123,'0'),
	(124,124,''),
	(125,125,''),
	(126,126,'1'),
	(127,127,'2'),
	(128,128,'0'),
	(129,129,'on'),
	(130,130,'on'),
	(131,131,''),
	(132,132,''),
	(133,133,'2'),
	(134,134,'2'),
	(135,135,'0'),
	(136,136,''),
	(137,137,''),
	(138,138,'2'),
	(139,139,'3'),
	(140,140,'0'),
	(141,141,''),
	(89,89,''),
	(90,90,''),
	(91,91,'1'),
	(92,92,'2'),
	(93,93,'0'),
	(164,164,'3'),
	(163,163,'2'),
	(162,162,''),
	(165,165,'0'),
	(166,166,''),
	(167,167,''),
	(168,168,'2'),
	(169,169,'3'),
	(170,170,'0'),
	(171,171,''),
	(172,172,''),
	(173,173,'2'),
	(174,174,'3'),
	(175,175,'0'),
	(176,176,''),
	(177,177,''),
	(178,178,'2'),
	(179,179,'3'),
	(180,180,'0'),
	(181,181,''),
	(182,182,''),
	(183,183,'2'),
	(184,184,'3'),
	(185,185,'0'),
	(186,186,''),
	(187,187,''),
	(188,188,'2'),
	(189,189,'3'),
	(190,190,'0'),
	(191,191,''),
	(192,192,''),
	(193,193,'2'),
	(194,194,'3'),
	(195,195,'0'),
	(196,196,''),
	(197,197,''),
	(198,198,'2'),
	(199,199,'3'),
	(200,200,'0'),
	(201,201,''),
	(202,202,''),
	(203,203,'2'),
	(204,204,'3'),
	(205,205,'0'),
	(206,206,''),
	(207,207,''),
	(208,208,'2'),
	(209,209,'3'),
	(210,210,'0'),
	(211,211,''),
	(212,212,''),
	(213,213,'2'),
	(214,214,'3'),
	(215,215,'0'),
	(216,216,''),
	(217,217,''),
	(218,218,'2'),
	(219,219,'3'),
	(220,220,'0'),
	(221,221,''),
	(222,222,''),
	(223,223,'2'),
	(224,224,'3'),
	(225,225,'0'),
	(226,226,''),
	(227,227,''),
	(228,228,'2'),
	(229,229,'2'),
	(230,230,'0'),
	(231,231,'ossnwall/images/f442dc566888eb4bdd3afb84f041bb0f.jpg'),
	(232,232,''),
	(233,233,''),
	(234,234,'2'),
	(235,235,'3'),
	(236,236,'0'),
	(237,237,'35'),
	(238,238,'Hello'),
	(239,239,''),
	(240,240,''),
	(241,241,'2'),
	(242,242,'2'),
	(243,243,'0'),
	(244,244,'pbg3'),
	(245,245,''),
	(246,246,''),
	(247,247,'2'),
	(248,248,'3'),
	(249,249,'0'),
	(250,250,'pbg8'),
	(251,251,''),
	(252,252,''),
	(253,253,'2'),
	(254,254,'3'),
	(255,255,'0'),
	(256,256,''),
	(257,257,''),
	(258,258,'2'),
	(259,259,'3'),
	(260,260,'0'),
	(261,261,'Hello'),
	(262,262,'10'),
	(263,263,'hello'),
	(264,264,'Hay quá bạn ơi'),
	(265,265,'1631806103'),
	(266,266,'Hi bạn'),
	(267,267,'Hi bạn'),
	(268,268,'Hi bạn'),
	(269,269,'Hi bạn'),
	(270,270,'Hi bạn'),
	(271,271,'Hi bạn'),
	(272,272,'Hi bạn'),
	(273,273,'Hi bạn'),
	(274,274,'Hi bạn'),
	(275,275,'Hi bạn'),
	(276,276,'hay'),
	(277,277,'Thích quá'),
	(278,278,'Cho mình đi câu với bạn'),
	(279,279,''),
	(280,280,''),
	(281,281,'2'),
	(282,282,'3'),
	(283,283,'0'),
	(284,284,''),
	(285,285,''),
	(286,286,''),
	(287,287,''),
	(288,288,''),
	(289,289,''),
	(290,290,''),
	(291,291,''),
	(292,292,''),
	(293,293,''),
	(294,294,'Hello'),
	(295,295,''),
	(296,296,''),
	(297,297,'2'),
	(298,298,'2'),
	(299,299,'0'),
	(300,300,'pbg7'),
	(301,301,'Hello'),
	(302,302,'123123'),
	(378,378,'profile:photo'),
	(377,377,'389'),
	(382,382,'0'),
	(381,381,'2'),
	(380,380,'2'),
	(379,379,'375'),
	(336,336,'c196f17a380fb5496d30e797b99689dc'),
	(335,335,'843201319650511'),
	(375,375,'profile/photo/11f2759d5e1cf7bc622260e0bf905a31.jpeg'),
	(339,339,'yes'),
	(338,338,''),
	(337,337,''),
	(376,376,'1636000381'),
	(344,344,''),
	(343,343,''),
	(342,342,'yes'),
	(341,341,''),
	(340,340,''),
	(345,345,'yes'),
	(346,346,''),
	(347,347,''),
	(348,348,''),
	(349,349,'no'),
	(384,384,'profile:photo'),
	(383,383,'profile/photo/edb6f6eaea4c4318a4d01ef61fe93bd8.jpeg'),
	(387,387,'2'),
	(386,386,'2'),
	(385,385,'383'),
	(388,388,'0'),
	(389,389,'profile/photo/94bfa2d25b25845dda65224cb08b786d.jpg'),
	(390,390,'profile:photo'),
	(391,391,'389'),
	(392,392,'2'),
	(393,393,'2'),
	(394,394,'0'),
	(395,395,'profile/kyc/8e5a98c22a21da703d817319a7746df6.jpg'),
	(396,396,'profile/kyc/becbb2104f66a2c622ed39ffe1b0123e.jpg'),
	(397,397,'profile/kyc/c71dcf270dbf22600274a15553c3a9b5.jpg'),
	(398,398,'profile/kyc/a4d69c5bbd71c0f6fcedee0bbe957756.jpg'),
	(399,399,'profile/kyc/79f6709d75f47d226ae1c48579553dbd.jpeg'),
	(400,400,'profile/kyc/de676b35884a7570635354e0004f81f5.jpg'),
	(401,401,'profile/kyc/ef1317925898e05c23ed3423646e60e1.jpg'),
	(402,402,'profile/kyc/bfccadb4535e05ca53b52f9e6c8e1f2d.jpg'),
	(403,403,'profile/kyc/6da9d9a431b751ccdf97c5a4cc8c3027.jpg'),
	(404,404,'profile/kyc/c8c946e9991e787119b51a6d0b55f908.jpg'),
	(405,405,'profile/kyc/4386c79f11b61620f8ffbb7c6bdc6911.jpg'),
	(406,406,'profile/kyc/e08b384ad6314a405588db3c0a8ecd4c.jpg'),
	(407,407,'profile/kyc/350570f76c16e61203cdbb8aa57e480f.jpg'),
	(408,408,'profile/kyc/c99eec47274ffe36926b21aecb104ca5.jpg'),
	(409,409,'profile/kyc/d592be216d2346377c17aab19f94d151.jpg'),
	(410,410,'profile/kyc/cefc59b450806bbf4ca1ed0cbb6c5bae.jpg'),
	(411,411,'profile/kyc/7741ade9d14ddb5680f44eab61035fea.jpg'),
	(412,412,'profile/kyc/4d8ea6012ee2faf78eaef78e76eb0562.jpg'),
	(413,413,''),
	(414,414,''),
	(415,415,'2'),
	(416,416,'3'),
	(417,417,'0'),
	(418,418,''),
	(419,419,''),
	(420,420,'2'),
	(421,421,'2'),
	(422,422,'0'),
	(423,423,''),
	(424,424,''),
	(425,425,'2'),
	(426,426,'2'),
	(427,427,'0');

/*!40000 ALTER TABLE `ossn_entities_metadata` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_jackpot
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_jackpot`;

CREATE TABLE `ossn_jackpot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `am_pm` varchar(2) DEFAULT NULL,
  `full_slot` int(6) DEFAULT NULL,
  `slot_1` int(1) DEFAULT NULL,
  `slot_2` int(1) DEFAULT NULL,
  `slot_3` int(1) DEFAULT NULL,
  `slot_4` int(1) DEFAULT NULL,
  `slot_5` int(1) DEFAULT NULL,
  `slot_6` int(1) DEFAULT NULL,
  `total_jackpot` int(11) DEFAULT NULL,
  `reward` decimal(12,2) DEFAULT NULL,
  `without_reward_round` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_jackpot` WRITE;
/*!40000 ALTER TABLE `ossn_jackpot` DISABLE KEYS */;

INSERT INTO `ossn_jackpot` (`id`, `date`, `am_pm`, `full_slot`, `slot_1`, `slot_2`, `slot_3`, `slot_4`, `slot_5`, `slot_6`, `total_jackpot`, `reward`, `without_reward_round`, `time_created`, `time_updated`)
VALUES
	(1,'2021-10-23','pm',913153,9,1,3,1,5,3,NULL,10000.00,1,1635009589,NULL),
	(2,'2021-10-24','am',132020,1,3,2,0,2,0,NULL,20000.00,2,1635046217,NULL),
	(3,'2021-10-25','pm',996679,9,9,6,6,7,9,NULL,40000.00,3,1635168320,NULL),
	(4,'2021-10-26','am',315453,3,1,5,4,5,3,NULL,80000.00,4,1635223981,NULL);

/*!40000 ALTER TABLE `ossn_jackpot` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_jackpot_play
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_jackpot_play`;

CREATE TABLE `ossn_jackpot_play` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `am_pm` varchar(2) DEFAULT NULL,
  `jackpot_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_slot` int(6) DEFAULT NULL,
  `slot_1` int(1) DEFAULT NULL,
  `slot_2` int(1) DEFAULT NULL,
  `slot_3` int(1) DEFAULT NULL,
  `slot_4` int(1) DEFAULT NULL,
  `slot_5` int(1) DEFAULT NULL,
  `slot_6` int(1) DEFAULT NULL,
  `max_slot_prize` varchar(255) DEFAULT NULL,
  `prize_amount` decimal(12,2) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_jackpot_play` WRITE;
/*!40000 ALTER TABLE `ossn_jackpot_play` DISABLE KEYS */;

INSERT INTO `ossn_jackpot_play` (`id`, `date`, `am_pm`, `jackpot_id`, `user_id`, `full_slot`, `slot_1`, `slot_2`, `slot_3`, `slot_4`, `slot_5`, `slot_6`, `max_slot_prize`, `prize_amount`, `time_created`, `time_updated`)
VALUES
	(1,'2021-10-23','am',NULL,2,848841,8,4,8,8,4,1,NULL,NULL,1634907720,NULL),
	(2,'2021-10-23','pm',1,2,123452,1,2,4,4,5,2,'3',100.00,1634907720,1635009836),
	(3,'2021-10-23','pm',1,3,351269,3,5,1,2,6,9,'4',50.00,1634907720,1635009836),
	(4,'2021-10-23','pm',1,4,877972,3,5,1,2,6,9,'1',1000.00,1634907720,1635009836),
	(5,'2021-10-24','am',2,2,349161,3,4,9,1,6,1,'2',500.00,1635046016,1635046217),
	(6,'2021-11-06','am',NULL,2,731801,7,3,1,8,0,1,NULL,NULL,1635046664,NULL);

/*!40000 ALTER TABLE `ossn_jackpot_play` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_likes`;

CREATE TABLE `ossn_likes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_id` bigint(20) NOT NULL,
  `guid` bigint(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `subtype` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subtype` (`subtype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_likes` WRITE;
/*!40000 ALTER TABLE `ossn_likes` DISABLE KEYS */;

INSERT INTO `ossn_likes` (`id`, `subject_id`, `guid`, `type`, `subtype`)
VALUES
	(3,44,2,'post','love'),
	(4,46,2,'post','love'),
	(6,48,2,'post','love'),
	(7,45,2,'post','love'),
	(8,43,2,'post','love'),
	(9,45,3,'post','love'),
	(10,16,2,'annotation','love'),
	(11,49,2,'post','love');

/*!40000 ALTER TABLE `ossn_likes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_messages`;

CREATE TABLE `ossn_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_from` bigint(20) NOT NULL,
  `message_to` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `viewed` varchar(1) DEFAULT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_to` (`message_to`),
  KEY `message_from` (`message_from`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_messages` WRITE;
/*!40000 ALTER TABLE `ossn_messages` DISABLE KEYS */;

INSERT INTO `ossn_messages` (`id`, `message_from`, `message_to`, `message`, `viewed`, `time`)
VALUES
	(1,3,2,'Hi Nam','1',1633162605),
	(2,2,3,'123','0',1633529290),
	(3,2,3,'123','0',1633529304),
	(4,2,3,'1111','0',1633533316),
	(5,2,3,'123','0',1633533329);

/*!40000 ALTER TABLE `ossn_messages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_notifications`;

CREATE TABLE `ossn_notifications` (
  `guid` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `poster_guid` bigint(20) NOT NULL,
  `owner_guid` bigint(20) NOT NULL,
  `subject_guid` bigint(20) NOT NULL,
  `viewed` varchar(1) DEFAULT NULL,
  `time_created` int(11) NOT NULL,
  `item_guid` bigint(20) NOT NULL,
  PRIMARY KEY (`guid`),
  KEY `poster_guid` (`poster_guid`),
  KEY `owner_guid` (`owner_guid`),
  KEY `subject_guid` (`subject_guid`),
  KEY `time_created` (`time_created`),
  KEY `item_guid` (`item_guid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_notifications` WRITE;
/*!40000 ALTER TABLE `ossn_notifications` DISABLE KEYS */;

INSERT INTO `ossn_notifications` (`guid`, `type`, `poster_guid`, `owner_guid`, `subject_guid`, `viewed`, `time_created`, `item_guid`)
VALUES
	(1,'like:post',3,2,45,NULL,1631806094,45),
	(2,'comments:post',3,2,45,NULL,1631806098,5),
	(3,'comments:post',3,2,45,NULL,1631806256,6),
	(4,'comments:post',3,2,45,NULL,1631806279,7),
	(5,'comments:post',3,2,45,NULL,1631806302,8),
	(6,'comments:post',3,2,45,NULL,1631806325,9),
	(7,'comments:post',3,2,45,NULL,1631806360,10),
	(8,'comments:post',3,2,45,NULL,1631806504,11),
	(9,'comments:post',3,2,45,NULL,1631806560,12),
	(10,'comments:post',3,2,45,NULL,1631806667,13),
	(11,'comments:post',3,2,45,NULL,1631806687,14),
	(12,'comments:post',3,2,45,'',1631806760,15),
	(13,'comments:post',3,2,43,'',1631807871,18),
	(14,'comments:post',3,2,50,NULL,1634302501,20),
	(15,'comments:post',3,2,50,'',1634302510,21);

/*!40000 ALTER TABLE `ossn_notifications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_object`;

CREATE TABLE `ossn_object` (
  `guid` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner_guid` bigint(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `time_created` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `subtype` varchar(30) NOT NULL,
  PRIMARY KEY (`guid`),
  KEY `owner_guid` (`owner_guid`),
  KEY `time_created` (`time_created`),
  KEY `type` (`type`),
  KEY `subtype` (`subtype`),
  KEY `oky_ts` (`type`,`subtype`),
  KEY `oky_tsg` (`type`,`subtype`,`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_object` WRITE;
/*!40000 ALTER TABLE `ossn_object` DISABLE KEYS */;

INSERT INTO `ossn_object` (`guid`, `owner_guid`, `type`, `time_created`, `title`, `description`, `subtype`)
VALUES
	(34,2,'user',1629279062,'','{\"post\":\"123123\"}','wall'),
	(35,2,'user',1629279073,'','{\"post\":\"123123\"}','wall'),
	(21,1,'user',1626944260,'','{\"post\":\"https:\\/\\/www.facebook.com\\/watch\\/?v=403516277742390\"}','wall'),
	(22,1,'user',1626944298,'','{\"post\":\"https:\\/\\/www.facebook.com\\/1202773936405522\\/videos\\/261981098411963\"}','wall'),
	(23,1,'user',1626944313,'','{\"post\":\"https:\\/\\/www.facebook.com\\/vietcupid\\/posts\\/10217169866633390\"}','wall'),
	(24,2,'user',1629266348,'','{\"post\":\"Hello\"}','wall'),
	(25,2,'user',1629277306,'','{\"post\":\"https:\\/\\/www.facebook.com\\/vietcupid\\/posts\\/10217169866633390\"}','wall'),
	(26,2,'user',1629278366,'','{\"post\":\"Thú Cưng, Phim Hoạt Hình\"}','wall'),
	(33,2,'user',1629279046,'','{\"post\":\"Abc, Def\"}','wall'),
	(29,2,'user',1629278662,'','{\"post\":\"Ô Tô, Làm Đẹp\\r\\n\"}','wall'),
	(30,2,'user',1629278929,'','{\"post\":\"Ô Tô, Làm Đẹp\\r\\n\"}','wall'),
	(31,2,'user',1629278962,'','{\"post\":\"Ô Tô, Làm Đẹp\\r\\n\"}','wall'),
	(32,2,'user',1629279007,'','{\"post\":\"Ô Tô, Làm Đẹp\\r\\n\"}','wall'),
	(16,1,'user',1626942621,'','{\"post\":\"https:\\/\\/www.facebook.com\\/vietcupid\\/posts\\/10217169866633390\"}','wall'),
	(36,2,'user',1629279114,'','{\"post\":\"123123\"}','wall'),
	(37,2,'user',1629279151,'','{\"post\":\"123123\"}','wall'),
	(38,2,'user',1629279225,'','{\"post\":\"123123\"}','wall'),
	(39,2,'user',1629279246,'','{\"post\":\"123123\"}','wall'),
	(40,2,'user',1629279340,'','{\"post\":\"123123\"}','wall'),
	(41,2,'user',1629279354,'','{\"post\":\"123123\"}','wall'),
	(42,2,'user',1629279379,'','{\"post\":\"Oto, Giai tri\"}','wall'),
	(43,2,'user',1629294140,'','{\"post\":\"Câu cá\"}','wall'),
	(44,2,'user',1629978888,'','{\"post\":\"Give user points based on the contents they add. The points will motivate them to add more valuable content. It works like this:\\r\\n\\r\\n5 points for creating a wall post\\r\\n2 Points for every like\\r\\n2 Points for every comment\\r\\n10 points for adding a photo\\r\\n2 points for sending a message\"}','wall'),
	(45,2,'user',1630329745,'','{\"post\":\"New Post\"}','wall'),
	(46,2,'user',1631599179,'','{\"post\":\"Hello\"}','wall'),
	(47,2,'user',1631678932,'','{\"post\":\"https:\\/\\/www.youtube.com\\/watch?v=Qb8-Ej-a2to\"}','wall'),
	(48,2,'user',1631678970,'','{\"post\":\"https:\\/\\/www.facebook.com\\/tiktokvietnam.official\\/videos\\/1266959913737210\"}','wall'),
	(49,2,'user',1631971371,'','{\"post\":\"Hello\"}','wall'),
	(50,2,'user',1633603280,'','{\"post\":\"24234234\"}','wall'),
	(62,2,'user',1635999995,'','{\"post\":\"null:data\"}','wall'),
	(63,2,'user',1636000015,'','{\"post\":\"null:data\"}','wall'),
	(64,2,'user',1636000381,'','{\"post\":\"null:data\"}','wall'),
	(65,2,'user',1636386749,'','{\"post\":\"https:\\/\\/twitter.com\\/bigdaddyGOC\\/status\\/1457736471285280771?s=20\"}','wall'),
	(66,2,'user',1636387125,'','{\"post\":\"https:\\/\\/twitter.com\\/electroneum\\/status\\/1457679482018467841?s=20\"}','wall'),
	(67,2,'user',1636704222,'','{\"post\":\"Status\"}','wall');

/*!40000 ALTER TABLE `ossn_object` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_object_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_object_category`;

CREATE TABLE `ossn_object_category` (
  `guid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_object_category` WRITE;
/*!40000 ALTER TABLE `ossn_object_category` DISABLE KEYS */;

INSERT INTO `ossn_object_category` (`guid`, `object_id`, `category_id`)
VALUES
	(1,43,6),
	(2,46,4);

/*!40000 ALTER TABLE `ossn_object_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_point_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_point_log`;

CREATE TABLE `ossn_point_log` (
  `guid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `point_setting_id` int(11) DEFAULT NULL,
  `value` decimal(12,2) DEFAULT NULL,
  `before_balance` decimal(12,2) DEFAULT NULL,
  `after_balance` decimal(12,2) DEFAULT NULL,
  `change_type` int(11) DEFAULT NULL,
  `source` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `time_deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_point_log` WRITE;
/*!40000 ALTER TABLE `ossn_point_log` DISABLE KEYS */;

INSERT INTO `ossn_point_log` (`guid`, `user_id`, `point_setting_id`, `value`, `before_balance`, `after_balance`, `change_type`, `source`, `time_created`, `time_updated`, `time_deleted`)
VALUES
	(1,2,1,10.00,0.00,10.00,1,1,1631807800,NULL,NULL),
	(2,3,1,10.00,0.00,10.00,1,1,1631807827,NULL,NULL),
	(3,2,5,0.50,10.00,10.50,1,1,1631807851,NULL,NULL),
	(4,3,5,0.50,10.00,10.50,1,1,1631807871,NULL,NULL),
	(5,1,1,10.00,0.00,10.00,1,1,1631809191,NULL,NULL),
	(6,2,1,10.00,10.50,20.50,1,1,1631887563,NULL,NULL),
	(7,1,1,10.00,10.00,20.00,1,1,1631887624,NULL,NULL),
	(8,1,1,10.00,20.00,30.00,1,1,1631971250,NULL,NULL),
	(9,2,1,10.00,20.50,30.50,1,1,1633145834,NULL,NULL),
	(10,3,1,10.00,10.50,20.50,1,1,1633162576,NULL,NULL),
	(11,1,1,10.00,30.00,40.00,1,1,1633164826,NULL,NULL),
	(12,3,1,10.00,100.00,110.00,1,1,1633599159,NULL,NULL),
	(13,2,5,0.50,30.50,31.00,1,1,1633603275,NULL,NULL),
	(14,2,1,10.00,31.00,41.00,1,1,1634029344,NULL,NULL),
	(15,2,1,10.00,2041.00,2051.00,1,1,1634193652,NULL,NULL),
	(17,3,5,0.50,0.00,0.50,1,1,1634302501,NULL,NULL),
	(18,3,5,0.50,1.00,1.50,1,1,1634302510,NULL,NULL),
	(19,2,1,10.00,1351.00,1361.00,1,1,1634302596,NULL,NULL),
	(20,3,1,10.00,2.00,12.00,1,1,1634302749,NULL,NULL),
	(21,2,1,10.00,0.00,10.00,1,1,1634714402,NULL,NULL),
	(22,1,1,10.00,0.00,10.00,1,1,1634714409,NULL,NULL),
	(23,2,1,10.00,10.00,20.00,1,1,1634870913,NULL,NULL),
	(24,1,1,10.00,10.00,20.00,1,1,1634906857,NULL,NULL),
	(25,2,1,10.00,501.00,511.00,1,1,1635219088,NULL,NULL),
	(26,1,1,10.00,20.00,30.00,1,1,1635494864,NULL,NULL),
	(27,2,5,0.50,511.00,511.50,1,1,1635496266,NULL,NULL),
	(28,2,5,0.50,512.00,512.50,1,1,1635496510,NULL,NULL),
	(29,2,1,10.00,513.00,523.00,1,1,1635497469,NULL,NULL),
	(30,2,1,10.00,523.00,533.00,1,1,1635948060,NULL,NULL),
	(31,2,1,10.00,529.00,539.00,1,1,1636703723,NULL,NULL);

/*!40000 ALTER TABLE `ossn_point_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_point_setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_point_setting`;

CREATE TABLE `ossn_point_setting` (
  `guid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `value` decimal(12,2) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `time_deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_point_setting` WRITE;
/*!40000 ALTER TABLE `ossn_point_setting` DISABLE KEYS */;

INSERT INTO `ossn_point_setting` (`guid`, `code`, `name`, `value`, `added_by`, `status`, `time_created`, `time_updated`, `time_deleted`)
VALUES
	(1,'login','Login',10.00,1,1,1631784738,1631785030,NULL),
	(2,'top_trending','Top Trending',0.10,1,1,1631785531,1631785719,NULL),
	(3,'top_view','Top View',0.10,1,1,1631785611,1631785710,NULL),
	(4,'love','Love',0.10,1,1,1631785619,1631785729,NULL),
	(5,'comment','Comment',0.50,1,1,1631785640,1631785742,NULL),
	(6,'share','Share',0.10,1,1,1631785653,1631785746,NULL),
	(7,'jackpot_buy_price','Jackpot Buy Pricing',10.00,1,1,1634906907,NULL,NULL),
	(8,'jackpot','Jackpot Reward',10000.00,1,1,1634906984,NULL,NULL),
	(9,'jackpot_1','Jackpot 1st Reward',1000.00,1,1,1634907042,NULL,NULL),
	(10,'jackpot_2','Jackpot 2nd Reward',500.00,1,1,1634907074,NULL,NULL),
	(11,'jackpot_3','Jackpot 3rd Reward',100.00,1,1,1634907101,NULL,NULL),
	(12,'jackpot_4','Jackpot 4th Reward',50.00,1,1,1634907101,NULL,NULL),
	(13,'jackpot_5','Jackpot 5th Reward',20.00,1,1,1634907101,NULL,NULL);

/*!40000 ALTER TABLE `ossn_point_setting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_relationships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_relationships`;

CREATE TABLE `ossn_relationships` (
  `relation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `relation_from` bigint(20) NOT NULL,
  `relation_to` bigint(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`relation_id`),
  KEY `relation_to` (`relation_to`),
  KEY `relation_from` (`relation_from`),
  KEY `time` (`time`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_relationships` WRITE;
/*!40000 ALTER TABLE `ossn_relationships` DISABLE KEYS */;

INSERT INTO `ossn_relationships` (`relation_id`, `relation_from`, `relation_to`, `type`, `time`)
VALUES
	(3,2,44,'rtctypingpost',1631698048),
	(4,2,46,'rtctypingpost',1631806015),
	(5,3,45,'rtctypingpost',1631806255),
	(6,2,48,'rtctypingpost',1631807083),
	(7,2,43,'rtctypingpost',1631807850),
	(8,3,43,'rtctypingpost',1631807870),
	(9,2,49,'rtctypingpost',1633603273),
	(10,3,2,'friend:request',1633162596),
	(11,2,3,'friend:request',1633162609),
	(12,3,50,'rtctypingpost',1634302508);

/*!40000 ALTER TABLE `ossn_relationships` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_send
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_send`;

CREATE TABLE `ossn_send` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `from_wallet_id` int(11) DEFAULT NULL,
  `to_wallet_id` int(11) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `send_amount` decimal(12,2) DEFAULT NULL,
  `receive_amount` decimal(12,2) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_send` WRITE;
/*!40000 ALTER TABLE `ossn_send` DISABLE KEYS */;

INSERT INTO `ossn_send` (`id`, `from_user_id`, `to_user_id`, `from_wallet_id`, `to_wallet_id`, `symbol`, `send_amount`, `receive_amount`, `time_created`)
VALUES
	(1,2,3,3,1,'DAK',1.00,1.00,1636390996),
	(2,2,3,3,1,'DAK',2.00,2.00,1636391100),
	(3,2,3,3,1,'DAK',1.00,1.00,1636391374);

/*!40000 ALTER TABLE `ossn_send` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_site_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_site_settings`;

CREATE TABLE `ossn_site_settings` (
  `setting_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_site_settings` WRITE;
/*!40000 ALTER TABLE `ossn_site_settings` DISABLE KEYS */;

INSERT INTO `ossn_site_settings` (`setting_id`, `name`, `value`)
VALUES
	(1,'theme','goblue'),
	(2,'site_name','SYNT'),
	(3,'language','en'),
	(4,'cache','0'),
	(5,'owner_email','enterid@gmail.com'),
	(6,'notification_email','noreply@localhost.synt'),
	(7,'upgrades','[\"1410545706.php\",\"1411396351.php\", \"1412353569.php\",\"1415553653.php\",\"1415819862.php\", \"1423419053.php\", \"1423419054.php\", \"1439295894.php\", \"1440716428.php\", \"1440867331.php\", \"1440603377.php\", \"1443202118.php\", \"1443211017.php\", \"1443545762.php\", \"1443617470.php\", \"1446311454.php\", \"1448807613.php\", \"1453676400.php\", \"1459411815.php\", \"1468010638.php\", \"1470127853.php\", \"1480759958.php\", \"1495366993.php\", \"1513524535.php\", \"1513603766.php\", \"1513783390.php\", \"1542223614.php\", \"1564080285.php\", \"1577836800.php\", \"1597058454.php\", \"1597734806.php\", \"1598389337.php\", \"1605286634.php\"]'),
	(9,'display_errors','on'),
	(10,'site_key','76cd0a47'),
	(11,'last_cache','0'),
	(12,'site_version','5.6');

/*!40000 ALTER TABLE `ossn_site_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_swap
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_swap`;

CREATE TABLE `ossn_swap` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `from_wallet_id` int(11) DEFAULT NULL,
  `to_wallet_id` int(11) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `swap_amount` decimal(12,2) DEFAULT NULL,
  `receive_amount` decimal(12,2) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table ossn_transaction
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_transaction`;

CREATE TABLE `ossn_transaction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table ossn_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_users`;

CREATE TABLE `ossn_users` (
  `guid` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `salt` varchar(8) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `birthday` date DEFAULT NULL,
  `kyc_level` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `id_front_image` varchar(255) DEFAULT '',
  `id_back_image` varchar(255) DEFAULT NULL,
  `id_and_face_image` varchar(255) DEFAULT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `default_address` varchar(255) DEFAULT NULL,
  `last_login` int(11) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `activation` varchar(32) DEFAULT NULL,
  `time_created` int(11) NOT NULL,
  PRIMARY KEY (`guid`),
  KEY `last_login` (`last_login`),
  KEY `last_activity` (`last_activity`),
  KEY `time_created` (`time_created`),
  FULLTEXT KEY `type` (`type`),
  FULLTEXT KEY `email` (`email`),
  FULLTEXT KEY `first_name` (`first_name`),
  FULLTEXT KEY `last_name` (`last_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_users` WRITE;
/*!40000 ALTER TABLE `ossn_users` DISABLE KEYS */;

INSERT INTO `ossn_users` (`guid`, `type`, `username`, `email`, `password`, `salt`, `first_name`, `last_name`, `birthday`, `kyc_level`, `id_type`, `id_number`, `id_front_image`, `id_back_image`, `id_and_face_image`, `balance`, `default_address`, `last_login`, `last_activity`, `activation`, `time_created`)
VALUES
	(1,'admin','admin','enterid@gmail.com','$2y$10$OfI6jQnwPNllhy0nyP0q3O32MHscHDjBRxMqTPNidSVU83z1eebPW','331d0755','Nam','Le',NULL,NULL,NULL,NULL,'',NULL,NULL,40.00,NULL,1635494864,1635497346,'',1626198833),
	(2,'normal','nam01','nam01@gmail.com','$2y$10$eFz248qUj052thvkSNfxIeaOkFl5d/2/cR4HjiOK/RJF9CKzQcGpq','3da3dadf','Long','Nguyen Van','1995-05-23',2,1,'174324001','',NULL,NULL,41.00,NULL,1636703723,1636704931,'',1626338232),
	(3,'normal','nam02','nam02@gmail.com','$2y$10$mznp2vpci2qaiduYyJqeGezvjXcxnUw500UygV39S6VcRVRXLTIEG','e9523eec','Nam','Le',NULL,NULL,NULL,NULL,'',NULL,NULL,20.50,NULL,1634303752,1634460569,'',1626345109),
	(4,'normal','nam03','nam03@gmail.com','$2y$10$OiqWCy1WYOM.y3ysHJujzOtUNa2Vpi/2O6oJmvWYYPjg.ybppv36a','236b7dc9','Nam','Le',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,0,0,'23dfe805259f016bd337eb2308785f18',1626366518);

/*!40000 ALTER TABLE `ossn_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_wallet
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_wallet`;

CREATE TABLE `ossn_wallet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `symbol` varchar(32) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  `time_deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_wallet` WRITE;
/*!40000 ALTER TABLE `ossn_wallet` DISABLE KEYS */;

INSERT INTO `ossn_wallet` (`id`, `user_id`, `name`, `symbol`, `address`, `balance`, `time_created`, `time_updated`, `time_deleted`)
VALUES
	(1,3,'DAK','DAK','0x4C837055cc4cB2E1cbA1c455231B73154d59E27D',75,1634306838,1635009836,NULL),
	(2,3,'USDT','USDT','0x4fC560F31425d142C988A04dEe6931935AEa1c3E',NULL,1634306838,1634306838,NULL),
	(3,2,'DAK','DAK','0x2559E00dc247960373DF6B8A1D2050bAbeE87166',539,1634714402,1635046664,NULL),
	(4,1,'DAK','DAK',NULL,30,1634714409,NULL,NULL),
	(5,2,'USDT','USDT','0xc6eAe449c2743F4c21627160D985485dc5538120',NULL,1634870916,1634870916,NULL);

/*!40000 ALTER TABLE `ossn_wallet` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ossn_wallet_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_wallet_log`;

CREATE TABLE `ossn_wallet_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `from` varchar(64) DEFAULT NULL,
  `to` varchar(64) DEFAULT NULL,
  `tx` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table ossn_withdraw
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ossn_withdraw`;

CREATE TABLE `ossn_withdraw` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `to_address` varchar(255) DEFAULT NULL,
  `tx_hash` varchar(255) DEFAULT NULL COMMENT 'Transaction ID',
  `time_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ossn_withdraw` WRITE;
/*!40000 ALTER TABLE `ossn_withdraw` DISABLE KEYS */;

INSERT INTO `ossn_withdraw` (`id`, `wallet_id`, `user_id`, `status`, `amount`, `from_address`, `to_address`, `tx_hash`, `time_created`)
VALUES
	(1,3,2,2,100.00,'0x2559E00dc247960373DF6B8A1D2050bAbeE87166','0x2559E00dc247960373DF6B8A1D2050bAbeE87166','0x99a9a21cf4e26b29a73dcb1c2392aff17cda3e60e8a7369af8c920caf454f0a6',1635046512);

/*!40000 ALTER TABLE `ossn_withdraw` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
