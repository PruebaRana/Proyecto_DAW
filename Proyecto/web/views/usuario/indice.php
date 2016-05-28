<?php ob_start() ?>
<div id="Centro" data-options="fit:false">

	<table id="dg"></table>
	<div id="toolbar" style="display:none">
		<a id="Add" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="javascript:Añadir('Añadir un nuevo usuario', 310);" plain="true"></a>&nbsp;
		<a id="Edit" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit',disabled:true" onclick="javascript:Editar('Edicion del usuario', 310);" plain="true"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a id="Del" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove',disabled:true" onclick="javascript:Borrar();" plain="true"></a>&nbsp; &nbsp; &nbsp;
		
		<input id="Buscador"></input>
		<div id="OpcionesBuscador" style="width:120px">
			<div data-options="name:'Nombre'">Nombre</div>
			<div data-options="name:'DNI'">DNI</div>
			<div data-options="name:'Telefono'">Telefono</div>
			<div data-options="name:'Movil'">Movil</div>
			<div data-options="name:'Correo'">Email</div>
			<div data-options="name:'Direccion'">Direccion</div>
			<div data-options="name:'Provincia'">Provincia</div>
			<div data-options="name:'Poblacion'">Poblacion</div>
			<div data-options="name:'CP'">Cod. Postal</div>
		</div>
	</div>

</div>
<?php $seccionContenido = ob_get_clean() ?>

<?php ob_start() ?>
<script src="js/Logica/Listados.js" type="text/javascript"></script>		
<script>
	jQuery(document).ready(function() {
		$('#Centro').css("height", $('#contenido').css("height"));
	});
	
	var lsTitulo = 'Listado de usuarios';
	var lURLEdicion = '';
	var lURLAñadir = '';
	var lURLEliminar = '';
	var lURLListado = '';
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
					{ field: 'Fecha', title: 'Fecha', align: 'center', sortable: 'true', resizable: false,
						formatter: function (value, row, index) {
							if (value.length > 10) {
								if(value == "0001/01/01 00:00:00") {
									return " ";
								}else{
									return value.substring(0, 10);
								}
							} else {
								return value;
							}
						} 
					},
					{ field: 'Nombre', title: 'Nombre', width: 200, sortable: 'true'},
					{ field: 'DNI', title: 'DNI/NIE/CIF', sortable: 'true', align: 'center', resizable: false},
					{ field: 'Telefono', title: 'Telefono', align: 'center', sortable: 'true', resizable: false, width: 0},
					{ field: 'Movil', title: 'Movil', align: 'center', sortable: 'true', resizable: false, width: 0},
					{ field: 'Correo', title: 'Email', sortable: 'true', width: 0,
						formatter: function (value, row, index) {
							if (value != null && value.length > 0) {
								return '<a href="mailto:' + value + '">' + value + '</a>';
							} else {
								return ' ';
							}
						}
					},
					{ field: 'Direccion', title: 'Direccion', width: 150, sortable: 'true'},
					{ field: 'Provincia', title: 'Provincia', sortable: 'true', resizable: false},
					{ field: 'Poblacion', title: 'Poblacion', sortable: 'true', hidden: 'true', resizable: false},
					{ field: 'CP', title: 'CP', align: 'right', sortable: 'true', hidden: 'true', resizable: false},
					{ field: 'Vitalicio', title: 'VIP', align: 'center', sortable: 'true',
						formatter: function (value, row, index) {
							if (value != null && value == 1) {
								return '<i class="fa fa-gift fa-lg purpura4"></i>';
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
						createColumnMenu("Pais,Direccion,CP,Provincia,Poblacion");
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
		// LLamar por Ajax al delete
		var lItem = $('#dg').datagrid('getSelected');
		if (lItem != null) {
			$.ajax({
				type: "POST",
				url: lURLEliminar + lItem.Id,
				data: $('<form>@Html.AntiForgeryToken()</form>').serialize(),
			}).done(function (msg) {
				if(msg == true ) {
					// Si todo es correcto, eliminar del grid y refrescar
					$('#dg').datagrid('deleteRow', lIndexSelected).datagrid('clearSelections').datagrid('reload');
					ActualizarBotones();
				}else {
					alert(msg);
				}
			});
		}
	}

	function CerrarPanel() {}
	
</script>
<?php $seccionJS = ob_get_clean() ?>

<?php include 'views/plantilla.php' ?>