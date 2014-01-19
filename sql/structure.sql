--
-- Structure de la table `t_user`
--
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
    `use_id` INT(11) NOT NULL AUTO_INCREMENT,
    `use_active` TINYINT(1) NOT NULL DEFAULT '0',
    `use_key` char(64) NOT NULL,
    `use_username` VARCHAR(20) NOT NULL,
    `use_group` VARCHAR(15) NOT NULL DEFAULT 'user',
    `use_password` char(64) NOT NULL,
    `use_email` VARCHAR(60) NOT NULL,
    `use_lastname` VARCHAR(35) NOT NULL,
    `use_firstname` VARCHAR(35) NOT NULL,
    `use_address` VARCHAR(300) NOT NULL,
    `use_postcode` VARCHAR(10) NOT NULL,
    `use_city` VARCHAR(100) NOT NULL,
    `use_registered` DATETIME NOT NULL,
    `use_team` INTEGER NOT NULL DEFAULT 0,
    `use_starcraft` INTEGER NOT NULL DEFAULT 0,
    PRIMARY KEY (`use_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Structure de la table `t_team`
--
DROP TABLE IF EXISTS `t_team`;
CREATE TABLE `t_team` (
    `tea_id` INT(11) NOT NULL AUTO_INCREMENT,
    `tea_name` VARCHAR(100) NOT NULL,
    `tea_tag` VARCHAR(50) NOT NULL,
    `tea_password` char(64) NOT NULL,
    PRIMARY KEY (`tea_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
