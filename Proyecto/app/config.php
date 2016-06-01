<?php

define("CONTROLADOR_DEFECTO", "Inicio");
define("ACCION_DEFECTO", "indice");

// Instanciamos la clase config
$config = Config::GetInstance();
 
$config->set('controllersFolder', 'app/controllers/');
$config->set('modelsFolder', 'app/models/');
$config->set('viewsFolder', 'app/views/');
 
$config->set('dbhost', 'localhost:3305');
$config->set('dbname', 'proyecto_daw');
$config->set('dbuser', 'proyecto_daw');
$config->set('dbpass', '.Proyecto_Daw.13');
?>