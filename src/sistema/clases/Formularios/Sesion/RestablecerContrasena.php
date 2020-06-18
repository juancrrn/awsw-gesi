<?php

/**
 * Gesión del formulario de inicio de sesión.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

namespace Awsw\Gesi\Formularios\Sesion;

use Awsw\Gesi\Formularios\Formulario;
use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Validacion\Valido;
use Awsw\Gesi\Vistas\Vista;

class RestablecerContrasena extends Formulario
{

    private const FORM_ID = 'form-acceso-restablecer-contrasena';

    public function __construct(string $action)
    {
        parent::__construct(self::FORM_ID, array('action' => $action));
    }
    
    protected function generaCampos(array & $datos_iniciales = array()): string
    {
        $this->html .= <<< HTML
        <div class="form-group">
            <label for="nif">NIF o NIE</label>
            <input class="form-control" id="nif" type="text" name="nif" placeholder="NIF o NIE" required="required">
        </div>
        <div class="form-group">
            <label for="email">Dirección de correo electrónico</label>
            <input class="form-control" id="email" type="email" name="email" placeholder="Dirección de correo electrónico" required="required">
        </div>
        <div class="form-group">
            <label for="password">Nueva contraseña</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="Nueva contraseña" required="required">
        </div>
        <div class="form-group">
            <label for="passwordRep">Repetir nueva contraseña</label>
            <input class="form-control" type="password" id="passwordRep" name="passwordRep" placeholder="Repetir nueva contraseña" required="required">
        </div>
        <button type="submit" class="btn btn-primary">Continuar</button>
        HTML;
        return $this->html;
    }

    protected function procesa(array & $datos): void
    {
        $nif = isset($datos['nif']) ? $datos['nif'] : null;
        $email = isset($datos['email']) ? $datos['email'] : null;
        $password = isset($datos['password']) ? $datos['password'] : null;
        $passwordRep = isset($datos['passwordRep']) ? $datos['passwordRep'] : null;
                
        if (empty($nif)) {
            Vista::encolaMensajeError("El campo NIF o NIE no puede estar vacío.");
        }
                
        if (empty($email)) {
            Vista::encolaMensajeError("El campo dirección de correo electrónico no puede estar vacío.");
        }
                
        if (empty($password)) {
            Vista::encolaMensajeError("El campo nueva contraseña no puede estar vacío.");
        } elseif (! Valido::testPassword($password)) {
            Vista::encolaMensajeError("El campo contraseña no es válido. Debe tener entre 8 y 64 caracteres y contener, al menos, una minúscula, una mayúscula y un número,");
        }
                
        if (empty($passwordRep)) {
            Vista::encolaMensajeError("El campo repetir nueva contraseña no puede estar vacío.");
        } elseif (! empty($password) && $password != $passwordRep) {
            Vista::encolaMensajeError("Los campos nueva contraseña y repetir nueva contraseña deben coincidir.");
        }

        // Si no hay ningún error, continuar.
        if (! Vista::hayMensajesError()) {
            if (! Usuario::dbExisteNifYEmail($nif, $email)) {
                Vista::encolaMensajeError("No se ha encontrado ningún usuario con estos datos.");
            } else {
                $usuario = Usuario::dbGetByNifYEmail($nif, $email);

                if ($usuario->dbActualizaPassword(password_hash($password,  PASSWORD_DEFAULT))) {
                    Vista::encolaMensajeExito('Contraseña actualizada correctamente.', '/sesion/iniciar/');
                } else {
                    Vista::encolaMensajeError('Hubo un error al cambiar la contraseña');
                }
            }
        } else {
            $this->genera();
        }
    }
}

?>