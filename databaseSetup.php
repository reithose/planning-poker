<?php
include_once("include.php");
$setupQuery = "
# Dump of table session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sessionId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `round` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `active` set('1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `master` set('1') COLLATE utf8_unicode_ci DEFAULT NULL,
  `pokerSession_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_user_session` (`pokerSession_id`),
  CONSTRAINT `cons_fk_user_pokerSession_id_id` FOREIGN KEY (`pokerSession_id`) REFERENCES `session` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table vote
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vote`;

CREATE TABLE `vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `points` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `round` tinyint(3) unsigned DEFAULT NULL,
  `session_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_vote_session` (`session_id`),
  KEY `index_foreignkey_vote_user` (`user_id`),
  CONSTRAINT `cons_fk_vote_session_id_id` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `cons_fk_vote_user_id_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
if(R::exec($setupQuery) == 0)
  echo "Tabellen aangemaakt. Je moet databaseSetup.php nu verwijderen.";
?>

