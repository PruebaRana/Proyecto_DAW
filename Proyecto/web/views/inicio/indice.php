<?php ob_start() ?>

<h1 class="Tcen">Pagina principal</h1>
<br>

<p>Bienvenidos a la pagina del proyecto DAW de Jaime Aguilá Sánchez</p>
<br>			
<p>Si es la primera vez que accede, puede crear la BD y el usuario admin accediendo a <a href="./instalar/index.php">/instalar/index.php</a></p>
<p>Una vez que haya generado la BD, elimine la carpeta instalar.</p>
<br>

Titulo: <?php echo $ltitulo; ?>
<br>
ole ole ole
<br>

<?php $seccionContenido = ob_get_clean() ?>

<?php include 'views/plantilla.php' ?>
