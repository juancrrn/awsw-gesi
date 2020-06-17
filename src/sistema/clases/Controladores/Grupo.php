<?php

/**
 * Puntos de entrada relacionados con la vistas vistas relacionadas con grupos.
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

use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsCreate;
use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsDelete;
use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsRead;
use Awsw\Gesi\FormulariosAjax\Grupo\GrupoPsUpdate;

use Awsw\Gesi\Vistas\Grupo\GrupoPsList;

use Awsw\Gesi\Vistas\Vista;

class Grupo extends Controlador
{

    public static function controla(): void
    {   

        /**
         * Personal de Secretaría.
         */

        parent::get('/ps/grupos/', function () {
            Vista::dibuja(new GrupoPsList());
        });

        // Create.
        parent::get('/ps/grupo/create/', function(){
            (new GrupoPsCreate(true))->manage();
        });
        parent::post('/ps/grupo/create/', function(){
            (new GrupoPsCreate(true))->manage();
        });

        // Read.
        parent::get('/ps/grupo/read/', function(){
            (new GrupoPsRead(true))->manage();
        });
        parent::post('/ps/grupo/read/', function(){
            (new GrupoPsRead(true))->manage();
        });

        // Update.
        parent::get('/ps/grupo/update/', function(){
            (new GrupoPsUpdate(true))->manage();
        });
        parent::patch('/ps/grupo/update/', function(){
            (new GrupoPsUpdate(true))->manage();
        });

        // Delete.
        parent::get('/ps/grupo/delete/', function(){
            (new GrupoPsDelete(true))->manage();
        });
        parent::delete('/ps/grupo/delete/', function(){
            (new GrupoPsDelete(true))->manage();
        });
    }
}

?>