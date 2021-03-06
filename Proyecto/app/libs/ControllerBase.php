<?php
abstract class ControllerBase
{
	protected $_Nombre;
	protected $_Method;
	protected $_Config;
	
    public function __construct($asNombre)
    {
		$this->_Nombre = $asNombre;
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
		$this->_Method = $_SERVER['REQUEST_METHOD'];
		$this->_Config = Config::GetInstance();
    }
}

// Clase usada por las acciones ObtenerDatos de los controladores para obtener los parametros que envia el grid
class ParametrosObtenerDatos {
	var $_page = 0;
	var $_rows = 1;
	var $_sort = "fecha";
	var $_order = "DESC";
	var $_whereCampo = "";
	var $_whereValor = "";

    function __construct($asCampoSortDefault = "id")
    {
		$this->_page = sanitizar(obtenParametroArray($_POST, "page", 0));
		$this->_rows = sanitizar(obtenParametroArray($_POST, "rows", 1));
		$this->_sort = sanitizar(obtenParametroArray($_POST, "sort", $asCampoSortDefault));
		$this->_order = sanitizar(obtenParametroArray($_POST, "order", "ASC"));
		$this->_whereCampo = sanitizar(obtenParametroArray($_POST, "WhereCampo", ""));
		$this->_whereValor = sanitizar(obtenParametroArray($_POST, "WhereValor", ""));
	}
} 

// Clase usada por las acciones ObtenerDatos para retornar el resultado por JSON
class DatosGrid {
	var $total;
	var $rows;
} 

?>