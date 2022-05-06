/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`category_id`, `category_title`) VALUES
	(1, 'General'),
	(2, 'Utility'),
	(3, 'Minor Repair'),
	(4, 'Major Repair');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `country_code` (`country_code`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_code`) REFERENCES `country` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` (`city_id`, `city_name`, `country_code`) VALUES
	(1, 'Bath', 'UK'),
	(2, 'Birmingham', 'UK'),
	(3, 'Bradford', 'UK'),
	(4, 'Brighton and Hove', 'UK'),
	(5, 'Bristol', 'UK'),
	(6, 'Cambridge', 'UK'),
	(7, 'Canterbury', 'UK'),
	(8, 'Carlisle', 'UK'),
	(9, 'Chelmsford', 'UK'),
	(10, 'Chester', 'UK'),
	(11, 'Chichester', 'UK'),
	(12, 'Coventry', 'UK'),
	(13, 'Derby', 'UK'),
	(14, 'Durham', 'UK'),
	(15, 'Ely', 'UK'),
	(16, 'Exeter', 'UK'),
	(17, 'Gloucester', 'UK'),
	(18, 'Hereford', 'UK'),
	(19, 'Kingston upon Hull', 'UK'),
	(20, 'Lancaster', 'UK'),
	(21, 'Leeds', 'UK'),
	(22, 'Leicester', 'UK'),
	(23, 'Lichfield', 'UK'),
	(24, 'Lincoln', 'UK'),
	(25, 'Liverpool', 'UK'),
	(26, 'London', 'UK'),
	(27, 'Manchester', 'UK'),
	(28, 'Newcastle upon Tyne', 'UK'),
	(29, 'Norwich', 'UK'),
	(30, 'Nottingham', 'UK'),
	(31, 'Oxford', 'UK'),
	(32, 'Peterborough', 'UK'),
	(33, 'Plymouth', 'UK'),
	(34, 'Portsmouth', 'UK'),
	(35, 'Preston', 'UK'),
	(36, 'Ripon', 'UK'),
	(37, 'Salford', 'UK'),
	(38, 'Salisbury', 'UK'),
	(39, 'Sheffield', 'UK'),
	(40, 'Southampton', 'UK'),
	(41, 'St Albans', 'UK'),
	(42, 'Stoke-on-Trent', 'UK'),
	(43, 'Sunderland', 'UK'),
	(44, 'Truro', 'UK'),
	(45, 'Wakefield', 'UK'),
	(46, 'Wells', 'UK'),
	(47, 'Westminster', 'UK'),
	(48, 'Winchester', 'UK'),
	(49, 'Wolverhampton', 'UK'),
	(50, 'Worcester', 'UK'),
	(51, 'York', 'UK');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `country` (
  `country_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`country_code`, `country_name`) VALUES
	('AD', 'Andorra'),
	('AE', 'United Arab Emirates'),
	('AF', 'Afghanistan'),
	('AG', 'Antigua and Barbuda'),
	('AI', 'Anguilla'),
	('AL', 'Albania'),
	('AM', 'Armenia'),
	('AN', 'Antilles - Netherlands'),
	('AO', 'Angola'),
	('AQ', 'Antarctica'),
	('AR', 'Argentina'),
	('AS', 'American Samoa'),
	('AT', 'Austria'),
	('AU', 'Australia'),
	('AW', 'Aruba'),
	('AX', 'Aland Islands'),
	('AZ', 'Azerbaijan'),
	('BA', 'Bosnia and Herzegovina'),
	('BB', 'Barbados'),
	('BD', 'Bangladesh'),
	('BE', 'Belgium'),
	('BF', 'Burkina Faso'),
	('BG', 'Bulgaria'),
	('BH', 'Bahrain'),
	('BI', 'Burundi'),
	('BJ', 'Benin'),
	('BM', 'Bermuda'),
	('BN', 'Brunei Darussalam'),
	('BO', 'Bolivia'),
	('BR', 'Brazil'),
	('BS', 'Bahamas'),
	('BT', 'Bhutan'),
	('BV', 'Bouvet Island'),
	('BW', 'Botswana'),
	('BZ', 'Belize'),
	('CA', 'Canada'),
	('CC', 'Cocos (Keeling) Islands'),
	('CD', 'Democratic Republic of the Congo'),
	('CF', 'Central African Republic'),
	('CG', 'Congo'),
	('CH', 'Switzerland'),
	('CI', 'Cote DIvoire (Ivory Coast)'),
	('CK', 'Cook Islands'),
	('CL', 'Chile'),
	('CM', 'Cameroon'),
	('CN', 'China'),
	('CO', 'Colombia'),
	('CR', 'Costa Rica'),
	('CS', 'Serbia and Montenegro'),
	('CU', 'Cuba'),
	('CV', 'Cape Verde'),
	('CX', 'Christmas Island'),
	('CY', 'Cyprus'),
	('CZ', 'Czech Republic'),
	('DE', 'Germany (Deutschland)'),
	('DJ', 'Djibouti'),
	('DK', 'Denmark'),
	('DM', 'Dominica'),
	('DO', 'Dominican Republic'),
	('DZ', 'Algeria'),
	('EC', 'Ecuador'),
	('EE', 'Estonia'),
	('EG', 'Egypt'),
	('EH', 'Western Sahara'),
	('ER', 'Eritrea'),
	('ES', 'Spain'),
	('ET', 'Ethiopia'),
	('FI', 'Finland'),
	('FJ', 'Fiji'),
	('FK', 'Falkland Islands (Malvinas)'),
	('FM', 'Federated States of Micronesia'),
	('FO', 'Faroe Islands'),
	('FR', 'France'),
	('FX', 'France, Metropolitan'),
	('GA', 'Gabon'),
	('GB', 'Great Britain (UK)'),
	('GD', 'Grenada'),
	('GE', 'Georgia'),
	('GF', 'French Guiana'),
	('GH', 'Ghana'),
	('GI', 'Gibraltar'),
	('GL', 'Greenland'),
	('GM', 'Gambia'),
	('GN', 'Guinea'),
	('GP', 'Guadeloupe'),
	('GQ', 'Equatorial Guinea'),
	('GR', 'Greece'),
	('GS', 'S. Georgia and S. Sandwich Islands'),
	('GT', 'Guatemala'),
	('GU', 'Guam'),
	('GW', 'Guinea-Bissau'),
	('GY', 'Guyana'),
	('HK', 'Hong Kong'),
	('HM', 'Heard Island and McDonald Islands'),
	('HN', 'Honduras'),
	('HR', 'Croatia (Hrvatska)'),
	('HT', 'Haiti'),
	('HU', 'Hungary'),
	('ID', 'Indonesia'),
	('IE', 'Ireland'),
	('IL', 'Israel'),
	('IN', 'India'),
	('IO', 'British Indian Ocean Territory'),
	('IQ', 'Iraq'),
	('IR', 'Iran'),
	('IT', 'Italy'),
	('JM', 'Jamaica'),
	('JO', 'Jordan'),
	('JP', 'Japan'),
	('KE', 'Kenya'),
	('KG', 'Kyrgyzstan'),
	('KH', 'Cambodia'),
	('KI', 'Kiribati'),
	('KM', 'Comoros'),
	('KN', 'Saint Kitts and Nevis'),
	('KP', 'Korea (North)'),
	('KR', 'Korea (South)'),
	('KW', 'Kuwait'),
	('KY', 'Cayman Islands'),
	('KZ', 'Kazakhstan'),
	('LA', 'Laos'),
	('LB', 'Lebanon'),
	('LC', 'Saint Lucia'),
	('LI', 'Liechtenstein'),
	('LK', 'Sri Lanka'),
	('LR', 'Liberia'),
	('LS', 'Lesotho'),
	('LT', 'Lithuania'),
	('LU', 'Luxembourg'),
	('LV', 'Latvia'),
	('LY', 'Libya'),
	('MA', 'Morocco'),
	('MC', 'Monaco'),
	('MD', 'Moldova'),
	('MG', 'Madagascar'),
	('MH', 'Marshall Islands'),
	('MK', 'Macedonia'),
	('ML', 'Mali'),
	('MM', 'Myanmar'),
	('MN', 'Mongolia'),
	('MO', 'Macao'),
	('MP', 'Northern Mariana Islands'),
	('MQ', 'Martinique'),
	('MR', 'Mauritania'),
	('MS', 'Montserrat'),
	('MT', 'Malta'),
	('MU', 'Mauritius'),
	('MV', 'Maldives'),
	('MW', 'Malawi'),
	('MX', 'Mexico'),
	('MY', 'Malaysia'),
	('MZ', 'Mozambique'),
	('NA', 'Namibia'),
	('NC', 'New Caledonia'),
	('NE', 'Niger'),
	('NF', 'Norfolk Island'),
	('NG', 'Nigeria'),
	('NI', 'Nicaragua'),
	('NL', 'Netherlands'),
	('NO', 'Norway'),
	('NP', 'Nepal'),
	('NR', 'Nauru'),
	('NU', 'Niue'),
	('NZ', 'New Zealand (Aotearoa)'),
	('OM', 'Oman'),
	('PA', 'Panama'),
	('PE', 'Peru'),
	('PF', 'French Polynesia'),
	('PG', 'Papua New Guinea'),
	('PH', 'Philippines'),
	('PK', 'Pakistan'),
	('PL', 'Poland'),
	('PM', 'Saint Pierre and Miquelon'),
	('PN', 'Pitcairn'),
	('PR', 'Puerto Rico'),
	('PS', 'Palestinian Territory'),
	('PT', 'Portugal'),
	('PW', 'Palau'),
	('PY', 'Paraguay'),
	('QA', 'Qatar'),
	('RE', 'Reunion'),
	('RO', 'Romania'),
	('RU', 'Russian Federation'),
	('RW', 'Rwanda'),
	('SA', 'Saudi Arabia'),
	('SB', 'Solomon Islands'),
	('SC', 'Seychelles'),
	('SD', 'Sudan'),
	('SE', 'Sweden'),
	('SG', 'Singapore'),
	('SH', 'Saint Helena'),
	('SI', 'Slovenia'),
	('SJ', 'Svalbard and Jan Mayen'),
	('SK', 'Slovakia'),
	('SL', 'Sierra Leone'),
	('SM', 'San Marino'),
	('SN', 'Senegal'),
	('SO', 'Somalia'),
	('SR', 'Suriname'),
	('ST', 'Sao Tome and Principe'),
	('SU', 'USSR (former)'),
	('SV', 'El Salvador'),
	('SY', 'Syria'),
	('SZ', 'Swaziland'),
	('TC', 'Turks and Caicos Islands'),
	('TD', 'Chad'),
	('TG', 'Togo'),
	('TH', 'Thailand'),
	('TJ', 'Tajikistan'),
	('TK', 'Tokelau'),
	('TL', 'Timor-Leste'),
	('TM', 'Turkmenistan'),
	('TN', 'Tunisia'),
	('TO', 'Tonga'),
	('TP', 'East Timor'),
	('TR', 'Turkey'),
	('TT', 'Trinidad and Tobago'),
	('TV', 'Tuvalu'),
	('TW', 'Taiwan'),
	('TZ', 'Tanzania'),
	('UA', 'Ukraine'),
	('UG', 'Uganda'),
	('UK', 'United Kingdom'),
	('UM', 'United States Minor Outlying Islands'),
	('US', 'United States'),
	('UY', 'Uruguay'),
	('UZ', 'Uzbekistan'),
	('VA', 'Vatican City State'),
	('VC', 'Saint Vincent and the Grenadines'),
	('VE', 'Venezuela'),
	('VG', 'Virgin Islands (British)'),
	('VI', 'Virgin Islands (U.S.)'),
	('VN', 'Viet Nam'),
	('VU', 'Vanuatu'),
	('WF', 'Wallis and Futuna'),
	('WS', 'Samoa'),
	('YE', 'Yemen'),
	('YT', 'Mayotte'),
	('YU', 'Yugoslavia (former)'),
	('ZA', 'South Africa'),
	('ZM', 'Zambia'),
	('ZR', 'Zaire (former)'),
	('ZW', 'Zimbabwe');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `property` (
  `property_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `property_type_id` int(11) DEFAULT NULL,
  `property_description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `floor_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `property_sqft` int(11) DEFAULT NULL,
  `rent_per_month` decimal(10,2) DEFAULT NULL,
  `property_status` enum('AVAILABLE','RENTED','ONHOLD') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`property_id`),
  KEY `owner_id` (`owner_id`),
  KEY `property_type_id` (`property_type_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `property_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `property_ibfk_2` FOREIGN KEY (`property_type_id`) REFERENCES `property_type` (`property_type_id`),
  CONSTRAINT `property_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` (`property_id`, `owner_id`, `property_type_id`, `property_description`, `property_number`, `floor_number`, `building_name`, `address`, `city_id`, `property_sqft`, `rent_per_month`, `property_status`) VALUES
	(1, 1, 1, 'Spacious Stduio', '001', '14', NULL, NULL, 44, 256, 512.00, 'RENTED'),
	(2, 5, 2, 'Spacious Apartment', '70', '32', NULL, NULL, 48, 356, 1424.00, 'AVAILABLE'),
	(3, 3, 5, 'Luxury Building', '92', '43', NULL, NULL, 36, 1586, 7930.00, 'AVAILABLE'),
	(4, 1, 5, 'Luxury Building', '80', '19', NULL, NULL, 24, 743, 2972.00, 'AVAILABLE'),
	(5, 5, 5, 'Beautiful Building', '8', '28', NULL, NULL, 17, 1819, 7276.00, 'AVAILABLE'),
	(6, 1, 4, 'Modern Office', '61', '38', NULL, NULL, 22, 1068, 3204.00, 'AVAILABLE'),
	(7, 1, 1, 'Brand New Stduio', '14', '6', NULL, NULL, 38, 184, 920.00, 'AVAILABLE'),
	(8, 3, 2, 'Modern Apartment', '61', '9', NULL, NULL, 43, 780, 3120.00, 'AVAILABLE'),
	(9, 3, 3, 'Modern Villa', '31', '46', NULL, NULL, 23, 692, 3460.00, 'AVAILABLE'),
	(10, 3, 4, 'Brand New Office', '90', '50', NULL, NULL, 44, 1979, 9895.00, 'AVAILABLE'),
	(11, 3, 5, 'Modern Building', '76', '17', NULL, NULL, 23, 1409, 2818.00, 'AVAILABLE'),
	(12, 3, 4, 'Brand New Office', '77', '11', NULL, NULL, 17, 1646, 4938.00, 'AVAILABLE'),
	(13, 3, 5, 'Modern Building', '90', '34', NULL, NULL, 20, 621, 3105.00, 'AVAILABLE'),
	(14, 1, 2, 'Luxury Apartment', '50', '22', NULL, NULL, 15, 491, 1473.00, 'AVAILABLE'),
	(15, 3, 4, 'Spacious Office', '82', '27', NULL, NULL, 14, 1123, 2246.00, 'AVAILABLE'),
	(16, 1, 3, 'Modern Villa', '33', '14', NULL, NULL, 50, 520, 1560.00, 'AVAILABLE'),
	(17, 3, 5, 'Modern Building', '20', '9', NULL, NULL, 25, 1287, 5148.00, 'AVAILABLE'),
	(18, 3, 1, 'Luxury Stduio', '64', '18', NULL, NULL, 30, 476, 952.00, 'AVAILABLE'),
	(19, 5, 2, 'Luxury Apartment', '46', '1', NULL, NULL, 47, 618, 1854.00, 'AVAILABLE'),
	(20, 3, 2, 'Modern Apartment', '31', '48', NULL, NULL, 48, 411, 1644.00, 'AVAILABLE'),
	(26, 1, 4, 'Modern Fully Furnished Office ', '124', NULL, NULL, NULL, 26, 525, 750.00, 'AVAILABLE');
/*!40000 ALTER TABLE `property` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `property_media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL DEFAULT '0',
  `media_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `media_type` enum('IMAGE','DOCUMENT','VIDEO') COLLATE utf8_unicode_ci DEFAULT NULL,
  `media_title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `media_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `is_private` enum('YES','NO') COLLATE utf8_unicode_ci DEFAULT 'NO',
  PRIMARY KEY (`media_id`),
  KEY `fk_property_media_property` (`property_id`),
  CONSTRAINT `fk_property_media_property` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `property_media` DISABLE KEYS */;
INSERT INTO `property_media` (`media_id`, `property_id`, `media_date`, `media_type`, `media_title`, `media_url`, `owner_id`, `is_private`) VALUES
	(13, 1, '2021-11-26 03:49:55', 'IMAGE', 'Aeroplane', '61a013131f61d.jpg', 1, 'YES'),
	(14, 1, '2021-11-26 04:12:52', 'IMAGE', 'Team 1', '61a02b31df9b7.png', 1, 'YES'),
	(15, 2, '2021-11-26 05:13:34', 'IMAGE', 'Outside View', '61a026ae8937a.jpg', 1, 'YES'),
	(16, 2, '2021-11-26 05:15:41', 'IMAGE', 'Inner View', '61a0272d475fb.jpg', 1, 'YES'),
	(17, 3, '2021-11-26 05:22:18', 'IMAGE', 'Living Room', '61a028bae5228.png', 1, 'YES'),
	(18, 3, '2021-11-26 05:23:03', 'IMAGE', 'Dubai', '61a116a0ca1ec.jpg', 1, 'YES'),
	(19, 4, '2021-11-26 05:33:52', 'IMAGE', 'TV Lounge', '61a02b7017972.jpg', 1, 'YES'),
	(20, 4, '2021-11-26 05:35:08', 'IMAGE', 'Living Room', '61a02bbc981d2.jpg', 1, 'YES'),
	(21, 8, '2021-11-26 05:35:26', 'IMAGE', 'TV Lounge', '61a02bce4a2c3.jpg', 1, 'YES'),
	(22, 7, '2021-11-26 05:37:43', 'IMAGE', 'Living Room', '61a02c5734690.jpg', 1, 'YES'),
	(23, 6, '2021-11-26 05:39:26', 'IMAGE', 'Pool View', '61a02cbe884d1.jpg', 1, 'YES'),
	(24, 14, '2021-11-26 05:40:34', 'IMAGE', 'Outside View', '61a02d020ce69.jpg', 1, 'YES'),
	(25, 19, '2021-11-26 05:41:42', 'IMAGE', 'Office', '61a02d4625912.jpg', 1, 'YES'),
	(26, 18, '2021-11-26 05:42:20', 'IMAGE', 'Reception', '61a02d6c168f6.jpg', 1, 'YES'),
	(27, 20, '2021-11-26 22:09:48', 'IMAGE', 'Outside View', '61a114dc896bf.jpg', 1, 'NO'),
	(29, 9, '2021-11-26 22:11:10', 'VIDEO', 'Map', '61a1152eca325.mp4', 1, 'YES'),
	(31, 9, '2022-05-03 05:22:34', 'IMAGE', 'test', '627075ca11a2b.png', 1, 'YES');
/*!40000 ALTER TABLE `property_media` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `property_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_text` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `property_id` (`property_id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`),
  CONSTRAINT `property_message_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`),
  CONSTRAINT `property_message_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `property_message_ibfk_3` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `property_message` DISABLE KEYS */;
INSERT INTO `property_message` (`message_id`, `property_id`, `sender_id`, `recipient_id`, `message_date`, `message_text`) VALUES
	(1, 2, 1, 5, '2022-05-04 01:14:08', 'Hi, I am interested to rent out this property, but can we negotiate the rental a bit?'),
	(2, 2, 2, 5, '2022-05-04 01:39:23', 'Hi, when can we visit the property.'),
	(7, 2, 5, 2, '2022-05-04 05:04:10', 'Yes you can visit this Sunday between 1pm and 5pm. Please confirm your eta.'),
	(8, 2, 5, 1, '2022-05-04 05:08:08', 'Hi David, We have recently renovated the house. The price is not flexible, sorry.'),
	(10, 8, 1, 3, '2022-05-04 08:10:02', 'Hello, How many bedrooms this apartment has?'),
	(11, 2, 2, 5, '2022-05-04 08:11:01', 'That\'s great. We will be there at 3pm. '),
	(12, 2, 5, 2, '2022-05-04 08:12:09', 'Alright, I will be looking forward to see you. '),
	(14, 2, 2, 5, '2022-05-04 08:29:34', 'Can you please send us the driving directions?'),
	(15, 2, 5, 2, '2022-05-04 08:29:58', 'Yes, they are available on the detail page.'),
	(16, 2, 2, 5, '2022-05-04 08:38:45', 'Thanks'),
	(17, 19, 1, 5, '2022-05-04 08:47:39', 'Hi, I can also consider this property.'),
	(18, 2, 5, 2, '2022-05-04 09:01:29', 'Great'),
	(19, 1, 2, 1, '2022-05-04 16:42:01', 'Hello,, we want to visit the property.'),
	(20, 1, 1, 2, '2022-05-04 16:48:21', 'You can come anytime, building watchman will show you the property. ');
/*!40000 ALTER TABLE `property_message` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `property_note` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `note_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`note_id`),
  KEY `user_id` (`user_id`),
  KEY `fk_note_property` (`property_id`),
  CONSTRAINT `fk_note_property` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  CONSTRAINT `property_note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `property_note` DISABLE KEYS */;
INSERT INTO `property_note` (`note_id`, `property_id`, `user_id`, `note_date`, `note_text`) VALUES
	(5, 1, 1, '2021-11-26 03:53:33', 'A simple text note'),
	(6, 2, 1, '2021-11-26 04:13:07', 'A wonderful office'),
	(8, 1, 1, '2021-11-26 22:12:59', '<h5>Important</h5>\r\nVery important notice.');
/*!40000 ALTER TABLE `property_note` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `property_type` (
  `property_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_type_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`property_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `property_type` DISABLE KEYS */;
INSERT INTO `property_type` (`property_type_id`, `property_type_name`) VALUES
	(1, 'Studio'),
	(2, 'Apartment'),
	(3, 'Villa'),
	(4, 'Office'),
	(5, 'Building'),
	(6, 'Yard'),
	(7, 'Warehouse');
/*!40000 ALTER TABLE `property_type` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `tenancy` (
  `tenancy_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `tenancy_date` date NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `rent_per_month` decimal(10,2) DEFAULT NULL,
  `tenancy_status` enum('DRAFT','ACTIVE','VOID') COLLATE utf8_unicode_ci DEFAULT 'DRAFT',
  PRIMARY KEY (`tenancy_id`),
  KEY `property_id` (`property_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `tenancy_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`),
  CONSTRAINT `tenancy_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `tenancy` DISABLE KEYS */;
INSERT INTO `tenancy` (`tenancy_id`, `property_id`, `tenancy_date`, `tenant_id`, `start_date`, `end_date`, `rent_per_month`, `tenancy_status`) VALUES
	(9, 1, '2022-05-04', 2, '2022-05-04', '2023-05-03', 4500.00, 'ACTIVE');
/*!40000 ALTER TABLE `tenancy` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `tenancy_id` int(11) NOT NULL,
  `ticket_date` date NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `ticket_text` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ticket_status` enum('OPEN','CLOSED') COLLATE utf8_unicode_ci DEFAULT 'OPEN',
  PRIMARY KEY (`ticket_id`),
  KEY `tenancy_id` (`tenancy_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`tenancy_id`) REFERENCES `tenancy` (`tenancy_id`),
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` (`ticket_id`, `tenancy_id`, `ticket_date`, `category_id`, `ticket_text`, `ticket_status`) VALUES
	(1, 9, '2022-05-05', 1, 'We need to prepare a land patch for a small garden besides the gate,.', 'CLOSED');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `ticket_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_text` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `ticket_message_ibfk_1` (`ticket_id`),
  KEY `ticket_message_ibfk_2` (`sender_id`),
  CONSTRAINT `ticket_message_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`),
  CONSTRAINT `ticket_message_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `ticket_message` DISABLE KEYS */;
INSERT INTO `ticket_message` (`message_id`, `ticket_id`, `sender_id`, `message_date`, `message_text`) VALUES
	(1, 1, 2, '2022-05-05 03:53:33', 'Can we start the work?'),
	(2, 1, 1, '2022-05-05 03:55:50', 'Please send me cost estimate. '),
	(3, 1, 2, '2022-05-05 04:03:07', 'It would cost around $2000 for preparation and plants.'),
	(4, 1, 1, '2022-05-05 04:05:10', 'The cost is too high. I can arrange the preparation, but I think you should buy the plants at your own cost.  '),
	(5, 1, 2, '2022-05-05 04:06:04', 'We don\'t mind that. But please include the boundary plants in the preparation. We will take care of the rest.'),
	(7, 1, 1, '2022-05-05 04:40:27', 'That\'s alright. Please go ahead.');
/*!40000 ALTER TABLE `ticket_message` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` enum('YES','NO') COLLATE utf8_unicode_ci DEFAULT 'YES',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `user_name`, `email`, `password`, `mobile`, `is_active`) VALUES
	(1, 'David Smith', 'david.smith@mail.com', 'pass123', '2224136680', 'YES'),
	(2, 'Susan Smith', 'susan.smith@mail.com', 'pass123', '5984406678', 'YES'),
	(3, 'David Brown', 'david.brown@mail.com', 'pass123', '4012103760', 'YES'),
	(4, 'Sarah Smith', 'sarah.smith@mail.com', 'pass123', '4261379108', 'YES'),
	(5, 'Sarah Jones', 'sarah.jones@mail.com', 'pass123', '3613100943', 'YES'),
	(6, 'David Jones', 'david.jones@mail.com', 'pass123', '4759995912', 'NO'),
	(7, 'Christine Smith', 'christine.smith@mail.com', 'pass123', '2939826399', 'YES'),
	(8, 'David Williams', 'david.williams@mail.com', 'pass123', '8607470244', 'YES'),
	(9, 'John Smith', 'john.smith@mail.com', 'pass123', '7522033073', 'YES'),
	(10, 'Mary Smith', 'mary.smith@mail.com', 'pass123', '3756986206', 'YES'),
	(11, 'test', 'test@mail.com', 'pass123', '123123', 'YES');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tenancy_after_delete` AFTER DELETE ON `tenancy` FOR EACH ROW BEGIN
	UPDATE property SET property_status = 'AVAILABLE'
	WHERE property_id = OLD.property_id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tenancy_after_insert` AFTER INSERT ON `tenancy` FOR EACH ROW BEGIN
	UPDATE property SET property_status = 'ONHOLD'
	WHERE property_id = NEW.property_id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tenancy_after_update` AFTER UPDATE ON `tenancy` FOR EACH ROW BEGIN
	UPDATE property SET property_status = 'AVAILABLE'
	WHERE property_id = OLD.property_id;
	
	IF(NEW.tenancy_status = 'VOID') THEN
		UPDATE property SET property_status = 'AVAILABLE'
		WHERE property_id = NEW.property_id;
	ELSE
		UPDATE property SET property_status = 'RENTED'
		WHERE property_id = NEW.property_id;
	END IF;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
