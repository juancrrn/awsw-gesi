<?php

/**
 * Puntos de entrada de vistas relacionadas con usuarios.
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

namespace Awsw\Gesi\Controladores;

use Awsw\Gesi\Vistas\Vista as V;

class Usuario extends Controlador
{

    public static function controla() : void
    {
        // Permitir que se ejecuten varios puntos de entrada. Los de los formularios solo se ejecutarán si el método y el id coincide con los esperados.
        parent::disableLast();

        // Vista de lista de usuarios.

        parent::get('/admin/usuarios/', function () {
            V::dibuja(new \Awsw\Gesi\Vistas\Usuario\UsuarioAdminList());
        });

        // TODO comprobar permisos

        // Formularios AJAX de usuarios con rol estudiante.

        parent::get('/admin/usuarios/est/create/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminCreate();

            $formulario->manage();
        });

        parent::post('/admin/usuarios/est/create/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminCreate();

            $formulario->manage();
        });

        parent::get('/admin/usuarios/est/read/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminRead();

            $formulario->manage();
        });

        parent::post('/admin/usuarios/est/read/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminRead();

            $formulario->manage();
        });

        parent::get('/admin/usuarios/est/read/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminRead();

            $formulario->manage();
        });

        parent::post('/admin/usuarios/est/read/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminRead();

            $formulario->manage();
        });
        
        parent::get('/admin/usuarios/est/update/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminUpdate();

            $formulario->manage();
        });

        parent::patch('/admin/usuarios/est/update/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminUpdate();

            $formulario->manage();
        });
        
        parent::get('/admin/usuarios/est/delete/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminDelete();

            $formulario->manage();
        });

        parent::delete('/admin/usuarios/est/delete/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\Est\EstAdminDelete();

            $formulario->manage();
        });

        // Formularios AJAX de usuarios con rol personal docente.

        parent::get('/admin/usuarios/pd/create/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\PD\PDAdminCreate();

            $formulario->manage();
        });

        parent::post('/admin/usuarios/pd/create/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\PD\PDAdminCreate();

            $formulario->manage();
        });
        
        parent::get('/admin/usuarios/pd/delete/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\PD\PDAdminDelete();

            $formulario->manage();
        });

        parent::delete('/admin/usuarios/pd/delete/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\PD\PDAdminDelete();

            $formulario->manage();
        });

        // Formularios AJAX de usuarios con rol personal de Secretaría.

        parent::get('/admin/usuarios/ps/create/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\PS\PSAdminCreate();

            $formulario->manage();
        });

        parent::post('/admin/usuarios/ps/create/', function () {
            $formulario = new \Awsw\Gesi\FormulariosAjax\Usuario\PS\PSAdminCreate();

            $formulario->manage();
        });

    }
}