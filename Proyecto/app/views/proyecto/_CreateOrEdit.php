<div class="divinput20" style="float:right; margin: 9px 0 1rem;">
	<label for="Grupo">Grupo</label>
	<input data-val="true" data-val-length-max="2"
		id="Grupo" maxlength="2" name="Grupo" placeholder="Seleccione el Grupo" size="4" type="text" value="<?PHP echo($Model->Grupo); ?>" />
</div>
<div class="divinput20" style="float:right; margin: 9px 0 1rem;">
	<label for="Ciclo">Ciclo</label>
	<input data-val="true" data-val-length-max="5"
		id="Ciclo" maxlength="5" name="Ciclo" placeholder="Seleccione el ciclo" size="10" type="text" value="<?PHP echo($Model->Ciclo); ?>" />
</div>
<div class="divinput20" style="float:right; margin: 9px 0 1rem;">
	<label for="Curso">Curso</label>
	<input data-val="true" data-val-length="Como maximo 4 caracteres" data-val-length-max="4" data-val-required="El campo Curso es obligatorio"
		class="easyui-numberspinner" data-options="min:2010,max:2025,editable:false"
		class="number" id="Curso" maxlength="4" name="Curso" placeholder="Curso" size="4" type="text" value="<?PHP echo($Model->Curso); ?>" />
</div>
<div class="limpiar"></div>

<div class="divinput">
	<label for="Titulo">Titulo</label>
	<input data-val="true" data-val-length="Como maximo 100 caracteres" data-val-length-max="100" data-val-required="El campo Titulo es obligatorio"
		id="Titulo" maxlength="100" name="Titulo" placeholder="Titulo del proyecto" size="80" type="text" value="<?PHP echo($Model->Titulo); ?>" />
</div>
<div class="limpiar"></div>

<div class="divinput" style="margin: 9px 0 1rem;">
	<label for="IdAlumno">Alumno</label>
	<input data-val="true" data-val-length-max="50"
		id="IdAlumno" maxlength="2" name="IdAlumno" placeholder="Seleccione el Alumno" size="50" type="text" value="<?PHP echo($Model->IdAlumno); ?>" />
</div>
<div class="limpiar"></div>


<div id="tabs" class="easyui-tabs" data-options="plain:false,border:true,fit:false,height:400">
	<div title="General" class="tab">
		<div class="divinput" style="margin: 9px 0 1rem;">
			<label for="Fecha">Fecha</label>
			<span id="Fecha" name="Fecha"><?PHP echo($Model->Fecha); ?></span>
		</div>
		<div class="limpiar"></div>

		<div class="divinput" style="margin: 9px 0 1rem;">
			<label for="IdTutor">Tutor</label>
			<input id="IdTutor" name="IdTutor" size="50" type="text" value="<?PHP echo($Model->IdTutor); ?>" />
		</div>
		<div class="limpiar"></div>

		<div class="divinput" style="margin: 9px 0 1rem;">
			<label for="Valoracion">Valoracion</label>
			<input data-val="true" data-val-length-max="15"
				id="Valoracion" maxlength="15" name="Valoracion" placeholder="Seleccione una valoración" size="25" type="text" value="<?PHP echo($Model->Valoracion); ?>" />
		</div>
		<div class="limpiar"></div>
		
		<div class="divinput" style="float:right; margin: 9px 0 1rem;">
			<label for="Modulos">Modulos relacionados</label>
			<input data-val="true" data-val-length-max="30"
				id="Modulos" maxlength="30" name="Modulos" placeholder="Seleccione Modulos" size="17" type="text" value="" />
		</div>
		<div class="limpiar"></div>
		
		<div class="divinput" style="float:right; margin: 9px 0 1rem;">
			<label for="Cualidades">Cualidades en que destaca</label>
			<input data-val="true" data-val-length-max="30"
				id="Cualidades" maxlength="30" name="Cualidades" placeholder="Seleccione cualidades" size="17" type="text" value="" />
		</div>
		
	</div>

	<div title="Resumen" class="tab">
		<textarea class="tinymce" height="370px" id="Resumen" name="Resumen" placeholder="Resumen del proyecto"><?PHP echo($Model->Resumen); ?></textarea>
	</div>

	<div title="Herramientas" class="tab">
		<textarea class="tinymce" height="370px" id="Herramientas" name="Herramientas" placeholder="Herramientas y tecnologías del proyecto"><?PHP echo($Model->Herramientas); ?></textarea>
	</div>

	<div title="Comentarios" class="tab">
		<textarea class="tinymce" height="370px" id="Comentarios" name="Comentarios" placeholder="Comentarios del proyecto"><?PHP echo($Model->Comentarios); ?></textarea>
	</div>

	<div title="Ficheros" class="tab">
		<?php if($Model->Id == 0) { ?>
			<p>Guarde el proyecto y entre en edición para poder subir los ficheros adjuntos.</p>
		<?php } else { ?>
			<table id="dgFicheros"></table>
		<?php } ?>
	</div>
