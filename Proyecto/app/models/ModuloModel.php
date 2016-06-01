<?php
class ModuloModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $IdCiclo;
    public $Nombre;
    public $Descripcion;
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
			else if ($asCampo == "descripcion" || $asCampo == "a.descripcion")
			{
				$this->_WherePDO->Where = "a.descripcion like concat('%', :descripcion, '%')";
				$this->_WherePDO->ArrayWhere = array(":descripcion" => $asValor);
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
		return $this->_db->ModulosObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->ModulosCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->ModulosItem($aiId);
	}

	public function Añadir()
	{
		return $this->_db->ModulosAñadir($this);
	}
	public function Modificar()
	{
		return $this->_db->ModulosModificar($this);
	}
	public function Eliminar()
	{
		return $this->_db->ModulosEliminar($this->Id);
	}
	/* Metodos principales */

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
		if($this->IdCiclo < 1)
		{
			$lswRes = false;
		}
		
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Nombre = mb_strtoupper(sanitizar($this->Nombre));
		$this->Descripcion = capitalizarPalabras(sanitizar($this->Descripcion));
		$this->Ciclo = capitalizarPalabras(sanitizar($this->Ciclo));
		
		return $this;
	}
	/* Metodos auxiliares */
	
}

?>