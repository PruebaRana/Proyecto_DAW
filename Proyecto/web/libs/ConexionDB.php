<?php


// FUNCIÓN DE CONEXIÓN CON LA BASE DE DATOS MYSQL
function conectarDB($alink = null){
	if($alink != null){
		return $alink;
	}

	//uso de las excepciones en php try y catch
	try {
		$config = Config::singleton();
		$db = new PDO("mysql:host=". $config->get('dbhost') . ";dbname=" . $config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));
		//Realiza el enlace con la BD en utf-8
		$db->exec("set names utf8");

		$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
		return($db);
	} catch (PDOException $e) {
		print "<p>Error: No puede conectarse con la base de datos.<br> $e </p>\n";
		trigger_error ("No se puede conectar con la BD. " . $config->get('dbhost') . '/' . $config->get('dbname') . "-> " . $config->get('dbuser') . ":" . $config->get('dbpass'), E_USER_NOTICE);
		exit();
	}
}

function desconectarDB($alinkDesconectar = null, $alinkOriginal = null){
	// Si $alinkDesconectar no es null, hay una conexion
	if($alinkDesconectar != null){
		// Si $alinkOriginal es null, se debe cerrar $alinkDesconectar
		// Si no es nulo, indica que la conexion nos ha venido abierta, no la cerramos, ya se encargara quien la abrio de cerrarla
		if($alinkOriginal == null){
			$alinkDesconectar = null;
		}
	}
}


?>