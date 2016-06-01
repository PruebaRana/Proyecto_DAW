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

/*
	Clase usada por los modelos cuando deben mandar datos para un combo
*/
class DatosCombo {
	var $id;
	var $nombre;

    public function __construct($asId=null, $asNombre=null)
    {
        $this->id = $asId;
		$this->nombre = $asNombre; 
    }
} 

?>