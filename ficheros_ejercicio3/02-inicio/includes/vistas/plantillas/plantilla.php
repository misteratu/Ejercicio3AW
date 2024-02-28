<!DOCTYPE html>
<html>
 <head><title><?= $tituloPagina ?></title>
 <meta charset="UTF-8">
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
 <body>
 <div id="contenedor">   
 <?php
require('./includes/vistas/comun/cabecera.php');
require('./includes/vistas/comun/sidebarIzq.php');
?>  
 …<main>
		<article>
             <?= $contenidoPrincipal ?>
         </article>
	</main>    
 <?php
require('./includes/vistas/comun/sidebarDer.php');
require('./includes/vistas/comun/pie.php');
?>
 …
</html>