<?php
//Incluimos algunas clases:
$lsRuta = str_replace("web\ObtenArchivo.php", "", $_SERVER["SCRIPT_FILENAME"]);

require_once $lsRuta."web/"."libs/Config.php"; 		//de configuracion
require_once $lsRuta."web/".'libs/ConexionDB.php'; 	//Acceso a BD por PDO con singleton
require_once $lsRuta."web/".'libs/Utiles.php'; 		//

require_once $lsRuta."web/".'config.php'; 				//Archivo con configuraciones.

// Iniciamos la sesion
require_once $lsRuta."web/".'models/SessionModel.php';
session_start();
$_SESSION = unserialize(serialize($_SESSION));
global $usuario;
$usuario = obtenParametroArray($_SESSION, "user", new SesionModel());
$IdUsuario = $usuario->Id;

// Obtenemos todos los parametros necesarios
$lsROOT = __DIR__ ."/Contenidos/";
$IdUser = $_GET['IdUser'];
$File = $_GET['File'];
$FicheroFinal = $lsROOT.$IdUser."/".$File;
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

// 3 - Si el Rol no es Administrador ni profesor, el fichero debe ser del alumno
if(!$usuario->isInRol("Administrador Profesor")) {
	header('HTTP/1.0 403 Forbidden');
    echo "<h1>Error 403 No tiene permisos suficientes.</h1>";
    echo "No tiene permisos suficientes para acceder al fichero.";	
	exit;
}


// Si todo lo anterior es correcto, obtener el fichero y mandarlo al cliente.
$len = filesize($FicheroFinal);
// header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="'.$NombreFichero.'"');
header('Content-Length: '.$len);
readfile($FicheroFinal);
?>