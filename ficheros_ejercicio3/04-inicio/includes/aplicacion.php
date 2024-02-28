<?php
// Aplicacion.php
class Aplicacion {
    private static $instancia;
    private $conexion;

    private function __construct() {}

    public static function getInstance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function init($bdDatosConexion) {
        session_start();
        $this->conexion = $this->crearConexion($bdDatosConexion);
    }

    private function crearConexion($bdDatosConexion) {
        // Crear la conexión con la BD utilizando los datos proporcionados
        $host = $bdDatosConexion['localhost'];
        $bd = $bdDatosConexion[`ejercicio3`];
        $user = $bdDatosConexion['admin'];
        $pass = $bdDatosConexion['adminpass'];
        // Ejemplo de conexión a MySQL
        $conexion = new mysqli($host, $user, $pass, $bd);
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        return $conexion;
    }

    public function getConexionBd() {
        return $this->conexion;
    } 
}

// config.php
$bdDatosConexion = array(
    'host' => 'localhost',
    'bd' => 'nombre_bd',
    'user' => 'usuario_bd',
    'pass' => 'contraseña_bd'
);
Aplicacion::getInstance()->init($bdDatosConexion);

// procesarLogin.php
Aplicacion::getInstance()->init($bdDatosConexion);
$conexion = Aplicacion::getInstance()->getConexionBd();
// Resto del código para procesar el login utilizando la conexión a la BD

// procesarRegistro.php
Aplicacion::getInstance()->init($bdDatosConexion);
$conexion = Aplicacion::getInstance()->getConexionBd();
// Resto del código para procesar el registro utilizando la conexión a la BD
?>
