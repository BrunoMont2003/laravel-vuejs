DROP TABLE IF EXISTS `resumes`;

CREATE TABLE `resumes` (
	`id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`user_id` bigint unsigned NOT NULL,
	`title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	`name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	`email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	`website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	`picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/storage/pictures/default.png',
	`skills` json DEFAULT NULL,
	`about` text COLLATE utf8mb4_unicode_ci,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;