<?php

/**
 * Puntos de entrada de vistas relacionadas con la sesión.
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

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Sesion\SesionIniciar;
use Awsw\Gesi\Vistas\Sesion\SesionPerfil;
use Awsw\Gesi\Vistas\Sesion\SesionRestablecerContrasena;

use Awsw\Gesi\Vistas\Vista;

class Sesion extends Controlador
{
    public static function controla(): void
    {
        /**
         * Iniciar sesión.
         */

        parent::get('/sesion/iniciar/', function () {
            Vista::dibuja(new SesionIniciar());
        });
        parent::post('/sesion/iniciar/', function () {
            Vista::dibuja(new SesionIniciar());
        });

        /**
         * Restablecer contraseña.
         */
        
        parent::get('/sesion/reset/', function () {
            Vista::dibuja(new SesionRestablecerContrasena());
        });
        parent::post('/sesion/reset/', function () {
            Vista::dibuja(new SesionRestablecerContrasena());
        });

        /**
         * Perfil.
         */
        
        parent::get('/sesion/perfil/', function () {
            Vista::dibuja(new SesionPerfil());
        });
    }
}

?>