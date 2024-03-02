CREATE TABLE `user_favourites` (
  `user_id` int NOT NULL,
  `listing_id` int NOT NULL,
  PRIMARY KEY (`user_id`, `listing_id`),
  CONSTRAINT `fk_user_favourites_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_user_favourites_listings` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
