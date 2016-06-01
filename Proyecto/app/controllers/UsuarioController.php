<?php
class UsuarioController extends ControllerBase
{
    function __construct()
    {
		parent::__construct("Usuario");
    }
    public function __destruct() 
	{
    }	
 
	public function Indice()
	{
		$data['titulo'] = "Alumnos";
		$data['Mensaje'] = "";
 
        //Finalmente presentamos nuestra plantilla
        $this->view->show($this->_Nombre . "/indice.php", $data);
	}


}
?>