<!DOCTYPE html>

<html lang="es-ES">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>MVC Inicio</title>
		<link rel="stylesheet" type="text/css" href="css/estilos.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/buttons.css" media="all" />
	</head>
	<body>
		<header>
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

			Titulo: <?php echo $vars["ltitulo"]; ?>
			<br>
			ole ole ole
			
			<br>
			
			
		</section>
		
		<footer>
		<?php
			include("includes/_pie.php"); 
		?>
		</footer>
	</body>
</html>	
