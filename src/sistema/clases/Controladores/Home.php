<?php

/**
 * Puntos de entrada relacionados con la vista de landing.
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

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Home\Home as VistaHome;

use Awsw\Gesi\Vistas\Vista;

class Home extends Controlador
{

    public static function controla(): void
    {
        parent::get('/?', function () {
            Vista::dibuja(new VistaHome());
        });
    }
}

?>