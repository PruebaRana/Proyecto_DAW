<?php
global $usuario;

if ($usuario->Id == 0) {
	?>
	<nav>
		<ul id="menus">
			<li class="menuactual"><a href="<?php echo FrontController::getURL("Inicio", "indice"); ?>"><i class="fa fa-home"></i></a></li>
		</ul>
		<ul id="login">
			<li><a href="<?php echo FrontController::getURL("autentificacion", "login"); ?>"><i class="fa fa-power-off"></i> Login</a></li>
		</ul>
	</nav>
	<?php
}else{
	?>
	<nav>
		<ul id="menu">
			<li><a href="<?php echo FrontController::getURL("Inicio", "indice"); ?>"><i class="fa fa-home"></i></a></li>
			<?php if ($usuario->isInRol("Administrador")) { ?>
				<li class="menuactual"><a href="<?php echo FrontController::getURL("Usuario", "indice"); ?>">Usuarios</a></li>
				<li><a href="#">Auxiliares <i class="fa fa-caret-down"></i></a>
					<ul >
						<li><a href="<?php echo FrontController::getURL("Ciclo", "indice"); ?>">Ciclos</a></li>
						<li><a href="<?php echo FrontController::getURL("Grupo", "indice"); ?>">Grupos</a></li>
						<li><a href="<?php echo FrontController::getURL("Modulo", "indice"); ?>">Modulos</a></li>
						<li><a href="<?php echo FrontController::getURL("Cualidad", "indice"); ?>">Cualidades</a></li>
						<li><a href="<?php echo FrontController::getURL("Valoracion", "indice"); ?>">Valoraciones</a></li>
					</ul>
				</li>
			<?php } else if ($usuario->isInRol("Profesor")) { ?>
				<li><a href="<?php echo FrontController::getURL("Usuario", "indice"); ?>">Alumnos</a></li>
			<?php } ?>
		</ul>
					
		<ul id="login">
			<li><a href="<?php echo FrontController::getURL("Perfil", "indice"); ?>"><?php echo $usuario->Nombre; ?></a></li>
			<li><a href="<?php echo FrontController::getURL("Autentificacion", "logoff"); ?>"><i class="fa fa-power-off"></i> Salir</a></li>
		</ul>
	</nav>
	<?php
}
?>