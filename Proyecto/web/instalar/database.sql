-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: proyecto_daw
-- ------------------------------------------------------
-- Server version	5.6.17-log

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
-- Table structure for table `ciclos`
--
DROP TABLE IF EXISTS `ciclos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciclos` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciclos`
--
LOCK TABLES `ciclos` WRITE;
/*!40000 ALTER TABLE `ciclos` DISABLE KEYS */;
INSERT INTO `ciclos` VALUES (1,'ASIR','Técnico Superior en Administración de Sistemas Informáticos en Red'),(2,'DAM','Técnico Superior En Desarrollo De Aplicaciones Multiplataforma'),(3,'DAW','Técnico Superior en Desarrollo de Aplicaciones Web');
/*!40000 ALTER TABLE `ciclos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cualidades`
--
DROP TABLE IF EXISTS `cualidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cualidades` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cualidades`
--

LOCK TABLES `cualidades` WRITE;
/*!40000 ALTER TABLE `cualidades` DISABLE KEYS */;
INSERT INTO `cualidades` VALUES (1,'Actualidad'),(2,'Internet'),(3,'Seguridad'),(4,'Web'),(5,'Rendimiento'),(6,'Calidad'),(7,'Estetica');
/*!40000 ALTER TABLE `cualidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IdCiclo` int(11) unsigned NOT NULL,
  `Nombre` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (1,1,'7L'),(2,1,'7M'),(3,1,'7P'),(4,2,'7J'),(5,2,'7N'),(6,2,'7U'),(7,3,'7K'),(8,3,'7S');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IdCiclo` int(11) unsigned NOT NULL,
  `Nombre` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` varchar(75) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,1,'ISO','Implantación de sistemas operativos'),(2,1,'PAD','Planificación y administración de redes'),(3,1,'FHW','Fundamentos de hardware'),(4,2,'SGBD','Sistemas Gestores De Bases De Datos'),(5,1,'LGM','Lenguajes de marcas y sistemas de gestión de información'),(6,1,'ASO','Administración de sistemas operativos'),(7,1,'SRI','Servicios de red e Internet'),(8,1,'AW','Implantación de aplicaciones web'),(9,1,'GBD','Gestión de bases de datos'),(10,1,'SAD','Seguridad y alta disponibilidad'),(11,1,'EIE','Empresa e iniciativa emprendedora'),(12,1,'ING','Ingles'),(13,1,'FOL','Formación y orientación laboral'),(14,2,'SI','Sistemas informáticos'),(15,2,'BD','Bases de datos'),(16,2,'PRO','Programación'),(17,2,'LGM','Lenguajes de marcas y sistemas de gestión de información'),(18,2,'ED','Entornos de desarrollo'),(19,2,'DWEC','Desarrollo web en entorno cliente'),(20,2,'DWS','Desarrollo web en entorno servidor'),(21,2,'DAW','Despliegue de aplicaciones web'),(22,2,'DIW','Diseño de interfaces WEB'),(23,2,'EIE','Empresa e iniciativa emprendedora'),(24,2,'ING','Ingles'),(25,2,'FOL','Formación y orientación laboral'),(26,3,'SI','Sistemas informáticos'),(27,3,'BD','Bases de Datos'),(28,3,'PRO','Programación'),(29,3,'LGM','Lenguajes de marcas y sistemas de gestión de información'),(30,3,'ED','Entornos de desarrollo'),(31,3,'AD','Acceso a datos'),(32,3,'DI','Desarrollo de interfaces'),(33,3,'PMM','Programación multimedia y dispositivos móviles'),(34,3,'PSP','Programación de servicios y procesos'),(35,3,'SGE','Sistemas de gestión empresarial'),(36,3,'EIE','Empresa e iniciativa emprendedora'),(37,3,'ING','Ingles'),(38,3,'FOL','Formación y orientación laboral');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plantillascorreo`
--

DROP TABLE IF EXISTS `plantillascorreo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plantillascorreo` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Asunto` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plantillascorreo`
--

LOCK TABLES `plantillascorreo` WRITE;
/*!40000 ALTER TABLE `plantillascorreo` DISABLE KEYS */;
INSERT INTO `plantillascorreo` VALUES (1,'RecuperarContrasena','Recuperar contraseña','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"es\" xml:lang=\"es\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>[ASUNTO]</title><style type=\"text/css\">H1{font-size:1.5em;color:#EE7600;font-family:Segoe XDR, Segoe WP, Segoe UI, Helvetica, Arial}TABLE{width:100%;font-family:Segoe XDR, Segoe WP, Segoe UI, Helvetica, Arial}TD{border-bottom:1px dotted #D5D2BD;margin:3px 5px}SPAN{font-family:Calibri, sans-serif}</style></head><body><table style=\'border-bottom:2px dotted #D5D2BB\'><tr><td style=\'border:0;vertical-align:text-bottom\'><h1>[ASUNTO]</h1></td></tr></table><br /><br />Hola <b>[NOMBRE]</b><br /><br />¿Solicitó un restablecimiento de contraseña para su cuenta de acceso?<br /><br />Si solicitó este restablecimiento de contraseña, diríjase aquí: <a href=\"[ENLACE]\" Title=\"Cambiar Contraseña\">Cambiar Contraseña</a><br /><br />Si usted no lo solicitó por favor ignore esta notificación.<br /><br /><hr>Si persiste la solicitud o tiene alguna dificultad contacte con el Administrador del Sitio.<br /><br /><br /><br /><b><span style=\'font-size:6.0pt;font-family:\"Arial\",\"sans-serif\";color:#404040\'>No imprima este mail si no es necesario. Protejamos el Medio Ambiente.</span></b><span style=\'font-size:6.0pt;font-family:\"Arial\",\"sans-serif\";color:#404040\'><br />Aviso Legal: Le informamos, como destinatario de este mensaje, que el correo electrónico y las comunicaciones por medio de Internet no permiten asegurar ni garantizar la confidencialidad de los mensajes transmitidos, así como tampoco su integridad o su correcta recepción, por lo que no asumimos responsabilidad alguna por tales circunstancias. Si no consintiese en la utilización del correo electrónico o de las comunicaciones vía Internet le rogamos nos lo comunique y ponga en nuestro conocimiento de manera inmediata. Este mensaje va dirigido, de manera exclusiva, a su destinatario y contiene información confidencial, personal e intransferible, cuya divulgación no está permitida por la ley. En caso de haber recibido este mensaje por error, le rogamos que, de forma inmediata, nos lo comunique mediante correo electrónico remitido a nuestra atención o a través del teléfono 96 3950076  y proceda a su eliminación, así como a la de cualquier documento adjunto al mismo. Asimismo, le comunicamos que la distribución, copia o utilización de este mensaje, o de cualquier documento adjunto al mismo, cualquiera que fuera su finalidad, están prohibidas por la ley.</span></body></html>'),(2,'CorreoDeAcceso','Acceso por primera vez','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"es\" xml:lang=\"es\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>[ASUNTO]</title><style type=\"text/css\">H1{font-size:1.5em;color:#EE7600;font-family:Segoe XDR, Segoe WP, Segoe UI, Helvetica, Arial}TABLE{width:100%;font-family:Segoe XDR, Segoe WP, Segoe UI, Helvetica, Arial}TD{border-bottom:1px dotted #D5D2BD;margin:3px 5px}SPAN{font-family:Calibri, sans-serif}</style></head><body><table style=\'border-bottom:2px dotted #D5D2BB\'><tr><td style=\'border:0;vertical-align:text-bottom\'><h1>[ASUNTO]</h1></td></tr></table><br /><br />Hola <b>[NOMBRE]</b><br /><br />Para poder acceder a su cuenta para la gestion de proyectos, siga el siguiente enlace.<br /><br /><a href=\"[ENLACE]\" Title=\"Acceder al sistema\">Acceder al sistema</a><br /><br />Si usted no lo solicitó por favor ignore esta notificación.<br /><br /><hr>Si persiste la solicitud o tiene alguna dificultad contacte con el Administrador del Sitio.<br /><br /><br /><br /><b><span style=\'font-size:6.0pt;font-family:\"Arial\",\"sans-serif\";color:#404040\'>No imprima este mail si no es necesario. Protejamos el Medio Ambiente.</span></b><span style=\'font-size:6.0pt;font-family:\"Arial\",\"sans-serif\";color:#404040\'><br />Aviso Legal: Le informamos, como destinatario de este mensaje, que el correo electrónico y las comunicaciones por medio de Internet no permiten asegurar ni garantizar la confidencialidad de los mensajes transmitidos, así como tampoco su integridad o su correcta recepción, por lo que no asumimos responsabilidad alguna por tales circunstancias. Si no consintiese en la utilización del correo electrónico o de las comunicaciones vía Internet le rogamos nos lo comunique y ponga en nuestro conocimiento de manera inmediata. Este mensaje va dirigido, de manera exclusiva, a su destinatario y contiene información confidencial, personal e intransferible, cuya divulgación no está permitida por la ley. En caso de haber recibido este mensaje por error, le rogamos que, de forma inmediata, nos lo comunique mediante correo electrónico remitido a nuestra atención o a través del teléfono 96 3950076  y proceda a su eliminación, así como a la de cualquier documento adjunto al mismo. Asimismo, le comunicamos que la distribución, copia o utilización de este mensaje, o de cualquier documento adjunto al mismo, cualquiera que fuera su finalidad, están prohibidas por la ley.</span></body></html>');
/*!40000 ALTER TABLE `plantillascorreo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IdAlumno` int(11) unsigned NOT NULL,
  `IdTutor` int(11) unsigned DEFAULT NULL,
  `Curso` int(4) unsigned NOT NULL,
  `Ciclo` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Grupo` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Resumen` text COLLATE utf8_spanish2_ci,
  `Herramientas` text COLLATE utf8_spanish2_ci,
  `Comentarios` text COLLATE utf8_spanish2_ci,
  `Valoracion` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `borrado` bit(1) DEFAULT b'0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectosarchivos`
--

DROP TABLE IF EXISTS `proyectosarchivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectosarchivos` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IdProyecto` int(11) unsigned NOT NULL,
  `tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectosarchivos`
--

LOCK TABLES `proyectosarchivos` WRITE;
/*!40000 ALTER TABLE `proyectosarchivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectosarchivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectosarchivostipos`
--

DROP TABLE IF EXISTS `proyectosarchivostipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectosarchivostipos` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectosarchivostipos`
--

LOCK TABLES `proyectosarchivostipos` WRITE;
/*!40000 ALTER TABLE `proyectosarchivostipos` DISABLE KEYS */;
INSERT INTO `proyectosarchivostipos` VALUES (1,'Documento de memoria'),(2,'Video'),(3,'Presentacion'),(4,'Codigo Fuente'),(5,'Otros');
/*!40000 ALTER TABLE `proyectosarchivostipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectoscualidades`
--

DROP TABLE IF EXISTS `proyectoscualidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectoscualidades` (
  `idProyecto` int(11) unsigned NOT NULL,
  `IdCualidad` int(11) unsigned NOT NULL,
  PRIMARY KEY (`idProyecto`,`IdCualidad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectoscualidades`
--

LOCK TABLES `proyectoscualidades` WRITE;
/*!40000 ALTER TABLE `proyectoscualidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectoscualidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectosmodulos`
--

DROP TABLE IF EXISTS `proyectosmodulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectosmodulos` (
  `IdProyecto` int(11) unsigned NOT NULL,
  `IdModulo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`IdProyecto`,`IdModulo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectosmodulos`
--

LOCK TABLES `proyectosmodulos` WRITE;
/*!40000 ALTER TABLE `proyectosmodulos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectosmodulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Profesor'),(3,'Alumno');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(32) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(75) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_alta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto` varchar(25) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'foto.jpg',
  `activo` bit(1) NOT NULL DEFAULT b'1',
  `Borrado` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=356 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','827ccb0eea8a706c4c34a16891f84e7b','Administrador Del Sistema','jaguila@pymsolutions.com','2016-05-24 17:32:37','foto.jpg','','\0'),(2,'profesor','827ccb0eea8a706c4c34a16891f84e7b','Profesor de pruebas','jaguila@aptavs.com','2016-05-24 19:38:30','foto.jpg','','\0'),(3,'alumno','827ccb0eea8a706c4c34a16891f84e7b','Alumno De Pruebas','jaime@aptavsonline.com','2016-05-24 19:38:30','foto.jpg','','\0');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariosroles`
--

DROP TABLE IF EXISTS `usuariosroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariosroles` (
  `IdUsuario` int(10) unsigned NOT NULL,
  `IdRol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IdUsuario`,`IdRol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariosroles`
--

LOCK TABLES `usuariosroles` WRITE;
/*!40000 ALTER TABLE `usuariosroles` DISABLE KEYS */;
INSERT INTO `usuariosroles` VALUES (1,1),(1,2),(2,2),(3,3);
/*!40000 ALTER TABLE `usuariosroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valoraciones`
--

DROP TABLE IF EXISTS `valoraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valoraciones` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valoraciones`
--

LOCK TABLES `valoraciones` WRITE;
/*!40000 ALTER TABLE `valoraciones` DISABLE KEYS */;
INSERT INTO `valoraciones` VALUES (1,'Normal'),(2,'Buena'),(3,'Muy Buena'),(4,'Excelente');
/*!40000 ALTER TABLE `valoraciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-06 18:15:18