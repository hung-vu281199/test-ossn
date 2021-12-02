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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;