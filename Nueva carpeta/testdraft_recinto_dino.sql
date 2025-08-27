-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
DROP TABLE IF EXISTS `recinto_dino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recinto_dino` (
  `ID_Recinto` int(11) NOT NULL,
  `ID_Dinosaurio` int(11) NOT NULL,
  PRIMARY KEY (`ID_Recinto`,`ID_Dinosaurio`),
  KEY `ID_Dinosaurio` (`ID_Dinosaurio`),
  CONSTRAINT `recinto_dino_ibfk_1` FOREIGN KEY (`ID_Dinosaurio`) REFERENCES `dinosaurio` (`ID_Dinosaurio`),
  CONSTRAINT `recinto_dino_ibfk_2` FOREIGN KEY (`ID_Recinto`) REFERENCES `recinto` (`ID_Recinto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recinto_dino`
--

LOCK TABLES `recinto_dino` WRITE;
/*!40000 ALTER TABLE `recinto_dino` DISABLE KEYS */;
/*!40000 ALTER TABLE `recinto_dino` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-18 15:06:14
