<?php
class ProyectoArchivoModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $IdProyecto;
    public $Tipo;
    public $Ruta;
		
	private $_WherePDO = null;
    private $_File = null;
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
			else if ($asCampo == "idproyecto" || $asCampo == "a.idproyecto")
			{
				$this->_WherePDO->Where = "a.idproyecto=:idproyecto";
				$this->_WherePDO->ArrayWhere = array(":idproyecto" => $asValor);
			}
			else if ($asCampo == "tipo" || $asCampo == "a.tipo")
			{
				$this->_WherePDO->Where = "a.tipo like concat('%', :tipo, '%')";
				$this->_WherePDO->ArrayWhere = array(":tipo" => $asValor);
			}
			else
			{
				$this->_WherePDO->Where = "a.ruta like concat('%', :ruta, '%')";
				$this->_WherePDO->ArrayWhere = array(":ruta" => $asValor);
			}		
		}
		
    }
	/* Magicos, contructor destructor acceso y seteo */

	
	/* Metodos principales */
	public function ObtenerPagina($aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		return $this->_db->ProyectosArchivosObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->ProyectosArchivosCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->ProyectosArchivosItem($aiId);
	}
	
	public function Añadir()
	{
		$lRes = 0;
		if($this->Ruta != null){
			$lRes = $this->_db->ProyectosArchivosAñadir($this);
		}		
		return $lRes;
	}
	public function Eliminar()
	{
		$lRes = 0;
		if($this->DeleteFile()){
			$lRes = $this->_db->ProyectosArchivosEliminar($this->Id);
		}		
		return $lRes;
	}
	/* Metodos principales */

		
	/* Metodos auxiliares */
	public function AddFile($asFile = null)
	{
        $config = Config::GetInstance();
		$this->_File = $asFile;
		if($this->_File != null){
			$CarpetaFicheros = $config->get("Ruta").'app/contenidos/proyectos/';
			checkCarpeta($CarpetaFicheros);
			checkCarpeta($CarpetaFicheros.$this->IdProyecto);
			$Nombrefichero = $this->IdProyecto.'/'.getToken(4)."_".normaliza($this->_File['name']);
			$ficheroFinal = $CarpetaFicheros.$Nombrefichero;

			if (move_uploaded_file($this->_File['tmp_name'], $ficheroFinal)) {
				// Guardarlo en la BD
				$this->Ruta = $Nombrefichero;
			}else{
				$this->Ruta = null;
			}
		}
	}
	public function DeleteFile()
	{
		$Res = false;
        $config = Config::GetInstance();
		$Fichero = $this->Ruta;
		if($Fichero != null){
			$CarpetaFicheros = $config->get("Ruta").'app/contenidos/proyectos/';
			$Nombrefichero = $Fichero;
			$ficheroFinal = $CarpetaFicheros.$Nombrefichero;

			if (unlink ( $ficheroFinal ) ) {
				$Res = true;
			}
		}
		return $Res;
	}

	public function IsValid()
	{
		// hay que comprobar que el usuario y el correo no existan
		$lswRes = true;
		if(strlen($this->Ruta) < 1)
		{
			$lswRes = false;
		}
		if(strlen($this->Tipo) < 1)
		{
			$lswRes = false;
		}
		if($this->IdProyecto < 1)
		{
			$lswRes = false;
		}
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Id = sanitizar($this->Id);
		$this->IdProyecto = sanitizar($this->IdProyecto);
		$this->Tipo = Capitalizar(sanitizar($this->Tipo));
		$this->Ruta = normalizar(sanitizar($this->Ruta));

		return $this;
	}
	/* Metodos auxiliares */
}

?>