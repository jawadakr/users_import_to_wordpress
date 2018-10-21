DROP TABLE IF EXISTS `wsd_migration_log`;
CREATE TABLE IF NOT EXISTS `wsd_migration_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `email` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20635 DEFAULT CHARSET=latin1;
