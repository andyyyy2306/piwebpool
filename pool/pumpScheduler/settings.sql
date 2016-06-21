DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(40) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `userSetting` BOOLEAN NOT NULL ,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `value`) VALUES
('scheduler', 1),
('logTableCollapse', 1),
('actionTableCollapse', 1),
('blocklyTableCollapse', 1),
('scheduleTableCollapse', 1),
('sensorTableCollapse', 0),
('settingsTableCollapse', 1);


ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);