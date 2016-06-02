<?php ob_start() ?>

<br>
<h1 class="Tcen">Usuarios registrados</h1>

<div id="capalogin" class="Tcen">
	Por favor, escriba su dirección de correo electrónico, y le enviaremos un correo, con las instrucciones para establecer su nueva contraseña.
	<br /><br />

	<div class="Tcen icono_user"><i class="fa fa-user"></i></div>
	<div class="Tcen rojo mensaje"><?php echo $mensaje;?></div>
	
	<form action="<?php echo FrontController::getURL("autentificacion", "recordar"); ?>" autocomplete="off" method="post" novalidate="novalidate" >
		<input data-val="true" data-val-regex="El correo no es valido" data-val-regex-pattern="^\w[-+\.\w]+[-+\w]@\w+[-+\.\w]+\.\w+$" data-val-required="El campo Correo es obligatorio." id="Correo" name="Correo" type="text" value="">
		<input type="submit" class="button button-rounded button-primary button-large Tcen" value="Enviar" />
		<a href="<?php echo FrontController::getURL("autentificacion", "login"); ?>">« Volver al Inicio de sesión</a>
	</form>
</div>

<?php $seccionContenido = ob_get_clean() ?>

<?php ob_start() ?>
<script src="<?php echo $config->get('URL'); ?>/js/md5.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function () { 
		$("#Correo").focus(); 
	});
</script>
<?php $seccionJS = ob_get_clean() ?>

<?php include $config->get('Ruta').$config->get('viewsFolder').'plantilla.php' ?>