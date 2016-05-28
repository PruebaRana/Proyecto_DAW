<?php ob_start() ?>

<br>
<h1 class="Tcen">Entrada al sistema</h1>
<div id="capalogin" class="Tcen">
	<div class="Tcen icono_user"><i class="fa fa-user"></i></div>
	<div class="Tcen rojo mensaje"><?php echo $mensaje;?></div>
	
	<form action="./index.php?controlador=autentificacion&accion=login" autocomplete="off" method="post" novalidate="novalidate" >
		<input autocomplete="off" id="UserName" maxlength="10" name="UserName" placeholder="Usuario" type="text" value="" />
		<input autocomplete="off" id="Pass" name="Pass" placeholder="Contraseña" type="password" value="" />
		<input id="Password" name="Password" type="hidden" value="" />
		<input type="submit" class="button button-rounded button-primary button-large Tcen" value="Entrar al sistema" />
	</form>
</div>

<?php $seccionContenido = ob_get_clean() ?>

<?php ob_start() ?>
<script src="./js/md5.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function () { 
		$("#UserName").focus(); 
		setTimeout(function(){ $(".mensaje").html(""); }, 5000);
	});

	$(function () {
		$("form").submit(function (e) {
			if ($("form").valid() == true) {
				if ($("#Pass").val() != "") {
					var lTMP = $("#Pass").val();
					$("#Password").val($.md5($("#Pass").val()));
					$("#Pass").val("");
				}
			}
		});
	});
</script>
<?php $seccionJS = ob_get_clean() ?>

<?php include 'views/plantilla.php' ?>