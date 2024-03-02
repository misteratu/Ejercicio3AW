<?php 
session_start();

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

require_once __DIR__.'/aplicacion.php';

// Datos de conexión a la base de datos
$bdDatosConexion = array(
    'host' => "localhost",
    'bd' => "ejercicio3",
    'user' => "ejercicio3",
    'pass' => "ejercicio3"
);
$app = Aplicacion::getInstance();

$app->init($bdDatosConexion);

?>