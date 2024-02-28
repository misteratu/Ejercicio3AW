<?php
//Inicio del procesamiento
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Portada</title>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
<body>
<div id="contenedor">
<?php
require('./includes/vistas/comun/cabecera.php');
require('./includes/vistas/comun/sidebarIzq.php');
?>
	<main>
		<article>
			<h1>Página principal</h1>
			<p> Aquí está el contenido público, visible para todos los usuarios. </p>
		</article>
	</main>
<?php
require('./includes/vistas/comun/sidebarDer.php');
require('./includes/vistas/comun/pie.php');
?>
</div>
</body>
</html>
