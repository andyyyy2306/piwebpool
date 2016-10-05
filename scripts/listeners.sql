DROP TABLE IF EXISTS `listeners`;
CREATE TABLE `listeners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `url` char(255) NOT NULL,
  `material` char(60) NOT NULL,
  `valueOn` char(32) NOT NULL,
  `valueOff` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `listeners`
  ADD PRIMARY KEY (`id`);