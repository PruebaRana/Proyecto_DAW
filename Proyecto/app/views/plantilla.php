<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="es-ES">
	<head>
		<title><?php echo obtenParametro($TituloPagina);?></title>
		<meta charset="utf-8" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta http-equiv="content-language" content="es" />
		<meta name="Locality" content="Valencia, España" />
		<meta name="Lang" content="ES" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="x-dns-prefetch-control" content="on">
		<meta name="robots" content="NOINDEX,NOARCHIVE,NOFOLLOW" />
		<link rel="shortcut icon" href="<?php echo $config->get('URL'); ?>/favicon.ico" type="image/x-icon" />
	
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('URL'); ?>/js/easyui/themes/default/easyui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('URL'); ?>/js/easyui/themes/icon.css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('URL'); ?>/css/estilos.css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('URL'); ?>/css/tema_defecto.css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('URL'); ?>/css/buttons.css" media="all" />
		<?php echo obtenParametro($seccionCSS);?>
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<header id="cabecera"><?php include($config->get('Ruta')."app/includes/_cabecera.php"); ?></header>
		<section id="contenido">
			<?php echo obtenParametro($seccionContenido);?>
		</section>
		
		<footer id="pie"><?php include($config->get('Ruta')."app/includes/_pie.php"); ?></footer>

		<!--[if !IE]><!-->
		<script src="<?php echo $config->get('URL'); ?>/js/jquery-2.2.4.min.js" type="text/javascript"></script>
		<!--<![endif]-->
		<!--[if gte IE 9]>
		<script src="<?php echo $config->get('URL'); ?>/js/jquery-2.2.4.min.js" type="text/javascript"></script>
		<![endif]-->
		<!--[if IE 8]>
		<script src="@Url.Content("~/Scripts/jquery-1.8.3.min.js")" type="text/javascript"></script>
		<![endif]-->
		<!--[if lt IE 8]>
		<script src="@Url.Content("~/Scripts/jquery-1.8.3.min.js")" type="text/javascript"></script>
		<![endif]-->
		<script src="<?php echo $config->get('URL'); ?>/js/EasyUI/jquery.easyui.min.js" type="text/javascript"></script>
		<script src="<?php echo $config->get('URL'); ?>/js/EasyUI/locale/easyui-lang-es.js" type="text/javascript"></script>
		<script src="<?php echo $config->get('URL'); ?>/js/jquery.unobtrusive-ajax.min.js" type="text/javascript"></script>
		<script src="<?php echo $config->get('URL'); ?>/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="<?php echo $config->get('URL'); ?>/js/jquery.validate.unobtrusive.min.js" type="text/javascript"></script>
		<script src="<?php echo $config->get('URL'); ?>/js/jquery.validate.inline.min.js")" type="text/javascript"></script>
		<script>
			var AltoFilasGrid = 30;
			var cantidadFilas = 20;
			
			<?php if (obtenParametro($Mensaje) != null){ ?>
			$.messager.show({ title:'Titulo', msg:'<?php echo $Mensaje; ?>', timeout:8000, height:60, style:{
				left:'', right:0, top:document.body.scrollTop+document.documentElement.scrollTop+45, bottom:'' }
			});
			<?php } ?>
			
			function IrA(asURL) {
				document.location.href = asURL;
			}
		</script>
		<?php echo obtenParametro($seccionJS);?>
	</body>
</html>	