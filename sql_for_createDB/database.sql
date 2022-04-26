CREATE DATABASE IF NOT EXISTS `travelhk` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `travelhk`;

CREATE TABLE `account_type` (
    `type_id`           tinyint         NOT NULL,
    `zh-hk`             varchar(255)    NOT NULL,
    `en`                varchar(255)    NOT NULL,
    PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `account_status` (
    `status_id`         tinyint         NOT NULL,
    `zh-hk`             varchar(255)    NOT NULL,
    `en`                varchar(255)    NOT NULL,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `account` (
    `account_id`        int             NOT NULL,
    `email`             varchar(255)    NOT NULL,
    `password`          varchar(255)    NOT NULL,
    `firstname`         varchar(35)     NULL,
    `lastname`          varchar(35)     NULL,
    `nickname`          varchar(20)     NOT NULL,
    `gender`            varchar(1)      NOT NULL,
    `phone_number`      varchar(8)      NULL,
    `birth_year`        varchar(4)      NOT NULL,
    `birth_month`       varchar(2)      NOT NULL,
    `icon_path`         varchar(255)    NULL,
    `type_id`           tinyint         NOT NULL,
    `status`            tinyint         NOT NULL,
    `registration_time` datetime        NOT NULL,
    PRIMARY KEY (`account_ID`),
    INDEX (`type_ID`),
    INDEX (`status`),

    FOREIGN KEY (`type_ID`)
        REFERENCES `account_type` (`type_ID`),
    FOREIGN KEY (`status`)
        REFERENCES `account_status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `account`
    MODIFY `account_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

CREATE TABLE `vehicle` (
    `id`                    int             not null,
    `seat`                  int             not null,
    `license_plate_number`  varchar(255)    not null,
    `worker_id`             int             not null,
    PRIMARY KEY (`id`),
    INDEX (`worker_id`),

    FOREIGN KEY (`worker_id`)
        REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `vehicle`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `hong_kong_region` (
    `region_id`     int(1)          not null,           -- PRIMARY KEY
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `hong_kong_district` (
    `district_id`   int(4)          not null,           -- PRIMARY KEY
    `region_id`     int(1)          not null,           -- FOREIGN KEY
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    `latitude`      double          not null,           -- 緯度
    `longitude`     double          not null,           -- 經度
    PRIMARY KEY (`district_id`),
    INDEX (`region_id`),

    FOREIGN KEY (`region_id`)
        REFERENCES `hong_kong_region` (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `payment_method_list`(
    `method_id`     int             not null,   -- PRIMARY KEY
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_status` (
    `status_id`     int             not null,
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_type_list` (
    `type_id`       int             not null,
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_equipment_list` (
    `equipment_id`      int             not null,
    `zh-hk`             varchar(255)    not null,
    `en`                varchar(255)    not null,
    PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction` (
    `attraction_id`             int             not null,       -- PRIMARY KEY
    `attraction_chinese_name`   varchar(255)    null,
    `attraction_english_name`   varchar(255)    null,
    `description`               text            null,
    `district`                  int             not null,       -- FOREIGN KEY
    `chinese_address`           text            not null,
    `english_address`           text            not null,
    `phone_number`              varchar(8)      null,
    `website`                   varchar(255)    null,
    `email`                     varchar(255)    null,
    `weekday_business_hours`    varchar(255)    not null,
    `weekend_business_hours`    varchar(255)    not null,
    `holiday_business_hours`    varchar(255)    not null,
    `latitude`                  double          not null,
    `longitude`                 double          not null,
    `create_datetime`           datetime        not null,
    `status`                    int             not null,       -- FOREIGN KEY
    PRIMARY KEY (`attraction_id`),
    INDEX (`district`),
    INDEX (`status`),

    FOREIGN KEY (`district`)
        REFERENCES `hong_kong_district` (`district_id`),
    FOREIGN KEY (`Status`)
        REFERENCES `attraction_status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `attraction`
    MODIFY `attraction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

CREATE TABLE `attraction_type` (
    `attraction_id`     int             not null,
    `type_id`           int             not null,
    INDEX (`attraction_id`),
    INDEX (`type_id`),

    FOREIGN KEY (`attraction_id`)
        REFERENCES `attraction` (`attraction_id`),
    FOREIGN KEY (`type_id`)
        REFERENCES `attraction_type_list` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_equipment` (
    `attraction_id`     int             not null,
    `equipment_id`      int             not null,
    INDEX (`attraction_id`),
    INDEX (`equipment_id`),

    FOREIGN KEY (`attraction_id`)
        REFERENCES `attraction` (`attraction_id`),
    FOREIGN KEY (`equipment_id`)
        REFERENCES `attraction_equipment_list` (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_photo` (
    `photo_id`          int             not null,       -- PRIMARY KEY
    `attraction_id`     int             not null,       -- FOREIGN KEY
    `path`              varchar(255)    not null,
    PRIMARY KEY (`photo_id`),
    INDEX (`attraction_id`),

    FOREIGN KEY (`attraction_id`)
        REFERENCES `attraction` (`attraction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_payment_method` (
    `attraction_id`     int             not null,
    `method_id`         int             not null,
    INDEX (`attraction_id`),
    INDEX (`method_id`),

    FOREIGN KEY (`attraction_id`)
        REFERENCES `attraction` (`attraction_id`),
    FOREIGN KEY (`method_id`)
        REFERENCES `payment_method_list` (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `comment_status` (
    `status_id`         tinyint         not null,       -- PRIMARY KEY
    `zh-hk`             varchar(255)    not null,
    `en`                varchar(255)    not null,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_comment` (
    `comment_id`        int             not null,       -- PRIMARY KEY
    `account_id`        int             not null,       -- FOREIGN KEY
    `attraction_id`     int             not null,       -- FOREIGN KEY
    `title`             varchar(255)    not null,
    `date_of_visit`     varchar(255)    not null,
    `content`           text            not null,
    `environment_rating`tinyint         not null,
    `service_rating`    tinyint         not null,
    `hygiene_rating`    tinyint         not null,
    `create_datetime`   datetime        not null,
    `status`            tinyint         not null,       -- FOREIGN KEY
    PRIMARY KEY (`comment_id`),
    INDEX (`account_id`),
    INDEX (`attraction_id`),
    INDEX (`status`),

    FOREIGN KEY (`account_id`)
        REFERENCES `account` (`account_id`),
    FOREIGN KEY (`attraction_id`)
        REFERENCES `attraction` (`attraction_id`),
    FOREIGN KEY (`status`)
        REFERENCES `comment_status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `attraction_comment`
    MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `restaurant_status` (
    `status_id`     tinyint         not null,
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant` (
    `restaurant_id`             int             not null,       -- PRIMARY KEY
    `restaurant_chinese_name`   varchar(255)    null,
    `restaurant_english_name`   varchar(255)    null,
    `district`                  int(4)          not null,       -- FOREIGN KEY
    `chinese_address`           text            not null,
    `english_address`           text            not null,
    `latitude`                  double          not null,       -- 緯度
    `longitude`                 double          not null,       -- 經度
    `phone_number`              varchar(8)      not null,
    `email`                     varchar(255)    not null,
    `number_of_seats`           int             not null,
    `weekday_business_hours`    varchar(255)    not null,
    `weekend_business_hours`    varchar(255)    not null,
    `holiday_business_hours`    varchar(255)    not null,
    `create_datetime`           datetime        not null,
    `status`                    tinyint         not null,       -- FOREIGN KEY
    `partner_id`                int             null,           -- FOREIGN KEY
    PRIMARY KEY (`restaurant_id`),
    INDEX (`district`),
    INDEX (`status`),
    INDEX (`partner_id`),

    FOREIGN KEY (`district`)
        REFERENCES `hong_kong_district` (`district_id`),
    FOREIGN KEY (`status`)
        REFERENCES `restaurant_status` (`status_id`),
    FOREIGN KEY (`partner_id`)
        REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `restaurant`
    MODIFY `restaurant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

CREATE TABLE `restaurant_photo` (
    `photo_id`          int             not null,       -- PRIMARY KEY
    `restaurant_id`     int             not null,       -- FOREIGN KEY
    `path`              varchar(255)    not null,
    PRIMARY KEY (`photo_id`),
    INDEX (`restaurant_id`),

    FOREIGN KEY (`restaurant_id`)
        REFERENCES `restaurant` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_comment` (
    `comment_id`        int             not null,       -- PRIMARY KEY
    `account_id`        int             not null,       -- FOREIGN KEY
    `restaurant_id`     int             not null,       -- FOREIGN KEY
    `title`             varchar(255)    not null,
    `date_of_visit`     varchar(255)    not null,
    `dining_method`     varchar(255)    not null,
    `content`           text            not null,
    `taste_rating`      tinyint         not null,
    `environment_rating`tinyint         not null,
    `service_rating`    tinyint         not null,
    `hygiene_rating`    tinyint         not null,
    `create_datetime`   datetime        not null,
    `status`            tinyint         not null,       -- FOREIGN KEY
    PRIMARY KEY (`comment_id`),
    INDEX (`account_id`),
    INDEX (`restaurant_id`),
    INDEX (`status`),

    FOREIGN KEY (`account_id`)
        REFERENCES `account` (`account_id`),
    FOREIGN KEY (`restaurant_id`)
        REFERENCES `restaurant` (`restaurant_id`),
    FOREIGN KEY (`status`)
        REFERENCES `comment_status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `restaurant_comment`
    MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `cuisine_list`(
    `cuisine_id`    int             not null,   -- PRIMARY KEY
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`cuisine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_type_list`(
    `type_id`       int             not null,   -- PRIMARY KEY
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_equipment_list`(
    `equipment_id`  int             not null,   -- PRIMARY KEY
    `zh-hk`         varchar(255)    not null,
    `en`            varchar(255)    not null,
    PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_payment_method` (
    `restaurant_id`     int          not null,       -- FOREIGN KEY
    `method_id`         int          not null,       -- FOREIGN KEY
    INDEX (`restaurant_id`),
    INDEX (`method_id`),

    FOREIGN KEY (`restaurant_id`)
        REFERENCES `restaurant` (`restaurant_id`),
    FOREIGN KEY (`method_id`)
        REFERENCES `payment_method_list` (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_cuisine` (
    `restaurant_id`     int          not null,       -- FOREIGN KEY
    `cuisine_id`        int          not null,       -- FOREIGN KEY
    INDEX (`restaurant_id`),
    INDEX (`cuisine_id`),

    FOREIGN KEY (`restaurant_id`)
        REFERENCES `restaurant` (`restaurant_id`),
    FOREIGN KEY (`cuisine_id`)
        REFERENCES `cuisine_list` (`cuisine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_type` (
    `restaurant_id`     int          not null,       -- FOREIGN KEY
    `type_id`           int          not null,       -- FOREIGN KEY
    INDEX (`restaurant_id`),
    INDEX (`type_id`),

    FOREIGN KEY (`restaurant_id`)
        REFERENCES `restaurant` (`restaurant_id`),
    FOREIGN KEY (`type_id`)
        REFERENCES `restaurant_type_list` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_equipment` (
    `restaurant_id`     int          not null,       -- FOREIGN KEY
    `equipment_id`      int          not null,       -- FOREIGN KEY
    INDEX (`restaurant_id`),
    INDEX (`equipment_id`),

    FOREIGN KEY (`restaurant_id`)
        REFERENCES `restaurant` (`restaurant_id`),
    FOREIGN KEY (`equipment_id`)
        REFERENCES `restaurant_equipment_list` (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `partner_request_status`(
    `status_id`     tinyint             not null,   -- PRIMARY KEY
    `zh-hk`         varchar(255)        not null,
    `en`            varchar(255)        not null,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_partner_request`(
    `request_id`                int             not null,   -- PRIMARY KEY
    `restaurant_chinese_name`   varchar(255)    null,
    `restaurant_english_name`   varchar(255)    null,
    `district`                  int             not null,
    `chinese_address`           varchar(255)    not null,
    `english_address`           varchar(255)    not null,
    `restaurant_phone_number`   varchar(8)      not null,
    `number_of_seats`           int             not null,
    `weekday_business_hours`    varchar(255)    not null,
    `weekend_business_hours`    varchar(255)    not null,
    `holiday_business_hours`    varchar(255)    not null,
    `contact_email`             varchar(255)    not null,
    `contact_name`              varchar(255)    not null,
    `submit_datetime`           datetime        not null,
    `response_datetime`         datetime        null,
    `status`                    tinyint         not null,   -- FOREIGN KEY
    `responder_staff_id`        int             null,       -- FOREIGN KEY
    `partner_id`                int             null,       -- FOREIGN KEY
    PRIMARY KEY (`request_id`),
    INDEX (`status`),
    INDEX (`responder_staff_id`),
    INDEX (`partner_id`),

    FOREIGN KEY (`status`)
        REFERENCES `partner_request_status` (`status_id`),
    FOREIGN KEY (`responder_staff_id`)
        REFERENCES `account` (`account_id`),
    FOREIGN KEY (`partner_id`)
        REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `restaurant_partner_request`
    MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

CREATE TABLE `restaurant_partner_request_payment_method`(
    `request_id`    int             not null,   -- FOREIGN KEY
    `method_id`     int             not null,   -- FOREIGN KEY
    INDEX (`request_id`),
    INDEX (`method_id`),

    FOREIGN KEY (`request_id`)
        REFERENCES `restaurant_partner_request` (`request_id`),
    FOREIGN KEY (`method_id`)
        REFERENCES `payment_method_list` (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_partner_request_cuisine`(
    `request_id`    int             not null,   -- FOREIGN KEY
    `cuisine_id`    int             not null,   -- FOREIGN KEY
    INDEX (`request_id`),
    INDEX (`cuisine_id`),

    FOREIGN KEY (`request_id`)
        REFERENCES `restaurant_partner_request` (`request_id`),
    FOREIGN KEY (`cuisine_id`)
        REFERENCES `cuisine_list` (`cuisine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_partner_request_type`(
    `request_id`    int             not null,   -- FOREIGN KEY
    `type_id`       int             not null,   -- FOREIGN KEY
    INDEX (`request_id`),
    INDEX (`type_id`),

    FOREIGN KEY (`request_id`)
        REFERENCES `restaurant_partner_request` (`request_id`),
    FOREIGN KEY (`type_id`)
        REFERENCES `restaurant_type_list` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_partner_request_equipment`(
    `request_id`    int             not null,   -- FOREIGN KEY
    `equipment_id`  int             not null,   -- FOREIGN KEY
    INDEX (`request_id`),
    INDEX (`equipment_id`),

    FOREIGN KEY (`request_id`)
        REFERENCES `restaurant_partner_request` (`request_id`),
    FOREIGN KEY (`equipment_id`)
        REFERENCES `restaurant_equipment_list` (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `worker_application_status`(
    `status_id`     tinyint             not null,   -- PRIMARY KEY
    `zh-hk`         varchar(255)        not null,
    `en`            varchar(255)        not null,
    PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `driver_application`(
    `id`                    int             not null,
    `chinese_firstname`     varchar(255)    not null,
    `chinese_lastname`      varchar(255)    not null,
    `birth_year`            varchar(4)      not null,
    `birth_month`           varchar(2)      not null,
    `hkid`                  varchar(255)    not null,
    `phone_number`          varchar(255)    not null,
    `email`                 varchar(255)    not null,
    `seat`                  int             not null,
    `license_plate_number`  varchar(255)    not null,
    `status`                tinyint         not null,
    `responder_staff_id`    int             null,
    `worker_id`             int             null,
    `submit_datetime`       datetime        not null,
    PRIMARY KEY (`id`),
    INDEX (`status`),
    INDEX (`responder_staff_id`),
    INDEX (`worker_id`),

    FOREIGN KEY (`status`)
        REFERENCES `worker_application_status` (`status_id`),
    FOREIGN KEY (`responder_staff_id`)
        REFERENCES `account` (`account_id`),
    FOREIGN KEY (`worker_id`)
        REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `driver_application`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

CREATE TABLE `tourist_guide_application` (
  `id` int not null,
  `chinese_firstname` varchar(255) not null,
  `chinese_lastname` varchar(255) not null,
  `birth_year` varchar(4) not null,
  `birth_month` varchar(2) not null,
  `hkid` varchar(255) not null,
  `tgid` varchar(255) not null,
  `phone_number` varchar(255) not null,
  `email` varchar(255) not null,
  `status` tinyint(4) not null,
  `responder_staff_id` int null,
  `worker_id` int null,
  `submit_datetime` datetime not null,
  PRIMARY KEY (`id`),
  INDEX (`status`),
  INDEX (`responder_staff_id`),
  INDEX (`worker_id`),

  FOREIGN KEY (`status`)
      REFERENCES `worker_application_status` (`status_id`),
  FOREIGN KEY (`responder_staff_id`)
      REFERENCES `account` (`account_id`),
  FOREIGN KEY (`worker_id`)
      REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tourist_guide_application`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

CREATE TABLE `discovery_status_list` (
  `id`    tinyint       not null,
  `zh-hk` varchar(255)  not null,
  `en`    varchar(255)  not null,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_discover` (
  `id`                      int(11) NOT NULL,
  `attraction_chinese_name` varchar(255) NOT NULL,
  `attraction_english_name` varchar(255) NOT NULL,
  `district`                int(4) NOT NULL,
  `chinese_address`         text NOT NULL,
  `english_address`         text NOT NULL,
  `weekday_business_hours`  varchar(255) NOT NULL,
  `weekend_business_hours`  varchar(255) NOT NULL,
  `holiday_business_hours`  varchar(255) NOT NULL,
  `website`                 varchar(255) NOT NULL,
  `email`                   varchar(255) NOT NULL,
  `phone_number`            varchar(8) NOT NULL,
  `submit_date`             datetime NOT NULL,
  `status`                  tinyint NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`district`),
  INDEX (`status`),

  FOREIGN KEY (`district`)
    REFERENCES `hong_kong_district` (`district_id`),
  FOREIGN KEY (`status`)
    REFERENCES `discovery_status_list` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `attraction_discover`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `attraction_discover_payment_method` (
  `id`        int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  INDEX (`id`),
  INDEX (`method_id`),

  FOREIGN KEY (`id`)
    REFERENCES `attraction_discover` (`id`),
  FOREIGN KEY (`method_id`)
    REFERENCES `payment_method_list` (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_discover_type` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  INDEX (`id`),
  INDEX (`type_id`),

  FOREIGN KEY (`id`)
    REFERENCES `attraction_discover` (`id`),
  FOREIGN KEY (`type_id`)
    REFERENCES `attraction_type_list` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_discover` (
  `id`                      int(11) NOT NULL,
  `restaurant_chinese_name` varchar(255) NOT NULL,
  `restaurant_english_name` varchar(255) NOT NULL,
  `district`                int(4) NOT NULL,
  `chinese_address`         text NOT NULL,
  `english_address`         text NOT NULL,
  `number_of_seats`         int(11) NOT NULL,	
  `weekday_business_hours`  varchar(255) NOT NULL,
  `weekend_business_hours`  varchar(255) NOT NULL,
  `holiday_business_hours`  varchar(255) NOT NULL,
  `email`                   varchar(255) NOT NULL,
  `phone_number`            varchar(8) NOT NULL,
  `submit_date`             datetime NOT NULL,
  `status`                  tinyint NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`district`),
  INDEX (`status`),

  FOREIGN KEY (`district`)
    REFERENCES `hong_kong_district` (`district_id`),
  FOREIGN KEY (`status`)
    REFERENCES `discovery_status_list` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `restaurant_discover`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `restaurant_discover_payment_method` (
  `id`        int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  INDEX (`id`),
  INDEX (`method_id`),

  FOREIGN KEY (`id`)
    REFERENCES `restaurant_discover` (`id`),
  FOREIGN KEY (`method_id`)
    REFERENCES `payment_method_list` (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_discover_type` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  INDEX (`id`),
  INDEX (`type_id`),

  FOREIGN KEY (`id`)
    REFERENCES `restaurant_discover` (`id`),
  FOREIGN KEY (`type_id`)
    REFERENCES `restaurant_type_list` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_discover_cuisine` (
  `id` int(11) NOT NULL,
  `cuisine_id` int(11) NOT NULL,
  INDEX (`id`),
  INDEX (`cuisine_id`),

  FOREIGN KEY (`id`)
    REFERENCES `restaurant_discover` (`id`),
  FOREIGN KEY (`cuisine_id`)
    REFERENCES `cuisine_list` (`cuisine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `itinerary_status` (
  `status_id` int(4) NOT NULL,
  `zh-hk` varchar(255) NOT NULL,
  `en` varchar(255) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `itinerary` (
  `itinerary_id` int(11) NOT NULL,
  `create_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(4) NOT NULL,
  `account_id` int(11) NOT NULL,
  `itinerary_chinese_name` varchar(255) DEFAULT NULL,
  `itinerary_english_name` varchar(255) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`itinerary_id`),
  ADD KEY `account_id` (`account_id`);

ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

ALTER TABLE `itinerary`
  MODIFY `itinerary_id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `itinerary_schedule` (
  `itinerary_id` int(11) NOT NULL,
  `attraction_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  INDEX (`itinerary_id`),
  INDEX (`attraction_id`),

  FOREIGN KEY (`itinerary_id`)
    REFERENCES `itinerary` (`itinerary_id`),
  FOREIGN KEY (`attraction_id`)
    REFERENCES `attraction` (`attraction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `booking_status` (
  `status_id`     tinyint       not null,
  `zh-hk`         varchar(255)  not null,
  `en`            varchar(255)  not null,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `itinerary_booking` (
  `booking_id`        int           NOT NULL,
  `itinerary_id`      int           NOT NULL,
  `account_id`        int           NOT NULL,
  `drive_service`     tinyint       NOT NULL,
  `tourguide_service` tinyint       NOT NULL,
  `start_date`        date          NOT NULL,
  `start_time`        time          NOT NULL,
  `people_num`        int           NOT NULL,
  `start_address`     varchar(255)  NOT NULL,
  `end_address`       varchar(255)  NOT NULL,
  `status`            tinyint       NOT NULL,
  `driver_id`         int           NULL,
  `tourguide_id`      int           NULL,
  `create_datetime`   datetime      NULL,
  `complete_datetime` DATETIME      NULL,
  PRIMARY KEY (`booking_id`),
  INDEX (`itinerary_id`),
  INDEX (`account_id`),
  INDEX (`status`),
  INDEX (`driver_id`),
  INDEX (`tourguide_id`),

  FOREIGN KEY (`itinerary_id`)
    REFERENCES `itinerary` (`itinerary_id`),
  FOREIGN KEY (`account_id`)
    REFERENCES `account` (`account_id`),
  FOREIGN KEY (`status`)
    REFERENCES `booking_status` (`status_id`),
  FOREIGN KEY (`driver_id`)
    REFERENCES `account` (`account_id`),
  FOREIGN KEY (`tourguide_id`)
    REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `itinerary_booking`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `tour_guide_booking_record` (
  `booking_id`  int   NOT NULL,
  `account_id`  int   NOT NULL,
  PRIMARY KEY (`booking_id`),
  INDEX (`booking_id`),
  INDEX (`account_id`),

  FOREIGN KEY (`booking_id`)
    REFERENCES `itinerary_booking` (`booking_id`),
  FOREIGN KEY (`account_id`)
    REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attraction_hit_count` (
  `attraction_id`   int   NOT NULL,
  `date`            date  NOT NULL,
  `count`           int   NOT NULL,
  PRIMARY KEY (`attraction_id`),
  INDEX (`attraction_id`),

  FOREIGN KEY (`attraction_id`)
    REFERENCES `attraction` (`attraction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restaurant_hit_count` (
  `restaurant_id`   int   NOT NULL,
  `date`            date  NOT NULL,
  `count`           int   NOT NULL,
  PRIMARY KEY (`restaurant_id`),
  INDEX (`restaurant_id`),

  FOREIGN KEY (`restaurant_id`)
    REFERENCES `restaurant` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `guesthouse` (
  `guesthouse_id` int(11) NOT NULL,
  `guesthouse_chinese_name` varchar(255) DEFAULT NULL,
  `guesthouse_english_name` varchar(255) DEFAULT NULL,
  `district` int(4) NOT NULL,
  `chinese_address` text NOT NULL,
  `english_address` text NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `phone_number` varchar(8) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number_of_rooms` int(11) NOT NULL,
  `weekday_business_hours` varchar(255) NOT NULL,
  `weekend_business_hours` varchar(255) NOT NULL,
  `holiday_business_hours` varchar(255) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `partner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_comment` (
  `comment_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `guesthouse_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_of_visit` varchar(255) NOT NULL,
  `dining_method` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `taste_rating` tinyint(4) NOT NULL,
  `environment_rating` tinyint(4) NOT NULL,
  `service_rating` tinyint(4) NOT NULL,
  `hygiene_rating` tinyint(4) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_discover` (
  `id` int(11) NOT NULL,
  `guesthouse_chinese_name` varchar(255) NOT NULL,
  `guesthouse_english_name` varchar(255) NOT NULL,
  `district` int(4) NOT NULL,
  `chinese_address` text NOT NULL,
  `english_address` text NOT NULL,
  `number_of_rooms` int(11) NOT NULL,
  `weekday_business_hours` varchar(255) NOT NULL,
  `weekend_business_hours` varchar(255) NOT NULL,
  `holiday_business_hours` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(8) NOT NULL,
  `submit_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_discover_payment_method` (
  `id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_equipment` (
  `guesthouse_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_equipment_list` (
  `equipment_id` int(11) NOT NULL,
  `zh-hk` varchar(255) NOT NULL,
  `en` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_partner_request` (
  `request_id` int(10) NOT NULL,
  `guesthouse_chinese_name` varchar(255) DEFAULT NULL,
  `guesthouse_english_name` varchar(255) DEFAULT NULL,
  `district` int(4) NOT NULL,
  `chinese_address` varchar(255) NOT NULL,
  `english_address` varchar(255) NOT NULL,
  `guesthouse_phone_number` varchar(8) NOT NULL,
  `guesthouse_email` varchar(255) NOT NULL,
  `number_of_rooms` int(11) NOT NULL,
  `weekday_business_hours` varchar(255) NOT NULL,
  `weekend_business_hours` varchar(255) NOT NULL,
  `holiday_business_hours` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `submit_datetime` datetime NOT NULL,
  `response_datetime` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `responder_staff_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_partner_request_equipment` (
  `request_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_partner_request_payment_method` (
  `request_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_payment_method` (
  `guesthouse_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_photo` (
  `photo_id` int(11) NOT NULL,
  `guesthouse_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guesthouse_status` (
  `status_id` tinyint(4) NOT NULL,
  `zh-hk` varchar(255) NOT NULL,
  `en` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `guesthouse`
  ADD PRIMARY KEY (`guesthouse_id`),
  ADD KEY `district` (`district`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `status` (`status`);

ALTER TABLE `guesthouse_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `status` (`status`),
  ADD KEY `guesthouse_id` (`guesthouse_id`),
  ADD KEY `account_id` (`account_id`);

ALTER TABLE `guesthouse_discover`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district` (`district`),
  ADD KEY `status` (`status`);

ALTER TABLE `guesthouse_discover_payment_method`
  ADD KEY `id` (`id`),
  ADD KEY `method_id` (`method_id`);

ALTER TABLE `guesthouse_equipment`
  ADD KEY `guesthouse_id` (`guesthouse_id`),
  ADD KEY `equipment_id` (`equipment_id`);

ALTER TABLE `guesthouse_equipment_list`
  ADD PRIMARY KEY (`equipment_id`);

ALTER TABLE `guesthouse_partner_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `district` (`district`),
  ADD KEY `status` (`status`),
  ADD KEY `responder_staff_id` (`responder_staff_id`),
  ADD KEY `partner_id` (`partner_id`);

ALTER TABLE `guesthouse_partner_request_equipment`
  ADD KEY `equipment_id` (`equipment_id`),
  ADD KEY `request_id` (`request_id`);

ALTER TABLE `guesthouse_partner_request_payment_method`
  ADD KEY `method_id` (`method_id`),
  ADD KEY `request_id` (`request_id`);

ALTER TABLE `guesthouse_payment_method`
  ADD KEY `guesthouse_id` (`guesthouse_id`),
  ADD KEY `method_id` (`method_id`);

ALTER TABLE `guesthouse_photo`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `guesthouse_id` (`guesthouse_id`);

ALTER TABLE `guesthouse_status`
  ADD PRIMARY KEY (`status_id`);

ALTER TABLE `guesthouse`
  MODIFY `guesthouse_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `guesthouse_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `guesthouse_discover`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `guesthouse_partner_request`
  MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `guesthouse`
  ADD CONSTRAINT `guesthouse_ibfk_1` FOREIGN KEY (`district`) REFERENCES `hong_kong_district` (`district_id`),
  ADD CONSTRAINT `guesthouse_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `account` (`account_id`),
  ADD CONSTRAINT `guesthouse_ibfk_3` FOREIGN KEY (`status`) REFERENCES `guesthouse_status` (`status_id`);

ALTER TABLE `guesthouse_comment`
  ADD CONSTRAINT `guesthouse_comment_ibfk_1` FOREIGN KEY (`status`) REFERENCES `comment_status` (`status_id`),
  ADD CONSTRAINT `guesthouse_comment_ibfk_2` FOREIGN KEY (`guesthouse_id`) REFERENCES `guesthouse` (`guesthouse_id`),
  ADD CONSTRAINT `guesthouse_comment_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

ALTER TABLE `guesthouse_discover`
  ADD CONSTRAINT `guesthouse_discover_ibfk_1` FOREIGN KEY (`district`) REFERENCES `hong_kong_district` (`district_id`),
  ADD CONSTRAINT `guesthouse_discover_ibfk_2` FOREIGN KEY (`status`) REFERENCES `discovery_status_list` (`id`);

ALTER TABLE `guesthouse_discover_payment_method`
  ADD CONSTRAINT `guesthouse_discover_payment_method_ibfk_1` FOREIGN KEY (`id`) REFERENCES `guesthouse_discover` (`id`),
  ADD CONSTRAINT `guesthouse_discover_payment_method_ibfk_2` FOREIGN KEY (`method_id`) REFERENCES `payment_method_list` (`method_id`);

ALTER TABLE `guesthouse_equipment`
  ADD CONSTRAINT `guesthouse_equipment_ibfk_1` FOREIGN KEY (`guesthouse_id`) REFERENCES `guesthouse` (`guesthouse_id`),
  ADD CONSTRAINT `guesthouse_equipment_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `guesthouse_equipment_list` (`equipment_id`);

ALTER TABLE `guesthouse_partner_request`
  ADD CONSTRAINT `guesthouse_partner_request_ibfk_1` FOREIGN KEY (`district`) REFERENCES `hong_kong_district` (`district_id`),
  ADD CONSTRAINT `guesthouse_partner_request_ibfk_2` FOREIGN KEY (`status`) REFERENCES `partner_request_status` (`status_id`),
  ADD CONSTRAINT `guesthouse_partner_request_ibfk_3` FOREIGN KEY (`responder_staff_id`) REFERENCES `account` (`account_id`),
  ADD CONSTRAINT `guesthouse_partner_request_ibfk_4` FOREIGN KEY (`partner_id`) REFERENCES `account` (`account_id`);

ALTER TABLE `guesthouse_partner_request_equipment`
  ADD CONSTRAINT `guesthouse_partner_request_equipment_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `guesthouse_equipment_list` (`equipment_id`),
  ADD CONSTRAINT `guesthouse_partner_request_equipment_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `guesthouse_partner_request` (`request_id`);

ALTER TABLE `guesthouse_partner_request_payment_method`
  ADD CONSTRAINT `guesthouse_partner_request_payment_method_ibfk_1` FOREIGN KEY (`method_id`) REFERENCES `payment_method_list` (`method_id`),
  ADD CONSTRAINT `guesthouse_partner_request_payment_method_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `guesthouse_partner_request` (`request_id`);

ALTER TABLE `guesthouse_payment_method`
  ADD CONSTRAINT `guesthouse_payment_method_ibfk_1` FOREIGN KEY (`guesthouse_id`) REFERENCES `guesthouse` (`guesthouse_id`),
  ADD CONSTRAINT `guesthouse_payment_method_ibfk_2` FOREIGN KEY (`method_id`) REFERENCES `payment_method_list` (`method_id`);

ALTER TABLE `guesthouse_photo`
  ADD CONSTRAINT `guesthouse_photo_ibfk_1` FOREIGN KEY (`guesthouse_id`) REFERENCES `guesthouse` (`guesthouse_id`);

CREATE TABLE `user_attraction_log` (
  `id`  int   NOT NULL,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `time` datetime NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `custom_weight` int NULL,
  PRIMARY KEY (`id`),
  INDEX (`user_id`),
  INDEX (`item_id`),

  FOREIGN KEY (`user_id`)
    REFERENCES `account` (`account_id`),
  FOREIGN KEY (`item_id`)
    REFERENCES `attraction` (`attraction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `user_attraction_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `user_restaurant_log` (
  `id`  int   NOT NULL,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `time` datetime NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `custom_weight` int NULL,
  PRIMARY KEY (`id`),
  INDEX (`user_id`),
  INDEX (`item_id`),

  FOREIGN KEY (`user_id`)
    REFERENCES `account` (`account_id`),
  FOREIGN KEY (`item_id`)
    REFERENCES `restaurant` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `user_restaurant_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `user_guesthouse_log` (
  `id`  int   NOT NULL,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `time` datetime NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `custom_weight` int NULL,
  PRIMARY KEY (`id`),
  INDEX (`user_id`),
  INDEX (`item_id`),

  FOREIGN KEY (`user_id`)
    REFERENCES `account` (`account_id`),
  FOREIGN KEY (`item_id`)
    REFERENCES `guesthouse` (`guesthouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `user_guesthouse_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `restaurant_booking` (
  `booking_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `people` varchar(11) NOT NULL,
  `booking_subject` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone` varchar(8) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `create_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `complete_datetime` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 0,
  `table` text null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `restaurant_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `status` (`status`);

ALTER TABLE `restaurant_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `restaurant_booking`
  ADD CONSTRAINT `restaurant_booking_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`),
  ADD CONSTRAINT `restaurant_booking_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`),
  ADD CONSTRAINT `restaurant_booking_ibfk_3` FOREIGN KEY (`status`) REFERENCES `booking_status` (`status_id`);

CREATE TABLE `restaurant_layout` (
  `restaurant_id` int(11) NOT NULL,
  `r_id` int(5) NOT NULL,
  `position` text NOT NULL,
  `timeInterval` int(3) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `restaurant_layout`
  ADD PRIMARY KEY (`restaurant_id`);

CREATE TABLE `guesthouse_booking` (
  `booking_id` int(11) NOT NULL,
  `guesthouse_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `room` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone` varchar(8) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `create_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `complete_datetime` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `guesthouse_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `guesthouse_id` (`guesthouse_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `status` (`status`);

ALTER TABLE `guesthouse_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `guesthouse_booking`
  ADD CONSTRAINT `guesthouse_booking_ibfk_1` FOREIGN KEY (`guesthouse_id`) REFERENCES `guesthouse` (`guesthouse_id`),
  ADD CONSTRAINT `guesthouse_booking_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`),
  ADD CONSTRAINT `guesthouse_booking_ibfk_3` FOREIGN KEY (`status`) REFERENCES `booking_status` (`status_id`);

CREATE TABLE `tourguide_tourgroup` (
  `tourgroup_id` int(11) NOT NULL,
  `itinerary_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `fee` double NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `max_people` int(11) NOT NULL,
  `start_address` varchar(255) NOT NULL,
  `end_address` varchar(255) NOT NULL,
  `joined_people` int(11) NOT NULL,
  `status` int(4) NOT NULL,
  `create_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL DEFAULT current_timestamp(),
  `cutoff_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tourguide_tourgroup`
  ADD PRIMARY KEY (`tourgroup_id`),
  ADD KEY `itinerary_id` (`itinerary_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `status` (`status`);

ALTER TABLE `tourguide_tourgroup`
  MODIFY `tourgroup_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tourguide_tourgroup`
  ADD CONSTRAINT `tourguide_tourgroup_ibfk_1` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary` (`itinerary_id`),
  ADD CONSTRAINT `tourguide_tourgroup_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`),
  ADD CONSTRAINT `tourguide_tourgroup_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `itinerary_booking` (`booking_id`),
  ADD CONSTRAINT `tourguide_tourgroup_ibfk_4` FOREIGN KEY (`status`) REFERENCES `itinerary_status` (`status_id`);

CREATE TABLE `tourgroup_member` (
  `tourgroup_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `num_people` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tourgroup_member`
  ADD KEY `tourgroup_id` (`tourgroup_id`),
  ADD KEY `account_id` (`account_id`);

ALTER TABLE `tourgroup_member`
  ADD CONSTRAINT `tourgroup_member_ibfk_1` FOREIGN KEY (`tourgroup_id`) REFERENCES `tourguide_tourgroup` (`tourgroup_id`),
  ADD CONSTRAINT `tourgroup_member_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

USE travelhk;

INSERT INTO `account_type` (
  `type_id`,
  `zh-hk`,
  `en`) VALUES
('0', '管理員', 'Administrator'),
('1', '普通用戶', 'General'),
('2', '餐廳管理員', 'Restaurant'),
('3', '民宿管理員', 'Guesthouse'),
('4', '導遊', 'Tourist Guide'),
('5', '司機', 'Driver');


INSERT INTO `account_status` (
  `status_id`,
  `zh-hk`,
  `en`
) VALUES
('0', '已凍結', 'Freezed'),
('1', '正常', 'Normal'),
('2', '已刪除', 'Deleted');


INSERT INTO `partner_request_status` (
  `status_id`,
  `zh-hk`,
  `en`
) VALUES
('1', '已提交', 'Submitted'),
('2', '審核中', 'Under Review'),
('3', '審核通過', 'Approved'),
('4', '已完成', 'Completed'),
('5', '拒絕',   'Rejected');


INSERT INTO `payment_method_list` (
  `method_id`,
  `zh-hk`,
  `en`) VALUES
('0', '其他', 'Other'),
('1', 'Visa', 'Visa'),
('2', 'Master', 'Master'),
('3', 'AMEX', 'AMEX'),
('4', '現金', 'Cash'),
('5', 'Apple Pay', 'Apple Pay'),
('6', 'Google Pay', 'Google Pay'),
('7', '支付寶', 'Alipay'),
('8', '微信支付', 'WeChat Pay');


INSERT INTO `cuisine_list` (
  `cuisine_id`,
  `zh-hk`,
  `en`) VALUES
('0', '其他', 'Other'),
('1', '港式', 'Hong Kong Style'),
('2', '中菜', 'Chinese'),
('3', '台灣菜', 'Taiwanese'),
('4', '日本菜', 'Japanese'),
('5', '韓國菜', 'Korean'),
('6', '泰國菜', 'Thai'),
('7', '意大利菜', 'Italian'),
('8', '法國菜', 'French'),
('9', '多國菜', 'Multinational');


INSERT INTO `restaurant_type_list` (
  `type_id`,
  `zh-hk`,
  `en`) VALUES
('0', '其他', 'Other'),
('1', '自助餐', 'Buffet'),
('2', '中式食品', 'Chinese Food'),
('3', '日韓食品', 'Japanese Korean Food'),
('4', '火鍋', 'Hot Pot'),
('5', '甜品', 'Dessert'),
('6', '扒房', 'Steak House'),
('7', '燒烤', 'BBQ'),
('8', '薄餅', 'Pizza'),
('9', '私房菜', 'Private Kitchen'),
('10', '咖喱', 'Curry'),
('11', '快餐', 'Fast Food'),
('12', '酒吧', 'Bar');

INSERT INTO `restaurant_status` (
  `status_id`,
  `zh-hk`,
  `en`
) VALUES
(0, '隱藏', 'Hidden'),
(1, '營業中', 'Open'),
(2, '已結業', 'Closed');

INSERT INTO `restaurant_equipment_list` (
  `equipment_id`,
  `zh-hk`,
  `en`) VALUES
('0', '其他', 'Other'),
('1', 'Wi-Fi', 'Wi-Fi');

INSERT INTO `guesthouse_equipment_list` (`equipment_id`, `zh-hk`, `en`) VALUES
(0, '其他', 'Other'),
(1, 'Wi-Fi', 'Wi-Fi');

INSERT INTO `guesthouse_status` (`status_id`, `zh-hk`, `en`) VALUES
(0, '隱藏', 'Hidden'),
(1, '營業中', 'Open'),
(2, '已結業', 'Closed');

INSERT INTO `hong_kong_region` (
  `region_id`,
  `zh-hk`,
  `en`) VALUES
('1', '香港島', 'Hong Kong Island'),
('2', '九龍', 'Kowloon'),
('3', '新界', 'New Territories'),
('4', '離島', 'Islands');


INSERT INTO `hong_kong_district` (
  `district_id`,
  `region_id`,
  `zh-hk`,
  `en`,
  `latitude`,
  `longitude`) VALUES
-- ID    Region_ID   zh-hk        en             Latitude            Longitude --
('1001',    '1',    '金鐘',   'Admiralty',      '22.279248',        '114.164944'),
('1002',    '1',    '鴨脷洲', 'Ap Lei Chau',    '22.240246',        '114.153271'),
('1003',    '1',    '香港仔', 'Aberdeen',       '22.250653',        '114.148464'),
('1004',    '1',    '銅鑼灣', 'Causeway Bay',   '22.2802708611615', '114.183965921402'),
('1005',    '1',    '中環',   'Central',        '22.281035',        '114.15885'),
('1006',    '1',    '柴灣',   'Chai Wan',       '22.264872',        '114.239573'),
('1007',    '1',    '深水灣', 'Deep Water Bay', '22.23965',         '114.190006'),
('1008',    '1',    '跑馬地', 'Happy Valley',   '22.268526',        '114.186444'),
('1009',    '1',    '杏花邨', 'Heng Fa Chuen',  '22.2767861512954', '114.239273071289'),
('1010',    '1',    '半山',   'Mid-levels',     '22.280519',        '114.14825'),
('1011',    '1',    '北角',   'North Point',    '22.2914',          '114.200735'),
('1012',    '1',    '薄扶林', 'Pokfulam',       '22.268843',        '114.131513'),
('1013',    '1',    '鰂魚涌', 'Quarry Bay',     '22.288739',        '114.21037'),
('1014',    '1',    '淺水灣', 'Repulse Bay',    '22.236909',        '114.198332'),
('1015',    '1',    '西環',   'Sai Wan',        '22.286833',        '114.140482'),
('1016',    '1',    '西灣河', 'Sai Wan Ho',     '22.281909',        '114.222922'),
('1017',    '1',    '筲箕灣', 'Shau Kei Wan',   '22.277302',        '114.231806'),
('1018',    '1',    '石澳',   'Shek O',         '22.237545',        '114.238243'),
('1019',    '1',    '上環',   'Sheung Wan',     '22.286992',        '114.15164'),
('1020',    '1',    '赤柱',   'Stanley',        '22.219668',        '114.209146'),
('1021',    '1',    '大坑',   'Tai Hang',       '22.2784639854031', '114.191915988922'),
('1022',    '1',    '太古',   'Tai Koo',        '22.285733',        '114.217431'),
('1023',    '1',    '山頂',   'The Peak',       '22.271425',        '114.149666'),
('1024',    '1',    '天后',   'Tin Hau',        '22.2825740975104', '114.192087650299'),
('1025',    '1',    '灣仔',   'Wan Chai',       '22.277759',        '114.173076'),
('1026',    '1',    '黃竹坑', 'Wong Chuk Hang', '22.2459198',       '114.1664957'),
('2001',    '2',    '牛頭角', 'Ngau Tau Kok',   '22.317565',        '114.217601'),
('2002',    '2',    '長沙灣', 'Cheung Sha Wan', '22.3355479798467', '114.155716896057'),
('2003',    '2',    '彩虹',   'Choi Hung',      '22.3344166511554', '114.212086200714'),
('2004',    '2',    '鑽石山', 'Diamond Hill',   '22.342018',        '114.201207'),
('2005',    '2',    '何文田', 'Ho Man Tin',     '22.313356',        '114.179835'),
('2006',    '2',    '紅磡',   'Hung Hom',       '22.304741',        '114.187946'),
('2007',    '2',    '佐敦',   'Jordan',         '22.305178',        '114.171638'),
('2008',    '2',    '九龍灣', 'Kowloon Bay',    '22.32344',         '114.211464'),
('2009',    '2',    '九龍城', 'Kowloon City',   '22.330308',        '114.193182'),
('2010',    '2',    '九龍塘', 'Kowloon Tong',   '22.337533',        '114.178548'),
('2011',    '2',    '觀塘',   'Kwun Tong',      '22.312801',        '114.225798'),
('2012',    '2',    '荔枝角', 'Lai Chi Kok',    '22.336937',        '114.145246'),
('2013',    '2',    '藍田',   'Lam Tin',        '22.309307',        '114.233565'),
('2014',    '2',    '鯉魚門', 'Lei Yue Mun',    '22.296085',        '114.238071'),
('2015',    '2',    '樂富',   'Lok Fu',         '22.338128',        '114.18756'),
('2016',    '2',    '美孚',   'Mei Foo',        '22.3375724398611', '114.140117168426'),
('2017',    '2',    '旺角',   'Mong Kok',       '22.318716',        '114.169579'),
('2018',    '2',    '太子',   'Prince Edward',  '22.324552',        '114.167991'),
('2019',    '2',    '新蒲崗', 'San Po Kong',    '22.337215',        '114.195457'),
('2020',    '2',    '深水埗', 'Sham Shui Po',   '22.330983',        '114.16224'),
('2021',    '2',    '石硤尾', 'Shek Kip Mei',   '22.333662',        '114.167819'),
('2022',    '2',    '大角咀', 'Tai Kok Tsui',   '22.321535',        '114.162669'),
('2023',    '2',    '土瓜灣', 'To Kwa Wan',     '22.31558',         '22.31558'),
('2024',    '2',    '尖沙咀', 'Tsim Sha Tsui',  '22.299381',        '114.172111'),
('2025',    '2',    '慈雲山', 'Tsz Wan Shan',   '22.348806',        '114.196744'),
('2026',    '2',    '黃大仙', 'Wong Tai Sin',   '22.341979',        '114.194512'),
('2027',    '2',    '油麻地', 'Yau Ma Tei',     '22.313277',        '114.170566'),
('2028',    '2',    '油塘',   'Yau Tong',       '22.296462',        '114.237556'),
('3001',    '3',    '粉嶺',   'Fanling',        '22.493209',        '114.139366'),
('3002',    '3',    '火炭',   'Fo Tan',         '22.3952373474545', '114.198160171508'),
('3003',    '3',    '葵涌',   'Kwai Chung',     '22.362776',        '114.131985'),
('3004',    '3',    '葵芳',   'Kwai Fong',      '22.3566644303792', '114.12790775299'),
('3005',    '3',    '流浮山', 'Lau Fau Shan',   '22.4675128926014', '113.984484672546'),
('3006',    '3',    '羅湖',   'Lo Wu',          '22.5276212360402', '114.113359451293'),
('3007',    '3',    '落馬洲', 'Lok Ma Chau',    '22.507244',        '114.079714'),
('3008',    '3',    '馬鞍山', 'Ma On Shan',     '22.407537',        '114.225883'),
('3009',    '3',    '馬灣',   'Ma Wan',         '22.348171',        '114.059029'),
('3010',    '3',    '西貢',   'Sai Kung',       '22.379167',        '114.268069'),
('3011',    '3',    '沙田',   'Sha Tin',        '22.3816666142371', '114.189147949219'),
('3012',    '3',    '深井',   'Sham Tseng',     '22.36738',         '114.054909'),
('3013',    '3',    '上水',   'Sheung Shui',    '22.503438',        '114.126492'),
('3014',    '3',    '大埔',   'Tai Po',         '22.450538',        '114.164643'),
('3015',    '3',    '大圍',   'Tai Wai',        '22.373002',        '114.178584'),
('3016',    '3',    '太和',   'Tai Wo',         '22.452085105425',  '114.160737991333'),
('3017',    '3',    '天水圍', 'Tin Shui Wai',   '22.462397',        '114.001436'),
('3018',    '3',    '將軍澳', 'Tseung Kwan O',  '22.311252',        '114.258928'),
('3019',    '3',    '青衣',   'Tsing Yi',       '22.350552',        '114.101686'),
('3020',    '3',    '荃灣',   'Tsuen Wan',      '22.358966',        '114.119196'),
('3021',    '3',    '屯門',   'Tuen Mun',       '22.395396',        '113.973627'),
('3022',    '3',    '元朗',   'Yuen Long',      '22.440741',        '114.015899'),
('4001',    '4',    '赤鱲角', 'Chek Lap Kok',   '22.304423',        '113.937321'),
('4002',    '4',    '長洲',   'Cheung Chau',    '22.210689',        '114.028945'),
('4003',    '4',    '愉景灣', 'Discovery Bay',  '22.29545',         '114.016242'),
('4004',    '4',    '南丫島', 'Lamma Island',   '22.207113',        '114.124947'),
('4005',    '4',    '大嶼山', 'Lantau Island',  '22.260821',        '113.949165'),
('4006',    '4',    '坪洲',   'Peng Chau',      '22.285721',        '114.040618'),
('4007',    '4',    '蒲苔島', 'Po Toi Island',  '22.1699193514979', '114.262447357177'),
('4008',    '4',    '大澳',   'Tai O',          '22.255244',        '113.859815'),
('4009',    '4',    '東涌',   'Tung Chung',     '22.2898111751485', '113.940839767456');

INSERT INTO `attraction_status` (
  `status_id`,
  `zh-hk`,
  `en`
) VALUES
(0, '隱藏', 'Hidden'),
(1, '公開', 'Public');

INSERT INTO `attraction_type_list` (
  `type_id`,
  `zh-hk`,
  `en`
) VALUES
(0, '其他', 'Other'),
(1, '公園', 'Park'),
(2, '行山', 'Hiking'),
(3, '歷史古蹟', 'Historical Landmark'),
(4, '廟宇', 'Temple'),
(5, '主題樂園', 'Theme Park'),
(6, '博物館', 'Museum'),
(7, '沙灘', 'Beach'),
(8, '運動', 'Sport'),
(9, '風景', 'Landscape');

INSERT INTO `attraction_equipment_list` (
  `equipment_id`,
  `zh-hk`,
  `en`) VALUES
('0', '其他', 'Other'),
('1', 'Wi-Fi', 'Wi-Fi');

INSERT INTO `comment_status` (
  `status_id`,
  `zh-hk`,
  `en`) VALUES
('0', '隱藏', 'Hidden'),
('1', '公開', 'Public'),
('2', '刪除', 'Deleted'),
('3', '凍結', 'Freezed');

INSERT INTO `worker_application_status` (
  `status_id`,
  `zh-hk`,
  `en`) VALUES
('1', '已提交', 'Submitted'),
('2', '審核中', 'Under Review'),
('3', '審核通過', 'Approved'),
('4', '已完成', 'Completed'),
('5', '拒絕',   'Rejected');

INSERT INTO `discovery_status_list` (
  `id`,
  `zh-hk`,
  `en`) VALUES
(1, '審核中', 'Under Review'),
(2, '審核通過', 'Approved'),
(3, '拒絕', 'Rejected');

INSERT INTO `account` 
  (`account_id`,
  `email`,
  `password`,
  `firstname`,
  `lastname`,
  `nickname`,
  `gender`,
  `phone_number`,
  `birth_year`,
  `birth_month`,
  `icon_path`,
  `type_id`,
  `status`,
  `registration_time`) VALUES
(1, 'admin@travelhk.com', 'admin', 'Admin', 'Admin', 'Administrator', 'm', '', '1901', '1', '', 0, 1, '1950-01-01 00:00:00'),
(1000, 'test@gmail.com', '1234', 'TesterFirstname', 'TesterLastname', 'Tester', 'm', '', '2000', '11', '', 1, 1, '2022-01-01 00:00:00');

INSERT INTO `restaurant`
  (`restaurant_chinese_name`,
  `restaurant_english_name`,
  `district`,
  `chinese_address`,
  `english_address`,
  `latitude`,
  `longitude`,
  `phone_number`,
  `email`,
  `number_of_seats`,
  `weekday_business_hours`,
  `weekend_business_hours`,
  `holiday_business_hours`,
  `create_datetime`,
  `status`,
  `partner_id`) VALUES
('新樂園魚蛋粉', 'Sun Lok Yuen', 3010, '將軍澳調景嶺彩明街1號彩明商場2樓265號舖', 'Shop 265, 2/F, Choi Ming Shopping Centre, 1 Choi Ming Street, Tiu Keng Leng, Tseung Kwan O', 22.3067341, 114.252298, '21781333', '', 60, '07:00 - 00:00', '07:00 - 00:00', '07:00 - 00:00', NOW(), 1, null),
('吉豚屋吉列豬扒專門店', 'Ca-Tu-Ya', 3010, '將軍澳調景嶺彩明街1號彩明商場2樓247-248號舖', 'Shop 247-248, 2/F, Choi Ming Shopping Centre, 1 Choi Ming Street, Tiu Keng Leng, Tseung Kwan O', 22.305797, 114.251334, '23666392', '', '60', '11:30 - 22:30', '11:30 - 22:30', '11:30 - 22:30', NOW(), 1, null),
('宏富雲南米線', '', 3010, '將軍澳調景嶺彩明街1號彩明街市72-73號舖', 'Shop 72-73, 1/F, Choi Ming Market, 1 Choi Ming Street, Tiu Keng Leng, Tseung Kwan O', 22.3062622, 114.2524104, '27250268', '', 40, '08:00 - 20:00', '08:00 - 20:00', '08:00 - 20:00',  NOW(), 1, null),
('一碗肉燥 (調景嶺)', 'Taiwan Bowl (Tiu Keng Leng)', 3010, '將軍澳調景嶺景嶺路8號都會駅2樓R04號舖', 'Shop R04, 2/F, Metro Town, 8 King Ling Road, Tiu Keng Leng, Tseung Kwan O', 22.3049429, 114.2518906, '28564023', '', 50, '11:30 - 21:00', '08:00 - 21:00', '08:00 - 21:00', NOW(), 1, null),
('紅茶冰室', 'Red Tea Cafe', 2011, '觀塘駿業街56號中海日升中心地下', 'G/F, COS Centre, 56 Tsun Yip Street, Kwun Tong', 22.3112472, 114.2225736, '55322338', '', 150, '07:00 - 23:00', '07:00 - 23:00', '07:00 - 23:00', NOW(), 1, null),
('光榮冰室 (福昌大廈)', '', 2011, '觀塘開源道63號福昌大廈地下A11號舖', 'Shop A11, G/F, Fook Cheong Building, 63 Hoi Yuen Road, Kwun Tong', 22.310794, 114.2247003, '54878240', '', 40, '07:00 - 19:00', '07:00 - 19:00', '07:00 - 19:00', NOW(), 1, null);

INSERT INTO `restaurant_cuisine` (
  `restaurant_id`,
  `cuisine_id`) VALUES
(1001, 1),
(1001, 2),
(1002, 4),
(1003, 2),
(1004, 2),
(1005, 1),
(1005, 2),
(1005, 3),
(1005, 4),
(1005, 5),
(1006, 1),
(1006, 2);

INSERT INTO `restaurant_type` (
  `restaurant_id`,
  `type_id`) VALUES
(1001, 2),
(1002, 3),
(1003, 2),
(1004, 2),
(1005, 2),
(1005, 11),
(1006, 2),
(1006, 11);

INSERT INTO `restaurant_payment_method` (
  `restaurant_id`,
  `method_id`) VALUES
(1001, 4),
(1002, 1),
(1002, 2),
(1002, 3),
(1002, 4),
(1002, 5),
(1002, 6),
(1002, 7),
(1002, 8),
(1003, 4),
(1004, 1),
(1004, 2),
(1004, 3),
(1004, 4),
(1004, 5),
(1004, 6),
(1004, 7),
(1004, 8),
(1005, 4),
(1005, 5),
(1005, 6),
(1005, 7),
(1005, 8),
(1006, 4);

INSERT INTO `attraction`
  (`attraction_chinese_name`,
  `attraction_english_name`,
  `description`,
  `district`,
  `chinese_address`,
  `english_address`,
  `phone_number`,
  `website`,
  `email`,
  `weekday_business_hours`,
  `weekend_business_hours`,
  `holiday_business_hours`,
  `latitude`,
  `longitude`,
  `create_datetime`,
  `status`) VALUES
('海洋公園', 'Ocean Park', '', 1026, '香港海洋公園 香港仔黃竹坑道一百八十號', 'Ocean Park Hong Kong, 180 Wong Chuk Hang Road, Aberdeen, Hong Kong', '39232323', 'https://www.oceanpark.com.hk', 'gr@oceanpark.com.hk', '10:00 - 18:00', '10:00 - 19:00', '10:00 - 19:00', 22.2393815, 114.1629856, NOW(), 1),
('香港迪士尼樂園', 'Hong Kong Disneyland Park', '', 4005, '香港大嶼山香港迪士尼樂園度假區', "Hong Kong Disneyland Resort, Penny's Bay, Lantau Island, Hong Kong", '35503388', 'https://www.hongkongdisneyland.com', 'information@hongkongdisneyland.com', '10:30 - 19:30', '10:30 - 20:30', '10:30 - 20:30', 22.3129666, 114.0412819, NOW(), 1),
('昂坪360', 'Ngong Ping 360', '', 4005, '香港大嶼山東涌達東路11號', '11 Tat Tung Road, Tung Chung, Lantau, Hong Kong ', '36660606', 'https://www.np360.com.hk/', 'info@np360.com.hk', '10:00 - 18:00', '10:00 - 18:00', '10:00 - 18:00', 22.2563163, 113.9014163, NOW(), 1),
('香港太空館', 'Hong Kong Space Museum', '', 2024, '尖沙咀梳士巴利道10號', '10 Salisbury Road, Tsim Sha Tsui, Kowloon, Hong Kong', '27210226', 'https://hk.space.museum/', 'hkspm@lcsd.gov.hk', '13:00 - 21:00', '10:00 - 21:00', '10:00 - 21:00', 22.294288, 114.1697123, NOW(), 1);

INSERT INTO `attraction_type`(
    `attraction_id`,
    `type_id`
) VALUES
(1001, 5),
(1002, 5),
(1003, 9),
(1004, 6);

INSERT INTO `itinerary_status` (`status_id`, `zh-hk`, `en`) VALUES
(0, '已儲存', 'Draft'),
(1, '待處理', 'Wait for processing'),
(2, '已完成', 'Completed'),
(3, '已取消', 'Canceled'),
(4, '公開', 'Public'),
(5, '隱藏', 'Hidden');

INSERT INTO `booking_status` (`status_id`, `zh-hk`, `en`) VALUES
(0, '待處理', 'Wait for processing'),
(1, '處理中', 'Processing'),
(2, '已完成', 'Completed'),
(3, '已取消', 'Canceled');