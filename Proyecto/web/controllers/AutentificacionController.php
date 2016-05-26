<?php
class AutentificacionController
{
	private $_Nombre = "autentificacion";
	private $_db;
	private $_Method;
	
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
		$this->_db = conectarDB(null);
		$this->_Method = $_SERVER['REQUEST_METHOD'];
    }
    public function __destruct() {
        desconectarDB($this->_db);
    }	
 
 
    public function login()
    {
		if($this->_Method == "POST")
		{
			$this->login_post();
		}
		else
		{
			$this->login_get();
		}
    }
    private function login_get()
    {
        //Incluye el modelo que corresponde
        require_once 'models/LoginModel.php';
 
        //Creamos una instancia de nuestro "modelo"
        $item = new LogonModel();
 
        //Le pedimos al modelo todos los items
        //$listado = $items->listadoTotal();
 
        //Pasamos a la vista toda la información que se desea representar
		$data["Item"] = $item;
		$data["mensaje"] = "";
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre . "/login.php", $data);
	}
    private function login_post()
    {
		//Incluye el modelo que corresponde
        require_once 'models/LoginModel.php';
 
        //Creamos una instancia de nuestro "modelo"
        $item = new LogonModel($this->_db);
		
		$Usuario = obtenParametroArray($_POST, "UserName");
		$Password = obtenParametroArray($_POST, "Password");
		
		$item->ComprobarUserPass($Usuario, $Password);
		
		if($item->Id > 0)
		{
			// Seteo la session
			$usuario = new SesionModel();
			$usuario->cargar($item->Id, $item->Nombre, $item->Usuario, $item->Perfiles);
			
			$_SESSION["user"] = $usuario;
			// Redirigir al indice
			$this->redirect();
		}
		else
		{
			// no se ha logueado.
			$data["Item"] = $item;
			$data["mensaje"] = "No se ha podido loguear";

			//Finalmente presentamos nuestra plantilla
			$this->view->show($this->_Nombre . "/login.php", $data);
		}
	}
    public function logoff()
    {
		session_destroy();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		// Redirigir al indice
		$this->redirect();
    }
	
	
	
	
	public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        header("Location:index.php?controlador=".$controlador."&accion=".$accion);
    }	
	
    public function agregar()
    {
        echo 'Aquí incluiremos nuestro formulario para insertar items';
    }
}
?>