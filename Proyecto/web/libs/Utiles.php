<?php
// Usado por las plantillas para comprobar si una seccion esta definida y retornarla sin producir errores en el fichero de php
function obtenParametro(&$aParametro, $aDefault = null) {
	$lRes = $aDefault;
	if (isset($aParametro)) {
		$lRes = $aParametro;
	}
	return $lRes;
}

// Usado para acceder a un elemento de un array sin producir errores si no existe el parametro
function obtenParametroArray($aArray, $aParametro, $aDefault = null) {
	$lRes = $aDefault;
	if (isset($aArray[$aParametro])) {
		$lRes = $aArray[$aParametro];
	}
	return $lRes;
}

// Si no se pasan roles, solo comprueba que este logueado, 
// Si se pasa una lista de roles, comprueba que el usuario tenga al menos uno de ellos
// Lo utilizaremos para comprobar si es usuario tiene permiso para acceder a una seccion
function EstaLogueado($aRoles = null) {
	global $usuario;
	
	if(!$usuario->isInRol($aRoles)) {
		header("Location:index.php?controlador=autentificacion&accion=login");
		die();
	}
}

?>