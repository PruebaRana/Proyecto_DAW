<?php
/*
 Clase base para los modelos, se encarga de mantener acceso con la base de datos
*/

abstract class ModelBase
{
	protected $_db;
	protected $_titulo;
	
    public function __construct()
    {
        // Obtenemos la única instancia a la BD
        $this->_db = ConexionBD::GetInstance();		
		$this->_titulo = "SIP"; 
    }
	
}
?>