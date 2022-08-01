/* create a database and its user */
create database website;
create user dbuser@localhost identified by '123';
grant all on website.* to dbuser@localhost;

/* load the database info */
use website;
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
  /* Id is the entry number*/
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  /* Path is a filename in the data folder */
  `Path` text DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `memes` WRITE;
/*!40000 ALTER TABLE `memes` DISABLE KEYS */;
INSERT INTO `memes` VALUES
  /* The actual values go here */
  (1,'angery.png'),(2,'audiovideo.png'),(3,'awscharge.jpg'),(4,'awsproblem.png'),(5,'awsservice.jpg'),
  (6,'awssleep.jpg'),(7,'backlog.png'),(8,'badcode.png'),(9,'binary.png'),(10,'ddos.jpg'),
  (11,'doge.jpg'),(12,'gitlab.jpg'),(13,'gitops.jpg'),(14,'handshake.jpg'),(15,'hardproblem.png'),
  (16,'harry.jpg'),(17,'it.jpg'),(18,'juniormaster.png'),(19,'kubetutorial.png'),(20,'kubeyaml.jpg'),
  (21,'meta.png'),(22,'options.jpg'),(23,'permissions.jpg'),(24,'phases.png'),(25,'propagate.png'),
  (26,'readme.jpg'),(27,'scm.jpg'),(28,'scope.jpg'),(29,'simply.jpg'),(30,'starwars.jpg'),
  (31,'taskfear.jpg'),(32,'undef.png'),(33,'windows8.jpg'),(34,'worstcode.png');
/*!40000 ALTER TABLE `memes` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/* Modified from a sql dump */
