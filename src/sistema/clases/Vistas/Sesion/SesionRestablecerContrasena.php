<?php

/**
 * Vista de restablecimiento de contraseña por parte de cualquier persona que 
 * no haya iniciado sesión.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundar
 * 
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\App;
use Awsw\Gesi\Formularios\Sesion\RestablecerContrasena as FormularioRestablecerContrasena;
use Awsw\Gesi\Vistas\Modelo;
use Awsw\Gesi\Sesion;

class SesionRestablecerContrasena extends Modelo
{
    private const VISTA_NOMBRE = "Restablecer contraseña";
    private const VISTA_ID = "sesion-restablecer-contrasena";

    private $form;

    public function __construct()
    {
        Sesion::requerirSesionNoIniciada();

        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->form = new FormularioRestablecerContrasena('/sesion/reset/'); 

        $this->form->gestiona();
    }

    public function procesaContent(): void
    {
        $app = App::getSingleton();
        $urlIniciar = $app->getUrl() . '/sesion/iniciar/';

        $formulario = $this->form->getHtml();

        $html = <<< HTML
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h2 class="mb-4">$this->nombre</h2>
                    <div class="auth-form card p-4">
                        $formulario
                    </div>
                </div>
                <div class="col-md-6 mt-md-5">
                    <p class="mb-3">Introduce tu NIF o NIE, tu dirección de correo electrónico y una nueva contraseña.</p>
                    <p><a href="$urlIniciar">Volver a Iniciar sesión.</a></p>
                </div>
            </div>
        </div>
        HTML;

        echo $html;

    }
}

?>