<?php ob_start() ?>
<?php $Titulo = ($Completo ? "usuario":"alumno") ?>
<div id="Centro" data-options="fit:false">
	<table id="dg"></table>
	<div id="toolbar" style="display:none">
		<a id="Add" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="javascript:Añadir('Añadir un nuevo <?php echo $Titulo; ?>', 310);" plain="true"></a>&nbsp;
		<a id="Edit" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit',disabled:true" onclick="javascript:Editar('\'Edición del <?php echo $Titulo; ?> \' + lItem.Nombre', 310);" plain="true"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a id="Del" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove',disabled:true" onclick="javascript:Borrar();" plain="true"></a>&nbsp; &nbsp; &nbsp;
		
		<input id="Buscador"></input>
		<div id="OpcionesBuscador" style="width:120px">
			<div data-options="name:'Nombre'">Nombre</div>
			<div data-options="name:'DNI'">Usuario</div>
			<div data-options="name:'Email'">Correo</div>
			<div data-options="name:'Activo'">Activo</div>
			<div data-options="name:'Roles'">Roles</div>
		</div>
	</div>

</div>
<?php $seccionContenido = ob_get_clean() ?>

<?php ob_start() ?>
<script src="<?php echo $config->get('URL'); ?>/js/Logica/Listados.js" type="text/javascript"></script>		
<script>
	jQuery(document).ready(function() {
		$('#Centro').css("height", $('#contenido').css("height"));
	});
	
	var lsTitulo = 'Listado de <?php echo $Titulo; ?>s';
	var lURLAñadir = '<?PHP echo(obtenURLController("Usuario", "crear")); ?>';
	var lURLEdicion = '<?PHP echo(obtenURLController("Usuario", "editar")); ?>&id=';
	var lURLEliminar = '<?PHP echo(obtenURLController("Usuario", "eliminarid")); ?>&id=';
	var lURLListado = '<?php echo(obtenURLController("Usuario", "ObtenerDatos")); ?>';
	lLiteralBusqueda = 'Escriba lo que desee buscar';
	//
	$(document).ready(function () {
		// Inicia
		Inicia();
		//Inicializo el grid
		$(function () {
			$('#dg').datagrid({
				title: lsTitulo,
				url: lURLListado,
				iconCls: 'bicon-list',
				autoRowHeight: false,
				nowrap: true,
				fit: true,
				fitColumns: true,
				singleSelect: true,
				pagination: true,
				rownumbers: false,
				loadMsg: '',
				scrollbarSize: 0,
				pagePosition: 'bottom',
				sortName: 'Fecha',
				sortOrder: 'desc',
				toolbar: '#toolbar',
				remoteSort: true,
				pageList: [cantidadFilas],
				pageSize: cantidadFilas,

				striped: true,
				columns: [[
					{ field: 'Id', title: 'Id', width: 0, hidden: 'true'},
					{ field: 'Fecha_Alta', title: 'Fecha', align: 'center', sortable: 'true', resizable: false,
						formatter: function (value, row, index) {
							if (value.length > 10) {
								if(value == "0001/01/01 00:00:00") {
									return " ";
								}else{
									return "   "+value.substring(0, 10)+"   ";
								}
							} else {
								return "   "+value+"   ";
							}
						} 
					},
					{ field: 'Usuario', title: 'Usuario', width: 200, sortable: 'true', resizable: 'true'},
					{ field: 'Nombre', title: 'Nombre', width: 200, sortable: 'true', resizable: 'true'},
					{ field: 'EMail', title: 'Email', width: 200, sortable: 'true', width: 0, resizable: 'true',
						formatter: function (value, row, index) {
							if (value != null && value.length > 0) {
								return '<a href="mailto:' + value + '">' + value + '</a>';
							} else {
								return ' ';
							}
						}
					},
					{ field: 'Roles', title: 'Roles', width: 200, sortable: 'true', resizable: 'true'},
					{ field: 'Activo', title: 'Activo', align: 'center', sortable: 'true',
						formatter: function (value, row, index) {
							if (value != null && value == 1) {
								return '<i class="fa fa-check fa-lg verde"></i>';
							} else {
								return ' ';
							}
						}
					}
				]],
				idField: 'Id',
				onHeaderContextMenu: function (e, field) {
					e.preventDefault();
					if (!cmenu) {
						createColumnMenu("");
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
							$('#dg').datagrid('clearSelections');
						}
					}
					$('.datagrid-row').css("height", AltoFilasGrid);
					$('.datagrid-footer-inner').css("height", AltoFilasGrid);
					ActualizarBotones();
				},
				onClickRow: function (index) {
					lIndexSelected = index;
					ActualizarBotones();
				}
			});
			lIniciado = true;
			// Quitar el combo de la paginacion
			$(".pagination").pagination({showPageList:false});
		});
	});

	function BorrarRegistro() {
		// LLamar por Ajax al borrado
		var lItem = $('#dg').datagrid('getSelected');
		if (lItem != null) {
			$.ajax({
				type: "POST",
				url: lURLEliminar + lItem.Id,
				data: <?php echo json_encode(obtenerJSAntiCSRF()); ?>
			}).done(function (msg) {
				if(msg){
					resultObj = eval(msg);
					if(resultObj["Estado"] == 1 ) {
						// Si todo es correcto, eliminar del grid y refrescar
						$('#dg').datagrid('deleteRow', lIndexSelected).datagrid('clearSelections').datagrid('reload');
						ActualizarBotones();
					}else {
						$.messager.alert('DAW', resultObj["Error"], 'error'); 
					}
				}else{
					$.messager.alert('DAW', "Error", 'error'); 
				}				
			});
		}
	}
	function CerrarPanel() {}
</script>
<?php $seccionJS = ob_get_clean() ?>

<?php include $config->get('Ruta').$config->get('viewsFolder').'plantilla.php' ?>