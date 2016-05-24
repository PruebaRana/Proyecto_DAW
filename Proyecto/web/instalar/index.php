<!DOCTYPE html>
<?php
require_once "../lib/conexion.php";
require_once "../lib/usuarios.php";
require_once "../lib/utiles.php";
require_once "./instalar.php";

session_start();
$_SESSION = unserialize(serialize($_SESSION));
$usuario = obtenParametroArray($_SESSION, "user");

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == "POST")
{
	$db = conectarDB();
	executeSqlScript($db, './mensajes.sql');
	desconectarDB($db);
}
	
?>
<html lang="es-ES">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Practica Jaime Aguilá Sánchez</title>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css" media="all" />
		<link rel="stylesheet" type="text/css" href="../css/buttons.css" media="all" />
	</head>
	<body>
		<section id="contenido">
		
			<h1 class="Tcen">Instalar</h1>
			<?php 
			if ($metodo == "POST"){
			?>
				<p>
					Se ha lanzado el script de creacion, si todo ha funcionado correctamente se ha creado un usuario admin con pass admin.<br><br>
					Si todo es correcto, acuerdese de borrar esta carpeta una vez finalizado el proceso.
				</p>
				<br>
				<br>
				<input type="button" class="button button-rounded button-primary button-large Tcen" value="Acceder al sistema" onclick="window.location='../index.php';" />
			
			<?php 
			}else{
			?>
				<p>
					Asegurese de que los datos de conexion del fichero ./lib/conexion.php son correctos.
				</p>
				<br>
				<p>define("_HOST", '<?php echo _HOST; ?>');</p>
				<p>define("_USER", '<?php echo _USER; ?>');</p>
				<p>define("_PASS", '<?php echo _PASS; ?>');</p>
				<p>define("_BD", '<?php echo _BD; ?>');</p>
				<br><br>
				<p>El usuario '<?php echo _USER; ?>' tiene privilegios suficientes para poder crear las tablas y ejecutar consultas de Creacion, Listado, Actualizacion y Delete.</p>
				<p>Y no menos importante, existe un esquema llamado mensajes, a ser posible vacio o al menos la tabla de usuarios, ya que las claves van en MD5.</p>
				<br><br><br>
				<p>Si todo lo anterior se cumple, puede pulsar el boton instalar, para proceder con la creacion de la BD. Muchas gracias.</p>
				<br><br>
				
				<form action="./index.php" autocomplete="off" method="post" novalidate="novalidate" >
					<input type="submit" class="button button-rounded button-primary button-large Tcen" value="Instalar" />
				</form>
			<?php
			}
			?>
		</section>
	</body>
</html>	
