<div class="divinput">
	<label for="Tipo">Tipo</label>
	<input id="Tipo" maxlength="5" name="Tipo" placeholder="Seleccione el tipo" size="20" type="text" value="" />
</div>
<div class="limpiar"></div>
<div class="divinput" style="margin: 9px 0 1rem;">
	<label for="Fichero">Fichero</label>
	<input id="Fichero" name="Fichero" size="40" type="text" />
</div>
<input id="IdProyecto" name="IdProyecto" type="hidden" value="<?PHP echo($Model->IdProyecto); ?>">

<div class="CapaBotonesForm">
	<input name="Id" type="hidden" value="<?PHP echo($Model->Id); ?>">
	<?PHP echo obtenerHTMLHiddenAntiCSRF(); ?>
	<input type="submit" class="button button-rounded button-primary" value="Guardar" data-loading-text="Enviando..." />&nbsp;&nbsp;
	<input type="button" class="button button-rounded" value="Cancelar" onclick="javascript:CerrarFile();" />
</div>

<script src="<?php echo $config->get('URL'); ?>/js/jquery.form.min.js" type="text/javascript"></script>
<script>

$(document).ready(function () {
	$('#Tipo').combobox({
		required: true,
		valueField: 'id',
		textField: 'nombre',
		prompt: 'Seleccione el tipo',
		data: <?php echo $ComboTipos; ?>,
		editable: false,
		height: 28,
		panelHeight:'auto'
	});
	$('#Fichero').filebox({
		buttonText: 'Seleccione el fichero',
		buttonAlign: 'left'
	})
    
	var options = { 
		target: '#DivRespuestaFile',
		//beforeSubmit:  showRequest,
		success: showResponse,
		url: '<?php echo(obtenURLController("ProyectoArchivo", "crear")); ?>',
		clearForm: true,
		resetForm: true
	}; 
	$('#formFile').submit(function() { 
		console.log ("Enviando...");
		// inside event callbacks 'this' is the DOM element so we first 
		// wrap it in a jQuery object and then invoke ajaxSubmit 
		$(this).ajaxSubmit(options); 

		// always return false to prevent standard browser submit and page navigation 
		return false; 
	}); 
});

function showResponse(responseText, statusText, xhr, $form)  { 
	var lTexto = $("#DivRespuestaFile").text();
	if(lTexto != "Ok"){
		$.messager.alert("Añadir fichero", lTexto, "error");
	}else{
		$.messager.show({title:'Añadir fichero', msg:'El fichero ha sido guardado', showType:'show'});
	}
	CerrarFile();
} 
</script>