</div>


<div class="CapaBotonesForm">
	<input id="returnUrl" name="returnUrl" type="hidden" value="<?PHP echo($returnUrl); ?>">
	<?PHP echo obtenerHTMLHiddenAntiCSRF(); ?>
	<input type="submit" class="button button-rounded button-primary" value="Guardar" data-loading-text="Enviando..." />&nbsp;&nbsp;
	<input type="button" class="button button-rounded" value="Cancelar" onclick="javascript:Cerrar();" />
</div>

<div style="display:none">
	<div id="dlgAddFile" class="easyui-dialog form-horizontal" title="Añadir fichero" style="width:550px;height:220px;padding:10px" 
		data-options="iconCls:'icon-save',resizable:false,modal:true,closed:true">
	</div>
</div>

<script src="<?php echo $config->get('URL'); ?>/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js" type="text/javascript"></script>
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
		var _Modulos = $('#Modulos').combobox('getValues');
		_StrModulos = String(_Modulos);
		$('#Modulos').combobox('setValue', _StrModulos);

		var _Cualidades = $('#Cualidades').combobox('getValues');
		_StrCualidades = String(_Cualidades);
		$('#Cualidades').combobox('setValue', _StrCualidades);

		
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

	// Obligatorio cuando hay Tinymce junto con fichas del easyUI, sin esto el Tiny deja de funcionar bien
	$('#tabs').tabs({ border: false,
		onSelect:function(title){
			if(title == "Ficheros")
			{
				dgFicheros();
			}
		}  
	});	
	
	$('#IdAlumno').combobox({
		required: true,
		valueField: 'id',
		textField: 'nombre',
		prompt: 'Seleccione el alumno',
		data: <?php echo $ComboAlumnos; ?>,
		editable: false,
		height: 28,
		panelHeight: 200
	});
	$('#IdTutor').combobox({
		required: true,
		valueField: 'id',
		textField: 'nombre',
		data: <?php echo $ComboTutores; ?>,
		editable: false,
		height: 28,
		panelHeight: 200
	});
	$('#Ciclo').combobox({
		required: true,
		valueField: 'id',
		textField: 'nombre',
		prompt: 'Seleccione el ciclo',
		data: <?php echo $ComboCiclos; ?>,
		editable: false,
		height: 28,
		panelHeight:'auto'
	});
	$('#Grupo').combobox({
		required: true,
		valueField: 'id',
		textField: 'nombre',
		prompt: 'Seleccione el grupo',
		data: <?php echo $ComboGrupos; ?>,
		editable: false,
		height: 28,
		panelHeight:'auto'
	});

	$('#Valoracion').combobox({
		valueField: 'id',
		textField: 'nombre',
		separator: ',',
		prompt: 'Seleccione una valoracion',
		data: <?php echo $ComboValoraciones; ?>,
		editable: false,
		height: 28,
		panelHeight:'auto'
	});
	$('#Cualidades').combobox({
		multiple: true,
		valueField: 'id',
		textField: 'nombre',
		separator: ',',
		prompt: 'Seleccione las cualidades',
		data: <?php echo $ComboCualidades; ?>,
		editable: false,
		height: 28,
		panelHeight:'auto'
	});
	$('#Modulos').combobox({
		multiple: true,
		valueField: 'id',
		textField: 'nombre',
		separator: ',',
		prompt: 'Seleccione los modulos',
		data: <?php echo $ComboModulos; ?>,
		editable: false,
		height: 28,
		panelHeight:'auto'
	});

	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo $config->get('URL'); ?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js',
		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		// Theme options
		theme_advanced_buttons1: "bold,italic,underline,|,pastetext,pasteword,blockquote,|,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,undo,redo,|,link,unlink,|,image,|,preview,code",
		theme_advanced_buttons2: "",

		width: "100%",
		height: "360px",

		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",

		// Example content CSS (should be your site CSS)
		content_css: '<?php echo $config->get('URL'); ?>/css/estilos.css',
	});
	
	//Convert multiple combobox integer to string value START
	$('#Cualidades').combobox('setValues', [<?PHP echo($Model->getCualidades()); ?>]);
	$('#Modulos').combobox('setValues', [<?PHP echo($Model->getModulos()); ?>]);
    
    // Inicia
    Inicia();

});

