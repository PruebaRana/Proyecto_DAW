<?php ob_start() ?>

<div class="ficha" id="DivRespuesta">
<form action="<?PHP echo(obtenURLController("Ciclo", "crear")); ?>" class="form-horizontal" data-ajax="true" data-ajax-method="Post" data-ajax-mode="replace" data-ajax-update="#DivRespuesta" id="form" method="post" accept-charset="UTF8">
	<br />
	<!-- aqui deberiamos de pintar los mensajes de summary del modelo si este ha producido errores -->
    <br />
	
	<?php include "_CreateOrEdit.php" ?>

</form>
</div>
<?php $seccionContenido = ob_get_clean() ?>

<?php 
echo obtenParametro($seccionContenido);
?>

