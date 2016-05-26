<?php
abstract class ControllerBase
{
	protected $_Nombre;
	protected $_Method;
	
    public function __construct($asNombre)
    {
		$this->_Nombre = $asNombre;
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
		$this->_Method = $_SERVER['REQUEST_METHOD'];
    }
}
?>