<?php ob_start() ?>

<br>
<h1 class="Tcen">Informacion de la cuenta</h1>

<div id="capalogin" class="Tcen">
	<p>Rellene el formulario para cambiar la contraseña</p>
	<p>La nueva contraseña requiere un minimo de 7 caracteres.</p>
	<br />

	<div class="Tcen icono_user"><i class="fa fa-user"></i></div>
	<div class="Tcen rojo mensaje"><?php echo $mensaje;?></div>
	
	<form action="<?php echo FrontController::getURL("autentificacion", "cambiarcontrasenaolvidada"); ?>" autocomplete="off" method="post" novalidate="novalidate" >
		<label for="NewPassword">Contraseña nueva</label>
		<input data-val="true" data-val-length="La Contraseña nueva debe tener al menos 6 caracteres de longitud." data-val-length-max="100" data-val-length-min="6" data-val-required="El campo Contraseña nueva es obligatorio." id="NewPassword" name="NewPassword" type="password" /><br />
		<span class="field-validation-valid" data-valmsg-for="NewPassword" data-valmsg-replace="true"></span>
	
		<label for="ConfirmPassword">Confirmar contraseña</label>
		<input data-val="true" data-val-equalto="La contraseña nueva y la confirmacion deben de ser identicas" data-val-equalto-other="*.NewPassword" id="ConfirmPassword" name="ConfirmPassword" type="password" /><br />
		
		
		<input name="Id" type="hidden" value="<?PHP echo($Item->Id); ?>">
		<input name="Token" type="hidden" value="<?PHP echo($Item->Token); ?>">		

		<span class="field-validation-valid" data-valmsg-for="ConfirmPassword" data-valmsg-replace="true"></span>
		<input type="submit" class="button button-rounded button-primary button-large Tcen" value="Cambiar contraseña" />
	</form>
</div>

<?php $seccionContenido = ob_get_clean() ?>

<?php ob_start() ?>
<script src="<?php echo $config->get('URL'); ?>/js/md5.min.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
    // Poner el foco en el correo
    $("#NewPassword").focus();
});
$(function () {
    $("form").submit(function (e) {
        if ($("form").valid() == true) {
            if ($("#ConfirmPassword").val() != "") {
                var lTMP = $("#NewPassword").val();
                $("#NewPassword").val($.md5(lTMP));
                $("#ConfirmPassword").val($("#NewPassword").val());
            }
        }
    });
});
</script>
<?php $seccionJS = ob_get_clean() ?>

<?php include $config->get('Ruta').$config->get('viewsFolder').'plantilla.php' ?>