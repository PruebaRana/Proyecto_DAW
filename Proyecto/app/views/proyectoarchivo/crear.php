<div class="ficha" id="DivRespuestaFile">
<form action="<?PHP echo(obtenURLController("ProyectoArchivo", "crear")); ?>" class="form-horizontal" data-ajax="true" 
	data-ajax-method="Post" data-ajax-mode="replace" data-ajax-update="#DivRespuestaFile" id="formFile" name="formFile" method="post">
	<br />
	<!-- aqui deberiamos de pintar los mensajes de summary del modelo si este ha producido errores -->
    <br />
	<?php include "_CreateOrEdit.php" ?>
</form>
</div>
