<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="es-ES">
	<head>
		<title>$TituloPagina</title>
		<meta charset="utf-8" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="text/css" http-equiv="content-style-type" />
		<meta http-equiv="content-language" content="es" />
		<meta name="Locality" content="Valencia, España" />
		<meta name="Lang" content="ES" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="x-dns-prefetch-control" content="on">
		<meta name="robots" content="NOINDEX,NOARCHIVE,NOFOLLOW" />
		<meta name="resource-type" content="document" />
		<meta name="distribution" content="global" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
		<link rel="stylesheet" type="text/css" href="js/easyui/themes/default/easyui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="js/easyui/themes/icon.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/estilos.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/tema_defecto.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/buttons.css" media="all" />
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->

		<header id="cabecera">
			<?php
			include("includes/_cabecera.php"); 
			?>
		</header>

		<section id="contenido">
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
		</section>
		
		<footer id="pie">
			<?php
			include("includes/_pie.php"); 
			?>
		</footer>

		<script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
		<script src="js/EasyUI/jquery.easyui.min.js" type="text/javascript"></script>
		<script src="js/EasyUI/locale/easyui-lang-es.js" type="text/javascript"></script>
		<script src="js/jquery.unobtrusive-ajax.min.js" type="text/javascript"></script>
		<script src="js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="js/jquery.validate.unobtrusive.min.js" type="text/javascript"></script>
		<script src="js/jquery.validate.inline.min.js")" type="text/javascript"></script>

		<script src="js/Logica/Listados.js" type="text/javascript"></script>		
		<script>
		var AltoFilasGrid = 32;
		var cantidadFilas = 20;

		<?php if ($Mensaje != null){ ?>
		$.messager.show({ title:'Titulo', msg:'<?php echo $Mensaje; ?>', timeout:8000, height:60, style:{
				left:'',
				right:0,
				top:document.body.scrollTop+document.documentElement.scrollTop+45,
				bottom:''
			}
		});
		<?php } ?>

		function IrA(asURL) {
			document.location.href = asURL;
			return false;
		}
		
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

	</body>
</html>	
