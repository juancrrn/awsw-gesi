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

        parent::get('/ps/usuarios/', function () {
            Vista::dibuja(new UsuarioPsList());
        });

        // TODO comprobar permisos

        /**
         * Formularios AJAX de usuarios con rol estudiante.
         */

        // Create
        parent::get('/ps/usuarios/est/create/', function () {
            (new EstPsCreate())->manage();
        });
        parent::post('/ps/usuarios/est/create/', function () {
            (new EstPsCreate())->manage();
        });

        // Read
        parent::get('/ps/usuarios/est/read/', function () {
            (new EstPsRead())->manage();
        });

        // Update
        parent::get('/ps/usuarios/est/update/', function () {
            (new EstPsUpdate())->manage();
        });
        parent::patch('/ps/usuarios/est/update/', function () {
            (new EstPsUpdate())->manage();
        });

        // Delete
        parent::get('/ps/usuarios/est/delete/', function () {
            (new EstPsDelete())->manage();
        });
        parent::delete('/ps/usuarios/est/delete/', function () {
            (new EstPsDelete())->manage();
        });

        /**
         * Formularios AJAX de usuarios con rol personal docente.
         */

        // Create
        parent::get('/ps/usuarios/pd/create/', function () {
            (new PdPsCreate())->manage();
        });
        parent::post('/ps/usuarios/pd/create/', function () {
            (new PdPsCreate())->manage();
        });

        // Read
        parent::get('/ps/usuarios/pd/read/', function () {
            (new PdPsRead())->manage();
        });

        // Update
        parent::get('/ps/usuarios/pd/update/', function () {
            (new PdPsUpdate())->manage();
        });
        parent::patch('/ps/usuarios/pd/update/', function () {
            (new PdPsUpdate())->manage();
        });

        // Delete
        parent::get('/ps/usuarios/pd/delete/', function () {
            (new PdPsDelete())->manage();
        });
        parent::delete('/ps/usuarios/pd/delete/', function () {
            (new PdPsDelete())->manage();
        });

        /**
         * Formularios AJAX de usuarios con rol personal de Secretaría.
         */

        // Create
        parent::get('/ps/usuarios/ps/create/', function () {
            (new PsPsCreate())->manage();
        });
        parent::post('/ps/usuarios/ps/create/', function () {
            (new PsPsCreate())->manage();
        });
        
        // Read
        parent::get('/ps/usuarios/ps/read/', function () {
            (new PsPsRead())->manage();
        });
    
        // Update
        parent::get('/ps/usuarios/ps/update/', function () {
            (new PsPsUpdate())->manage();
        });
        parent::patch('/ps/usuarios/ps/update/', function () {
            (new PsPsUpdate())->manage();
        });

        // Delete
        parent::get('/ps/usuarios/ps/delete/', function () {
            (new PsPsDelete())->manage();
        });
        parent::delete('/ps/usuarios/ps/delete/', function () {
            (new PsPsDelete())->manage();
        });
    }
}

?>