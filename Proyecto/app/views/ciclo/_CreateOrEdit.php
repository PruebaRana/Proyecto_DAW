	<div class="divinput">
		<label for="Nombre">Nombre</label>
		<input data-val="true" data-val-length="Como maximo 5 caracteres" data-val-length-max="5" data-val-required="El campo Nombre es obligatorio"
			id="Nombre" maxlength="5" name="Nombre" placeholder="Nombre" size="5" type="text" value="<?PHP echo($Model->Nombre); ?>" />
	</div>
	<div class="limpiar"></div>
	
	<div class="divinput">
		<label for="Descripcion">Descripcion</label>
		<input data-val="true" data-val-length="Como maximo 100 caracteres" data-val-length-max="100" data-val-required="El campo Descripcion es obligatorio"
			id="Descripcion" maxlength="100" name="Descripcion" placeholder="Descripcion" size="75" type="text" value="<?PHP echo($Model->Descripcion); ?>" />
	</div>
	<div class="limpiar"></div>

	<div class="CapaBotonesForm">
		<input name="Id" type="hidden" value="<?PHP echo($Model->Id); ?>">
		<?PHP echo obtenerHTMLHiddenAntiCSRF(); ?>
		<input type="submit" class="button button-rounded button-primary" value="Guardar" data-loading-text="Enviando..." />&nbsp;&nbsp;
		<input type="button" class="button button-rounded" value="Cancelar" onclick="javascript:Cerrar();" />
	</div>

<script>
$(document).ready(function () {
    $.validator.unobtrusive.addValidation("#DivRespuesta");
	var flag = false;
	var actionurl;
    $("form").makeValidationInline();
	
	$('form').submit(function(){
        if ($('form').valid()) {
            $('input:submit').attr('disabled','disabled');
        }else{
            $('input:submit').removeAttr('disabled');
            return false;
        }
    });
	
	/*
	$('#form').submit(function(e){
		if ($('#form').valid()) {
			if(flag) {
				return false;
			}
			console.log("Enviando...");
			flag = true;
			//prevent Default functionality
			e.preventDefault();
			//get the action-url of the form
			actionurl = e.currentTarget.action;
			$.ajax({
				url: actionurl,
				type: "POST",
				data : $('#form').serialize(),
				success: function(datos){
				
				},
				error: function(){
					flag = false;
					$.messager.alert("Error en el envio", "Algún campo contiene caracteres no permitidos por seguridad.", "error");
					$('input:submit').button('reset');
				}
			});
			return false;
		}else{
			$.messager.alert("Error en el envio", "No se ha enviado el formulario.<br><br>Algun campo no es valido", "error");
			return false;
		}
	});	
	*/
	
    $(':input').change(function() {    // monitor all inputs for changes
        $('input:submit').removeAttr('disabled');
    });

    // Solo numeros
    $('.number').keypress(isNumberKey);
    
    // Inicia
    Inicia();

});
</script>