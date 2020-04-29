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

use Awsw\Gesi\App;
use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Datos\Usuario;
use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\Vistas\Vista;

class Login extends Formulario
{
    public function __construct(string $action) {
        parent::__construct('form-login', array('action' => $action));
    }
    
    protected function generaCampos(array & $datos_iniciales = array()) : void
    {
        $nif = '';

        if (! empty($datos_iniciales)) {
            $nif = isset($datos_iniciales['nif']) ? $datos_iniciales['nif'] : $nif;
        }

       $this->html .= <<< HTML
        <div class="form-group">
            <label for="nif">NIF o NIE</label>
            <input class="form-control" id="nif" type="text" name="nif" placeholder="NIF o NIE" value="$nif">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input class="form-control" id="password" type="password" name="password" placeholder="Contraseña">
        </div>

        <button type="submit" class="btn" name="login">Entrar</button>

HTML;

    }
    
    /**
     * Procesa un formulario enviado.
     */
    protected function procesa(array & $datos) : void
    {
        $nif = isset($datos['nif']) ? $datos['nif'] : null;
                
        if ( empty($nif) ) {
            Vista::encolaMensajeError("El NIF o NIE no puede estar vacío.");
        }
        
        $password = isset($datos['password']) ? $datos['password'] : null;
        
        if ( empty($password) ) {
            Vista::encolaMensajeError("La contraseña no puede estar vacía.");
        }
        
        // Si no hay ningún error, continuar.
        if (! Vista::hayMensajesError()) {

            // Comprobar si el NIF o NIE introducido existe.
            if (! Usuario::dbExisteNif($nif)) {
                Vista::encolaMensajeError("El NIF o NIE y la contraseña introducidos no coinciden. 1");
            } else {
                $id = Usuario::dbGetIdDesdeNif($nif);

                // Comprobar si la contraseña es correcta.
                if (! password_verify($password, Usuario::dbGetPasswordDesdeId($id))) {
                    Vista::encolaMensajeError("El NIF o NIE y la contraseña introducidos no coinciden. 2");
                } else {
                    $usuario = Usuario::dbGet($id);
                    Sesion::inicia($usuario);
                    
                    $app = App::getSingleton();

                    header("Location: " . $app->getUrl());
                    die();
                }
            }
        }

        $this->genera($datos);
    }
}