<?php
class ProyectoModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $Titulo;
    public $Fecha;
    public $IdAlumno;
    public $IdTutor;
    public $Curso;
    public $Ciclo;
    public $Grupo;
    public $Resumen;
    public $Herramientas;
    public $Comentarios;
    public $Valoracion;
    public $Borrado;
	//Extendidos
    public $Alumno;
    public $Tutor;
	public $IdCualidades;
	public $Cualidades;
	public $IdModulos;
	public $Modulos;
		
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
			else if ($asCampo == "alumno" || $asCampo == "b.alumno")
			{
				$this->_WherePDO->Where = "b.nombre like concat('%', :alumno, '%')";
				$this->_WherePDO->ArrayWhere = array(":alumno" => $asValor);
			}
			else if ($asCampo == "tutor" || $asCampo == "c.tutor")
			{
				$this->_WherePDO->Where = "c.nombre like concat('%', :tutor, '%')";
				$this->_WherePDO->ArrayWhere = array(":tutor" => $asValor);
			}
			else if ($asCampo == "curso" || $asCampo == "a.curso")
			{
				$this->_WherePDO->Where = "a.curso=:curso";
				$this->_WherePDO->ArrayWhere = array(":curso" => $asValor);
			}
			else if ($asCampo == "ciclo" || $asCampo == "a.ciclo")
			{
				$this->_WherePDO->Where = "a.ciclo like concat('%', :ciclo, '%')";
				$this->_WherePDO->ArrayWhere = array(":ciclo" => $asValor);
			}
			else if ($asCampo == "grupo" || $asCampo == "a.grupo")
			{
				$this->_WherePDO->Where = "a.grupo like concat('%', :grupo, '%')";
				$this->_WherePDO->ArrayWhere = array(":grupo" => $asValor);
			}
			else if ($asCampo == "valoracion" || $asCampo == "a.valoracion")
			{
				$this->_WherePDO->Where = "a.valoracion like concat('%', :valoracion, '%')";
				$this->_WherePDO->ArrayWhere = array(":valoracion" => $asValor);
			}
			else
			{
				$this->_WherePDO->Where = "a.titulo like concat('%', :titulo, '%')";
				$this->_WherePDO->ArrayWhere = array(":titulo" => $asValor);
			}		
		}
		
		// Por defecto generamos una clave a boleo. y lo activamos
		$this->Curso = date("Y");
		$this->Fecha = date("d/m/Y H:i:s", time());;
    }
	/* Magicos, contructor destructor acceso y seteo */

	
	/* Metodos principales */
	public function ObtenerPagina($aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		return $this->_db->ProyectosObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->ProyectosCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->ProyectosItem($aiId);
	}

	public function Añadir()
	{
		return $this->_db->ProyectosAñadir($this);
	}
	public function Modificar()
	{
		return $this->_db->ProyectosModificar($this);
	}
	public function Eliminar()
	{
		return $this->_db->ProyectosEliminar($this->Id);
	}
	/* Metodos principales */

	/* Metodos auxiliares */
	public function IsValid()
	{
		// hay que comprobar que el usuario y el correo no existan
		$lswRes = true;
		if(strlen($this->Titulo) < 1)
		{
			$lswRes = false;
		}
		if($this->Curso < 2010)
		{
			$lswRes = false;
		}
		if(strlen($this->Ciclo) < 1)
		{
			$lswRes = false;
		}
		if(strlen($this->Grupo) < 1)
		{
			$lswRes = false;
		}

		if($this->IdAlumno < 1)
		{
			$lswRes = false;
		}
		
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Titulo = capitalizarPalabras(sanitizar($this->Titulo));
		$this->Fecha = sanitizar($this->Fecha);
		$this->IdAlumno = sanitizar($this->IdAlumno);
		$this->IdTutor = sanitizar($this->IdTutor);
		$this->Curso = sanitizar($this->Curso);
		$this->Ciclo = mb_strtoupper(sanitizar($this->Ciclo));
		$this->Grupo = mb_strtoupper(sanitizar($this->Grupo));

		$this->Resumen = sanitizar($this->Resumen, true);
		$this->Herramientas = sanitizar($this->Herramientas, true);
		$this->Comentarios = sanitizar($this->Comentarios, true);
		$this->Valoracion = capitalizarPalabras(sanitizar($this->Valoracion));
		
		$this->Cualidades = capitalizarPalabras(sanitizar($this->Cualidades));
		$this->IdCualidades = capitalizarPalabras(sanitizar($this->IdCualidades));
		$this->Modulos = mb_strtoupper(sanitizar($this->Modulos));
		$this->IdModulos = mb_strtoupper(sanitizar($this->IdModulos));

		return $this;
	}
	/* Metodos auxiliares */

	public function getCualidades()
	{
		$lItems = explode("," ,$this->IdCualidades);
		$lCad = "";
		foreach($lItems as $Item){
			$lCad .= "\"".trim($Item)."\",";
		}
		return $lCad;
	}
	public function getModulos()
	{
		$lItems = explode("," ,$this->IdModulos);
		$lCad = "";
		foreach($lItems as $Item){
			$lCad .= "\"".trim($Item)."\",";
		}
		return $lCad;
	}

}

?>