<?php
require_once __DIR__.'/plantilla_utils.php';
$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilo.css" />
</head>
<body>
<?= $mensajes ?>
<div id="contenedor">
<?php
require(RAIZ_APP.'/vistas/comun/cabecera.php');
require(RAIZ_APP.'/vistas/comun/sidebarIzq.php');
?>
	<main>
		<article>
			<?= $contenidoPrincipal ?>
		</article>
	</main>
<?php
require(RAIZ_APP.'/vistas/comun/sidebarDer.php');
require(RAIZ_APP.'/vistas/comun/pie.php');
?>
</div>
</body>
</html>
