<!DOCTYPE html>
<?php
//Obtenemos la URL base y la Ruta local
$lsURL = str_replace("/instalar/index.php", "", $_SERVER["SCRIPT_NAME"]);
$lsRuta = str_replace("web\instalar\index.php", "", $_SERVER["SCRIPT_FILENAME"]);

//Incluimos algunas clases:
require_once $lsRuta.'app/libs/Config.php'; 		//de configuracion
require_once $lsRuta.'app/libs/ConexionDB.php'; 	//Acceso a BD por PDO con singleton
require_once $lsRuta.'app/libs/Utiles.php'; 		//
require_once "./instalar.php";
require_once $lsRuta.'app/config.php';

session_start();
$_SESSION = unserialize(serialize($_SESSION));
$usuario = obtenParametroArray($_SESSION, "user");

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == "POST")
{
	$db = ConexionBD::GetInstance();
	executeSqlScript($db, './database.sql');
}
	
?>
<html lang="es-ES">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
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
					Se ha lanzado el script de creación, si todo ha funcionado correctamente se han creado tres usuarios admin/profesor y alumno con pass 12345.<br><br>
					Si todo es correcto, acuérdese de borrar esta carpeta una vez finalizado el proceso.
				</p>
				<br>
				<br>
				<input type="button" class="button button-rounded button-primary button-large Tcen" value="Acceder al sistema" onclick="window.location='../index.php';" />
			
			<?php 
			}else{
			?>
				<p>
					Asegurese de que los datos de conexión del fichero ..app/config.php son correctos.
				</p>
				<br>
				<p>$config->set('dbhost', '<?php echo $config->get('dbhost'); ?>');</p>
				<p>$config->set('dbname', '<?php echo $config->get('dbname'); ?>');</p>
				<p>$config->set('dbuser', '<?php echo $config->get('dbuser'); ?>');</p>
				<p>$config->set('dbpass', '<?php echo $config->get('dbpass'); ?>');</p>
				<br><br>
				<p>El usuario '<?php echo $config->get('dbuser'); ?>' tiene privilegios suficientes para poder crear las tablas y ejecutar consultas de Creación, Listado, Actualización y Borrado.</p>
				<p>Y no menos importante, existe un esquema llamado <?php echo $config->get('dbname'); ?>, a ser posible vacio.</p>
				<br><br><br>
				<p>Si todo lo anterior se cumple, puede pulsar el botón instalar, para proceder con la creación de la BD. Muchas gracias.</p>
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
