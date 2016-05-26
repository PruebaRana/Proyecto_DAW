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

			<h1 class="Tcen">Pagina principal</h1>
			<br>
			
			<p>Bienvenidos a la pagina del proyecto DAW de Jaime Aguilá Sánchez</p>
			<br>			
			<p>Si es la primera vez que accede, puede crear la BD y el usuario admin accediendo a <a href="./instalar/index.php">/instalar/index.php</a></p>
			<p>Una vez que haya generado la BD, elimine la carpeta instalar.</p>
			<br>

			Titulo: <?php echo $ltitulo; ?>
			<br>
			ole ole ole
			
			<br>
			
			
		</section>
		
		<footer id="pie">
			<?php
			include("includes/_pie.php"); 
			?>
		</footer>
	</body>
</html>	
