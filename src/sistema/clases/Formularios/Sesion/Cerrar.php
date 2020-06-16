<?php

/**
 * Gesión del formulario de cierre de sesión.
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
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Formularios\Sesion;

use Awsw\Gesi\App;
use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Datos\Usuario;
use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\Vistas\Vista;

class Cerrar extends Formulario
{
    public function __construct(string $action) {
        parent::__construct('form-logout', array('action' => $action));
    }
    
    protected function generaCampos(array & $datos_iniciales = array()): void
    {
        $nif = '';

        if (! empty($datos_iniciales)) {
            $nif = isset($datos_iniciales['nif']) ? $datos_iniciales['nif'] : $nif;
        }

        $url_restablecer = App::getSingleton()->getUrl() . '/sesion/reset/';

        $this->html .= <<< HTML
                        <button type="submit">Cerrar sesión</button>

HTML;

    }
    
    /**
     * Procesa un formulario enviado.
     */
    protected function procesa(array & $datos): void
    {
        Sesion::cierra();

        Vista::encolaMensajeExito('Se ha cerrado la sesión correctamente.', '');
    }
}