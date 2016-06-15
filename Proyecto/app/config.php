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
$config->set('dbname', 'name');
$config->set('dbuser', 'user');
$config->set('dbpass', 'pass');

// Datos de Configuracion del correo
$config->set('CorreoHost', "host.com");
$config->set('CorreoUser', "cuenta");
$config->set('CorreoPass', "contraseña");

// Para que el sistema monte URL amigables, se tiene que configurar el servidor web para que las procese.
$config->set('urlFriendly', true);
?>