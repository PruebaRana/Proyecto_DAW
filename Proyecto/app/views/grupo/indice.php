<?php ob_start() ?>
<div id="Centro" data-options="fit:false">

	<table id="dg"></table>
	<div id="toolbar" style="display:none">
		<a id="Add" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="javascript:Añadir('Añadir un nuevo grupo', 310);" plain="true"></a>&nbsp;
		<a id="Edit" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit',disabled:true" onclick="javascript:Editar('\'Edición del grupo \' + lItem.Nombre', 310);" plain="true"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a id="Del" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove',disabled:true" onclick="javascript:Borrar();" plain="true"></a>&nbsp; &nbsp; &nbsp;
		
		<input id="Buscador"></input>
		<div id="OpcionesBuscador" style="width:120px">
			<div data-options="name:'Nombre'">Nombre</div>
			<div data-options="name:'Ciclo'">Ciclo</div>
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
	
	var lsTitulo = 'Listado de grupos';
	var lURLAñadir = '<?PHP echo(obtenURLController("Grupo", "crear")); ?>';
	var lURLEdicion = '<?PHP echo(obtenURLController("Grupo", "editar")); ?>&id=';
	var lURLEliminar = '<?PHP echo(obtenURLController("Grupo", "eliminarid")); ?>&id=';
	var lURLListado = '<?php echo(obtenURLController("Grupo", "ObtenerDatos")); ?>';
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
					{ field: 'IdCiclo', title: 'IdCiclo', width: 0, hidden: 'true'},
					{ field: 'Ciclo', title: 'Ciclo', width: 200, sortable: 'true'},
					{ field: 'Nombre', title: 'Nombre', width: 200, sortable: 'true'},
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