SET foreign_key_checks = 0;

CREATE TABLE IF NOT EXISTS `articleimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `image_id` (`image_id`),
  CONSTRAINT `articleimages_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `articleimages_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `edited_at` timestamp NULL DEFAULT NULL,
  `author` varchar(40) NOT NULL,
  `title` varchar(256) NOT NULL,
  `title_image` int(11) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `tags` varchar(256) DEFAULT NULL,
  `published` tinyint(4) DEFAULT NULL,
  `view` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` varchar(40) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `edited_at` timestamp NULL DEFAULT NULL,
  `deleted` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(512) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `user` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `displayname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `ban` int(11) DEFAULT NULL,
  `session` text DEFAULT NULL,
  `redactor` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `users` (`username`,`email`,`displayname`,`password`,`role`,`description`,`ban`,`session`,`redactor`)
SELECT 'admin','admin@admin.com','Administrator','$2y$10$t69jLdHEKQ.D84/ZQQ5F1O3VyN/3tAPy56medeY5QB0sQbxfFdtQi',9,NULL,NULL,'',NULL
WHERE NOT EXISTS (SELECT 1 FROM `users` WHERE `username` = 'admin');
