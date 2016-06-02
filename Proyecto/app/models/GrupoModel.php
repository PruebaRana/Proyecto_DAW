<?php
class GrupoModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $IdCiclo;
    public $Nombre;
	//Extendidos
    public $Ciclo;

	
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
			$asCampo = strtolower($asCampo);
			if ($asCampo == "id" || $asCampo == "a.id")
			{
				$this->_WherePDO->Where = "a.id=:id";
				$this->_WherePDO->ArrayWhere = array(":id" => $asValor);
			}
			else if ($asCampo == "ciclo" || $asCampo == "b.ciclo")
			{
				$this->_WherePDO->Where = "b.nombre like concat('%', :ciclo, '%')";
				$this->_WherePDO->ArrayWhere = array(":ciclo" => $asValor);
			}
			else
			{
				$this->_WherePDO->Where = "a.nombre like concat('%', :nombre, '%')";
				$this->_WherePDO->ArrayWhere = array(":nombre" => $asValor);
			}		
		}
    }
	/* Magicos, contructor destructor acceso y seteo */

	
	/* Metodos principales */
	public function ObtenerPagina($aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		return $this->_db->GruposObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->GruposCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->GruposItem($aiId);
	}

	public function Añadir()
	{
		return $this->_db->GruposAñadir($this);
	}
	public function Modificar()
	{
		return $this->_db->GruposModificar($this);
	}
	public function Eliminar()
	{
		return $this->_db->GruposEliminar($this->Id);
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
		if($this->IdCiclo < 1)
		{
			$lswRes = false;
		}
		
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Nombre = mb_strtoupper(sanitizar($this->Nombre));
		$this->Ciclo = capitalizarPalabras(sanitizar($this->Ciclo));
		
		return $this;
	}
	/* Metodos auxiliares */
	
}

?>