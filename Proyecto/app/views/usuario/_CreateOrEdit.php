	<div class="divinput20" style="float:right;">
		<label for="Activo">Activo</label>
		<input id="Activo" name="Activo" type="text" value="<?PHP echo($Model->Activo); ?>" />
		<input id="Activo1" name="Activo1" type="hidden" value="<?PHP echo($Model->Activo); ?>" />
	</div>
	<div class="divinput25" style="float:right; margin: 9px 0 1rem;">
		<label for="Roles">Roles</label>
		<input data-val="true" data-val-length-max="30"
			id="Roles" maxlength="30" name="Roles" placeholder="Seleccione los Roles" size="17" type="text" value="" />
	</div>
	
	<div class="divinput">
		<label for="Usuario">Usuario</label>
		<input data-val="true" data-val-length="Como maximo 20 caracteres" data-val-length-max="20" data-val-required="El campo Usuario es obligatorio"
			id="Usuario" maxlength="20" name="Usuario" placeholder="Nick usuario" size="20" type="text" value="<?PHP echo($Model->Usuario); ?>" />
	</div>
	<div class="limpiar"></div>
	
	<div class="divinput">
		<label for="Nombre">Nombre</label>
		<input data-val="true" data-val-length="Como maximo 150 caracteres" data-val-length-max="150" data-val-required="El campo Nombre es obligatorio"
			id="Nombre" maxlength="150" name="Nombre" placeholder="Nombre" size="75" type="text" value="<?PHP echo($Model->Nombre); ?>" />
	</div>
	<div class="limpiar"></div>
	
	<div class="divinput">
		<label for="Email">Correo</label>
		<input data-val="true" data-val-length="Como maximo 75 caracteres" data-val-length-max="75" data-val-required="El campo Correo es obligatorio"
			id="EMail" maxlength="75" name="EMail" placeholder="EMail" size="75" type="text" value="<?PHP echo($Model->EMail); ?>" />
	</div>
	<div class="limpiar"></div>
	
	<div class="CapaBotonesForm">
		<input name="Id" type="hidden" value="<?PHP echo($Model->Id); ?>">
		<?PHP echo obtenerHTMLHiddenAntiCSRF(); ?>
		<input type="submit" class="button button-rounded button-primary" value="Guardar" data-loading-text="Enviando..." />&nbsp;&nbsp;
		<input type="button" class="button button-rounded" value="Cancelar" onclick="javascript:Cerrar();" />
	</div>

<script>

<?php if (obtenParametro($Error) != null){ ?>
$.messager.show({ title:'Error', msg:'<?php echo $Error; ?>', timeout:4000, height:80, style:{
	left:'', right:0, top:document.body.scrollTop+document.documentElement.scrollTop+45, bottom:'' }
});
<?php } ?>


$(document).ready(function () {
    $.validator.unobtrusive.addValidation("#DivRespuesta");
    $("form").makeValidationInline();

	$('form').submit(function(){
		//Convert multiple combobox integer to string value START
		var _Roles = $('#Roles').combobox('getValues');
		_StrRoles = String(_Roles);
		$('#Roles').combobox('setValue', _StrRoles);

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

	$('#Activo').switchbutton({
		checked: <?php echo ($Model->Activo? "true": "false"); ?>,
		onText: "Si",
		offText: "No",
		onChange: function(checked){
			//$('#Activo').switchbutton({setValue:(checked)?1:0});
			//$('#Activo').val( (checked)?1:0 );
			$('#Activo1').val( (checked)?1:0 );
			//console.log(checked);
		}
	})

	
	$('#Roles').combobox({
		required: true,
		multiple: true,
		valueField: 'id',
		textField: 'nombre',
		separator: ',',
		<?php echo (!$Completo)? "readonly: true,": ""; ?>
		prompt: 'Seleccione los roles',
		data:  [{"id":"Administrador","nombre":"Administrador"},{"id":"Profesor","nombre":"Profesor"},{"id":"Alumno","nombre":"Alumno"}],
		editable: false,
		height: 28,
		panelHeight:'auto'
	});

	//Convert multiple combobox integer to string value START
//	var _Roles = $('#Roles').val();
//	_StrRoles = String(_Roles);
	$('#Roles').combobox('setValues', [<?PHP echo($Model->getRoles()); ?>]);
	
    
    // Inicia
    Inicia();
});
</script>