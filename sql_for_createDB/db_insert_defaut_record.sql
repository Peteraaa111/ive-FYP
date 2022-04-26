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