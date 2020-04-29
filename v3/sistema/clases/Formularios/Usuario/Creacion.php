<?php

/**
 * Gesión del formulario de creación de usuario.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

namespace Awsw\Gesi\Formularios\Usuario;

use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Datos\Usuario;

class Creacion extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro');
    }
    
    protected function generaCamposFormulario($datos)
    {
        $nombreUsuario = '';
        $nombre = '';
 

        if ($datos) {
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
            $nombre = isset($datos['nombre']) ? $datos['nombre'] : $nombre;
        }
        $html = <<<EOF
		<fieldset>
			<div class="grupo-control">
				<label>Nombre de usuario:</label> <input class="control" type="text" name="nombreUsuario" value="$nombreUsuario" />
			</div>
			<div class="grupo-control">
				<label>Apellidos:</label> <input class="control" type="text" name="nombre" value="$nombre" />
			</div>
            <div class="grupo-control">
                <label>DNI:</label> <input class="control" type="text" name="nombre" value="$nombre" />
            </div>
            <div class="grupo-control">
                <label>Fecha de Nacimiento:</label> <input class="control" type="date" name="nombre" value="$nombre" />
            </div>
            <div class="grupo-control">
                <label>Número de Telefono:</label> <input class="control" type="text" name="nombre" value="$nombre" />
            </div>
            <div class="grupo-control">
                <label>Correo Electrónico:</label> <input class="control" type="text" name="nombre" value="$nombre" />
            </div>
             <div class="grupo-control">
                
                <label>Primero de ESO:</label> <input class="control" type="radio" name="curso" value="PrimeroESO"  required/>
                <label>Segundo de ESO:</label> <input class="control" type="radio" name="curso" value="SegundoESO" required />
                <label>Tercero de ESO:</label> <input class="control" type="radio" name="curso" value="TerceroESO" required />
                <label>Cuarto de ESO:</label> <input class="control" type="radio" name="curso" value="CuartoESO" required />
                <label>Primero de Bachillerato:</label> <input class="control" type="radio" name="curso" value="PrimeroBACH" required />
                <label>Segundo de Bachillerato:</label> <input class="control" type="radio" name="curso" value="SegundoBACH" required />
            </div>
			<div class="grupo-control">
				<label>Password:</label> <input class="control" type="password" name="password" />
			</div>
			<div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>
			<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
		</fieldset>
EOF;
        return $html;
    }
    

    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null;
        
        if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $result[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $result[] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $result[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($datos['password2']) ? $datos['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result[] = "Los passwords deben coincidir";
        }
        
        if (count($result) === 0) {
            $user = Usuario::crea($nombreUsuario, $nombre, $password, 'user');
            if ( ! $user ) {
                $result[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                $result = 'index.php';
            }
        }
        return $result;
    }
}