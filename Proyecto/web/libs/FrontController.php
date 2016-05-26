<?php
class FrontController
{
    static function main()
    {
        //Incluimos algunas clases:
        require_once "libs/Config.php"; 		//de configuracion
        require_once 'libs/ConexionDB.php'; 	//Acceso a BD por PDO con singleton
        require_once 'libs/Utiles.php'; 		//
        require_once 'libs/ControllerBase.php'; 		//
		require_once 'libs/ModelBase.php'; 		//
		
        require_once 'libs/View.php'; 			//Mini motor de plantillas
        require_once 'config.php'; 				//Archivo con configuraciones.

		// Iniciamos la sesion
		require_once 'models/SessionModel.php';
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
 
        $controllerPath = $config->get('controllersFolder') . $controllerName . '.php';
 
        //Incluimos el fichero que contiene nuestra clase controladora solicitada
        if(is_file($controllerPath)){
			require $controllerPath;
		} else {
			// Lanzamos un 404
			die('El controlador no existe - 404 not found');
		}
 
        //Si no existe la clase que buscamos y su acción, mostramos un error 404
        if (is_callable(array($controllerName, $actionName)) == false)
        {
            trigger_error ($controllerName . '->' . $actionName . '` no existe', E_USER_NOTICE);
            return false;
        }
        
		//Si todo esta bien, creamos una instancia del controlador y llamamos a la acción
        $controller = new $controllerName();
        $controller->$actionName();
    }

	static function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO)
	{
		header("Location:index.php?controlador=".$controlador."&accion=".$accion);
    }	

}
?>