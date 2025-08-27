-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
DROP TABLE IF EXISTS `recinto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recinto` (
  `ID_Recinto` int(11) NOT NULL,
  `Tipo_de_reciento` enum('Bosque de la Semejanza','Prado de la Diferencia','Pradera del Amor','Trio Frondoso','Isla solitaria') NOT NULL,
  `Restricciones` varchar(255) DEFAULT NULL,
  `ID_Partida` int(11) DEFAULT NULL,
  `ID_Jugador` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Recinto`),
  KEY `ID_Jugador` (`ID_Jugador`),
  KEY `ID_Partida` (`ID_Partida`),
  CONSTRAINT `recinto_ibfk_1` FOREIGN KEY (`ID_Jugador`) REFERENCES `jugador` (`ID_Jugador`),
  CONSTRAINT `recinto_ibfk_2` FOREIGN KEY (`ID_Partida`) REFERENCES `partida` (`ID_Partida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recinto`
--

LOCK TABLES `recinto` WRITE;
/*!40000 ALTER TABLE `recinto` DISABLE KEYS */;
/*!40000 ALTER TABLE `recinto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-18 15:06:13
