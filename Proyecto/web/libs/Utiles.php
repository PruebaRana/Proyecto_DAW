<?php
function obtenParametroArray($aArray, $aParametro) {
	$lRes = null;
	if (isset($aArray[$aParametro])) {
		$lRes = $aArray[$aParametro];
	}
	return $lRes;
}


// Si no se pasa un nombre, solo comprueba que es un usuario, si se pasa un nombre, comprueba si es ese
// Lo utilizaremos para comprobar si es usuario o admin
function EstaLogueado($aRoles = null) {
	global $usuario;

	$res = false;
	if ($usuario != null && $usuario->Id > 0) 
	{
		if($aRoles != null)
		{
			$lsRoles = explode(" ", $aRoles);
			if($usuario->Perfiles != null)
			{
				$lsPerfiles = "|".$usuario->Perfiles."|";
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
	
	if(!$res) {
		header("Location:index.php?controlador=autentificacion&accion=login");
		die();
	}
}

?>