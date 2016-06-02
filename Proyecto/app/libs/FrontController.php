<?php
class FrontController
{
	private static $_URLFriendy = false;
    static function main()
    {
		//Obtenemos la URL base y la Ruta local
		$lsURL = str_replace("/index.php", "", $_SERVER["SCRIPT_NAME"]);
		$lsRuta = str_replace("web\index.php", "", $_SERVER["SCRIPT_FILENAME"]);
		
        //Incluimos algunas clases:
        require_once $lsRuta.'app/libs/Config.php'; 		//de configuracion
        require_once $lsRuta.'app/libs/ConexionDB.php'; 	//Acceso a BD por PDO con singleton
        require_once $lsRuta.'app/libs/Utiles.php'; 		//
        require_once $lsRuta.'app/libs/ControllerBase.php'; 		//
		require_once $lsRuta.'app/libs/ModelBase.php'; 		//
		
        require_once $lsRuta.'app/libs/View.php'; 			//Mini motor de plantillas
        require_once $lsRuta.'app/config.php'; 				//Archivo con configuraciones.
        require_once $lsRuta.'app/libs/nocsrf.php'; 		//Evita ataques csfr, implementa el ValidateAntiForgeryToken de .NET

		// Iniciamos la sesion
		require_once $lsRuta.'app/models/SessionModel.php';
		session_start();
		$_SESSION = unserialize(serialize($_SESSION));
		global $usuario;
		$usuario = obtenParametroArray($_SESSION, "user", new SesionModel());
		
        // Por similitud con otros MVC los controladores terminarán todos en Controller. Por ej, la clase controladora Items, será ItemsController
 
        // Obtenemos el Controlador o en su defecto, tomamos que es el InicioController
        if(! empty($_GET['controlador'])){
			$controllerName = $_GET['controlador'] . 'Controller';
		} else {
			$controllerName = "InicioController";
		}
 
        // Obtenemos la accion, si no hay acción, tomamos indice como acción
        if(! empty($_GET['accion'])){
			$actionName = $_GET['accion'];
		} else {
			$actionName = "indice";
		}
 
		// Nos guardamos en el config la URL y la Ruta base.
		$config->set('URL', $lsURL);
		$config->set('Ruta', $lsRuta);
		$config->set('Usuario', $usuario);
		self::$_URLFriendy = $config->get('urlFriendly');

        $controllerPath = $lsRuta.$config->get('controllersFolder').$controllerName.'.php';
        
		// Incluimos el fichero que contiene nuestra clase controladora solicitada
        if(is_file($controllerPath)){
			require $controllerPath;
		} else {
			// Lanzamos un 404
			header('HTTP/1.0 404 Not Found');
			echo "<h1>Error 404 Not Found</h1>";
			die('El controlador no existe - 404 not found');
		}
 
        //Si no existe la clase que buscamos y su acción, mostramos un error 404
        if (is_callable(array($controllerName, $actionName)) == false)
        {
            trigger_error ($controllerName . '->' . $actionName . '` no existe', E_USER_NOTICE);
			header('HTTP/1.0 404 Not Found');
			echo "<h1>Error 404 Not Found</h1>";
			die('La accion no existe - 404 not found');
        }
        
		//Si todo esta bien, creamos una instancia del controlador y llamamos a la acción
        $controller = new $controllerName();
        $controller->$actionName();
    }

	static function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO)
	{
		$URL = "";
		if(FrontController::$_URLFriendy){
			$URL = FrontController::getURLRaiz()."/seccion/".$controlador."/".$accion;
		}else{
			$URL = FrontController::getURLRaiz()."/index.php?controlador=".$controlador."&accion=".$accion;
		}

		header("Location:".$URL);
    }	

	static function getURL($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO)
	{
		$URL = "";
		if(FrontController::$_URLFriendy){
			$URL = FrontController::getURLRaiz()."/seccion/".$controlador."/".$accion;
		}else{
			$URL = FrontController::getURLRaiz()."/index.php?controlador=".$controlador."&accion=".$accion;
		}
		
		return $URL;
    }	
	static function getURLRaiz()
	{
		$config = Config::GetInstance();
		return $config->get('URL');
    }	
}
?>