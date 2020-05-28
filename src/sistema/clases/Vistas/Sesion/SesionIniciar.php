<?php

/**
 * Vista de inicio de sesión.
 *
 * Invitado (cualquiera): puede iniciar sesión.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundar
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

namespace Awsw\Gesi\Vistas\Sesion;

use Awsw\Gesi\App;
use Awsw\Gesi\Formularios\Sesion\Iniciar as FormularioSesionIniciar;
use Awsw\Gesi\Vistas\Modelo;

class SesionIniciar extends Modelo
{
    private const VISTA_NOMBRE = "Iniciar sesión";
    private const VISTA_ID = "sesion-iniciar";

    private $form;

    public function __construct()
    {
        $this->nombre = self::VISTA_NOMBRE;
        $this->id = self::VISTA_ID;

        $this->form = new FormularioSesionIniciar('/sesion/iniciar/'); 

        $this->form->gestiona();
    }

    public function procesaContent() : void
    {
        $app = App::getSingleton();
        $urlRestablecer = $app->getUrl() . '/sesion/reset/';

        $formulario = $this->form->getHtml();

        $html = <<< HTML
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h2 class="mb-4">Iniciar sesión</h2>
                    <div class="auth-form card p-4">
                        $formulario
                    </div>
                </div>
                <div class="col-md-6 mt-md-5">
                    <h4 class="text-secondary mb-3">¿Necesitas ayuda?</h4>
                    <p>Si tienes problemas para iniciar sesión, puedes <a href="$urlRestablecer">reestablecer tu contraseña</a>.</p>
                </div>
            </div>
        </div>
        HTML;

        echo $html;

    }
}

?>