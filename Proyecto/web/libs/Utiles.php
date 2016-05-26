<?php
function obtenParametroArray($aArray, $aParametro, $aDefault = null) {
	$lRes = $aDefault;
	if (isset($aArray[$aParametro])) {
		$lRes = $aArray[$aParametro];
	}
	return $lRes;
}

// Si no se pasa un nombre, solo comprueba que es un usuario, si se pasa un nombre, comprueba si es ese
// Lo utilizaremos para comprobar si es usuario o admin
function EstaLogueado($aRoles = null) {
	global $usuario;
	
	if(!$usuario->isInRol($aRoles)) {
		header("Location:index.php?controlador=autentificacion&accion=login");
		die();
	}
}

?>