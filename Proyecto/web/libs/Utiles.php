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

// Funciones para el tratamiento de texto
function sanitizar ($cadena){
	$lsRes = str_replace("'", "", $cadena);
	$lsRes = str_replace("\"", "", $lsRes);
	return $lsRes;
}
function normaliza ($cadena){
    $originales =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}
function capitalizarPalabras ($cadena){
	return ucwords(strtolower($cadena));
}
function capitalizarFrases ($cadena){
	$cadenas = explode('.',$cadena);
	$cadena_final='';
	foreach ($cadenas as $cadena){   
	   $cadena_sin_espacios = ltrim($cadena);
	   $cadena_final .= '. '.ucfirst($cadena_sin_espacios);
	}
	return substr($cadena_final,1); 
}

?>