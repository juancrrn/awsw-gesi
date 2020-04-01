<?php

/**
 * Gesión del formulario de inicio de sesión.
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

namespace Awsw\Gesi\Formularios\Sesion;

use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Datos\Usuario;
use \Awsw\Gesi\Sesion;

class Login extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin');
    }
    
    protected function generaCamposFormulario($datos)
    {
        $nif= '';
        if ($datos) {
            $nif = isset($datos['nif']) ? $datos['nif'] : $nombreUsuario;
        }
        $html = <<<EOF
        <fieldset>
            <legend>Usuario y contraseña</legend>
            <p><label>NIF / NIE:</label> <input type="text" name="nif" value="$nif"/></p>
            <p><label>Password:</label> <input type="password" name="password" /></p>
            <button type="submit" name="login">Entrar</button>
        </fieldset>
EOF;
        return $html;
    }
    
    /**
     * Procesa un formulario enviado.
     */
    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $nif = isset($datos['nif']) ? $datos['nif'] : null;
                
        if ( empty($nif) ) {
            $result[] = "El NIF o NIE no puede estar vacío.";
        }
        
        $password = isset($datos['password']) ? $datos['password'] : null;
        
        if ( empty($password) ) {
            $result[] = "El password no puede estar vacío.";
        }
        
        // Si no hay ningún error, continuar.
        if (count($result) === 0) {

            // Comprobar si el NIF o NIE introducido existe.
            if (! Usuario::dbExisteNif($nif)) {
                $result[] = "El NIF o NIE y la contraseña introducidos no coinciden. 1";
            } else {
                $id = Usuario::dbGetIdDesdeNif($nif);
                $usuario = Usuario::dbGet($id);

                // Comprobar si la contraseña es correcta.
                if (password_verify($usuario->getPassword(), $password)) {
                    $result[] = "El NIF o NIE y la contraseña introducidos no coinciden. 2";
                } else {
                    Sesion::login($usuario);
                    
                    $result = 'index.php';
                }
            }
        }

        return $result;
    }
}