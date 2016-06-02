<?php
class AutentificacionController extends ControllerBase
{
    function __construct()
    {
		parent::__construct("Autentificacion");

		// Se incluye el modelo que corresponde
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'LoginModel.php';

        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'PlantillaCorreoModel.php';
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'UsuarioModel.php';
	}
    public function __destruct() 
	{
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
        //Creamos una instancia de nuestro "modelo"
        $item = new LogonModel();
		
		$Usuario = sanitizar(obtenParametroArray($_POST, "UserName"));
		$Password = sanitizar(obtenParametroArray($_POST, "Password"));
		
		$item->ComprobarUserPass($Usuario, $Password);
		
		if($item->Id > 0)
		{
			// Seteo la session
			$usuario = new SesionModel();
			$usuario->cargar($item->Id, $item->Nombre, $item->Usuario, $item->Perfiles);
			
			$_SESSION["user"] = $usuario;
			// Redirigir al indice
			FrontController::redirect();
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
		FrontController::redirect();
    }

	
	
	/* Envios de Correo */
	public function EnviarCorreoAcceso()
	{
		require $this->_Config->get('Ruta')."app/libs/Correo.php";
		
		if($this->_Method == "POST")
		{
			// Obtenemos el id del usuario al que enviar el correo
			$liId = sanitizar(obtenParametroArray($_POST, "Id", 0));
			$lsNombre = "";
			$lsCorreo = "";
			if($liId>0){
				// Obtenemos el registro
				$User = new UsuarioModel();
				$User = $User->ObtenerItem($liId);
				
				$lsNombre = $User->Nombre;
				$lsCorreo = $User->EMail;
			}
			
			
			// Obtenemos la plantilla
			$Lista = $lsPlantilla->ObtenerPlantilla("CorreoDeAcceso");
			if(Count($Lista)>0 && strlen($lsNombre) > 0 && strlen($lsCorreo) > 0 ){
				$lMiPlantilla = $Lista(0);
				// Sustituir los elementos.
				// ASUNTO, NOMBRE, ENLACE
				$lsBody = $lMiPlantilla->Descripcion;
				$lsBody = str_replace("[ASUNTO]", $lMiPlantilla->Asunto, $lsBody);
				$lsBody = str_replace("[NOMBRE]", $lsNombre, $lsBody);
				$lsBody = str_replace("[ENLACE]", "--", $lsBody);

				echo $this->EnviarCorreo($lsBody, $lMiPlantilla->Asunto, $lsCorreo, $lsNombre);
			}
		}
		else
		{
			echo json_encode( array("Estado"=>0, "Error"=>"No permitido, solo por POST.") );
		}
	}
	
	public function EnviarCorreoRecordar()
	{
		$lsPlantilla = new PlantillaCorreoModel();
		
		if($this->_Method == "POST")
		{
			// Obtenemos el id del usuario al que enviar el correo
			$liId = sanitizar(obtenParametroArray($_POST, "Id", 0));
			$lsNombre = "";
			$lsCorreo = "";
			if($liId>0){
				// Obtenemos el registro
				$User = new UsuarioModel();
				$User = $User->ObtenerItem($liId);
				
				$lsNombre = $User->Nombre;
				$lsCorreo = $User->EMail;
			}
			
			
			// Obtenemos la plantilla
			$Lista = $lsPlantilla->ObtenerPlantilla("RecuperarContraseña");
			if(Count($Lista)>0 && strlen($lsNombre) > 0 && strlen($lsCorreo) > 0 ){
				$lMiPlantilla = $Lista(0);
				// Sustituir los elementos.
				// ASUNTO, NOMBRE, ENLACE
				$lsBody = $lMiPlantilla->Descripcion;
				$lsBody = str_replace("[ASUNTO]", $lMiPlantilla->Asunto, $lsBody);
				$lsBody = str_replace("[NOMBRE]", $lsNombre, $lsBody);
				$lsBody = str_replace("[ENLACE]", "--", $lsBody);

				echo $this->EnviarCorreo($lsBody, $lMiPlantilla->Asunto, $lsCorreo, $lsNombre);
			}
		}
		else
		{
			echo json_encode( array("Estado"=>0, "Error"=>"No permitido, solo por POST.") );
		}
	}
	private function EnviarCorreo($asContenido, $asAsunto, $asDestinatario, $asNombre)
	{
		require_once $this->_Config->get('Ruta')."app/libs/Correo.php";
		header ("content-type: application/json; charset=utf-8");
		return json_encode( array("Estado"=>EnviarCorreo($asContenido, $asAsunto, $asDestinatario, $asNombre)));
	}	
	/* Envios de Correo */
	
}
?>