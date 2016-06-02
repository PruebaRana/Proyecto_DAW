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
        require_once $this->_Config->get('Ruta').$this->_Config->get('modelsFolder').'RecordarModel.php';
	}
    public function __destruct() 
	{
    }	

	/* Login */
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
	/* Login */

	/* Recordar */
    public function recordar()
    {
		if($this->_Method == "POST")
		{
			$this->recordar_post();
		}
		else
		{
			$this->recordar_get();
		}
    }
    private function recordar_get()
    {
        //Creamos una instancia de nuestro "modelo"
        $item = new RecordarModel();
 
        //Le pedimos al modelo todos los items
        //$listado = $items->listadoTotal();
 
        //Pasamos a la vista toda la información que se desea representar
		$data["Item"] = $item;
		$data["mensaje"] = "";
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre . "/recordar.php", $data);
	}
    private function recordar_post()
    {
        //Creamos una instancia de nuestro "modelo"
        $item = new RecordarModel();
		$Correo = sanitizar(obtenParametroArray($_POST, "Correo"));

		// Buscar al usuario de ese correo
		$item->ObtenerUserByEmail($Correo);
		
		if($item->Id > 0)
		{
			// Le mando el correo
			$lsId = $item->Id;
			$lsUsuario = $item->Usuario;
			$lsNombre = $item->Nombre;
			$lsClave = $item->Clave;
			$lsCorreo = $item->Correo;

			// Obtenemos la plantilla
			$lsPlantilla = new PlantillaCorreoModel();
			$Lista = $lsPlantilla->ObtenerPlantilla("RecuperarContrasena");
			if(Count($Lista)>0 && strlen($lsNombre) > 0 && strlen($lsCorreo) > 0 ){
				$lMiPlantilla = $Lista[0];
				// Sustituir los elementos.
				// Obtener el enlace de validación
				$lsToken = md5($lsId ."^".$lsUsuario ."^".$lsClave);
				// Montar el Enlace
				$lsEnlace = "http://".$_SERVER["SERVER_NAME"].obtenURLController("Autentificacion", "CambiarContrasenaOlvidada")."/?id=".$lsId."&token=".base64_encode($lsToken);
					
				// ASUNTO, NOMBRE, ENLACE
				$lsBody = $lMiPlantilla->Descripcion;
				$lsBody = str_replace("[ASUNTO]", $lMiPlantilla->Asunto, $lsBody);
				$lsBody = str_replace("[NOMBRE]", $lsNombre, $lsBody);
				$lsBody = str_replace("[ENLACE]", $lsEnlace, $lsBody);

				if( $this->EnviarCorreo($lsBody, $lMiPlantilla->Asunto, $lsCorreo, $lsNombre) == "Ok"){
					FrontController::redirect("autentificacion", "login");
				}else{
					// no se ha logueado.
					$data["Item"] = $item;
					$data["mensaje"] = "No se ha podido enviar el correo";

					//Finalmente presentamos nuestra plantilla
					$this->view->show($this->_Nombre . "/recordar.php", $data);
				}
			}

		}
		else
		{
			// no se ha logueado.
			$data["Item"] = $item;
			$data["mensaje"] = "Lo siento, no hay usuarios con ese correo";

			//Finalmente presentamos nuestra plantilla
			$this->view->show($this->_Nombre . "/recordar.php", $data);
		}
	}
	/* Recordar */
	
	/* Contaseña olvidada */
    public function CambiarContrasenaOlvidada()
    {
		if($this->_Method == "POST")
		{
			$this->CambiarContrasenaOlvidada_post();
		}
		else
		{
			$this->CambiarContrasenaOlvidada_get();
		}
    }
    private function CambiarContrasenaOlvidada_get()
    {
		$id = obtenParametroArray($_GET, "id", "");
		$token = obtenParametroArray($_GET, "token", "");

        $item = new RecordarModel();
		// Buscar al usuario de ese correo
		$item->ObtenerUserById($id);
		
		if($item->Id != $id){
			FrontController::redirect("autentificacion", "recordar");
		}else{
			$lsId = $item->Id;
			$lsUsuario = $item->Usuario;
			$lsClave = $item->Clave;

			$lsToken = base64_encode(md5($lsId ."^".$lsUsuario ."^".$lsClave));
			
			if($token != $lsToken){
		echo "$lsId -- $lsUsuario -- $lsClave -- $token --  $lsToken";
		die;
				FrontController::redirect("autentificacion", "recordar");
			}
		}
		
		// Todo perfecto permitir acceso a la pagina de cambio de pass.
		$lItem = new CambioClaveOlvidadaModel();
		$lItem->Id=$lsId;
		$lItem->Token=$lsToken;
		
		//Pasamos a la vista toda la información que se desea representar
		$data["Item"] = $lItem;
		$data["mensaje"] = "";
 
		//Finalmente presentamos nuestra plantilla
		$this->view->show($this->_Nombre . "/CambiarContrasenaOlvidada.php", $data);
		
	}
    private function CambiarContrasenaOlvidada_post()
    {
		$id = obtenParametroArray($_POST, "Id", "");
		$token = obtenParametroArray($_POST, "Token", "");
		$NewPassword = obtenParametroArray($_POST, "NewPassword", "");
		$ConfirmPassword = obtenParametroArray($_POST, "ConfirmPassword", "");


        $item = new RecordarModel();
		// Buscar al usuario de ese correo
		$item->ObtenerUserById($id);
		
		if($item->Id != $id){
			FrontController::redirect("autentificacion", "recordar");
		}else{
			$lsId = $item->Id;
			$lsUsuario = $item->Usuario;
			$lsClave = $item->Clave;

			$lsToken = base64_encode(md5($lsId ."^".$lsUsuario ."^".$lsClave));
			
			if($token != $lsToken){
				FrontController::redirect("autentificacion", "recordar");
			}

            // Todo perfecto permitir acceso a la pagina de cambio de pass.
			if ($item->CambiarContrasena($lsId, $NewPassword) < 1){
				FrontController::redirect("autentificacion", "recordar");
			}
			else{
				FrontController::redirect("autentificacion", "login");
			}
		}
	}
	/* Contaseña olvidada */

	
	
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
		//header ("content-type: application/json; charset=utf-8");
		return EnviarCorreo($asContenido, $asAsunto, $asDestinatario, $asNombre);
	}	
	/* Envios de Correo */
	
}
?>