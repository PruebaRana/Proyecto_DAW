	<div class="divinput">
		<label for="Nombre">Nombre</label>
		<input data-val="true" data-val-length="Como maximo 15 caracteres" data-val-length-max="15" data-val-required="El campo Nombre es obligatorio"
			id="Nombre" maxlength="15" name="Nombre" placeholder="Nombre" size="15" type="text" value="<?PHP echo($Model->Nombre); ?>" />
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
    $("form").makeValidationInline();

	$('#form').submit(function(e){
		if ($('#form').valid()) {
			if(flag) {
				return false;
			}

			//prevent Default functionality
			e.preventDefault();
			//get the action-url of the form
			actionurl = e.currentTarget.action;

			console.log("Enviando...");
			flag = true;
			
			$('input:submit').button('Enviando...');
			$.ajax({
				url: actionurl,
				type: "POST",
				data : $('#form').serialize(),
				success: function(datos){
					flag = false;
					$('#dg').datagrid('reload');
					Cerrar();
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

    $(':input').change(function() {    // monitor all inputs for changes
        $('input:submit').removeAttr('disabled');
    });

    // Solo numeros
    $('.number').keypress(isNumberKey);
    
    // Inicia
    Inicia();

});
</script>