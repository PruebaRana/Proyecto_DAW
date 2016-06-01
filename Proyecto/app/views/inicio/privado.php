<?php ob_start() ?>

<h1 class="Tcen">Seccion privada</h1>
<br>

<?php
	echo "titulo: " . "ss";



  echo "<pre>";
  print_r($_SERVER);
  echo "</pre>";	
	
?>

<br>

<?php $seccionContenido = ob_get_clean() ?>

<?php include $config->get('Ruta').$config->get('viewsFolder').'plantilla.php' ?>




