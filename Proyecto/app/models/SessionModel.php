<?php
class SesionModel
{
	// Propiedades
    public $Id;
    public $Nombre;
    public $Usuario;
	public $Perfiles;
	// Propiedades
	
	function cargar ($id, $nombre, $usuario, $perfiles) {
		$this->Id = $id;
		$this->Nombre = $nombre;
		$this->Usuario = $usuario;
		$this->Perfiles = $perfiles;
	}
	
    // Constructores / destructores y magicos //
	public function __construct() {
		$this->Id = 0;
		$this->Nombre = null;
		$this->Usuario = null;
		$this->Perfiles = null;
    }
	function __destruct() {
	}	
	
	public function __get($name) {
		throw new Exception("Esta propiedad no existe $name");
	}
	public function __set($name, $val) {
		throw new Exception("Esta propiedad no existe $name");
	}
	public function __clone() {
		$this->id = 0;
	}
    // Constructores / destructores y magicos //
	
	function isInRol($aRoles = null) {
		$res = false;
		if ($this->Id > 0) 
		{
			if($aRoles != null)
			{
				$lsRoles = explode(" ", $aRoles);
				if($this->Perfiles != null)
				{
					$lsPerfiles = "|".$this->Perfiles."|";
					foreach($lsRoles as $lsRol)
					{
						if (strpos($lsPerfiles, "|".$lsRol."|") !== false) {
							$res = true;
							break;
						}				
					}
				}
			}
			else
			{
				$res = true;
			}
		}
		return $res;
	}
	
}
?>