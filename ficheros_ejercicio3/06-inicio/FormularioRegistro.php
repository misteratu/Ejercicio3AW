<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/includes/Usuario.php';

class FormularioRegistro extends Formulario
{
    public function __construct()
    {
        parent::__construct('formRegistrar', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $password = $datos['password'] ?? '';
        $password2 = $datos['password2'] ?? '';

        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'nombre', 'password', 'password2'], $this->errores, 'span', ['class' => 'error']);

        $html = <<<HTML
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
                <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" />
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" value="$password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" value="$password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        HTML;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombre = trim($datos['nombre'] ?? '');
        $password = trim($datos['password'] ?? '');
        $password2 = trim($datos['password2'] ?? '');

        if (mb_strlen($nombreUsuario) < 5) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario debe tener al menos 5 caracteres.';
        }

        if (mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre debe tener al menos 5 caracteres.';
        }

        if (mb_strlen($password) < 5) {
            $this->errores['password'] = 'El password debe tener al menos 5 caracteres.';
        }

        if ($password !== $password2) {
            $this->errores['password2'] = 'Los passwords deben coincidir.';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::crea($nombreUsuario, $password, $nombre, Usuario::USER_ROLE);
            if (!$usuario) {
                $this->errores[] = "El usuario ya existe.";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
                header('Location: index.php');
                exit();
            }
        }
    }
}
?>
