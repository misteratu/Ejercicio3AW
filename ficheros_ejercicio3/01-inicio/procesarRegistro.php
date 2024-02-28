<?php
//Inicio del procesamiento
session_start();

$formEnviado = isset($_POST['registro']);
if (! $formEnviado ) {
	header('Location: registro.php');
	exit();
}

require_once __DIR__.'/utils.php';

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) || mb_strlen($nombreUsuario) < 5) {
	$erroresFormulario['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
}

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombre || empty($nombre=trim($nombre)) || mb_strlen($nombre) < 5) {
	$erroresFormulario['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password || empty($password=trim($password)) || mb_strlen($password) < 5 ) {
	$erroresFormulario['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
}

$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password2 || empty($password2=trim($password2)) || $password != $password2 ) {
	$erroresFormulario['password2'] = 'Los passwords deben coincidir';
}

if (count($erroresFormulario) === 0) {
	$conn = conexionBD();
	
	$query=sprintf("SELECT * FROM Usuarios U WHERE U.nombreUsuario = '%s'", $conn->real_escape_string($nombreUsuario));
	$rs = $conn->query($query);
	if ($rs) {
		if ( $rs->num_rows > 0 ) {
			$erroresFormulario[] = 'El usuario ya existe';
			$rs->free();
		} else {
			$query=sprintf("INSERT INTO Usuarios(nombreUsuario, nombre, password) VALUES('%s', '%s', '%s')"
					, $conn->real_escape_string($nombreUsuario)
					, $conn->real_escape_string($nombre)
					, password_hash($password, PASSWORD_DEFAULT)
			);
			if ( $conn->query($query) ) {
				$idUsuario = $conn->insert_id;
				$query=sprintf("INSERT INTO RolesUsuario(rol, usuario) VALUES(%d, %d)"
					, USER_ROLE
					, $idUsuario
				);
				if ( $conn->query($query) ) {
					$_SESSION['login'] = true;
					$_SESSION['nombre'] = $nombre;
					$_SESSION['esAdmin'] = false;
					header('Location: index.php');
					exit();
				} else {
					echo "Error SQL ({$conn->errno}):  {$conn->error}";
					exit();
				}
			} else {
				echo "Error SQL ({$conn->errno}):  {$conn->error}";
				exit();
			}
		}		
	} else {
		echo "Error SQL ({$conn->errno}):  {$conn->error}";
		exit();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
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
<main>
	<article>
		<h1>Registro de usuario</h1>
		<?= generaErroresGlobalesFormulario($erroresFormulario) ?>
		<form action="procesarRegistro.php" method="POST">
		<fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
				<input id="nombreUsuario" type="text" name="nombreUsuario" value="<?= $nombreUsuario ?>" />
				<?=  generarError('nombreUsuario', $erroresFormulario) ?>
            </div>
            <div>
                <label for="nombre">Nombre:</label>
				<input id="nombre" type="text" name="nombre" value="<?= $nombre ?>" />
				<?=  generarError('nombre', $erroresFormulario) ?>
            </div>
            <div>
                <label for="password">Password:</label>
				<input id="password" type="password" name="password" value="<?= $password ?>" />
				<?=  generarError('password', $erroresFormulario) ?>
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
				<input id="password2" type="password" name="password2" value="<?= $password2 ?>" />
				<?=  generarError('password2', $erroresFormulario) ?>
            </div>
            <div>
				<button type="submit" name="registro">Registrar</button>
			</div>
		</fieldset>
		</form>
	</article>
</main>

<?php
require('./includes/vistas/comun/sidebarDer.php');
require('./includes/vistas/comun/pie.php');
?>
</div>
</body>
</html>
