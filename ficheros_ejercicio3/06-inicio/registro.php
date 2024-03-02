<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/FormularioRegistro.php';

$tituloPagina = 'Registrar';

$form = new FormularioRegistro();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Registrar';

$contenidoPrincipal = <<<EOS
<h1>Acceso al sistema</h1>
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
