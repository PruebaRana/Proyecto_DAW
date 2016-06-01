	<div class="divinput">
		<label for="Nombre">Nombre</label>
		<input data-val="true" data-val-length="Como maximo 50 caracteres" data-val-length-max="50" data-val-required="El campo Nombre es obligatorio"
			id="Nombre" maxlength="50" name="Nombre" placeholder="Nombre" size="40" type="text" value="<?PHP echo($Model->Nombre); ?>" />
		<span class="field-validation-valid" data-valmsg-for="Nombre" data-valmsg-replace="true"></span>
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
    $('form').submit(function(){
        if ($('form').valid()) {
            $('input:submit').attr('disabled','disabled');
        }else{
            $('input:submit').removeAttr('disabled');
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