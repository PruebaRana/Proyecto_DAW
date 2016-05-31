<?php
//Incluimos algunas clases:
require_once "libs/Config.php"; 		//de configuracion
require_once 'libs/ConexionDB.php'; 	//Acceso a BD por PDO con singleton
require_once 'libs/Utiles.php'; 		//

require_once 'config.php'; 				//Archivo con configuraciones.

// Iniciamos la sesion
require_once 'models/SessionModel.php';
session_start();
$_SESSION = unserialize(serialize($_SESSION));
global $usuario;
$usuario = obtenParametroArray($_SESSION, "user", new SesionModel());
$IdUsuario = $usuario->Id;

// Obtenemos todos los parametros necesarios
$lsROOT = __DIR__ ."/Contenidos/";
$File = $_GET['File'];
$FicheroFinal = $lsROOT.$IdUsuario."/".$File;
$NombreFichero = basename($FicheroFinal);

// Comprobaciones
// 1 - Esta logueado
EstaLogueado();

// 2 - Comprobar que el fichero en cuestion existe
if ( !file_exists( $FicheroFinal ) ) {
	header('HTTP/1.0 404 Not Found');
    echo "<h1>Error 404 Not Found</h1>";
    echo "El fichero que esta intentando consultar no existe.";	
	exit;
}

// Si todo lo anterior es correcto, obtener el fichero y mandarlo al cliente.
$len = filesize($FicheroFinal);
// header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="'.$NombreFichero.'"');
header('Content-Length: '.$len);
readfile($FicheroFinal);
?>