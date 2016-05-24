<?php
global $usuario;

if ($usuario == null) {
	?>
	<nav id="cabecera">
		<ul id="menus"><li><a href="./index.php?controlador=Inicio&accion=indice"><i class="fa fa-home"></i></a></li></ul>
		<ul id="login"><li><a href="./index.php?controlador=autentificacion&accion=login"><i class="fa fa-power-off"></i> Login</a></li></ul>
	</nav>
	<?php
}else{
	?>
	<nav id="cabecera">
		<ul id="menus">
			<li><a href="./index.php?controlador=Inicio&accion=indice"><i class="fa fa-home"></i></a></li>
		</ul>
					
		<ul id="login">
			<li><a href="./index.php?controlador=perfil&accion=indice"><?php echo $usuario->Nombre; ?></a></li>
			<li><a href="./index.php?controlador=autentificacion&accion=logoff"><i class="fa fa-power-off"></i> Salir</a></li>
		</ul>
	</nav>
	<?php
}
?>













