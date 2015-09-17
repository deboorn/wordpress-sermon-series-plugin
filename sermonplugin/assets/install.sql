CREATE TABLE IF NOT EXISTS `{wp_prefix}sermonplugin_series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `start_date` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`,`start_date`,`created_at`,`updated_at`)
) ENGINE=InnoDB {charset};

CREATE TABLE IF NOT EXISTS `{wp_prefix}sermonplugin_sermons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `sermon_date` int(11) NOT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `video_embed` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `series_id` (`series_id`),
  KEY `title` (`title`,`sermon_date`,`created_at`,`updated_at`)
) ENGINE=InnoDB {charset};