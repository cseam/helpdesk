CREATE DATABASE  IF NOT EXISTS `helpdesk` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `helpdesk`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: helpdesk
-- ------------------------------------------------------
-- Server version	5.5.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assign_engineers`
--

DROP TABLE IF EXISTS `assign_engineers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assign_engineers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engineerId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idengineers_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assign_engineers`
--

LOCK TABLES `assign_engineers` WRITE;
/*!40000 ALTER TABLE `assign_engineers` DISABLE KEYS */;
INSERT INTO `assign_engineers` VALUES (1,9);
/*!40000 ALTER TABLE `assign_engineers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calls`
--

DROP TABLE IF EXISTS `calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls` (
  `callid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `details` longtext,
  `assigned` int(11) DEFAULT NULL,
  `opened` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `closed` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `urgency` int(11) DEFAULT '2',
  `location` varchar(45) DEFAULT NULL,
  `room` varchar(45) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`callid`),
  UNIQUE KEY `callid_UNIQUE` (`callid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calls`
--

LOCK TABLES `calls` WRITE;
/*!40000 ALTER TABLE `calls` DISABLE KEYS */;
INSERT INTO `calls` VALUES (2,'Honey Drips','address@email.com','123456789','<div class=update>close call <h3>Closed By {EngineerName}, 28/07/14 02:59 </h3></div><div class=update>This is an update <h3>Update By {EngineerName}, 28/07/14 02:55 </h3></div><div class=update>this call has been reopened due to a problem. <h3>Update By {EngineerName}, 28/07/14 02:04 </h3></div><div class=update>this call is now closed <h3>Closed By {EngineerName}, 28/07/14 02:54 </h3></div><div class=update>Chillwave vinyl pour-over, flannel flexitarian mixtape ethnic four loko next level cray. Synth fanny pack hoodie tofu High Life whatever. Dreamcatcher jean shorts fanny pack art party, pour-over mixtape wayfarers cliche ennui readymade Vice Godard. Put a bird on it Truffaut freegan post-ironic farm-to-table, Banksy ethical cred mustache VHS kale chips meh fingerstache shabby chic. Selfies Pinterest farm-to-table street art. Small batch 90\'s Odd Future, food truck beard fap High Life irony brunch Pinterest roof party whatever chambray skateboard butcher. Pop-up put a bird on it Wes Anderson tousled Neutra. <h3>Update By {EngineerName}, 28/07/14 01:15 </h3></div><div class=update>Butcher brunch you probably haven\'t heard of them seitan. Four loko hoodie umami brunch, small batch pug ennui plaid occupy chia. Four loko Pinterest VHS McSweeney\'s narwhal. Four loko Kickstarter High Life McSweeney\'s, vegan fixie kitsch Brooklyn pop-up YOLO occupy. DIY keytar Truffaut, hella Echo Park authentic Kickstarter Wes Anderson 90\'s McSweeney\'s freegan. Banh mi Wes Anderson next level viral. Twee Austin trust fund, Kickstarter meh vegan mustache tattooed. <h3>Update By {EngineerName}, 28/07/14 01:56 </h3></div><div class=update>Cray High Life Schlitz, seitan craft beer raw denim organic selfies vinyl gastropub Wes Anderson banjo flannel. Cardigan beard swag vinyl synth, ethnic mixtape plaid flannel +1 art party skateboard hoodie four loko tote bag. Next level farm-to-table sustainable, chillwave pug flannel Vice. Direct trade pug yr Brooklyn art party, before they sold out Banksy PBR Marfa dreamcatcher Odd Future twee. Cray XOXO banjo church-key, cliche ugh direct trade fap bicycle rights typewriter farm-to-table bespoke you probably haven\'t heard of them lomo. YOLO quinoa aesthetic cliche gentrify. Single-origin coffee yr Tonx Pinterest VHS, authentic try-hard banh mi occupy scenester direct trade. <h3>Update By {EngineerName}, 28/07/14 01:38 </h3></div><div class=update>Try-hard actually typewriter chillwave, organic quinoa yr disrupt. Flexitarian fanny pack gastropub PBR chia. Helvetica blog forage PBR deep v scenester, gentrify lo-fi asymmetrical slow-carb Intelligentsia Odd Future master cleanse flannel letterpress. Tofu VHS readymade cray mlkshk XOXO wolf. Truffaut dreamcatcher Schlitz authentic sriracha messenger bag leggings distillery. Meggings pork belly Tonx selvage forage cardigan. Typewriter ennui freegan, kogi swag direct trade McSweeney\'s cornhole Thundercats put a bird on it street art letterpress. <h3>Update By {EngineerName}, 28/07/14 01:25 </h3></div><div class=original>Wes Anderson mixtape tattooed banjo. Shabby chic pickled Tonx American Apparel. Selfies polaroid keffiyeh banjo, Carles meh artisan Brooklyn mumblecore keytar stumptown fixie. Pinterest Pitchfork fashion axe aesthetic plaid. Try-hard sartorial next level, squid deep v flannel 3 wolf moon photo booth. +1 meggings PBR beard skateboard food truck. Irony gluten-free crucifix hoodie butcher typewriter, High Life Williamsburg polaroid Carles hashtag American Apparel whatever.</div>',8,'2014-07-24 11:26:08','2014-07-28 14:35:59','2014-07-28 14:35:59',2,2,' Main Site ','S117',' option1 '),(4,'Orange Peel','address@email.com','987654321','<div class=original>Retro skateboard church-key bicycle rights. Pug ethnic disrupt, banh mi +1 tote bag Etsy. Brunch viral wayfarers, Marfa food truck Tonx fashion axe Pinterest ennui ugh fingerstache trust fund direct trade. Pinterest fashion axe Intelligentsia plaid brunch. Fashion axe biodiesel cray, art party authentic disrupt blog squid shabby chic Cosby sweater ethnic master cleanse. Lomo whatever pour-over Tonx direct trade artisan. Viral biodiesel readymade chia, scenester bitters umami fanny pack seitan direct trade narwhal bicycle rights.</div>',9,'2014-07-24 12:00:48','2014-07-28 11:45:03',NULL,1,1,' Main Site ','S111',' option1 '),(6,'Apple Juice','address@email.com','222233333','<div class=original>Church-key fixie mixtape synth Austin American Apparel ennui, narwhal viral Thundercats freegan semiotics. Austin McSweeney\'s cardigan church-key, paleo biodiesel authentic ugh cred. DIY lomo Carles single-origin coffee deep v, cred fingerstache viral PBR&amp;B Thundercats kogi. Marfa jean shorts Tonx single-origin coffee, direct trade bicycle rights church-key viral 8-bit twee mlkshk tote bag semiotics. Schlitz Shoreditch Neutra, Vice street art bespoke raw denim four loko Etsy food truck McSweeney\'s 8-bit meh yr. Mustache selvage McSweeney\'s, wolf Brooklyn before they sold out jean shorts Shoreditch post-ironic pour-over whatever banh mi lo-fi PBR&amp;B skateboard. Bespoke meggings seitan vinyl, meh umami lo-fi keytar PBR.\r\n\r\nShoreditch leggings try-hard, mixtape ethical selfies Marfa messenger bag Portland Pitchfork. Small batch raw denim Williamsburg actually, semiotics narwhal iPhone wayfarers ethical craft beer squid cliche fixie direct trade freegan. 90\'s occupy try-hard forage. Seitan chillwave quinoa, dreamcatcher Etsy shabby chic typewriter literally hashtag Echo Park retro Tonx farm-to-table sustainable slow-carb. Gluten-free yr Marfa, bicycle rights Banksy stumptown skateboard semiotics crucifix. Synth small batch messenger bag try-hard. Gluten-free Bushwick ugh sartorial, single-origin coffee ethnic vinyl.\r\n\r\nLetterpress Schlitz Brooklyn chillwave kale chips sustainable, DIY slow-carb pour-over. Pork belly seitan Thundercats, ennui mixtape semiotics Tonx irony PBR messenger bag American Apparel asymmetrical. Narwhal hella banjo freegan quinoa. Small batch biodiesel actually wolf 3 wolf moon DIY. Pinterest tattooed fixie, church-key dreamcatcher beard hoodie organic. Art party readymade vinyl, sustainable Wes Anderson plaid tattooed whatever wolf fashion axe Portland banh mi High Life. Blog literally before they sold out butcher.\r\n\r\nCrucifix Carles street art, Blue Bottle XOXO Austin normcore mustache biodiesel. Deep v iPhone farm-to-table kogi, +1 brunch roof party twee. Echo Park forage photo booth, Brooklyn cray art party chia stumptown disrupt Cosby sweater retro iPhone jean shorts street art ennui. Wes Anderson meggings semiotics, selvage crucifix sartorial mixtape gastropub. Wolf meh lomo, meggings ethnic irony biodiesel. Vegan butcher pug authentic keffiyeh, normcore iPhone occupy retro vinyl bicycle rights. Authentic roof party small batch letterpress next level butcher.</div> ',9,'2014-07-24 12:07:03','2014-07-24 12:07:03',NULL,1,1,' Main Site ','L41',' option1 '),(7,'Pineapple Chunks','address@email.com','111111111','<div class=original>Gastropub hella stumptown chia, crucifix PBR&amp;B viral small batch umami chillwave kitsch. Crucifix disrupt wayfarers 3 wolf moon. Irony craft beer semiotics umami, actually bespoke Pitchfork Etsy Blue Bottle sriracha hashtag four loko. Whatever Cosby sweater pour-over street art before they sold out. Kale chips selfies Shoreditch, American Apparel umami beard gentrify Vice whatever mlkshk small batch direct trade Cosby sweater authentic. Raw denim mustache banh mi master cleanse, gastropub 8-bit hella Wes Anderson flannel cray Intelligentsia Tonx keytar PBR beard. Artisan fingerstache quinoa wayfarers.\r\n\r\nButcher Wes Anderson irony trust fund. Schlitz cred crucifix, flannel fap typewriter ennui mixtape Wes Anderson Truffaut mumblecore keffiyeh biodiesel sartorial Vice. Actually Portland synth Brooklyn +1 paleo. Selfies mixtape lomo, Tumblr farm-to-table church-key single-origin coffee normcore Truffaut ennui. Wayfarers kogi butcher, VHS post-ironic seitan occupy. Narwhal selvage forage kale chips. Dreamcatcher fingerstache Banksy, beard chambray kogi iPhone Wes Anderson keffiyeh church-key post-ironic hashtag Austin Echo Park vinyl.\r\n\r\nTofu swag pop-up flexitarian. Kitsch Odd Future fashion axe Echo Park leggings. Umami salvia Portland cardigan, normcore pour-over you probably haven\'t heard of them. Tote bag Brooklyn Tonx synth brunch. Yr Truffaut 3 wolf moon American Apparel iPhone, Schlitz cornhole. Distillery shabby chic McSweeney\'s, mumblecore Etsy roof party farm-to-table Thundercats leggings bespoke. Cardigan lo-fi Brooklyn bicycle rights literally mixtape, tattooed Godard.\r\n\r\nMumblecore jean shorts Carles small batch mixtape, American Apparel plaid Williamsburg try-hard street art single-origin coffee occupy Marfa. Dreamcatcher pug drinking vinegar, roof party mlkshk asymmetrical Vice synth Carles 90\'s. Kickstarter Shoreditch viral pickled fashion axe. Raw denim twee XOXO selfies lo-fi, meh Wes Anderson organic. Messenger bag seitan lo-fi, viral keytar fashion axe mlkshk vegan artisan sartorial kogi. Selvage swag Etsy disrupt, quinoa master cleanse 8-bit. Normcore pickled scenester art party, Carles sustainable photo booth master cleanse McSweeney\'s.\r\n\r\nTruffaut art party pour-over McSweeney\'s. Leggings vegan chambray, squid authentic crucifix yr keffiyeh food truck deep v polaroid next level narwhal. Plaid cliche deep v, hella 8-bit Neutra +1 Kickstarter letterpress blog lo-fi forage ugh ennui. Gastropub flannel blog mixtape, messenger bag 3 wolf moon PBR&amp;B pop-up hashtag food truck skateboard sriracha small batch cray. Wes Anderson Etsy 90\'s retro. Before they sold out dreamcatcher wolf, tattooed bitters Pinterest +1 post-ironic kitsch flannel whatever Echo Park meh chambray art party. Mixtape wayfarers Thundercats scenester, seitan PBR XOXO retro.\r\n\r\nBlog cred chillwave, stumptown organic Godard brunch fixie vinyl. Wayfarers bicycle rights art party kitsch put a bird on it, lo-fi American Apparel vinyl ethical beard flannel tote bag XOXO. Banh mi aesthetic flexitarian, Neutra salvia asymmetrical cray hashtag Portland bespoke church-key raw denim. High Life ethical street art lo-fi ennui. 8-bit mlkshk forage, aesthetic banjo wayfarers Brooklyn farm-to-table readymade. Freegan Helvetica artisan, master cleanse asymmetrical put a bird on it letterpress typewriter tofu synth. Ugh fingerstache asymmetrical, squid Cosby sweater selfies forage.\r\n\r\nSelfies salvia retro, hashtag photo booth occupy kitsch trust fund farm-to-table mlkshk quinoa paleo American Apparel ennui flexitarian. Scenester direct trade sartorial, PBR banjo art party Godard. Chillwave Intelligentsia meggings, direct trade Brooklyn Banksy crucifix drinking vinegar Helvetica ennui. Banksy leggings Echo Park gluten-free, kale chips mlkshk mumblecore butcher chia. Readymade fap typewriter umami, Pinterest tote bag retro Shoreditch hella organic master cleanse cred Marfa Bushwick. Single-origin coffee hashtag keytar, try-hard Carles disrupt ennui tote bag. Marfa freegan pop-up pour-over.\r\n\r\nPolaroid cliche chillwave Wes Anderson semiotics. Quinoa put a bird on it yr sartorial Odd Future, pop-up crucifix. Put a bird on it vegan seitan kale chips Truffaut wolf. Kogi McSweeney\'s Williamsburg kale chips art party. Synth banh mi shabby chic, dreamcatcher XOXO fixie gluten-free ugh flannel Portland authentic cred. Banjo 3 wolf moon Helvetica deep v Williamsburg, occupy swag kitsch Marfa slow-carb. Sartorial paleo Blue Bottle aesthetic, chillwave raw denim leggings crucifix ugh pour-over post-ironic photo booth.\r\n\r\nWes Anderson squid Odd Future, biodiesel ethical street art Intelligentsia pickled aesthetic cornhole. Next level Austin Blue Bottle keffiyeh locavore trust fund banh mi, art party single-origin coffee asymmetrical McSweeney\'s sriracha church-key polaroid cornhole. Umami hella PBR, put a bird on it kale chips direct trade vegan synth cray. Letterpress narwhal synth Austin single-origin coffee you probably haven\'t heard of them mumblecore. Pop-up American Apparel High Life, semiotics Neutra gentrify pickled messenger bag four loko dreamcatcher cornhole YOLO cardigan bitters hoodie. Wes Anderson Marfa Schlitz trust fund distillery, wayfarers occupy polaroid PBR gentrify literally retro letterpress Banksy. Bicycle rights sartorial asymmetrical mumblecore ethical occupy flannel mustache drinking vinegar small batch, roof party salvia.\r\n\r\nButcher Austin drinking vinegar seitan, tote bag put a bird on it hella Portland Godard church-key disrupt forage. Synth wayfarers Carles, Etsy skateboard Echo Park chillwave aesthetic. Selvage Brooklyn jean shorts lomo, meggings roof party direct trade. Tumblr fashion axe ugh American Apparel raw denim deep v, synth farm-to-table Helvetica seitan scenester. Raw denim Brooklyn 90\'s, pork belly actually skateboard dreamcatcher Intelligentsia asymmetrical polaroid Wes Anderson. Forage 3 wolf moon fap seitan +1 typewriter. Literally selfies Etsy YOLO vinyl. </div>',8,'2014-07-24 12:07:45','2014-07-24 12:07:45',NULL,1,1,' Main Site ','W104',' option1 ');
/*!40000 ALTER TABLE `calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engineers`
--

DROP TABLE IF EXISTS `engineers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engineers` (
  `idengineers` int(11) NOT NULL AUTO_INCREMENT,
  `engineerName` varchar(45) NOT NULL,
  `engineerEmail` varchar(45) NOT NULL,
  `availableMon` tinyint(1) NOT NULL,
  `availableTue` tinyint(1) NOT NULL,
  `availableWed` tinyint(1) NOT NULL,
  `availableThu` tinyint(1) NOT NULL,
  `availableFri` tinyint(1) NOT NULL,
  `availableSat` tinyint(1) NOT NULL,
  `availableSun` tinyint(1) NOT NULL,
  PRIMARY KEY (`idengineers`),
  UNIQUE KEY `idengineers_UNIQUE` (`idengineers`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engineers`
--

LOCK TABLES `engineers` WRITE;
/*!40000 ALTER TABLE `engineers` DISABLE KEYS */;
INSERT INTO `engineers` VALUES (8,'honey drips','honey@drips.com',0,0,0,0,0,0,0),(9,'orange peel','orange@peel.com',0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `engineers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusCode` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idengineers_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Open'),(2,'Closed');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-28 14:44:24