function dgFicheros(){
	//Inicializo el grid de ficheros
	$('#dgFicheros').datagrid({
		url: '<?php echo(obtenURLController("ProyectoArchivo", "ObtenerDatos")); ?>',
		queryParams: {
			whereCampo: 'IdProyecto',
			whereValor: '<?php echo $Model->Id ?>'
		},
		autoRowHeight: false,
		fit: true,
		fitColumns: true,
		singleSelect: true,
		pagination: true,
		rownumbers: false,
		scrollbarSize: 0,
		loadMsg: '',
		pagePosition: 'bottom',
		sortName: 'Fecha',
		sortOrder: 'desc',
		remoteSort: true,
		pageList: [10, 15, 20],
		pageSize: 10,
		striped: true,
		columns: [[
			{ field: 'Id', title: 'Id', width: 0, hidden: 'true' },
			{ field: 'IdProyecto', title: 'IdProyecto', width: 0, hidden: 'true' },
			{ field: 'Tipo', title: 'Tipo', width: 100, sortable: 'true'},
			{ field: 'Ruta', title: 'Ruta', width: 400, sortable: 'true',
				formatter: function (value, row, index) {
					if (value.length > 0)
					{
						return '<a href="<?php echo $config->get("URL")."/proyectos/" ?>' + value + '" target=_blank><i class="bicon-file" title="' + value + '"></i>' + value + '</a>';
					} else {
						return "";
					}
				} 
			
			
			}
		]],
		idField: 'Id',
		onHeaderContextMenu: function (e, field) {
			e.preventDefault();
			if (!cmenu) {
				createColumnMenu("IdProyecto");
			}
			cmenu.menu('show', {
				left: e.pageX,
				top: e.pageY
			});
		},
		onLoadSuccess: function (data) {
			if (lIndexSelected >= 0) {
				var lsw = false;
				var rows = $(this).datagrid('getRows');
				for (var i = 0; i < rows.length; i++) {
					if (rows[i].Id == lIdSelected) {
						lsw = true;
						break;
					}
				}
				if (lsw == false) {
					$('#dgFicheros').datagrid('clearSelections');
				}
			}
			$('#dgFicheros').datagrid('resize');
			$('#dgFicheros').datagrid('fixColumnSize');
			ActualizarBotonesFicheros();
		},
		onClickRow: function (index) {
			ActualizarBotonesFicheros();
		}
	});
	var Paginacion = $('#dgFicheros').datagrid('getPager');
	Paginacion.pagination({
		showPageList: false,
		buttons: [{
			id: 'btnAñadirFichero',
			iconCls: 'icon-add',
			text: 'Añadir fichero',
			disabled: false,
			handler: function () {
				OpenAddFile();
			}
		},{
			id: 'btnBorrarFichero',
			iconCls: 'icon-cancel',
			text: 'Eliminar fichero',
			disabled: true,
			handler: function () {
				DeleteFile();
			}
		}]
	});  
}

function ActualizarBotonesFicheros() {
	var lItem = $('#dgFicheros').datagrid('getSelected');
	if (lItem != null) {
		$('#btnBorrarFichero').linkbutton('enable');
	} else {
		$('#btnBorrarFichero').linkbutton('disable');
	}
}
function OpenAddFile() {
	//Muestro el dialogo
	$('#dlgAddFile').dialog( {href:'<?php echo(obtenURLController("ProyectoArchivo", "crear")); ?>/?IdProyecto=<?php echo $Model->Id; ?>' });
	$('#dlgAddFile').dialog('open');
}

function CerrarFile() {
	$('#dlgAddFile').dialog('close');
	$('#dgFicheros').datagrid('reload');
}

function DeleteFile() {
	//LLamar por Ajax al delete
	var lItem = $('#dgFicheros').datagrid('getSelected');
	if (lItem != null) {
		$.ajax({
			type: "POST",
			url: '<?php echo(obtenURLController("ProyectoArchivo", "eliminarid")); ?>&id=' + lItem.Id,
			data: <?php echo json_encode(obtenerJSAntiCSRF()); ?>,
		}).done(function (msg) {
			if(msg){
				resultObj = eval(msg);
				if(resultObj["Estado"] == 1 ) {
					// Si todo es correcto, eliminar del grid y refrescar
					$('#dgFicheros').datagrid('reload');
				}else {
					$.messager.alert('DAW', resultObj["Error"], 'error'); 
				}
			}else{
				$.messager.alert('DAW', "Error", 'error'); 
			}				
		});
	}
}

</script>