/*  create a database and its user  */
CREATE DATABASE website;
/*  the exposed password is fine because of containerization and least privilege  */
GRANT ALL ON website.* TO 'dbuser'@'%' IDENTIFIED BY 'Very!Strong@Password#I%Presume';
FLUSH PRIVILEGES;

USE website;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `memes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memes` (
  /*  Id is the entry number  */
  `Id` INT(2) NOT NULL AUTO_INCREMENT,
  /*  Path is a filename in the data folder  */
  `Path` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `memes` WRITE;
/*!40000 ALTER TABLE `memes` DISABLE KEYS */;
INSERT INTO `memes` (`Path`) VALUES
  /*  The actual filenames go here  */
  ('angery.png'),('audiovideo.png'),('awscharge.jpg'),('awsproblem.png'),('awsservice.jpg'),
  ('awssleep.jpg'),('backlog.png'),('badcode.png'),('binary.png'),('ddos.jpg'),
  ('doge.jpg'),('gitlab.jpg'),('gitops.jpg'),('handshake.jpg'),('hardproblem.png'),
  ('harry.jpg'),('it.jpg'),('juniormaster.png'),('kubetutorial.png'),('kubeyaml.jpg'),
  ('meta.png'),('options.jpg'),('permissions.jpg'),('phases.png'),('propagate.png'),
  ('readme.jpg'),('scm.jpg'),('scope.jpg'),('simply.jpg'),('starwars.jpg'),
  ('taskfear.jpg'),('undef.png'),('windows8.jpg'),('worstcode.png');
/*!40000 ALTER TABLE `memes` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `userdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userdata` (
  /*  User IP to keep their data  */
  `IP` VARCHAR(15) NOT NULL,
  /*  a bitwise integer storage for seen memes  */
  `Seen` VARCHAR(11) DEFAULT 0,
  /*  how many times a meme was randomly chosen  */
  `Tries` INT(3) UNSIGNED DEFAULT 0,
  PRIMARY KEY (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

