<?php
class CualidadModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $Nombre;

	private $_WherePDO = null;
	/* Propiedades */
	
	/* Magicos, contructor destructor acceso y seteo */
    public function __construct($asCampo = null, $asValor = null)
    {
		/* Si implementamos __construct, acordarse de llamar tmb al __construct del parent, ModelBase, para tener acceso a la BD*/
		parent::__construct();
		// Si nos llegan parametros para filtrar, generamos el objeto WherePDO, que usar ObtenerPagina y CountItem
		if($asCampo != null && $asValor != null)
		{
			$this->_WherePDO = new WherePDO();
			if (substr($asCampo, 0, 2) == "Id" || substr($asCampo, 1, 3) == ".Id")
			{
				$this->_WherePDO->Where = "id=:id";
				$this->_WherePDO->ArrayWhere = array(":id" => $asValor);
			}
			else
			{
				$this->_WherePDO->Where = "nombre like concat('%', :nombre, '%')";
				$this->_WherePDO->ArrayWhere = array(":nombre" => $asValor);
			}		
		}
    }
	/* Magicos, contructor destructor acceso y seteo */

	
	/* Metodos principales */
	public function ObtenerPagina($aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		return $this->_db->CualidadesObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->CualidadesCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->CualidadesItem($aiId);
	}

	public function Añadir()
	{
		return $this->_db->CualidadesAñadir($this);
	}
	public function Modificar()
	{
		return $this->_db->CualidadesModificar($this);
	}
	public function Eliminar()
	{
		return $this->_db->CualidadesEliminar($this->Id);
	}
	/* Metodos principales */

	/* Obtener lista de opciones para un combo */
	public function ObtenerTodos()
	{
		$lItems = $this->ObtenerPagina(0, 1, "Nombre", "ASC", null);
		foreach ($lItems as $lItem)
		{
			$lRes[] = new DatosCombo($lItem->Id, $lItem->Nombre);
		}

		return json_encode($lRes);
	}
	/* Obtener lista de opciones para un combo */
	
	/* Metodos auxiliares */
	public function IsValid()
	{
		$lswRes = true;
		if(strlen($this->Nombre) < 1)
		{
			$lswRes = false;
		}
		
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Nombre = capitalizarPalabras(sanitizar($this->Nombre));
		
		return $this;
	}
	/* Metodos auxiliares */
	
}

?>