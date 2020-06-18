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
 * @version 0.0.4
 */

namespace Awsw\Gesi\Formularios\Sesion;

use \Awsw\Gesi\Formularios\Formulario;
use \Awsw\Gesi\Sesion;
use \Awsw\Gesi\Vistas\Vista;

class Cerrar extends Formulario
{

    private const FORM_ID = 'form-logout';

    public function __construct(string $action)
    {
        parent::__construct(self::FORM_ID, array('action' => $action));
    }
    
    protected function generaCampos(array & $datos_iniciales = array()): string
    {
        $html = <<< HTML
        <button type="submit">Cerrar sesión</button>
        HTML;

        return $html;
    }
    
    protected function procesa(array & $datos): void
    {
        Sesion::cierra();

        Vista::encolaMensajeExito('Se ha cerrado la sesión correctamente.', '');
    }
}

?>