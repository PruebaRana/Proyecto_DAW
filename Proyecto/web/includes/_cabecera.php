<?php
global $usuario;

if ($usuario->Id == 0) {
	?>
	<nav>
		<ul id="menus">
			<li class="menuactual"><a href="./index.php?controlador=Inicio&accion=indice"><i class="fa fa-home"></i></a></li>
		</ul>
		<ul id="login">
			<li><a href="./index.php?controlador=autentificacion&accion=login"><i class="fa fa-power-off"></i> Login</a></li>
		</ul>
	</nav>
	<?php
}else{
	?>
	<nav>
		<ul id="menus">
			<li><a href="./index.php?controlador=Inicio&accion=indice"><i class="fa fa-home"></i></a></li>
			<?php if ($usuario->isInRol("Administrador")) { ?>
				<li class="menuactual"><a href="./index.php?controlador=Usuario&accion=indice">Usuarios</a></li>
			<?php } else if ($usuario->isInRol("Profesor")) { ?>
				<li><a href="./index.php?controlador=Usuario&accion=indice">Alumnos</a></li>
			<?php } ?>
		</ul>
					
		<ul id="login">
			<li><a href="./index.php?controlador=perfil&accion=indice"><?php echo $usuario->Nombre; ?></a></li>
			<li><a href="./index.php?controlador=autentificacion&accion=logoff"><i class="fa fa-power-off"></i> Salir</a></li>
		</ul>
	</nav>
	<?php
}
?>