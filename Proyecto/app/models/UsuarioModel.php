<?php
class UsuarioModel extends ModelBase
{
	/* Propiedades */
    public $Id;
    public $Usuario;
    public $Clave;
    public $Nombre;
    public $EMail;
    public $Fecha_Alta;
    public $Foto;
    public $Activo;
    public $Borrado;
	//Extendidos
    public $Roles;
	
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
			else if ($asCampo == "roles" || $asCampo == "b.roles")
			{
				$this->_WherePDO->Where = "b.roles like concat('%', :roles, '%')";
				$this->_WherePDO->ArrayWhere = array(":roles" => $asValor);
			}
			else if ($asCampo == "usuario" || $asCampo == "a.usuario")
			{
				$this->_WherePDO->Where = "a.usuario like concat('%', :usuario, '%')";
				$this->_WherePDO->ArrayWhere = array(":usuario" => $asValor);
			}
			else if ($asCampo == "email" || $asCampo == "a.email")
			{
				$this->_WherePDO->Where = "a.email like concat('%', :email, '%')";
				$this->_WherePDO->ArrayWhere = array(":email" => $asValor);
			}
			else if ($asCampo == "activo" || $asCampo == "a.activo")
			{
				$this->_WherePDO->Where = "a.activo=:activo";
				$this->_WherePDO->ArrayWhere = array(":activo" => $asValor);
			}
			else
			{
				$this->_WherePDO->Where = "a.nombre like concat('%', :nombre, '%')";
				$this->_WherePDO->ArrayWhere = array(":nombre" => $asValor);
			}		
		}
		
		// Por defecto generamos una clave a boleo. y lo activamos
		$this->Clave = md5(getToken(10));
		$this->Activo = 1;
		$this->Roles = "Alumno";
    }
	/* Magicos, contructor destructor acceso y seteo */

	
	/* Metodos principales */
	public function ObtenerPagina($aiPaginaActual = 1, $aiItemsPorPagina = 10, $asCampoOrdenacion = "", $asTipoOrdenacion = "")
	{
		return $this->_db->UsuariosObtenerPagina($this->_WherePDO, $aiPaginaActual, $aiItemsPorPagina, $asCampoOrdenacion, $asTipoOrdenacion);
	}

	public function CountItems()
	{
		return $this->_db->UsuariosCount($this->_WherePDO);
	}

	public function ObtenerItem($aiId)
	{
		return $this->_db->UsuariosItem($aiId);
	}

	public function Añadir()
	{
		return $this->_db->UsuariosAñadir($this);
	}
	public function Modificar()
	{
		return $this->_db->UsuariosModificar($this);
	}
	public function Eliminar()
	{
		return $this->_db->UsuariosEliminar($this->Id);
	}
	/* Metodos principales */

	/* Metodos auxiliares */
	public function IsValid()
	{
		// hay que comprobar que el usuario y el correo no existan
		$lswRes = true;
		if(strlen($this->Usuario) < 1)
		{
			$lswRes = false;
		}
		if(strlen($this->EMail) < 1)
		{
			$lswRes = false;
		}
		if(strlen($this->Nombre) < 1)
		{
			$lswRes = false;
		}
		
		return $lswRes;
	}

	public function Sanitize()
	{
		$this->Usuario = sanitizar($this->Usuario);
		$this->Nombre = capitalizarPalabras(sanitizar($this->Nombre));
		$this->EMail = mb_strtolower(sanitizar($this->EMail));
		$this->Foto = normaliza(sanitizar($this->Foto));
		
		$this->Activo = ConexionBD::ObtenerSioNo(sanitizar($this->Activo));
		
		return $this;
	}
	/* Metodos auxiliares */

	public function getRoles()
	{
		$lRoles = explode("," ,$this->Roles);
		$lCad = "";
		foreach($lRoles as $rol){
			$lCad .= "\"".trim($rol)."\",";
		}
		return $lCad;
	}


	/* Obtener lista de opciones para un combo */
	public function ObtenerTodosAlumnos()
	{
		$WherePDO = new WherePDO();
		$WherePDO->Where = "b.roles like '%Alumno%' AND a.Activo=1";
		$WherePDO->ArrayWhere = array();

		$lItems = $this->_db->UsuariosObtenerTodos($WherePDO, "Nombre", "ASC");
		foreach ($lItems as $lItem)
		{
			$lRes[] = new DatosCombo($lItem->Id, $lItem->Nombre);
		}

		return json_encode($lRes);
	}
	public function ObtenerTodosProfesores()
	{
		$WherePDO = new WherePDO();
		$WherePDO->Where = "b.roles like '%Profesor%' AND a.Activo=1";
		$WherePDO->ArrayWhere = array();

		$lItems = $this->_db->UsuariosObtenerTodos($WherePDO, "Nombre", "ASC");
		foreach ($lItems as $lItem)
		{
			$lRes[] = new DatosCombo($lItem->Id, $lItem->Nombre);
		}

		return json_encode($lRes);
	}
	/* Obtener lista de opciones para un combo */

	
}

?>