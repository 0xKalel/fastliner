-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 12 Juin 2014 à 15:56
-- Version du serveur: 5.5.32-cll-lve
-- Version de PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `alpha`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `picture` varchar(250) NOT NULL,
  `url` varchar(150) NOT NULL,
  `value` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `descriptions`
--

CREATE TABLE IF NOT EXISTS `descriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(140) NOT NULL,
  `idchallenge` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Contenu de la table `descriptions`
--

INSERT INTO `descriptions` (`id`, `description`, `idchallenge`) VALUES
(22, 'Completing this 5 minute challenge will show your friends and family the importance of unplugging!', 6),
(23, '150 is the average number of times we check our phones a day. ABC News', 6),
(24, '112 is the average number of text messages sent and received by teens a day. Mashable', 6),
(25, '75% of people use their cell phone while going to the bathroom.  CBS News', 6),
(26, '9% of people answer their cell phone during sex. Forbes', 6),
(27, 'Although it may sound simple, putting your phone down during dinner is a sign of respect for others.', 7),
(28, 'Ask others about their day. You may find out some interesting stuff.', 7),
(29, 'Share your experiences with others. Its a great way to spark up a conversation with friends and family.', 7),
(30, 'Take your time eating and socialize with friends and family.  You will find you eat less at each meal.', 7),
(31, ' Take a Deep Thoughts break!', 8),
(32, ' aaaaa', 9),
(33, ' sdsddtd', 10),
(34, 'This is a test', 11),
(35, 'T2', 11),
(40, 'Happy 39th', 17),
(41, 'Happy 39th Kyla!', 18);

-- --------------------------------------------------------

--
-- Structure de la table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) NOT NULL,
  `idparticipant` int(10) NOT NULL,
  `friends` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(250) NOT NULL,
  `time` int(250) NOT NULL,
  `url_name` varchar(250) NOT NULL,
  `idchallenge` int(11) NOT NULL,
  `idparticipant` int(240) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `images`
--

INSERT INTO `images` (`id`, `image`, `time`, `url_name`, `idchallenge`, `idparticipant`) VALUES
(1, '5a7a4fdc.jpeg', 10, '5a7a4fdc', 42, 1),
(2, 'cdbe00c5.jpeg', 73, 'cdbe00c5', 83, 2),
(3, 'da202011.jpeg', 77, 'da202011', 42, 3),
(4, 'e94fba7b.jpeg', 15, 'e94fba7b', 42, 4),
(5, '98f32935.jpeg', 337, '98f32935', 42, 5),
(6, 'edbc1939.jpeg', 29, 'edbc1939', 42, 1),
(7, 'c3cd743b.jpeg', 6, 'c3cd743b', 42, 6),
(8, '8f3bd49c.jpeg', 216, '8f3bd49c', 84, 7),
(9, 'c2d62f2a.jpeg', 208, 'c2d62f2a', 85, 8),
(10, 'cf6080ad.jpeg', 266, 'cf6080ad', 86, 9),
(11, 'c42f7fb0.jpeg', 81, 'c42f7fb0', 87, 10),
(12, 'f63f8a75.jpeg', 191, 'f63f8a75', 42, 11),
(13, 'bbd3a33a.jpeg', 53, 'bbd3a33a', 42, 12),
(14, '240a4372.jpeg', 109, '240a4372', 42, 13),
(15, '683c2e73.jpeg', 388, '683c2e73', 42, 14),
(16, 'e0703001.jpeg', 3, 'e0703001', 42, 15),
(17, 'f76b578c.jpeg', 15, 'f76b578c', 42, 15),
(18, 'de083863.jpeg', 15, 'de083863', 42, 15),
(19, '15e32c3a.jpeg', 203, '15e32c3a', 42, 14),
(20, '534521f7.jpeg', 203, '534521f7', 42, 14),
(21, '31e424fb.jpeg', 203, '31e424fb', 42, 14),
(22, '3bb61319.jpeg', 1, '3bb61319', 42, 15),
(23, '7d8cc665.jpeg', 1, '7d8cc665', 42, 15),
(24, 'aaaa145d.jpeg', 3, 'aaaa145d', 42, 16),
(25, '5b11977b.jpeg', 2, '5b11977b', 42, 2),
(26, '3853d4f4.jpeg', 2, '3853d4f4', 42, 2),
(27, '9b67e693.jpeg', 6, '9b67e693', 42, 2),
(28, 'edf91462.jpeg', 2, 'edf91462', 42, 15),
(29, 'c883b02a.jpeg', 2, 'c883b02a', 42, 15),
(30, 'e1b59f8f.jpeg', 2, 'e1b59f8f', 42, 15),
(31, '6d10f6da.jpeg', 58, '6d10f6da', 42, 15),
(32, '81acee94.jpeg', 305, '81acee94', 42, 14),
(33, 'd9324b89.jpeg', 362, 'd9324b89', 42, 14),
(34, '483fbd60.jpeg', 358, '483fbd60', 42, 14),
(35, '1b5ce73d.jpeg', 422, '1b5ce73d', 85, 6),
(36, 'fc37f577.jpeg', 80, 'fc37f577', 42, 6);

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `url_name` varchar(250) NOT NULL,
  `profile_picture` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `participants`
--

INSERT INTO `participants` (`id`, `name`, `url_name`, `profile_picture`) VALUES
(6, 'Chris Henry', 'ChrisHenry', 'https://lh3.googleusercontent.com/-awuESk47dbs/AAAAAAAAAAI/AAAAAAAAQfE/jWlX7Sz72-k/photo.jpg?sz=50'),
(7, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(8, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(9, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(10, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(11, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(12, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(13, 'Chris Henry', 'ChrisHenry', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(14, 'Aaron Lindsay', 'AaronLindsay', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/t1.0-1/c34.34.426.426/s50x50/206784_10150158399206300_1561760_n.jpg'),
(15, 'Monder Rezzag', 'MonderRezzag', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/t1.0-1/c25.25.313.313/s50x50/970623_10200883495962972_1813802555_n.jpg'),
(16, 'Monder Rezzag', 'MonderRezzag', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/t1.0-1/c25.25.313.313/s50x50/970623_10200883495962972_1813802555_n.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challenge_title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `url_title` varchar(250) NOT NULL,
  `sponsor_link` varchar(250) NOT NULL,
  `logo` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Contenu de la table `urls`
--

INSERT INTO `urls` (`id`, `challenge_title`, `description`, `url_title`, `sponsor_link`, `logo`) VALUES
(1, 'none', '', 'none', '', ''),
(32, 'test', 'tttttttt', 'test', 'http://google.com', 'elements/logos/test1400618428.jpg'),
(33, 'test1', 'this is a test', 'test1', 'http://test', 'elements/logos/test11400623389.png'),
(34, 'hamada', 'this is a description', 'hamada', 'http://google.com', 'elements/logos/hamada1400663755.png'),
(35, 'tttt', 'dfd', 'tttt', 'http://sdfd', 'elements/logos/tttt1400664000.png'),
(36, 'abcd', 'qdqd', 'abcd', 'http://qdqsd', 'elements/logos/abcd1400664110.png'),
(37, 'ttttdfzl', 'ljhezfhzf', 'ttttdfzl', 'http://zfzef', 'elements/logos/ttttdfzl1400679493.png'),
(38, 'newtest', 'this is a descriptin', 'newtest', 'http://www.facebook.com/', 'elements/logos/newtest1400697562.jpg'),
(39, 'recode', 'Time to put your phone down and enjoy life', 'recode', 'http://www.recode.net', 'elements/logos/recode1400719351.jpg'),
(40, 'fifa', 'Put your PhoneDown, and support your favorite World Cup team!', 'fifa', 'http://www.fifa.com/worldcup', 'elements/logos/fifa1400721114.jpg'),
(41, 'manu', 'Support Manchester United!', 'manu', 'http://www.manchesterunited.com', 'elements/logos/manu1400722644.jpg'),
(42, 'PhoneDown', 'Visit this page on your Mobile Phone!  We want you to share your experiences when you put your Phone Down.', 'PhoneDown', 'http://www.phonedown.com', 'elements/logos/PhoneDown1400765128.png'),
(43, 'fbtest', 'aaaaaaaaaaaaa', 'fbtest', 'http://', 'elements/logos/fbtest1400860078.jpg'),
(44, 'testface', 'this is chllenge is for testing facebook share', 'testface', 'http://tet', 'elements/logos/testface1401090572.jpg'),
(45, 'testface2', 'this is chllenge is for testing facebook share', 'testface2', 'http://tet', 'elements/logos/testface21401090613.jpg'),
(46, 'testfb2', 'eeeeeeeeeee', 'testfb2', 'http://eee', 'elements/logos/testfb21401090691.jpg'),
(47, 'fbtest1', 'fbtest1 desc', 'fbtest1', 'http://s fbtest1', 'elements/logos/fbtest11401092754.jpg'),
(48, 'fbtest2', 'fbtest2 desc', 'fbtest2', 'http://s fbtest2', 'elements/logos/fbtest21401092847.jpg'),
(49, 'ccc', 'ccc', 'ccc', 'http://ccc', 'elements/logos/ccc1401092994.jpg'),
(50, 'test12', 'khg', 'test12', 'http://hkg', 'elements/logos/test121401199023.jpg'),
(51, 'mcgonigal', 'Challenge yourself to put your PhoneDown!', 'mcgonigal', 'http://www.kellymcgonigal.com', 'elements/logos/mcgonigal1401791860.jpg'),
(52, 'zenhabits', 'Take some time to savor life''s real social experiences, take a Phone Down Challenge today', 'zenhabits', 'http://www.zenhabits.net', 'elements/logos/zenhabits1401927121.jpg'),
(53, 'happinessproject', 'Being happy sometimes means simply savoring life''s simple things (without your phone)', 'happinessproject', 'http://www.gretchenrubin.com', 'elements/logos/happinessproject1401927543.jpg'),
(54, 'essentialism', 'Essentialism - the disciplined pursuit of less, includes periodically putting your phone down to enjoy life', 'essentialism', 'http://gregmckeown.com/', 'elements/logos/essentialism1401966908.jpg'),
(55, 'overwhelmed', 'Overwhelmed is a book about time pressure and modern life. One of the biggest time constraints is our screen time.', 'overwhelmed', 'http://www.brigidschulte.com', 'elements/logos/overwhelmed1401967352.jpg'),
(56, 'powerofhabit', 'Want to enjoy life more, practice the habit of putting your Phone Down!', 'powerofhabit', 'http://charlesduhigg.com/', 'elements/logos/powerofhabit1401967521.jpg'),
(57, 'distractionaddiction', 'Put your Phone Down and increase your focus!', 'distractionaddiction', 'http://www.distractionaddiction.com', 'elements/logos/distractionaddiction1401967648.jpg'),
(58, 'Mashable', 'Mashable wants to know what our readers are doing when they put their phown down.  Share your experiences with us!', 'Mashable', 'http://www.mashable.com', 'elements/logos/Mashable1402041930.jpg'),
(59, 'KellyClay', 'I want to know what your doing when your not reading my blog.  Share your experiences with me!', 'KellyClay', 'http://www.forbes.com/sites/kellyclay/', 'elements/logos/KellyClay1402045097.jpeg'),
(60, 'Test1 Test2', 'Testing', 'Test1Test2', 'http://www.test.com', 'elements/logos/Test1 Test21402046161.PNG'),
(61, 'FDOT District 2', 'We want you to put your Phone Down when Driving! Upload a photo before you get in your car and track the time your phone is down.', 'FDOTDistrict2', 'http://www.nflroads.com/', 'elements/logos/FDOT District 21402046615.jpeg'),
(62, 'testpopup', 'abc ded e cekjkfj', 'testpopup', 'http://azdefzef', 'elements/logos/testpopup1402237602.jpg'),
(63, 'gregmckeown', 'Essentialism - the disciplined pursuit of less, includes periodically putting your phone down to enjoy life', 'gregmckeown', 'http://www.gregmckeown.com', 'elements/logos/gregmckeown1402274483.jpg'),
(64, 'mindfulmanifesto', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'mindfulmanifesto', 'http://www.themindfulmanifesto.com', 'elements/logos/mindfulmanifesto1402275949.jpg'),
(65, 'outsidemag', 'Outside Online wants you to share your offline experiences, including the time spent enjoying nature!', 'outsidemag', 'http://www.outsideonline.com', 'elements/logos/outsidemag1402276932.jpg'),
(66, 'huffpostunplugged', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'huffpostunplugged', 'http://www.huffingtonpost.com/ellie-krupnick/', 'elements/logos/huffpostunplugged1402278277.jpg'),
(67, 'fourhour', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'fourhour', 'http://www.fourhourworkweek.com', 'elements/logos/fourhour1402280216.jpg'),
(68, 'minimalist', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down.', 'minimalist', 'http://www.becomingminimalist.com', 'elements/logos/minimalist1402280863.jpg'),
(69, 'farnamstreet', 'Time to put your Phone Down and enjoy life''s real social experiences', 'farnamstreet', 'http://www.farnamstreetblog.com', 'elements/logos/farnamstreet1402281345.jpg'),
(70, 'artofmanliness', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'artofmanliness', 'http://www.artofmanliness.com', 'elements/logos/artofmanliness1402282029.jpg'),
(71, 'garyarndt', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'garyarndt', 'http://www.everything-everywhere.com', 'elements/logos/garyarndt1402282162.jpg'),
(72, 'travellab', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'travellab', 'http://www.insidethetravellab.com', 'elements/logos/travellab1402282267.jpg'),
(73, 'charliehoehn', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'charliehoehn', 'http://www.charliehoehn.com', 'elements/logos/charliehoehn1402282366.jpg'),
(74, 'itstartswith', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'itstartswith', 'http://www.itstartswith.com', 'elements/logos/itstartswith1402282470.jpg'),
(75, 'AONC', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'AONC', 'http://www.chrisguillebeau.com', 'elements/logos/AONC1402282566.jpg'),
(76, 'contagious', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'contagious', 'http://www.jonahberger.com', 'elements/logos/contagious1402282672.jpg'),
(77, 'carrotsandsticks', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'carrotsandsticks', 'http://islandia.law.yale.edu/ayres/', 'elements/logos/carrotsandsticks1402282781.jpg'),
(78, 'Driving', 'Visit this page on your Mobile Phone! We want you to prove that your not texting and driving.', 'Driving', 'http://www.phonedown.com', 'elements/logos/Driving1402311103.jpg'),
(79, 'hackthesystem', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'hackthesystem', 'http://www.hackthesystem.com', 'elements/logos/hackthesystem1402314654.jpg'),
(80, 'ajjacobs', 'Visit this page on your Mobile Phone! We want you to share your experiences when you put your Phone Down', 'ajjacobs', 'http://www.ajjacobs.com', 'elements/logos/ajjacobs1402315055.jpg'),
(81, 'joshuafoer', 'Put down that Phone and start enjoying life''s real social experiences!', 'joshuafoer', 'http://www.joshuafoer.com', 'elements/logos/joshuafoer1402315705.jpg'),
(82, 'virginiadmv', 'The Virginia DMV wants you to put your PhoneDown, while driving! Take our challenge today!', 'virginiadmv', 'http://www.dmv.state.va.us/', 'elements/logos/virginiadmv1402317526.jpg'),
(83, 'toyotateendriver', 'Toyota Teen Driver wants you to put down your phone when you''re behind the wheel. Arrive safe!', 'toyotateendriver', 'http://www.toyotateendriver.com', 'elements/logos/toyotateendriver1402344093.jpg'),
(84, 'ndteendrivers', 'North Dakota Teen Drivers wants you to put down the phone behind the wheel. Take a PhoneDown challenge', 'ndteendrivers', 'http://https://www.dot.nd.gov/divisions/safety/teens-parents.htm', 'elements/logos/ndteendrivers1402443716.jpeg'),
(85, 'teensafedriving', 'The Safety Center wants you to put your Phone Down while driving. Take our PhoneDown challenge!', 'teensafedriving', 'http://www.safetycenter.org', 'elements/logos/teensafedriving1402444297.jpeg'),
(86, 'drivesmartva', 'Drive Smart Virginia wants you to put down your phone while driving. Take our PhoneDown challenge...', 'drivesmartva', 'http://www.drivesmartva.org', 'elements/logos/drivesmartva1402444903.jpg'),
(87, 'textkills', 'Text Kills wants you to put your Phone Down. Take the challenge on your mobile phone today!', 'textkills', 'http://www.textkills.com', 'elements/logos/textkills1402446000.jpg'),
(88, 'robdelaney', 'Rob Delaney puts his PhoneDown while he smokes marijuana cigarettes. You should too! #Bong', 'robdelaney', 'http://www.robdelaney.com', 'elements/logos/robdelaney1402446784.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
