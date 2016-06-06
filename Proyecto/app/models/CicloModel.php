<?php
class CicloModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $Nombre;
    public $Descripcion;

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
			else if (substr($asCampo, 0, 11) == "Descripcion" || substr($asCampo, 1, 12) == ".Descripcion")
			{
				$this->_WherePDO->Where = "descripcion like concat('%', :descripcion, '%')";
				$this->_WherePDO->ArrayWhere = array(":descripcion" => $asValor);
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
		return $this->_db->CiclosObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->CiclosCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->CiclosItem($aiId);
	}

	public function Añadir()
	{
		return $this->_db->CiclosAñadir($this);
	}
	public function Modificar()
	{
		return $this->_db->CiclosModificar($this);
	}
	public function Eliminar()
	{
		return $this->_db->CiclosEliminar($this->Id);
	}
	/* Metodos principales */

	/* Obtener lista de opciones para un combo */
	public function ObtenerTodos()
	{
		$lItems = $this->ObtenerPagina(0, 1, "Nombre", "ASC", null);
		$lRes[] = new DatosCombo(0, "Seleccione un ciclo");
				
		foreach ($lItems as $lItem)
		{
			$lRes[] = new DatosCombo($lItem->Id, $lItem->Nombre);
		}

		return json_encode($lRes);
	}
	public function ObtenerTodosTexto()
	{
		$lItems = $this->ObtenerPagina(0, 1, "Nombre", "ASC", null);
		foreach ($lItems as $lItem)
		{
			$lRes[] = new DatosCombo($lItem->Nombre, $lItem->Nombre);
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
		if(strlen($this->Descripcion) < 1)
		{
			$lswRes = false;
		}
		
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Nombre = capitalizar(sanitizar($this->Nombre));
		$this->Descripcion = capitalizarPalabras(sanitizar($this->Descripcion));
		
		return $this;
	}
	/* Metodos auxiliares */
}
?>