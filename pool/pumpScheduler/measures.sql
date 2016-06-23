DROP TABLE IF EXISTS `measures`;
CREATE TABLE IF NOT EXISTS `measures` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `orp` smallint(6) NOT NULL,
  `ph` float NOT NULL,
  `temperature` smallint(6) NOT NULL,
  `pump` tinyint(4) NOT NULL,
  `treatment` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `measures`
--

INSERT INTO `measures` (`id`, `timestamp`, `orp`, `ph`, `temperature`, `pump`, `treatment`) VALUES
(4, '2016-06-23 13:55:00', 646, 5.89, 31, 0, 0),
(5, '2016-06-23 13:55:57', 646, 5.95, -2, 0, 0),
(6, '2016-06-23 13:56:26', 646, 5.91, 21, 0, 0),
(7, '2016-06-23 13:56:50', 646, 5.92, 27, 0, 0),
(8, '2016-06-23 13:57:11', 646, 5.93, 11, 0, 0),
(9, '2016-06-23 14:17:19', 647, 5.71, 19, 0, 0),
(10, '2016-06-23 14:56:56', 646, 5.95, 11, 0, 0),
(11, '2016-06-23 19:55:48', 646, 5.97, 3, 1, 1),
(12, '2016-06-23 14:59:19', 646, 5.97, 26, 0, 0),
(13, '2016-06-23 14:59:38', 646, 5.98, 6, 0, 0),
(14, '2016-06-23 15:00:02', 646, 5.91, 1, 0, 0),
(15, '2016-06-23 15:01:12', 646, 5.88, 18, 0, 0),
(16, '2016-06-23 15:01:32', 646, 5.93, -4, 0, 0),
(17, '2016-06-23 15:04:54', 646, 5.92, 12, 0, 0),
(18, '2016-06-23 15:17:17', 646, 5.92, 6, 0, 0),
(19, '2016-06-23 15:44:59', 646, 5.57, -3, 0, 0),
(20, '2016-06-23 16:17:17', 646, 6.01, 21, 0, 0),
(21, '2016-06-23 17:17:17', 647, 5.69, 5, 0, 0),
(22, '2016-06-23 19:55:14', 647, 5.62, 13, 1, 0),
(23, '2016-06-23 19:17:17', 647, 5.96, 12, 0, 0),
(24, '2016-06-23 19:56:29', 646, 5.69, 19, 0, 0),
(28, '2016-06-23 20:14:22', 646, 5.7, 8, 1, 1),
(29, '2016-06-23 20:15:55', 646, 5.63, 8, 0, 0),
(30, '0000-00-00 00:00:00', 646, 5.64, 12, 1, 0),
(31, '2016-06-23 20:18:07', 646, 5.6, 13, 0, 0);