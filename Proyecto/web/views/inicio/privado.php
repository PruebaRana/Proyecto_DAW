<?php ob_start() ?>

<h1 class="Tcen">Seccion privada</h1>
<br>

<?php
	echo "titulo: " . "ss";
?>

<br>

<?php $seccionContenido = ob_get_clean() ?>

<?php include 'views/plantilla.php' ?>




