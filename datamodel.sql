CREATE TABLE `4ww3`.`user`
(
    `id`       INT(5)       NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(60)  NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email`    VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `4ww3`.`user` ADD UNIQUE(`username`);;

CREATE TABLE `4ww3`.`restaurant`
(
    `id`           INT(5)      NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(60) NOT NULL,
    `description`  TEXT        NOT NULL,
    `latitude`     DOUBLE      NOT NULL,
    `longitude`    DOUBLE      NOT NULL,
    `image`        TEXT        NOT NULL,
    `overall_star` DOUBLE      NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `4ww3`.`restaurant` CHANGE `overall_star` `overall_star` DOUBLE NOT NULL DEFAULT '1';

CREATE TABLE `4ww3`.`review`
(
    `id`            INT(5)      NOT NULL AUTO_INCREMENT,
    `restaurant_id` INT         NOT NULL,
    `star`          INT(1)      NOT NULL,
    `detail`        TEXT        NOT NULL,
    `reviewer`      VARCHAR(60) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `4ww3`.`review`
    ADD FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;