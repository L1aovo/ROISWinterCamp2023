CREATE DATABASE IF NOT EXISTS ez_sql;
USE ez_sql;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'why', 'why'),
(2, 'nobody', 'nobody'),
(3, 'does', 'does'),
(4, 'misc', 'misc'),
(5, 'im', 'im'),
(6, 'so', 'so'),
(7, 'sad', 'sad'),
(8, 'admin', 'ROIS{sqli_1s_in7ere5tingwaku}');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;