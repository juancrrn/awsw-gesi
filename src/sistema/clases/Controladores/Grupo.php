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
use Awsw\Gesi\Vistas\Grupo\GrupoPsList;
use Awsw\Gesi\Vistas\Vista as V;

class Grupo extends Controlador
{

    public static function controla() : void
    {
        /**
         * Formularios AJAX de grupos
         */

        parent::get('/ps/grupo/create/', function(){
            (new GrupoPsCreate())->manage();
        });
        parent::post('/ps/grupo/create/', function(){
            (new GrupoPsCreate())->manage();
        });
        
        /**
         * Personal de Secretaría.
         */

        parent::get('/ps/grupos/', function () {
            V::dibuja(new GrupoPsList());
        });
    }
}

?>