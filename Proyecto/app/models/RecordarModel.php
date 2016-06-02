<?php
class RecordarModel extends ModelBase
{
    public $Id;
    public $Usuario;
    public $Pass;
    public $Nombre;
    public $Correo;

	/* Si implementamos __construct, acordarse de llamar tmb al __construct del parent, ModelBase, para tener acceso a la BD
    public function __construct()
    {
		parent::__construct();
    }
	*/
	public function ObtenerUserByEmail($asEMail) {
		$res = null;

		$sql = strtolower("SELECT id, nombre, usuario, clave, email FROM usuarios WHERE email=:email");
		$result = $this->_db->prepare($sql);
		$result->execute(array(":email" => $asEMail));

		//Comprobamos cuantas retorna
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			foreach ($result as $valor) {
				$this->Id = sanitizar(obtenParametroArray($valor, "id"));
				$this->Usuario = sanitizar(obtenParametroArray($valor, "usuario"));
				$this->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
				$this->Clave = sanitizar(obtenParametroArray($valor, "clave"));
				$this->Correo = sanitizar(obtenParametroArray($valor, "email"));
				$res = $this;
			}
		}
		
		return $res;
	}
	public function ObtenerUserById($asId) {
		$res = null;

		$sql = strtolower("SELECT id, nombre, usuario, clave, email FROM usuarios WHERE id=:id");
		$result = $this->_db->prepare($sql);
		$result->execute(array(":id" => $asId));

		//Comprobamos cuantas retorna
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			foreach ($result as $valor) {
				$this->Id = sanitizar(obtenParametroArray($valor, "id"));
				$this->Usuario = sanitizar(obtenParametroArray($valor, "usuario"));
				$this->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
				$this->Clave = sanitizar(obtenParametroArray($valor, "clave"));
				$this->Correo = sanitizar(obtenParametroArray($valor, "email"));
				$res = $this;
			}
		}
		
		return $res;
	}	
	public function CambiarContrasena($asId, $asClave) {
		$res = null;

		$sql = strtolower("UPDATE usuarios SET Clave=:clave WHERE Id=:id");
		$result = $this->_db->prepare($sql);
		$result->execute(array(":clave" => $asClave, ":id" => $asId));

		//Comprobamos cuantas retorna
		return $result->rowCount();
	}
}


class CambioClaveOlvidadaModel extends ModelBase
{
	public $Id;
    public $Token;
    public $NewPassword;
    public $ConfirmPassword;

	/* Si implementamos __construct, acordarse de llamar tmb al __construct del parent, ModelBase, para tener acceso a la BD
    public function __construct()
    {
		parent::__construct();
    }
	*/
	public function ObtenerUserByEmail($asEMail) {
		$res = null;

		$sql = strtolower("SELECT id, nombre, usuario, clave, email FROM usuarios WHERE email=:email");
		$result = $this->_db->prepare($sql);
		$result->execute(array(":email" => $asEMail));

		//Comprobamos cuantas retorna
		$cuenta = $result->rowCount();
		if ($result && $result->rowCount()>0) {
			foreach ($result as $valor) {
				$this->Id = sanitizar(obtenParametroArray($valor, "id"));
				$this->Usuario = sanitizar(obtenParametroArray($valor, "usuario"));
				$this->Nombre = sanitizar(obtenParametroArray($valor, "nombre"));
				$this->Clave = sanitizar(obtenParametroArray($valor, "clave"));
				$this->Correo = sanitizar(obtenParametroArray($valor, "email"));
				$res = $this;
			}
		}
		
		return $res;
	}
}
?>