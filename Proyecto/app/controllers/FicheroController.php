<?php
class FicheroController extends ControllerBase
{
    function __construct()
    {
		// A esta sección solo puede entrar los administradores.
		EstaLogueado();
		
		$lsController = "Fichero";
		parent::__construct($lsController);
    }
    public function __destruct() 
	{
    }	
 
	/* Accion DESCARGAR */
	// Petición por GET
    public function descargar()
    {
		global $usuario;
		// Obtenemos todos los parametros necesarios
		$lsRutaProyectos = $this->_Config->get("Ruta").'app/contenidos/proyectos/';
		$IdProyecto = sanitizar(obtenParametroArray($_GET, "IdProyecto", 0));
		$File = normaliza(sanitizar(obtenParametroArray($_GET, "File", "")));

		$FicheroFinal = $lsRutaProyectos.$IdProyecto."/".$File;
		$NombreFichero = basename($FicheroFinal);
		$NombreFichero = substr($NombreFichero, 5);
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
	}
	/* Accion DESCARGAR */
}
?>