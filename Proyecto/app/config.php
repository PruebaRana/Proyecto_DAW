<?php

define("CONTROLADOR_DEFECTO", "Inicio");
define("ACCION_DEFECTO", "indice");

// Instanciamos la clase config
$config = Config::GetInstance();
 
$config->set('controllersFolder', 'app/controllers/');
$config->set('modelsFolder', 'app/models/');
$config->set('viewsFolder', 'app/views/');

// Datos de acceso a la BD 
$config->set('dbhost', 'localhost:3305');
$config->set('dbname', 'proyecto_daw');
$config->set('dbuser', 'proyecto_daw');
$config->set('dbpass', '.Proyecto_Daw.13');

// Datos de Configuracion del correo
$config->set('CorreoHost', "mail.pymsolutions.com");
$config->set('CorreoUser', "servicios@pymsolutions.com");
$config->set('CorreoPass', "jaimeservicios33");

// Para que el sistema monte URL amigables, se tiene que configurar el servidor web para que las procese.
$config->set('urlFriendly', true);
?>