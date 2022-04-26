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