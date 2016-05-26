<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="es-ES">
	<head>
		<title>$TituloPagina</title>
		<meta charset="utf-8" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="text/css" http-equiv="content-style-type" />
		<meta http-equiv="content-language" content="es" />
		<meta name="Locality" content="Valencia, España" />
		<meta name="Lang" content="ES" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="x-dns-prefetch-control" content="on">
		<meta name="robots" content="NOINDEX,NOARCHIVE,NOFOLLOW" />
		<meta name="resource-type" content="document" />
		<meta name="distribution" content="global" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
		<link rel="stylesheet" type="text/css" href="js/easyui/themes/default/easyui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="js/easyui/themes/icon.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/estilos.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/tema_defecto.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/buttons.css" media="all" />
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->

		<header id="cabecera">
			<?php
			include("includes/_cabecera.php"); 
			?>
		</header>

		<section id="contenido">

			<br>
			<h1 class="Tcen">Entrada al sistema</h1>
			<div id="capalogin" class="Tcen">
				<div class="Tcen icono_user"><i class="fa fa-user"></i></div>
				<div class="Tcen rojo mensaje"><?php echo $mensaje;?></div>
				
				<form action="./index.php?controlador=autentificacion&accion=login" autocomplete="off" method="post" novalidate="novalidate" >
					<input autocomplete="off" id="UserName" maxlength="10" name="UserName" placeholder="Usuario" type="text" value="" />
					<input autocomplete="off" id="Pass" name="Pass" placeholder="Contraseña" type="password" value="" />
					<input id="Password" name="Password" type="hidden" value="" />
					<input type="submit" class="button button-rounded button-primary button-large Tcen" value="Entrar al sistema" />
				</form>
			</div>
			
		</section>
		
		<footer id="pie">
			<?php
			include("includes/_pie.php"); 
			?>
		</footer>

		<script src="./js/jquery-1.8.3.min.js" type="text/javascript"></script>
		<script src="./js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="./js/md5.min.js" type="text/javascript"></script>
		<script>
			$(document).ready(function () { 
				$("#UserName").focus(); 
				setTimeout(function(){ $(".mensaje").html(""); }, 5000);
			});

			$(function () {
				$("form").submit(function (e) {
					if ($("form").valid() == true) {
						if ($("#Pass").val() != "") {
							var lTMP = $("#Pass").val();
							$("#Password").val($.md5($("#Pass").val()));
							$("#Pass").val("");
						}
					}
				});
			});
		</script>
	</body>
</html>	
