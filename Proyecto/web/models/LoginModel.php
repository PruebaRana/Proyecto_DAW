<?php
class LogonModel
{
    public $Id;
    public $Nombre;
    public $Usuario;
    public $Password;
    public $RememberMe;
	public $Perfiles;

	protected $_db;

    public function __construct()
    {
        // Obtenemos la �nica instancia a la BD
        $this->_db = ConexionBD::GetInstance();		
    }
 
	public function ComprobarUserPass($asUsuario, $asClave) {
		$res = null;

		$sql = strtolower("SELECT id, nombre, usuario, clave, email, fecha_alta, foto FROM usuarios WHERE usuario=:usuario AND clave=:clave");
		$result = $this->_db->prepare($sql);
		$result->execute(array(":usuario" => $asUsuario, ":clave" => $asClave));

		//Comprobamos cuantas retorna
		$cuenta = $result->rowCount();

		if ($result && $result->rowCount()>0) {
			foreach ($result as $valor) {
				$this->Id = obtenParametroArray($valor, "id");
				$this->Nombre = obtenParametroArray($valor, "nombre");
				$this->Usuario = obtenParametroArray($valor, "usuario");
				$this->Password = obtenParametroArray($valor, "clave");
				$res = $this;
			}
			$this->cargarPerfiles();
		}
		
		return $res;
	}
	
	private function cargarPerfiles() {
		$res = null;

		$sql = strtolower("SELECT A.nombre FROM roles A LEFT JOIN usuariosroles B ON A.Id = B.IdRol WHERE B.idusuario=:idusuario");
		$result = $this->_db->prepare($sql);
		$result->execute(array(":idusuario" => $this->Id));

		//Comprobamos cuantas retorna
		$cuenta = $result->rowCount();

		if ($result && $result->rowCount()>0) {
			foreach ($result as $valor) {
				$this->Perfiles .= obtenParametroArray($valor, "nombre") . "|";
			}
		}
	}
	
}

?>