<?php

/**
 * Puntos de entrada de vistas y formularios relacionados con usuarios.
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

use Awsw\Gesi\FormulariosAjax\Usuario\EstPsCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\EstPsRead;
use Awsw\Gesi\FormulariosAjax\Usuario\EstPsUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\EstPsDelete;

use Awsw\Gesi\FormulariosAjax\Usuario\PdPsCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\PdPsRead;
use Awsw\Gesi\FormulariosAjax\Usuario\PdPsUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\PdPsDelete;

use Awsw\Gesi\FormulariosAjax\Usuario\PsPsCreate;
use Awsw\Gesi\FormulariosAjax\Usuario\PsPsRead;
use Awsw\Gesi\FormulariosAjax\Usuario\PsPsUpdate;
use Awsw\Gesi\FormulariosAjax\Usuario\PsPsDelete;

use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Vistas\Usuario\UsuarioPsList;

class Usuario extends Controlador
{

    public static function controla() : void
    {
        /**
         * Vista de lista de usuarios.
         */

        parent::get('/admin/usuarios/', function () {
            Vista::dibuja(new UsuarioPsList());
        });

        // TODO comprobar permisos

        /**
         * Formularios AJAX de usuarios con rol estudiante.
         */

        // Create
        parent::get('/admin/usuarios/est/create/', function () {
            (new EstPsCreate())->manage();
        });
        parent::post('/admin/usuarios/est/create/', function () {
            (new EstPsCreate())->manage();
        });

        // Read
        parent::get('/admin/usuarios/est/read/', function () {
            (new EstPsRead())->manage();
        });

        // Update
        parent::get('/admin/usuarios/est/update/', function () {
            (new EstPsUpdate())->manage();
        });
        parent::patch('/admin/usuarios/est/update/', function () {
            (new EstPsUpdate())->manage();
        });

        // Delete
        parent::get('/admin/usuarios/est/delete/', function () {
            (new EstPsDelete())->manage();
        });
        parent::delete('/admin/usuarios/est/delete/', function () {
            (new EstPsDelete())->manage();
        });

        /**
         * Formularios AJAX de usuarios con rol personal docente.
         */

        // Create
        parent::get('/admin/usuarios/pd/create/', function () {
            (new PdPsCreate())->manage();
        });
        parent::post('/admin/usuarios/pd/create/', function () {
            (new PdPsCreate())->manage();
        });

        // Read
        parent::get('/admin/usuarios/pd/read/', function () {
            (new PdPsRead())->manage();
        });

        // Update
        parent::get('/admin/usuarios/pd/update/', function () {
            (new PdPsUpdate())->manage();
        });
        parent::patch('/admin/usuarios/pd/update/', function () {
            (new PdPsUpdate())->manage();
        });

        // Delete
        parent::get('/admin/usuarios/pd/delete/', function () {
            (new PdPsDelete())->manage();
        });
        parent::delete('/admin/usuarios/pd/delete/', function () {
            (new PdPsDelete())->manage();
        });

        /**
         * Formularios AJAX de usuarios con rol personal de Secretaría.
         */

        // Create
        parent::get('/admin/usuarios/ps/create/', function () {
            (new PsPsCreate())->manage();
        });
        parent::post('/admin/usuarios/ps/create/', function () {
            (new PsPsCreate())->manage();
        });
        
        // Read
        parent::get('/admin/usuarios/ps/read/', function () {
            (new PsPsRead())->manage();
        });
    
        // Update
        parent::get('/admin/usuarios/ps/update/', function () {
            (new PsPsUpdate())->manage();
        });
        parent::patch('/admin/usuarios/ps/update/', function () {
            (new PsPsUpdate())->manage();
        });

        // Delete
        parent::get('/admin/usuarios/ps/delete/', function () {
            (new PsPsDelete())->manage();
        });
        parent::delete('/admin/usuarios/ps/delete/', function () {
            (new PsPsDelete())->manage();
        });
    }
}

?>