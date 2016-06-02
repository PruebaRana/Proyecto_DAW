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
		FrontController::redirect("autentificacion", "login");
		die();
	}
}

// Funciones para montar URL
function obtenURLController($controller, $accion)
{
	return FrontController::getURL($controller, $accion);
}
function obtenURLRaiz()
{
	return FrontController::getURLRaiz();
}
// Funciones para montar URL


// Funciones para el tratamiento de texto
function ClearEvents($asTexto)
{
	return ClearCodeEvent($asTexto, "onBlur,onError,onFocus,onLoad,onResize,onUnload,onClick,onDblClick,onKeyDown,onKeyPress,onKeyUp,onMouseDown,onMouseMove,onMouseOut,onMouseOver,onMouseUp");
}
function ClearCodeEvent($asTexto, $asFilterEvent)
{
	$lsRes = $asTexto;
	$lEventos = explode(",", $asFilterEvent);
	foreach($lEventos as $lsItem)
	{
		$lsRes = preg_replace( "/".$lsItem."[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "" , $lsRes);
	}
	return $lsRes;
}
function ClearObjectsEmbed($asTexto)
{
	return ClearObjects($asTexto, "script,object,applet,embed");
}
function ClearObjects($asTexto, $asFilterObject)
{
	$lsRes = $asTexto;
	$lEventos = explode(",", $asFilterObject);
	foreach($lEventos as $lsItem)
	{
		$lsRes = preg_replace( "/((<".$lsItem.".*<\/[ ]?".$lsItem.">)|(<".$lsItem.".*\/>)|(<".$lsItem.">)|(<\/".$lsItem.">))/i", "" , $lsRes);
	}
	return $lsRes;
} 
function ClearJSScript($asTexto)
{
	$lsRes = $asTexto;
	$lsRes = preg_replace( "/((<script.*<\/[ ]?script>)|(<script.*\/>)|(<script>)|(<\/script>))/i", "" , $lsRes);

	return $lsRes;
} 


function sanitizar($asTexto, $aswAllowHTML = false){
	$lsRes = $asTexto;
	if ($aswAllowHTML)
	{
		// Eliminar los scripts
		//$lsRes = ClearJSScript($lsRes);
		$lsRes = ClearObjectsEmbed($lsRes);
		// Eliminar los posibles eventos
		$lsRes = ClearEvents($lsRes);
		
		// Escapar comillas y 
		$lsRes = addslashes($lsRes);
		//$lsRes = htmlentities($lsRes);
	}
	else
	{
		$lsRes = strip_tags($lsRes);
	}
	
	return $lsRes;
}
function normaliza ($cadena){
    $originales =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = mb_strtolower($cadena);
    return utf8_encode($cadena);
}
// OJO: No usar mb_strtolower, destroza acentos
function capitalizarPalabras ($cadena){
	return ucwords(mb_strtolower($cadena));
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
// Funciones para el tratamiento de texto


// Funciones para tokens
// Genera un Token totalmente random usando para ello una funcion mas segura que rand
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }
    return $token;
}
// Genera números random seguros, mejor que usar el rand()
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}
// Funciones para tokens

// Funciones para CSRF
function obtenerTokenAntiCSRF()
{
	NoCSRF::enableOriginCheck();
	return NoCSRF::generate('__RequestVerificationToken');
}
function obtenerHTMLHiddenAntiCSRF()
{
	NoCSRF::enableOriginCheck();
	return "<input name='__RequestVerificationToken' type='hidden' value='".NoCSRF::generate('__RequestVerificationToken')."' />";
}
function obtenerJSAntiCSRF()
{
	NoCSRF::enableOriginCheck();
	return array("__RequestVerificationToken_JS"=>NoCSRF::generate('__RequestVerificationToken_JS'));;
}
function validarTokenAntiCSRF($asSufijo="")
{
	$lswRes = false;
	try
	{
		NoCSRF::enableOriginCheck();
		// Run CSRF check, on POST data, in exception mode, for 20 minutes, in one-time mode.
		NoCSRF::check('__RequestVerificationToken'.$asSufijo, $_POST, true, 60*20, true );
		// form parsing, DB inserts, etc.
		$lswRes = true;
	}
	catch ( Exception $e )
	{
		// CSRF attack detected
		// $result = $e->getMessage() . ' Form ignored.';
	}
	return $lswRes;
}
// Funciones para CSRF
?>