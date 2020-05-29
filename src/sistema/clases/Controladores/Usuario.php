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
 * @version 0.0.4-beta.01
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

    public static function controla(): void
    {
        /**
         * Personal de Secretaría.
         */

        parent::get('/ps/usuarios/', function () {
            Vista::dibuja(new UsuarioPsList());
        });

        /**
         * Rol estudiante.
         */

        // Create.
        parent::get('/ps/usuarios/est/create/', function () {
            (new EstPsCreate(true))->manage();
        });
        parent::post('/ps/usuarios/est/create/', function () {
            (new EstPsCreate(true))->manage();
        });

        // Read.
        parent::get('/ps/usuarios/est/read/', function () {
            (new EstPsRead(true))->manage();
        });

        // Update.
        parent::get('/ps/usuarios/est/update/', function () {
            (new EstPsUpdate(true))->manage();
        });
        parent::patch('/ps/usuarios/est/update/', function () {
            (new EstPsUpdate(true))->manage();
        });

        // Delete.
        parent::get('/ps/usuarios/est/delete/', function () {
            (new EstPsDelete(true))->manage();
        });
        parent::delete('/ps/usuarios/est/delete/', function () {
            (new EstPsDelete(true))->manage();
        });
        
        /**
         * Rol personal docente.
         */

        // Create.
        parent::get('/ps/usuarios/pd/create/', function () {
            (new PdPsCreate(true))->manage();
        });
        parent::post('/ps/usuarios/pd/create/', function () {
            (new PdPsCreate(true))->manage();
        });

        // Read.
        parent::get('/ps/usuarios/pd/read/', function () {
            (new PdPsRead(true))->manage();
        });

        // Update.
        parent::get('/ps/usuarios/pd/update/', function () {
            (new PdPsUpdate(true))->manage();
        });
        parent::patch('/ps/usuarios/pd/update/', function () {
            (new PdPsUpdate(true))->manage();
        });

        // Delete.
        parent::get('/ps/usuarios/pd/delete/', function () {
            (new PdPsDelete(true))->manage();
        });
        parent::delete('/ps/usuarios/pd/delete/', function () {
            (new PdPsDelete(true))->manage();
        });
        
        /**
         * Rol personal de Secretaría.
         */

        // Create.
        parent::get('/ps/usuarios/ps/create/', function () {
            (new PsPsCreate(true))->manage();
        });
        parent::post('/ps/usuarios/ps/create/', function () {
            (new PsPsCreate(true))->manage();
        });
        
        // Read.
        parent::get('/ps/usuarios/ps/read/', function () {
            (new PsPsRead(true))->manage();
        });
    
        // Update.
        parent::get('/ps/usuarios/ps/update/', function () {
            (new PsPsUpdate(true))->manage();
        });
        parent::patch('/ps/usuarios/ps/update/', function () {
            (new PsPsUpdate(true))->manage();
        });

        // Delete.
        parent::get('/ps/usuarios/ps/delete/', function () {
            (new PsPsDelete(true))->manage();
        });
        parent::delete('/ps/usuarios/ps/delete/', function () {
            (new PsPsDelete(true))->manage();
        });
    }
}

?>